<?php

namespace App\Services;

use App\Models\Commande;
use App\Models\Produit;
use Illuminate\Support\Facades\DB;

class ProduitAvailabilityService
{
    public function reservedQuantity(Produit $produit, ?Commande $excludingCommande = null): int
    {
        $query = DB::table('commande_produit')
            ->join('commandes', 'commandes.id', '=', 'commande_produit.commande_id')
            ->where('commande_produit.produit_id', $produit->id)
            ->whereIn('commandes.statut', ['en_attente', 'confirmee']);

        if ($excludingCommande?->exists) {
            $query->where('commandes.id', '!=', $excludingCommande->id);
        }

        return (int) $query->sum('commande_produit.quantite');
    }

    public function availableToOrder(Produit $produit, ?Commande $excludingCommande = null): int
    {
        return max(0, (int) $produit->stock_disponible - $this->reservedQuantity($produit, $excludingCommande));
    }
}
