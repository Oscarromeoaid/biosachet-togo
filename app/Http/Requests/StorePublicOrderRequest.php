<?php

namespace App\Http\Requests;

use App\Models\Client;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePublicOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'digits:8'],
            'email' => ['nullable', 'email', 'max:255'],
            'type' => ['required', Rule::in(Client::TYPES)],
            'ville' => ['required', 'string', 'max:255'],
            'date_livraison' => ['nullable', 'date', 'after_or_equal:today'],
        ];
    }
}
