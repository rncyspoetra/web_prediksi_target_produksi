<?php

namespace App\Services;

use App\Models\PerhitunganRegresi;
use App\Models\PrediksiTarget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PrediksiTargetService
{
    public function store(array $data): array
    {
        return DB::transaction(function () use ($data) {
            $persamaan = PerhitunganRegresi::first();

            if (!$persamaan) {
                throw new RuntimeException(
                    'Silakan generate persamaan regresi terlebih dahulu.'
                );
            }

            $hasilPrediksi =
                $persamaan->intercept +
                ($persamaan->beta1 * $data['total_tenaga']) +
                ($persamaan->beta2 * $data['tenaga_produktif']) +
                ($persamaan->beta3 * $data['jam_kerja']);

            $hasilPrediksi = round($hasilPrediksi, 2);

            $prediksi = PrediksiTarget::create([
                'id_user' => Auth::id(),
                'tanggal' => now(),
                'total_tenaga' => $data['total_tenaga'],
                'tenaga_produktif' => $data['tenaga_produktif'],
                'jam_kerja' => $data['jam_kerja'],
                'hasil_prediksi' => $hasilPrediksi,
            ]);

            return [
                'prediksi' => $prediksi,
                'persamaan' => [
                    'intercept' => $persamaan->intercept,
                    'beta1' => $persamaan->beta1,
                    'beta2' => $persamaan->beta2,
                    'beta3' => $persamaan->beta3,
                ],
                'hasil_prediksi' => $hasilPrediksi,
            ];
        });
    }

    public function findById(int $id)
    {
        return PrediksiTarget::findOrFail($id);
    }

    public function destroy(int $id)
    {
        $prediksiTarget = $this->findById($id);

        $prediksiTarget->delete();
    }
}
