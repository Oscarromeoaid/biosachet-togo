<?php

use App\Models\Commande;
use Illuminate\Support\Collection;
use Livewire\Component;

new class extends Component
{
    public Commande $commande;
    public $clients = [];
    public $catalogue = [];
    public string $action = '';
    public string $httpMethod = 'POST';
    public array $lignes = [];
    public ?int $clientId = null;
    public string $statut = 'en_attente';
    public string $paiement = 'en_attente';
    public string $methodePaiement = 'cash';
    public ?string $dateLivraison = null;

    public function mount(
        Commande $commande,
        Collection|array $clients,
        Collection|array $produits,
        string $action,
        string $httpMethod = 'POST',
        array $initialLines = [],
        ?int $initialClientId = null,
        ?string $initialStatut = null,
        ?string $initialPaiement = null,
        ?string $initialMethodePaiement = null,
        ?string $initialDateLivraison = null,
    ): void {
        $this->commande = $commande;
        $this->clients = collect($clients)->map(fn ($client) => [
            'id' => $client['id'] ?? $client->id,
            'nom' => $client['nom'] ?? $client->nom,
        ])->all();
        $this->catalogue = collect($produits)->map(fn ($produit) => [
            'id' => $produit['id'] ?? $produit->id,
            'nom' => $produit['nom'] ?? $produit->nom,
            'format' => $produit['format'] ?? $produit->format,
            'prix_unitaire' => (float) ($produit['prix_unitaire'] ?? $produit->prix_unitaire),
        ])->values()->all();
        $this->action = $action;
        $this->httpMethod = $httpMethod;
        $this->clientId = $initialClientId ?: $commande->client_id;
        $this->statut = $initialStatut ?: ($commande->statut ?: 'en_attente');
        $this->paiement = $initialPaiement ?: ($commande->paiement ?: 'en_attente');
        $this->methodePaiement = $initialMethodePaiement ?: ($commande->methode_paiement ?: 'cash');
        $this->dateLivraison = $initialDateLivraison ?: optional($commande->date_livraison)->toDateString();

        if ($initialLines !== []) {
            $this->lignes = array_values($initialLines);
            return;
        }

        if ($commande->exists && $commande->relationLoaded('produits')) {
            $this->lignes = $commande->produits->map(fn ($produit) => [
                'produit_id' => $produit->id,
                'quantite' => (int) $produit->pivot->quantite,
                'prix_unitaire' => (float) $produit->pivot->prix_unitaire,
            ])->all();
        }

        if ($this->lignes === []) {
            $this->lignes[] = ['produit_id' => '', 'quantite' => 1, 'prix_unitaire' => 0];
        }
    }

    public function addLine(): void
    {
        $this->lignes[] = ['produit_id' => '', 'quantite' => 1, 'prix_unitaire' => 0];
    }

    public function removeLine(int $index): void
    {
        unset($this->lignes[$index]);
        $this->lignes = array_values($this->lignes);

        if ($this->lignes === []) {
            $this->addLine();
        }
    }

    public function applyProduct(int $index, $productId): void
    {
        $product = collect($this->catalogue)->firstWhere('id', (int) $productId);

        if (! $product) {
            return;
        }

        $this->lignes[$index]['produit_id'] = $product['id'];
        $this->lignes[$index]['prix_unitaire'] = $product['prix_unitaire'];
    }

    public function getTotalProperty(): float
    {
        return collect($this->lignes)->sum(fn ($ligne) => ((int) ($ligne['quantite'] ?? 0)) * ((float) ($ligne['prix_unitaire'] ?? 0)));
    }
};
?>

<div class="card p-6">
    <form method="POST" action="{{ $action }}" class="space-y-6">
        @csrf
        @if (strtoupper($httpMethod) !== 'POST')
            @method($httpMethod)
        @endif

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
            <div>
                <label class="label" for="client_id">Client</label>
                <select id="client_id" name="client_id" wire:model.live="clientId" class="input">
                    <option value="">Selectionner</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client['id'] }}">{{ $client['nom'] }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="label" for="statut">Statut</label>
                <select id="statut" name="statut" wire:model.live="statut" class="input">
                    @foreach (['en_attente' => 'En attente', 'confirmee' => 'Confirmee', 'livree' => 'Livree', 'annulee' => 'Annulee'] as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="label" for="paiement">Paiement</label>
                <select id="paiement" name="paiement" wire:model.live="paiement" class="input">
                    @foreach (['en_attente' => 'En attente', 'partiel' => 'Partiel', 'paye' => 'Paye'] as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="label" for="methode_paiement">Methode</label>
                <select id="methode_paiement" name="methode_paiement" wire:model.live="methodePaiement" class="input">
                    @foreach (config('biosachet.payment_methods') as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="label" for="date_livraison">Date de livraison</label>
            <input id="date_livraison" type="date" name="date_livraison" wire:model.live="dateLivraison" class="input max-w-sm">
        </div>

        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-stone-900">Lignes produits</h3>
                    <p class="text-sm text-stone-500">Ajoutez plusieurs formats et quantites dans la meme commande.</p>
                </div>
                <button type="button" wire:click="addLine" class="btn-secondary py-2">Ajouter une ligne</button>
            </div>

            @foreach ($lignes as $index => $ligne)
                <div class="grid gap-4 rounded-3xl border border-stone-200 bg-stone-50 p-4 lg:grid-cols-[2fr_1fr_1fr_auto]">
                    <div>
                        <label class="label">Produit</label>
                        <select name="produits[{{ $index }}][produit_id]" wire:change="applyProduct({{ $index }}, $event.target.value)" wire:model.live="lignes.{{ $index }}.produit_id" class="input">
                            <option value="">Selectionner un produit</option>
                            @foreach ($catalogue as $produit)
                                <option value="{{ $produit['id'] }}">{{ $produit['nom'] }} - {{ $produit['format'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="label">Quantite</label>
                        <input type="number" min="1" name="produits[{{ $index }}][quantite]" wire:model.live="lignes.{{ $index }}.quantite" class="input">
                    </div>
                    <div>
                        <label class="label">Prix unitaire</label>
                        <input type="number" min="1" step="0.01" name="produits[{{ $index }}][prix_unitaire]" wire:model.live="lignes.{{ $index }}.prix_unitaire" class="input">
                    </div>
                    <div class="flex items-end">
                        <button type="button" wire:click="removeLine({{ $index }})" class="rounded-full border border-red-200 px-4 py-3 text-sm font-semibold text-red-600">
                            Retirer
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex items-center justify-between rounded-3xl bg-[var(--bio-green)] px-6 py-4 text-white">
            <div>
                <p class="text-sm text-white/75">Total calcule</p>
                <p class="text-3xl font-bold">{{ number_format($this->total, 0, ',', ' ') }} FCFA</p>
            </div>
            <button type="submit" class="rounded-full bg-white px-5 py-3 text-sm font-semibold text-[var(--bio-green)]">
                Enregistrer la commande
            </button>
        </div>
    </form>
</div>
