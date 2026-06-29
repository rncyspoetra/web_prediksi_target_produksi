@extends('adminlte::page')
@section('title', 'Tambah User')
@vite('resources/css/pages/create.user.css')

@section('content')
    <div class="page-shell">

        {{-- ── Page Header ── --}}
        <div class="page-header">
            <h1>Tambah User</h1>
            <p>Buat akun pengguna baru dan tentukan hak akses rolenya.</p>
        </div>

        {{-- ── Form Card ── --}}
        <div class="section-card">
            <div class="section-card-header">
                <h2 class="section-card-title">Informasi Akun</h2>
            </div>
            <form action="{{ route('user.store') }}" method="POST">
                @csrf
                <div class="section-card-body">
                    <div class="form-grid">

                        <div class="form-field">
                            <label for="username">
                                Username <span class="required">*</span>
                            </label>
                            <input type="text" id="username" name="username" value="{{ old('username') }}"
                                placeholder="Masukkan username" class="{{ $errors->has('username') ? 'is-invalid' : '' }}">
                            @error('username')
                                <div class="invalid-msg">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label for="role">
                                Role <span class="required">*</span>
                            </label>
                            <select id="role" name="role" class="{{ $errors->has('role') ? 'is-invalid' : '' }}">
                                <option value="" disabled {{ old('role') ? '' : 'selected' }}>-- Pilih Role --
                                </option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="manajemen" {{ old('role') === 'manajemen' ? 'selected' : '' }}>Manajemen
                                </option>
                            </select>
                            @error('role')
                                <div class="invalid-msg">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label for="password">
                                Password <span class="required">*</span>
                            </label>
                            <input type="password" id="password" name="password" placeholder="Masukkan password"
                                class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                            @error('password')
                                <div class="invalid-msg">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label for="password_confirmation">
                                Konfirmasi Password <span class="required">*</span>
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                placeholder="Ulangi password">
                        </div>

                    </div>
                </div>
                <div class="section-card-footer">
                    <a href="{{ route('user.index') }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Simpan User
                    </button>
                </div>
            </form>
        </div>

    </div>
@stop
