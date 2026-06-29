@extends('adminlte::page')
@section('title', 'Edit User')
@vite('resources/css/pages/edit.user.css')

@section('content')
    <div class="page-shell">

        {{-- ── Page Header ── --}}
        <div class="page-header">
            <h1>Edit User</h1>
            <p>Perbarui informasi akun dan role pengguna.</p>
        </div>

        {{-- ── Form Card ── --}}
        <div class="section-card">
            <div class="section-card-header">
                <h2 class="section-card-title">Informasi Akun</h2>
            </div>
            <form action="{{ route('user.update', $user->id_user) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="section-card-body">
                    <div class="form-grid">

                        <div class="form-field">
                            <label for="username">
                                Username <span class="required">*</span>
                            </label>
                            <input type="text" id="username" name="username"
                                value="{{ old('username', $user->username) }}" placeholder="Masukkan username"
                                class="{{ $errors->has('username') ? 'is-invalid' : '' }}">
                            @error('username')
                                <div class="invalid-msg">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label for="role">
                                Role <span class="required">*</span>
                            </label>
                            <select id="role" name="role" class="{{ $errors->has('role') ? 'is-invalid' : '' }}">
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                    Admin
                                </option>
                                <option value="manajemen" {{ old('role', $user->role) === 'manajemen' ? 'selected' : '' }}>
                                    Manajemen
                                </option>
                            </select>
                            @error('role')
                                <div class="invalid-msg">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>
                <div class="section-card-footer">
                    <a href="{{ route('user.index') }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn-update">
                        <i class="fas fa-save"></i> Update Data
                    </button>
                </div>
            </form>
        </div>

    </div>
@stop
