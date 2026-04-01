<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
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
            'message' => ['required', 'string', 'min:10'],
        ];
    }
}
