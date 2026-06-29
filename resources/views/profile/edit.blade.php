@extends('adminlte::page')
@section('title', 'Profile')
@vite('resources/css/pages/profile.css')

@section('content')
    <div class="page-shell">

        {{-- ── Page Header ── --}}
        <div class="page-header">
            <h1>Profile</h1>
            <p>Kelola informasi akun dan keamanan login kamu.</p>
        </div>

        {{-- ── Profile Information ── --}}
        <div class="section-card">
            <div class="section-card-header">
                <h2 class="section-card-title">Informasi Profile</h2>
            </div>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')
                <div class="section-card-body">
                    <div class="form-field">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}"
                            class="{{ $errors->has('username') ? 'is-invalid' : '' }}">
                        @error('username')
                            <div class="invalid-msg">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-field">
                        <label>Role</label>
                        <input type="text" value="{{ $user->role }}" readonly>
                    </div>
                </div>
                <div class="section-card-footer">
                    <button type="submit" class="btn-save">
                        <i class="fas fa-check"></i> Simpan Perubahan
                    </button>
                    @if (session('status') === 'profile-updated')
                        <span class="saved-indicator">
                            <i class="fas fa-check-circle"></i> Tersimpan
                        </span>
                    @endif
                </div>
            </form>
        </div>

        {{-- ── Update Password ── --}}
        <div class="section-card">
            <div class="section-card-header">
                <h2 class="section-card-title">Ubah Password</h2>
            </div>
            <form method="POST" action="{{ route('profile.password.update') }}">
                @csrf
                @method('PUT')
                <div class="section-card-body">
                    <div class="form-field">
                        <label for="current_password">Password Lama</label>
                        <input type="password" id="current_password" name="current_password"
                            placeholder="Masukkan password saat ini"
                            class="{{ $errors->has('current_password') ? 'is-invalid' : '' }}">
                        @error('current_password')
                            <div class="invalid-msg">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-field">
                        <label for="password">Password Baru</label>
                        <input type="password" id="password" name="password" placeholder="Masukkan password baru"
                            class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                        @error('password')
                            <div class="invalid-msg">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-field">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            placeholder="Ulangi password baru">
                    </div>
                </div>
                <div class="section-card-footer">
                    <button type="submit" class="btn-password">
                        <i class="fas fa-lock"></i> Update Password
                    </button>
                    @if (session('status') === 'password-updated')
                        <span class="saved-indicator">
                            <i class="fas fa-check-circle"></i> Tersimpan
                        </span>
                    @endif
                </div>
            </form>
        </div>

        {{-- ── Danger Zone ── --}}
        <div class="section-card danger-zone">
            <div class="section-card-header">
                <h2 class="section-card-title">Hapus Akun</h2>
            </div>
            <div class="section-card-body">
                <p class="danger-desc">
                    Setelah akun dihapus, semua data terkait akan hilang secara permanen dan tidak bisa dikembalikan.
                </p>
                <button type="button" class="btn-danger" data-toggle="modal" data-target="#deleteModal">
                    <i class="fas fa-trash-alt"></i> Hapus Akun
                </button>
            </div>
        </div>

    </div>

    {{-- ── Delete Account Modal ── --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus Akun</h5>
                    </div>
                    <div class="modal-body">
                        <p>Masukkan password kamu untuk mengkonfirmasi penghapusan akun. Tindakan ini tidak dapat
                            dibatalkan.</p>
                        <div class="form-field" style="margin-bottom:0;">
                            <label for="delete_password">Password</label>
                            <input type="password" id="delete_password" name="password" placeholder="Masukkan password kamu"
                                class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                            @error('password')
                                <div class="invalid-msg">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-modal-cancel" data-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn-modal-danger">
                            <i class="fas fa-trash-alt"></i> Hapus Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
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
                type: 'error',
                title: 'Gagal',
                text: "{{ session('error') }}"
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                type: 'error',
                title: 'Validasi Gagal',
                text: 'Periksa kembali input kamu.'
            });
        </script>
    @endif
@endsection
