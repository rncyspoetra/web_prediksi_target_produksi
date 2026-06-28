<?php

namespace App\Http\Controllers;

use App\Exports\PrediksiExport;
use App\Models\PerhitunganRegresi;
use App\Models\Prediksi;
use App\Services\RegresiLinearService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RegresiLinearController extends Controller
{
    protected RegresiLinearService $service;

    public function __construct(RegresiLinearService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $persamaan = PerhitunganRegresi::first();
        $prediksi = Prediksi::with('dataHistoris')
            ->orderBy('id_prediksi')
            ->paginate(10);
        $chartData = Prediksi::with('dataHistoris')
            ->orderBy('id_prediksi')
            ->get();
        $mape = $chartData->avg('persentase_error');

        return view('proses-prediksi.index', [
            'persamaan' => $persamaan,
            'prediksi' => $prediksi,
            'mape' => round($mape, 2),
            'chartLabel' => $chartData->keys()->map(fn($i) => 'Data ke-' . ($i + 1)),
            'chartAktual' => $chartData->pluck('dataHistoris.target_produksi'),
            'chartPrediksi' => $chartData->pluck('hasil_prediksi')->map(fn($v) => round($v, 2)),

        ]);
    }

    public function generate()
    {
        try {
            $this->service->generate();
            return redirect()
                ->route('proses-prediksi.index')
                ->with(
                    'success',
                    'Persamaan regresi berhasil digenerate.'
                );
        } catch (\Throwable $e) {
            return redirect()
                ->route('proses-prediksi.index')
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }

    public function export()
    {
        return Excel::download(
            new PrediksiExport,
            'Laporan Prediksi Regresi.xlsx'
        );
    }
}
