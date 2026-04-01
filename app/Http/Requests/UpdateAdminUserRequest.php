<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdminUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = $this->route('user');

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user?->id)],
            'telephone' => ['nullable', 'digits:8'],
            'admin_role' => ['required', Rule::in(User::ADMIN_ROLES)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }
}
