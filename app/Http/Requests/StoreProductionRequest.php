<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'kg_manioc_utilise' => ['required', 'numeric', 'min:0.1'],
            'sachets_petit_transparent' => ['required', 'integer', 'min:0'],
            'sachets_moyen_souple' => ['required', 'integer', 'min:0'],
            'sachets_grand_solide' => ['required', 'integer', 'min:0'],
            'film_biodegradable_m2' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
