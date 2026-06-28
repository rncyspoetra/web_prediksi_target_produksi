@extends('adminlte::page')
@section('title', 'Tambah User')
@section('content')

    <div class="card card-primary mt-3">
        <div class="card-header">
            <h3 class="card-title">Tambah User</h3>
        </div>
        <form action="{{ route('user.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username"
                                class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}">
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Role</label>
                            <select name="role" class="form-control @error('role') is-invalid @enderror">
                                <option value="">-- Pilih Role --</option>
                                <option value="admin">Admin</option>
                                <option value="manajemen">Manajemen</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('user.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
                <button class="btn btn-primary">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@stop
