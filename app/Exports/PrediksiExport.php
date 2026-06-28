<?php

namespace App\Exports;

use App\Models\Prediksi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PrediksiExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithStyles,
    WithEvents
{
    public function collection()
    {
        $prediksi = Prediksi::with('dataHistoris')->get();

        $rows = collect();

        foreach ($prediksi as $i => $item) {

            $rows->push([

                $i + 1,

                $item->dataHistoris->total_tenaga,

                $item->dataHistoris->tenaga_produktif,

                $item->dataHistoris->jam_kerja,

                $item->dataHistoris->target_produksi,

                round($item->hasil_prediksi, 2),

                round($item->nilai_error, 2),

                round($item->persentase_error, 2) . '%',

            ]);
        }

        $mape = round($prediksi->avg('persentase_error'), 2);

        $rows->push([]);

        $rows->push([
            '',
            '',
            '',
            '',
            '',
            '',
            'Rata-rata MAPE',
            $mape . '%'
        ]);

        return $rows;
    }

    public function headings(): array
    {
        return [

            [
                'LAPORAN HASIL PREDIKSI REGRESI LINEAR BERGANDA'
            ],

            [
                'PT BMI INTERNUSA'
            ],

            [],

            [

                'No',

                'Total Tenaga',

                'Tenaga Produktif',

                'Jam Kerja',

                'Target Produksi',

                'Hasil Prediksi',

                'Error',

                'Persentase Error'

            ]

        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [

            1 => [

                'font' => [
                    'bold' => true,
                    'size' => 16
                ]

            ],

            2 => [

                'font' => [
                    'bold' => true,
                    'size' => 12
                ]

            ],

            4 => [

                'font' => [
                    'bold' => true
                ]

            ]

        ];
    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet;

                $sheet->mergeCells('A1:H1');
                $sheet->mergeCells('A2:H2');

                $sheet->getStyle('A4:H4')
                    ->getFill()
                    ->setFillType('solid')
                    ->getStartColor()
                    ->setARGB('D9EAD3');

                $lastRow = $sheet->getHighestRow();

                $sheet->getStyle("A4:H{$lastRow}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle('thin');

                $sheet->getStyle("A1:H2")
                    ->getAlignment()
                    ->setHorizontal('center');

                $sheet->getStyle("A4:H4")
                    ->getAlignment()
                    ->setHorizontal('center');
            }

        ];
    }
}
