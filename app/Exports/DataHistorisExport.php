<?php

namespace App\Exports;

use App\Models\DataHistoris;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DataHistorisExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return DataHistoris::orderBy('id_data', 'asc')
            ->get()
            ->map(function ($item, $index) {
                return [
                    'no' => $index + 1,
                    'total_tenaga' => $item->total_tenaga,
                    'tenaga_produktif' => $item->tenaga_produktif,
                    'jam_kerja' => $item->jam_kerja,
                    'target_produksi' => $item->target_produksi,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'No',
            'Total Tenaga',
            'Tenaga Produktif',
            'Jam Kerja',
            'Target Produksi',
        ];
    }
}
