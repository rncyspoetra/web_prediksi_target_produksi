<?php

namespace App\Services;

use App\Models\DataHistoris;
use Illuminate\Support\Facades\Auth;

class DataHistorisService
{
    public function all()
    {
        return DataHistoris::get();
    }

    public function store(array $data)
    {
        $data['id_user'] = Auth::id();
        return DataHistoris::create($data);
    }

    public function update(array $data, int $id)
    {
        $historis = DataHistoris::findOrFail($id);

        $historis->update($data);

        return $historis;
    }

    public function findById(int $id)
    {
        return DataHistoris::findOrFail($id);
    }

    public function delete($id)
    {
        $historis = $this->findById($id);

        $historis->delete();
    }

    public function count(): int
    {
        return DataHistoris::count();
    }

    public function avgTarget(): float
    {
        return (float) DataHistoris::avg('target_produksi');
    }

    public function avgJamKerja(): float
    {
        return (float) DataHistoris::avg('jam_kerja');
    }

    public function avgTenagaProduktif(): float
    {
        return (float) DataHistoris::avg('tenaga_produktif');
    }

    public function latest7()
    {
        return DataHistoris::orderBy('id_data', 'desc')
            ->limit(7)
            ->get()
            ->reverse()
            ->values();
    }

    public function getAllPaginated($perPage = 10)
    {
        return DataHistoris::orderBy('id_data', 'desc')
            ->paginate($perPage);
    }

    public function dashboardData(): array
    {
        return [
            'totalData' => $this->count(),
            'avgTarget' => round($this->avgTarget(), 2),
            'avgJam' => round($this->avgJamKerja(), 2),
            'avgProduktif' => round($this->avgTenagaProduktif(), 2),
            'chartData' => $this->latest7(),
        ];
    }
}
