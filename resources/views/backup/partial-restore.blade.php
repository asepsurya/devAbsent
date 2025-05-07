@extends('layout.main')
@section('css')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
@section('container')
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
</div>
<div class="bg-blue-50 border border-blue-300 text-blue-900 p-4 rounded-lg flex space-x-3 mb-3">
    <div >
        <p class="font-semibold mb-1">Petunjuk Penggunaan:</p>
        <ul class="list-disc list-inside text-sm space-y-1">
            <li class="flex items-start">
                <svg class="icon icon-tabler icon-tabler-table mr-1 mt-0.5 text-blue-500" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                    <rect x="4" y="4" width="16" height="16" rx="2" />
                    <line x1="4" y1="10" x2="20" y2="10" />
                    <line x1="10" y1="4" x2="10" y2="20" />
                </svg>
                Pilih <strong>tabel</strong> yang ingin Anda restore.
            </li>
            <li class="flex items-start">
                <svg class="icon icon-tabler icon-tabler-upload mr-1 mt-0.5 text-blue-500" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2" />
                    <polyline points="7 9 12 4 17 9" />
                    <line x1="12" y1="4" x2="12" y2="16" />
                </svg>
                Upload file <code>.sql</code> yang tabel yang download.
            </li>
            <li class="flex items-start">
                <svg class="icon icon-tabler icon-tabler-database mr-1 mt-0.5 text-blue-500" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                    <ellipse cx="12" cy="6" rx="8" ry="3" />
                    <path d="M4 6v6a8 3 0 0 0 16 0V6" />
                    <path d="M4 12v6a8 3 0 0 0 16 0v-6" />
                </svg>
                Klik tombol <strong>Restore</strong> untuk memulai proses pemulihan.
            </li>
        </ul>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('backup.processPartialRestore') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Pilih Tabel atau Data yang ingin anda restore</label>
                <select name="table_name" class="form-control select2" required>
                    <option value="">-- Pilih Tabel --</option>
                    @foreach($tableList as $table)
                        <option value="{{ $table }}">{{ $table }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload File SQL</label>
                <input type="file" name="sql_file" class="form-control" accept=".sql" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="ti ti-database-import"></i> Restore Data ke Tabel
            </button>
        </form>
    </div>
</div>

<center><a href="/backup/history">Kembali</a></center>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<script>
    $('.select2').select2();
</script>
@endsection
