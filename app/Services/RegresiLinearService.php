<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Prediksi;
use App\Models\PerhitunganRegresi;
use App\Models\DataHistoris;

class RegresiLinearService
{
    public function getData()
    {
        return DataHistoris::orderBy('id_data')->get();
    }

    public function hitungPersamaan(): array
    {
        $data = $this->getData();
        $X = [];
        $Y = [];

        foreach ($data as $row) {
            $X[] = [
                1,
                $row->total_tenaga,
                $row->tenaga_produktif,
                $row->jam_kerja,
            ];
            $Y[] = [
                $row->target_produksi
            ];
        }

        $Xt = $this->transpose($X);
        $XtX = $this->multiply($Xt, $X);
        $XtY = $this->multiply($Xt, $Y);
        $det = $this->determinant($XtX);

        if ($det == 0) {
            throw new \Exception("Determinan = 0. Matriks tidak memiliki invers.");
        }
        $inverse = $this->inverse($XtX);
        $beta = $this->multiply($inverse, $XtY);

        return [
            'intercept' => $beta[0][0],
            'beta1' => $beta[1][0],
            'beta2' => $beta[2][0],
            'beta3' => $beta[3][0],
            'xtx' => $XtX,
            'xty' => $XtY,
            'inverse' => $inverse,
            'determinan' => $det,
        ];
    }

    private function transpose(array $matrix): array
    {
        $result = [];
        foreach ($matrix as $i => $row) {
            foreach ($row as $j => $value) {
                $result[$j][$i] = $value;
            }
        }
        return $result;
    }

    private function multiply(array $A, array $B): array
    {
        $rowsA = count($A);
        $colsA = count($A[0]);
        $rowsB = count($B);
        $colsB = count($B[0]);

        if ($colsA != $rowsB) {
            throw new \Exception("Ukuran matriks tidak sesuai.");
        }
        $result = [];
        for ($i = 0; $i < $rowsA; $i++) {
            for ($j = 0; $j < $colsB; $j++) {
                $result[$i][$j] = 0;
                for ($k = 0; $k < $colsA; $k++) {
                    $result[$i][$j] +=
                        $A[$i][$k] * $B[$k][$j];
                }
            }
        }
        return $result;
    }

    private function determinant(array $matrix): float
    {
        $n = count($matrix);
        if ($n == 1) {
            return $matrix[0][0];
        }
        if ($n == 2) {
            return ($matrix[0][0] * $matrix[1][1])
                -
                ($matrix[0][1] * $matrix[1][0]);
        }
        $det = 0;
        foreach ($matrix[0] as $col => $value) {
            $minor = $this->minor($matrix, 0, $col);
            $det +=
                pow(-1, $col)
                *
                $value
                *
                $this->determinant($minor);
        }
        return $det;
    }

    private function minor(array $matrix, int $row, int $col): array
    {
        $minor = [];
        foreach ($matrix as $i => $rows) {
            if ($i == $row) {
                continue;
            }
            $temp = [];
            foreach ($rows as $j => $value) {
                if ($j == $col) {
                    continue;
                }
                $temp[] = $value;
            }
            $minor[] = $temp;
        }

        return $minor;
    }

    private function inverse(array $matrix): array
    {
        $det = $this->determinant($matrix);
        if ($det == 0) {
            throw new \Exception("Matriks tidak mempunyai invers.");
        }
        $size = count($matrix);
        $cofactor = [];
        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                $minor = $this->minor($matrix, $i, $j);
                $cofactor[$i][$j] =
                    pow(-1, $i + $j)
                    *
                    $this->determinant($minor);
            }
        }

        $adjoint = $this->transpose($cofactor);
        $inverse = [];
        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                $inverse[$i][$j] =
                    $adjoint[$i][$j] / $det;
            }
        }
        return $inverse;
    }

    public function hitungPrediksi(): array
    {
        $persamaan = $this->hitungPersamaan();
        $a = $persamaan['intercept'];
        $b1 = $persamaan['beta1'];
        $b2 = $persamaan['beta2'];
        $b3 = $persamaan['beta3'];

        $dataHistoris = $this->getData();
        $hasilPrediksi = [];
        $totalMape = 0;
        foreach ($dataHistoris as $row) {
            $prediksi =
                $a
                + ($b1 * $row->total_tenaga)
                + ($b2 * $row->tenaga_produktif)
                + ($b3 * $row->jam_kerja);
            $error = abs(
                $row->target_produksi - $prediksi
            );
            if ($row->target_produksi != 0) {
                $persentaseError =
                    ($error / $row->target_produksi) * 100;
            } else {
                $persentaseError = 0;
            }
            $totalMape += $persentaseError;
            $hasilPrediksi[] = [
                'id_data' => $row->id_data,
                'hasil_prediksi' => round($prediksi, 2),
                'nilai_error' => round($error, 2),
                'persentase_error' => round($persentaseError, 2),
                'total_tenaga' => $row->total_tenaga,
                'tenaga_produktif' => $row->tenaga_produktif,
                'jam_kerja' => $row->jam_kerja,
                'target_produksi' => $row->target_produksi,
            ];
        }

        $mape = 0;
        if (count($hasilPrediksi) > 0) {
            $mape = $totalMape / count($hasilPrediksi);
        }
        return [
            'persamaan' => $persamaan,
            'prediksi' => $hasilPrediksi,
            'mape' => round($mape, 2),
        ];
    }

    public function generate(): array
    {
        return DB::transaction(function () {
            $hasil = $this->hitungPrediksi();
            $persamaan = $hasil['persamaan'];

            PerhitunganRegresi::updateOrCreate(
                [
                    'id_perhitungan_regresi' => 1,
                ],
                [
                    'id_user' => auth()->id(),
                    'intercept' => $persamaan['intercept'],
                    'beta1' => $persamaan['beta1'],
                    'beta2' => $persamaan['beta2'],
                    'beta3' => $persamaan['beta3'],
                ]
            );

            DB::table('prediksi')->delete();
            foreach ($hasil['prediksi'] as $item) {
                Prediksi::create([
                    'id_data' => $item['id_data'],
                    'hasil_prediksi' => $item['hasil_prediksi'],
                    'nilai_error' => $item['nilai_error'],
                    'persentase_error' => $item['persentase_error'],
                ]);
            }
            return [
                'persamaan' => $persamaan,
                'prediksi' => $hasil['prediksi'],
                'mape' => $hasil['mape'],
            ];
        });
    }
}
