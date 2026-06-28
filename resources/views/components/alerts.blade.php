<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            type: 'success',
            title: @json(session('success')),
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            type: 'error',
            title: @json(session('error')),
            showConfirmButton: false,
            timer: 2500
        });
    </script>
@endif

@if ($errors->any())
    <script>
        Swal.fire({
            type: 'error',
            title: 'Validasi gagal',
            html: `{!! implode('<br>', $errors->all()) !!}`
        });
    </script>
@endif
