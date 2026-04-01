<?php

namespace App\Services;

use App\Models\Commande;
use App\Models\Produit;
use App\Models\StockMouvement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

class CommandeService
{
    public function __construct(
        private readonly ProduitAvailabilityService $availability,
        private readonly ActivityLogService $activityLog,
    )
    {
    }

    public function store(array $validated): Commande
    {
        return DB::transaction(function () use ($validated) {
            $this->guardReservableStock($validated['produits'], null, $validated['statut']);
            $commande = Commande::create($this->extractCommandeData($validated));
            $this->assignPublicIdentifiers($commande);
            $this->syncProduits($commande, $validated['produits']);
            $this->applyDeliveryStockReduction($commande);
            $this->activityLog->log(
                'commandes',
                'create',
                'Commande creee: '.$commande->reference,
                $commande,
                ['total' => (float) $commande->total, 'statut' => $commande->statut]
            );

            return $commande->refresh()->load(['client', 'produits']);
        });
    }

    public function update(Commande $commande, array $validated): Commande
    {
        return DB::transaction(function () use ($commande, $validated) {
            if ($commande->stock_decremente_le && $this->linesChanged($commande, $validated['produits'])) {
                throw new RuntimeException('Une commande deja livree ne peut plus modifier ses lignes produits.');
            }

            if ($commande->stock_decremente_le && $validated['statut'] !== 'livree') {
                throw new RuntimeException('Une commande deja livree ne peut plus changer de statut.');
            }

            $this->guardReservableStock($validated['produits'], $commande, $validated['statut']);

            $commande->fill($this->extractCommandeData($validated));
            $commande->save();
            $this->assignPublicIdentifiers($commande);

            $this->syncProduits($commande, $validated['produits']);
            $this->applyDeliveryStockReduction($commande);
            $this->activityLog->log(
                'commandes',
                'update',
                'Commande mise a jour: '.$commande->reference,
                $commande,
                ['total' => (float) $commande->total, 'statut' => $commande->statut]
            );

            return $commande->refresh()->load(['client', 'produits']);
        });
    }

    public function destroy(Commande $commande): void
    {
        if ($commande->stock_decremente_le) {
            throw new RuntimeException('Une commande deja livree ne peut pas etre supprimee pour conserver la trace de stock.');
        }

        DB::transaction(function () use ($commande) {
            $commande->produits()->detach();
            $this->activityLog->log(
                'commandes',
                'delete',
                'Commande supprimee: '.$commande->reference,
                $commande,
                ['total' => (float) $commande->total]
            );
            $commande->delete();
        });
    }

    protected function extractCommandeData(array $validated): array
    {
        return [
            'client_id' => $validated['client_id'],
            'statut' => $validated['statut'],
            'paiement' => $validated['paiement'],
            'methode_paiement' => $validated['methode_paiement'],
            'date_livraison' => $validated['date_livraison'] ?? null,
        ];
    }

    protected function syncProduits(Commande $commande, array $produits): void
    {
        $syncData = [];
        $total = 0;

        foreach ($produits as $ligne) {
            $produit = Produit::query()->publicCatalog()->findOrFail($ligne['produit_id']);
            $quantite = (int) $ligne['quantite'];
            $prix = (float) ($ligne['prix_unitaire'] ?? $produit->prix_unitaire);

            $syncData[$produit->id] = [
                'quantite' => $quantite,
                'prix_unitaire' => $prix,
            ];

            $total += $quantite * $prix;
        }

        $commande->produits()->sync($syncData);
        $commande->forceFill(['total' => round($total, 2)])->save();
    }

    protected function applyDeliveryStockReduction(Commande $commande): void
    {
        if ($commande->statut !== 'livree' || $commande->stock_decremente_le) {
            return;
        }

        $commande->loadMissing('produits');

        foreach ($commande->produits as $produit) {
            $quantite = (int) $produit->pivot->quantite;

            if ($produit->stock_disponible < $quantite) {
                throw new RuntimeException("Stock insuffisant pour le produit {$produit->nom}.");
            }
        }

        foreach ($commande->produits as $produit) {
            $quantite = (int) $produit->pivot->quantite;
            $stockAvant = (int) $produit->stock_disponible;

            $produit->decrement('stock_disponible', $quantite);
            $produit->refresh();

            StockMouvement::query()->create([
                'produit_id' => $produit->id,
                'commande_id' => $commande->id,
                'type' => 'sortie_livraison',
                'quantite' => $quantite,
                'stock_avant' => $stockAvant,
                'stock_apres' => (int) $produit->stock_disponible,
                'note' => 'Sortie de stock lors de la livraison de la commande '.$commande->reference,
            ]);
        }

        $commande->forceFill(['stock_decremente_le' => now()])->save();
    }

    protected function guardReservableStock(array $produits, ?Commande $commande = null, ?string $statut = null): void
    {
        if ($statut === 'annulee') {
            return;
        }

        $lignesParProduit = collect($produits)
            ->groupBy(fn (array $ligne) => (int) $ligne['produit_id'])
            ->map(fn ($lignes) => (int) collect($lignes)->sum('quantite'));

        foreach ($lignesParProduit as $produitId => $quantiteDemandee) {
            $produit = Produit::query()->publicCatalog()->findOrFail((int) $produitId);
            $disponibleCommande = $this->availability->availableToOrder($produit, $commande);

            if ($quantiteDemandee > $disponibleCommande) {
                throw new RuntimeException(
                    "Stock reserve insuffisant pour {$produit->nom}. Disponible a la commande: {$disponibleCommande}."
                );
            }
        }
    }

    protected function assignPublicIdentifiers(Commande $commande): void
    {
        $updates = [];

        if (! $commande->reference) {
            $updates['reference'] = 'BST-'.now()->format('Ymd').'-'.str_pad((string) $commande->id, 5, '0', STR_PAD_LEFT);
        }

        if (! $commande->suivi_token) {
            $updates['suivi_token'] = (string) Str::uuid();
        }

        if ($updates !== []) {
            $commande->forceFill($updates)->save();
        }
    }

    protected function linesChanged(Commande $commande, array $submittedLines): bool
    {
        $existing = $commande->produits()
            ->get()
            ->mapWithKeys(fn ($produit) => [
                $produit->id => [
                    'quantite' => (int) $produit->pivot->quantite,
                    'prix_unitaire' => (float) $produit->pivot->prix_unitaire,
                ],
            ])->all();

        $incoming = collect($submittedLines)->mapWithKeys(fn ($ligne) => [
            (int) $ligne['produit_id'] => [
                'quantite' => (int) $ligne['quantite'],
                'prix_unitaire' => (float) ($ligne['prix_unitaire'] ?? 0),
            ],
        ])->all();

        return $existing !== $incoming;
    }
}
