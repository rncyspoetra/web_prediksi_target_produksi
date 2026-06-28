@extends('adminlte::page')
@section('title', 'Data Historis')
@section('content_header')
    <h1>Data Historis</h1>
@stop

@section('content')

    <div class="mb-3 d-flex justify-content-between">
        <a href="{{ route('data-historis.create') }}" class="btn btn-primary mb-2">Tambah Data</a>
        <div class="d-flex">
            <a href="{{ route('data-historis.export') }}" class="btn btn-success mr-2  d-flex align-items-center flex-col">
                <i class="fas fa-file-excel mr-1"></i>
                Export Excel
            </a>
            <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#importModal">
                <i class="fas fa-file-import mr-1"></i>
                Import Dataset
            </button>
        </div>
    </div>
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Target Produksi</th>
                        <th class="text-center">Total Tenaga</th>
                        <th class="text-center">Tenaga Produktif</th>
                        <th class="text-center">Jam Kerja</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $item)
                        <tr>
                            <td class="text-center">{{ $data->firstItem() + $index }}</td>
                            <td class="text-center">{{ $item->target_produksi }}</td>
                            <td class="text-center">{{ $item->total_tenaga }}</td>
                            <td class="text-center">{{ $item->tenaga_produktif }}</td>
                            <td class="text-center">{{ $item->jam_kerja }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2 justify-content-center">
                                    <a href="{{ route('data-historis.edit', $item->id_data) }}"
                                        class="btn btn-warning btn-sm mr-2">
                                        Edit
                                    </a>
                                    <form action="{{ route('data-historis.destroy', $item->id_data) }}" method="POST"
                                        class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm btn-delete">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end mt-2">
                {{ $data->links() }}
            </div>
        </div>
    </div>
    <div class="modal fade" id="importModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('data-historis.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5>Import Dataset</h5>
                    </div>
                    <div class="modal-body">
                        <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Batal
                        </button>
                        <button class="btn btn-success">
                            Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop

@section('js')
    <script>
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                Swal.fire({
                    type: 'warning',
                    title: 'Yakin hapus data?',
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
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                type: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                confirmButtonColor: '#3085d6'
            });
        </script>
    @endif
@endsection
