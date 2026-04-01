<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockMatiereRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date_achat' => ['required', 'date'],
            'quantite_kg' => ['required', 'numeric', 'min:0.1'],
            'cout_total' => ['required', 'numeric', 'min:0'],
            'fournisseur' => ['required', 'string', 'max:255'],
        ];
    }
}
