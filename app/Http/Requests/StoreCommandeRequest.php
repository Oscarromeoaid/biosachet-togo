<?php

namespace App\Http\Requests;

use App\Models\Commande;
use App\Models\Produit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCommandeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => ['required', 'exists:clients,id'],
            'statut' => ['required', Rule::in(Commande::STATUTS)],
            'paiement' => ['required', Rule::in(Commande::PAIEMENTS)],
            'methode_paiement' => ['required', Rule::in(Commande::METHODES_PAIEMENT)],
            'date_livraison' => ['nullable', 'date'],
            'produits' => ['required', 'array', 'min:1'],
            'produits.*.produit_id' => [
                'required',
                Rule::exists('produits', 'id')->where(
                    fn ($query) => $query->whereIn('slug', Produit::CATALOG_SLUGS)
                ),
            ],
            'produits.*.quantite' => ['required', 'integer', 'min:1'],
            'produits.*.prix_unitaire' => ['nullable', 'numeric', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'produits.*.produit_id.exists' => 'Seuls les 4 produits officiels du catalogue peuvent etre commandes.',
        ];
    }
}
