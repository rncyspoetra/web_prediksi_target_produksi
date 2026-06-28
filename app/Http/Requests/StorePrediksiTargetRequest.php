<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePrediksiTargetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'total_tenaga' => [
                'required',
                'integer',
                'min:1',
            ],

            'tenaga_produktif' => [
                'required',
                'integer',
                'min:1',
                'lte:total_tenaga',
            ],

            'jam_kerja' => [
                'required',
                'integer',
                'min:1',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'total_tenaga' => 'total tenaga',
            'tenaga_produktif' => 'tenaga produktif',
            'jam_kerja' => 'jam kerja',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'integer' => ':attribute harus berupa angka.',
            'min' => ':attribute minimal :min.',
            'lte' => 'Tenaga produktif tidak boleh melebihi total tenaga.',
        ];
    }
}
