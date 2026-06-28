@extends('adminlte::page')
@section('title', 'Data User')
@section('content_header')
    <h1>Data User</h1>
@stop

@section('content')

    <div class="mb-3 d-flex justify-content-between">
        <a href="{{ route('user.create') }}" class="btn btn-primary">
            Tambah User
        </a>
    </div>
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $index => $user)
                        <tr class="text-center">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->username }}</td>
                            <td>
                                <span class="badge badge-info">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('user.edit', $user->id_user) }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                <form action="{{ route('user.reset-password', $user->id_user) }}" method="POST"
                                    class="d-inline btn-reset">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-success btn-sm">
                                        Reset Password
                                    </button>
                                </form>
                                <form action="{{ route('user.destroy', $user->id_user) }}" method="POST"
                                    class="d-inline btn-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('js')

    <script>
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                let form = this.closest('form');
                Swal.fire({
                    type: 'warning',
                    title: 'Yakin hapus user?',
                    text: 'Data tidak bisa dikembalikan!',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.value) {
                        form.submit();
                    }
                });
            });
        });
        document.querySelectorAll('.btn-reset').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                let form = this.closest('form');
                Swal.fire({
                    type: 'warning',
                    title: 'Reset password user ini?',
                    text: 'Password akan diubah menjadi 12345678',
                    showCancelButton: true,
                    confirmButtonText: 'Reset',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.value) {
                        form.submit();
                    }
                });
            });
        });
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                type: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}"
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({
                type: 'error',
                title: 'Gagal',
                text: "{{ session('error') }}"
            });
        </script>
    @endif
@stop
