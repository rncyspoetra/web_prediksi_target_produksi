@extends('adminlte::page')
@section('title', 'Prediksi Target Produksi')
@vite('resources/css/pages/prediksi-target.css')

@section('content')
    <div class="page-shell">

        {{-- ── Page Header ── --}}
        <div class="page-header">
            <h1>Prediksi Target Produksi</h1>
            <p>Masukkan variabel input untuk menghitung estimasi target produksi menggunakan model regresi.</p>
        </div>

        <div class="two-col">

            {{-- ── Kolom Kiri: Form Input ── --}}
            <div>
                <div class="section-card">
                    <div class="section-card-header">
                        <h2 class="section-card-title">Input Prediksi</h2>
                    </div>
                    <div class="section-card-body">
                        <form action="{{ route('prediksi-target.store') }}" method="POST">
                            @csrf

                            <div class="form-field">
                                <label for="total_tenaga">Total Tenaga</label>
                                <input type="number" id="total_tenaga" name="total_tenaga"
                                    value="{{ old('total_tenaga') }}" placeholder="Masukkan jumlah total tenaga" required>
                            </div>

                            <div class="form-field">
                                <label for="tenaga_produktif">Tenaga Produktif</label>
                                <input type="number" id="tenaga_produktif" name="tenaga_produktif"
                                    value="{{ old('tenaga_produktif') }}" placeholder="Masukkan jumlah tenaga produktif"
                                    required>
                            </div>

                            <div class="form-field">
                                <label for="jam_kerja">Jam Kerja</label>
                                <input type="number" id="jam_kerja" name="jam_kerja" value="{{ old('jam_kerja') }}"
                                    placeholder="Masukkan total jam kerja" required>
                            </div>

                            <button type="submit" class="btn-submit">
                                <i class="fas fa-calculator"></i>
                                Hitung Prediksi
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ── Kolom Kanan: Hasil + Riwayat ── --}}
            <div>

                {{-- Hasil Prediksi (conditional) --}}
                @if (session('hasil'))
                    <div class="section-card hasil-block">
                        <div class="section-card-header">
                            <h2 class="section-card-title">Hasil Prediksi</h2>
                        </div>
                        <div class="section-card-body">
                            <div class="eq-block">
                                <div class="eq-label">Persamaan Model</div>
                                <div class="eq-formula">
                                    Y = {{ session('hasil')['persamaan']['intercept'] }}
                                    + ({{ session('hasil')['persamaan']['beta1'] }}) X₁
                                    + ({{ session('hasil')['persamaan']['beta2'] }}) X₂
                                    + ({{ session('hasil')['persamaan']['beta3'] }}) X₃
                                </div>
                            </div>
                            <div class="hasil-number-block">
                                <span class="hasil-label">Target Produksi</span>
                                <span class="hasil-value">
                                    {{ number_format(session('hasil')['hasil_prediksi'], 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Riwayat Prediksi --}}
                <div class="section-card">
                    <div class="section-card-header">
                        <h2 class="section-card-title">Riwayat Prediksi</h2>
                    </div>
                    <div style="padding:0;">
                        <div class="data-table-wrap">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Total Tenaga</th>
                                        <th>Tenaga Produktif</th>
                                        <th>Jam Kerja</th>
                                        <th>Hasil</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($riwayat as $item)
                                        <tr>
                                            <td>{{ $item->tanggal }}</td>
                                            <td>{{ $item->total_tenaga }}</td>
                                            <td>{{ $item->tenaga_produktif }}</td>
                                            <td>{{ $item->jam_kerja }}</td>
                                            <td>{{ number_format($item->hasil_prediksi, 2) }}</td>
                                            <td>
                                                <form
                                                    action="{{ route('prediksi-target.destroy', $item->id_prediksi_target) }}"
                                                    method="POST" class="btn-delete" style="margin:0;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn-hapus">
                                                        <i class="fas fa-trash-alt"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">
                                                <div class="empty-state">
                                                    <i class="fas fa-inbox"></i>
                                                    <p>Belum ada riwayat prediksi.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
@stop

@section('js')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    let form = this.closest('form');
                    Swal.fire({
                        title: 'Yakin hapus data?',
                        text: "Data yang dihapus tidak bisa dikembalikan!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.value) {
                            form.submit();
                        }
                    });
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
