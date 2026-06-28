<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ImportDataHistorisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'file' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv'
            ]
        ];
    }
}
