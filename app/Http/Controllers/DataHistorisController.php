<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataHistoris;
use App\Services\DataHistorisService;
use App\Http\Requests\StoreDataHistorisRequest;
use App\Exports\DataHistorisExport;
use App\Imports\DataHistorisImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\ImportDataHistorisRequest;

class DataHistorisController extends Controller
{
    public function __construct(
        protected DataHistorisService $service
    ) {}

    public function export()
    {
        return Excel::download(new DataHistorisExport, 'data-historis.xlsx');
    }

    public function import(ImportDataHistorisRequest $request)
    {
        Excel::import(
            new DataHistorisImport,
            $request->file('file')
        );

        return redirect()
            ->route('data-historis.index')
            ->with('success', 'Dataset berhasil diimport');
    }

    public function index()
    {
        return view('admin.data-historis.index', [
            'data' => $this->service->getAllPaginated()
        ]);
    }

    public function create()
    {
        return view('admin.data-historis.create');
    }

    public function store(StoreDataHistorisRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()
            ->route('data-historis.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function edit(int $id)
    {
        return view(
            'admin.data-historis.edit',
            [
                'data' => $this->service->findById($id)
            ]
        );
    }

    public function update(StoreDataHistorisRequest $request, $id)
    {
        $this->service->update($request->validated(), $id);

        return redirect()->route('data-historis.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return redirect()->route('data-historis.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
