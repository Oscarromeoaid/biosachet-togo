<?php

namespace App\Http\Requests;

use App\Models\Client;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom' => ['required', 'string', 'max:255'],
            'telephone' => ['nullable', 'digits:8'],
            'email' => ['nullable', 'email', 'max:255'],
            'type' => ['required', Rule::in(Client::TYPES)],
            'ville' => ['required', 'string', 'max:255'],
        ];
    }
}
