<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommandeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'client' => [
                'id' => $this->client?->id,
                'nom' => $this->client?->nom,
                'telephone' => $this->client?->telephone,
            ],
            'total' => (float) $this->total,
            'statut' => $this->statut,
            'paiement' => $this->paiement,
            'methode_paiement' => $this->methode_paiement,
            'date_livraison' => optional($this->date_livraison)->toDateString(),
            'produits' => $this->produits->map(fn ($produit) => [
                'id' => $produit->id,
                'nom' => $produit->nom,
                'format' => $produit->format,
                'quantite' => (int) $produit->pivot->quantite,
                'prix_unitaire' => (float) $produit->pivot->prix_unitaire,
                'sous_total' => round((float) $produit->pivot->quantite * (float) $produit->pivot->prix_unitaire, 2),
            ])->values(),
            'created_at' => optional($this->created_at)->toDateTimeString(),
        ];
    }
}
