<?php

namespace App\Http\Requests;

use App\Models\Commande;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCommandePaiementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'montant' => ['required', 'numeric', 'min:1'],
            'methode_paiement' => ['required', Rule::in(Commande::METHODES_PAIEMENT)],
            'reference_paiement' => ['nullable', 'string', 'max:255'],
            'date_paiement' => ['required', 'date'],
            'note' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
