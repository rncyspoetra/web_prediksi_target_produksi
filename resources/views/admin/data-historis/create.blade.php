```blade
@extends('adminlte::page')
@section('title', 'Tambah Data Historis')
@section('content')

    <div class="card card-primary mt-3">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-plus-circle mr-2"></i>
                Tambah Data Historis
            </h3>
        </div>
        <form action="{{ route('data-historis.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Total Tenaga <span class="text-danger">*</span></label>
                            <input type="number" name="total_tenaga"
                                class="form-control @error('total_tenaga') is-invalid @enderror"
                                value="{{ old('total_tenaga') }}" placeholder="Masukkan total tenaga">
                            @error('total_tenaga')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tenaga Produktif <span class="text-danger">*</span></label>
                            <input type="number" name="tenaga_produktif"
                                class="form-control @error('tenaga_produktif') is-invalid @enderror"
                                value="{{ old('tenaga_produktif') }}" placeholder="Masukkan tenaga produktif">
                            @error('tenaga_produktif')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Jam Kerja <span class="text-danger">*</span></label>
                            <input type="number" step="0.1" name="jam_kerja"
                                class="form-control @error('jam_kerja') is-invalid @enderror" value="{{ old('jam_kerja') }}"
                                placeholder="Contoh: 7.5">
                            @error('jam_kerja')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Target Produksi <span class="text-danger">*</span></label>
                            <input type="number" name="target_produksi"
                                class="form-control @error('target_produksi') is-invalid @enderror"
                                value="{{ old('target_produksi') }}" placeholder="Masukkan target produksi">
                            @error('target_produksi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('data-historis.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i>
                    Simpan Data
                </button>
            </div>
        </form>
    </div>

@stop
