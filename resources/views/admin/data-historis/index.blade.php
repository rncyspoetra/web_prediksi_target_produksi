@extends('adminlte::page')
@section('title', 'Data Historis')
@vite('resources/css/pages/index.data-historis.css')

@section('content')
    <div class="page-shell">

        {{-- ── Page Header ── --}}
        <div class="page-header">
            <div class="page-header-left">
                <h1>Data Historis</h1>
                <p>Kelola data historis produksi yang digunakan sebagai dasar model regresi.</p>
            </div>
            <div class="page-header-actions">
                <a href="{{ route('data-historis.export') }}" class="btn-action btn-success-action">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
                <button type="button" class="btn-action btn-success-action" data-toggle="modal" data-target="#importModal">
                    <i class="fas fa-file-import"></i> Import Dataset
                </button>
                <a href="{{ route('data-historis.create') }}" class="btn-action btn-primary-action">
                    <i class="fas fa-plus"></i> Tambah Data
                </a>
            </div>
        </div>

        {{-- ── Table Card ── --}}
        <div class="section-card">
            <div class="section-card-header">
                <h2 class="section-card-title">Daftar Data Historis</h2>
            </div>
            <div class="data-table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Target Produksi</th>
                            <th>Total Tenaga</th>
                            <th>Tenaga Produktif</th>
                            <th>Jam Kerja</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $item)
                            <tr>
                                <td>{{ $data->firstItem() + $index }}</td>
                                <td>{{ number_format($item->target_produksi, 0) }}</td>
                                <td>{{ $item->total_tenaga }}</td>
                                <td>{{ $item->tenaga_produktif }}</td>
                                <td>{{ $item->jam_kerja }}</td>
                                <td>
                                    <div class="row-actions">
                                        <a href="{{ route('data-historis.edit', $item->id_data) }}" class="btn-edit">
                                            <i class="fas fa-pencil-alt"></i> Edit
                                        </a>
                                        <form action="{{ route('data-historis.destroy', $item->id_data) }}" method="POST"
                                            style="margin:0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-hapus btn-delete">
                                                <i class="fas fa-trash-alt"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <p>Belum ada data historis. Klik <strong>Tambah Data</strong> atau <strong>Import
                                                Dataset</strong> untuk memulai.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($data->count())
                <div class="table-footer">
                    {{ $data->links() }}
                </div>
            @endif
        </div>

    </div>

    {{-- ── Import Modal ── --}}
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('data-historis.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5>Import Dataset</h5>
                    </div>
                    <div class="modal-body">
                        <p>Pilih file Excel atau CSV yang berisi data historis produksi.</p>
                        <div class="file-input-wrap">
                            <input type="file" name="file" accept=".xlsx,.xls,.csv">
                        </div>
                        <div class="file-hint">Format yang didukung: .xlsx, .xls, .csv</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-modal-cancel" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-modal-success">
                            <i class="fas fa-file-import"></i> Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        document.querySelectorAll('.btn-delete').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                Swal.fire({
                    type: 'warning',
                    title: 'Hapus data ini?',
                    text: 'Data yang dihapus tidak bisa dikembalikan.',
                    showCancelButton: true,
                    confirmButtonColor: '#cc2929',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal'
                }).then(function(result) {
                    if (result.isConfirmed) {
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
                text: "{{ session('success') }}",
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    @endif
@endsection
