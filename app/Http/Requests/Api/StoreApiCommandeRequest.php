<?php

namespace App\Http\Requests\Api;

use App\Models\Commande;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreApiCommandeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'methode_paiement' => ['required', Rule::in(Commande::METHODES_PAIEMENT)],
            'date_livraison' => ['nullable', 'date'],
            'produits' => ['required', 'array', 'min:1'],
            'produits.*.produit_id' => ['required', 'exists:produits,id'],
            'produits.*.quantite' => ['required', 'integer', 'min:1'],
            'produits.*.prix_unitaire' => ['nullable', 'numeric', 'min:1'],
        ];
    }
}
