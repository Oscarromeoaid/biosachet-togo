<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProduitResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'slug' => $this->slug,
            'format' => $this->format,
            'usage_ideal' => $this->usage_ideal,
            'description' => $this->description,
            'prix_unitaire' => (float) $this->prix_unitaire,
            'cout_revient' => (float) $this->cout_revient,
            'stock_disponible' => $this->stock_disponible,
            'recette' => $this->recette,
            'notes_production' => $this->notes_production,
            'sechage_heures_min' => $this->sechage_heures_min,
            'sechage_heures_max' => $this->sechage_heures_max,
            'sechage_label' => $this->sechage_label,
            'proprietes' => $this->proprietes,
        ];
    }
}
