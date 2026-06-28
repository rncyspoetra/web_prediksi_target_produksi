<?php

namespace App\Imports;

use App\Models\DataHistoris;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataHistorisImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new DataHistoris([
            'id_user' => Auth::id(),
            'total_tenaga' => $row['total_tenaga'],
            'tenaga_produktif' => $row['tenaga_produktif'],
            'jam_kerja' => $row['jam_kerja'],
            'target_produksi' => $row['target_produksi'],
        ]);
    }
}
