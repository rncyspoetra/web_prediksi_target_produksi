<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDataHistorisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'total_tenaga' => 'required|integer|min:1',
            'tenaga_produktif' => 'required|integer|min:1',
            'jam_kerja' => 'required|numeric|min:0',
            'target_produksi' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'total_tenaga.required' => 'Total tenaga wajib diisi',
            'tenaga_produktif.required' => 'Tenaga produktif wajib diisi',
            'jam_kerja.required' => 'Jam kerja wajib diisi',
            'target_produksi.required' => 'Target produksi wajib diisi',
        ];
    }
}
