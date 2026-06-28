<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePrediksiTargetRequest;
use App\Models\PrediksiTarget;
use App\Services\PrediksiTargetService;

class PrediksiTargetController extends Controller
{
    public function __construct(
        protected PrediksiTargetService $service
    ) {}

    public function index()
    {
        $riwayat = PrediksiTarget::latest('tanggal')
            ->latest('id_prediksi_target')
            ->get();

        return view('prediksi-target.index', compact('riwayat'));
    }

    public function store(StorePrediksiTargetRequest $request)
    {
        try {

            $hasil = $this->service->store(
                $request->validated()
            );

            return redirect()
                ->route('prediksi-target.index')
                ->with('success', 'Prediksi berhasil dihitung.')
                ->with('hasil', $hasil);
        } catch (\Throwable $e) {

            return redirect()
                ->route('prediksi-target.index')
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->service->destroy($id);

            return redirect()
                ->route('prediksi-target.index')
                ->with('success', 'Riwayat prediksi berhasil dihapus.');
        } catch (\Throwable $e) {

            return redirect()
                ->route('prediksi-target.index')
                ->with('error', $e->getMessage());
        }
    }
}
