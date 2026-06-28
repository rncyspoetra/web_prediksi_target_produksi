@extends('adminlte::page')
@section('title', 'Edit User')
@section('content')

    <div class="card card-warning mt-3">
        <div class="card-header">
            <h3 class="card-title">Edit User</h3>
        </div>
        <form action="{{ route('user.update', $user->id_user) }}" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="card-body">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control  @error('username') is-invalid @enderror"
                        value="{{ old('username', $user->username) }}">
                    @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" class="form-control  @error('role') is-invalid @enderror">
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>
                        <option value="manajemen" {{ $user->role == 'manajemen' ? 'selected' : '' }}>
                            Manajemen
                        </option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('user.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-edit mr-1"></i>
                    Update Data
                </button>
            </div>
        </form>
    </div>

@stop
