<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => 'required|string|max:50|unique:users,username,' . $this->id_user . ',id_user',
            'role' => 'required|in:admin,manajemen',
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'Username wajib diisi',
            'username.string' => 'Username harus berupa teks',
            'username.max' => 'Username maksimal 50 karakter',
            'username.unique' => 'Username sudah digunakan',

            'role.required' => 'Role wajib dipilih',
            'role.in' => 'Role tidak valid (harus admin atau manajemen)',
        ];
    }
}
