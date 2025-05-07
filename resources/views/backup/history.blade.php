@extends('layout.main')
@section('container')
{{-- header --}}
<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1">{{ $title }}</h3>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Beranda</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
        <form method="POST" action="{{ route('backup.schedule') }}" id="backup-form" class="me-2" hidden>
            @csrf

            <select name="frequency" id="frequency" class="form-control select" onchange="document.getElementById('backup-form').submit()">
                <option value="daily" {{ old('frequency') == 'daily' ? 'selected' : '' }}> Backup Harian</option>
                <option value="weekly" {{ old('frequency') == 'weekly' ? 'selected' : '' }}>Backup Mingguan</option>
                <option value="monthly" {{ old('frequency') == 'monthly' ? 'selected' : '' }}>Backup Bulanan</option>
            </select>
        </form>

        <!-- Tombol Backup Database -->
        <a href="{{ route('backup.database') }}" class="btn btn-primary me-2">
            <i class="ti ti-database-export"></i> Lakukan Backup Database
        </a>

        <a href="{{ route('backup.partialRestorePage') }}" class="btn btn-outline-light bg-white">
            <i class="ti ti-database-export"></i> Restore Database
        </a>
    </div>

</div>

@if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th></th>
            <th>File Name</th>
            <th>Size</th>
            <th></th> <!-- Tambah kolom buat delete -->
        </tr>
    </thead>
    <tbody>
        @php $no=1; @endphp
        @forelse($backupFiles as $file)
        <tr>
            <td style="width: 1%;">{{ $no++ }}</td>
            <td style="width: 1%;">
                <a href="{{ route('backup.download', $file->getFilename()) }}" class="btn btn-outline-light bg-white btn-sm">
                    <span class="ti ti-download"></span>
                </a>
            </td>
            <td style="width: 40%;">{{ $file->getFilename() }}</td>
            <td style="width: 35%;">{{ number_format($file->getSize() / 1024, 2) }} KB</td>
            <td style="width: 1%;">
                <button type="button"
                    class="btn btn-outline-danger btn-sm btn-delete-backup"
                    data-filename="{{ $file->getFilename() }}">
                    <span class="ti ti-trash"></span>
                </button>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center text-muted">Belum ada file backup tersedia.</td>
        </tr>
        @endforelse

    </tbody>
</table>

@section('javascript')
<script>
    document.querySelectorAll('.btn-delete-backup').forEach(button => {
        button.addEventListener('click', function () {
            let filename = this.getAttribute('data-filename');

            Swal.fire({
                title: 'Yakin hapus file ini?',
                text: filename,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Buat form sementara untuk kirim request DELETE
                    let form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/backup/delete/' + filename;

                    // Tambahkan CSRF token
                    let csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);

                    // Tambahkan method spoofing untuk DELETE
                    let method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';
                    form.appendChild(method);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
</script>

@endsection
@endsection
