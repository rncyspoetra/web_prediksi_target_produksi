@extends('adminlte::page')
@section('title', 'Data User')
@vite('resources/css/pages/index.user.css')

@section('content')
    <div class="page-shell">

        {{-- ── Page Header ── --}}
        <div class="page-header">
            <div class="page-header-left">
                <h1>Data User</h1>
                <p>Kelola akun pengguna dan hak akses sistem.</p>
            </div>
            <div>
                <a href="{{ route('user.create') }}" class="btn-primary-action">
                    <i class="fas fa-plus"></i> Tambah User
                </a>
            </div>
        </div>

        {{-- ── Table Card ── --}}
        <div class="section-card">
            <div class="section-card-header">
                <h2 class="section-card-title">Daftar Pengguna</h2>
            </div>
            <div class="data-table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar">
                                            {{ strtoupper(substr($user->username, 0, 2)) }}
                                        </div>
                                        <span class="user-name">{{ $user->username }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="role-badge">{{ $user->role }}</span>
                                </td>
                                <td>
                                    <div class="row-actions">
                                        <a href="{{ route('user.edit', $user->id_user) }}" class="btn-edit">
                                            <i class="fas fa-pencil-alt"></i> Edit
                                        </a>
                                        <form action="{{ route('user.reset-password', $user->id_user) }}" method="POST"
                                            class="form-reset" style="margin:0;">
                                            @csrf
                                            @method('PUT')
                                            <button type="button" class="btn-reset btn-do-reset">
                                                <i class="fas fa-key"></i> Reset Password
                                            </button>
                                        </form>
                                        <form action="{{ route('user.destroy', $user->id_user) }}" method="POST"
                                            class="form-delete" style="margin:0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-hapus btn-do-delete">
                                                <i class="fas fa-trash-alt"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state">
                                        <i class="fas fa-users"></i>
                                        <p>Belum ada user. Klik <strong>Tambah User</strong> untuk menambahkan pengguna
                                            baru.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@stop

@section('js')
    <script>
        document.querySelectorAll('.btn-do-delete').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const form = this.closest('form');
                Swal.fire({
                    type: 'warning',
                    title: 'Hapus user ini?',
                    text: 'Data yang dihapus tidak bisa dikembalikan.',
                    showCancelButton: true,
                    confirmButtonColor: '#cc2929',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal'
                }).then(function(result) {
                    if (result.isConfirmed) form.submit();
                });
            });
        });

        document.querySelectorAll('.btn-do-reset').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const form = this.closest('form');
                Swal.fire({
                    type: 'warning',
                    title: 'Reset password user ini?',
                    text: 'Password akan diubah menjadi default (12345678).',
                    showCancelButton: true,
                    confirmButtonColor: '#2d5be3',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Reset',
                    cancelButtonText: 'Batal'
                }).then(function(result) {
                    if (result.isConfirmed) form.submit();
                });
            });
        });
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                type: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: "{{ session('error') }}"
            });
        </script>
    @endif
@endsection
