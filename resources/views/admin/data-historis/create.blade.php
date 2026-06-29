@extends('adminlte::page')
@section('title', 'Tambah Data Historis')
@vite('resources/css/pages/create.data-historis.css')

@section('content')
    <div class="page-shell">

        {{-- ── Page Header ── --}}
        <div class="page-header">
            <div class="page-header-left">
                <h1>Tambah Data Historis</h1>
                <p>Isi form di bawah untuk menambahkan data historis produksi baru.</p>
            </div>
        </div>

        {{-- ── Form Card ── --}}
        <div class="section-card">
            <div class="section-card-header">
                <h2 class="section-card-title">Informasi Data</h2>
            </div>
            <form action="{{ route('data-historis.store') }}" method="POST">
                @csrf
                <div class="section-card-body">
                    <div class="form-grid">

                        <div class="form-field">
                            <label for="total_tenaga">
                                Total Tenaga <span class="required">*</span>
                            </label>
                            <input type="number" id="total_tenaga" name="total_tenaga" value="{{ old('total_tenaga') }}"
                                placeholder="Masukkan total tenaga"
                                class="{{ $errors->has('total_tenaga') ? 'is-invalid' : '' }}">
                            @error('total_tenaga')
                                <div class="invalid-msg">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label for="tenaga_produktif">
                                Tenaga Produktif <span class="required">*</span>
                            </label>
                            <input type="number" id="tenaga_produktif" name="tenaga_produktif"
                                value="{{ old('tenaga_produktif') }}" placeholder="Masukkan tenaga produktif"
                                class="{{ $errors->has('tenaga_produktif') ? 'is-invalid' : '' }}">
                            @error('tenaga_produktif')
                                <div class="invalid-msg">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label for="jam_kerja">
                                Jam Kerja <span class="required">*</span>
                            </label>
                            <input type="number" step="0.1" id="jam_kerja" name="jam_kerja"
                                value="{{ old('jam_kerja') }}" placeholder="Contoh: 7.5"
                                class="{{ $errors->has('jam_kerja') ? 'is-invalid' : '' }}">
                            @error('jam_kerja')
                                <div class="invalid-msg">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label for="target_produksi">
                                Target Produksi <span class="required">*</span>
                            </label>
                            <input type="number" id="target_produksi" name="target_produksi"
                                value="{{ old('target_produksi') }}" placeholder="Masukkan target produksi"
                                class="{{ $errors->has('target_produksi') ? 'is-invalid' : '' }}">
                            @error('target_produksi')
                                <div class="invalid-msg">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>
                <div class="section-card-footer">
                    <a href="{{ route('data-historis.index') }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>

    </div>
@stop
