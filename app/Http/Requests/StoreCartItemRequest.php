<?php

namespace App\Http\Requests;

use App\Models\Produit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCartItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'produit_id' => [
                'required',
                Rule::exists('produits', 'id')->where(
                    fn ($query) => $query->whereIn('slug', Produit::CATALOG_SLUGS)
                ),
            ],
            'quantite' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'produit_id.exists' => 'Ce produit n est pas disponible dans le catalogue public.',
        ];
    }
}
