@extends('layout.main')
@section('css')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
@section('container')
<form action="{{ route('backup.processPartialRestore') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label class="form-label">Pilih Tabel</label>
        <select name="table_name" class="form-control" required>
            <option value="">-- Pilih Tabel --</option>
            @foreach($tableNames as $table)
                <option value="{{ $table }}">{{ $table }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Upload File SQL</label>
        <input type="file" name="sql_file" class="form-control" accept=".sql" required>
    </div>

    <button type="submit" class="btn btn-warning">
        <i class="ti ti-database-import"></i> Restore Data ke Tabel
    </button>
</form>

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
@endsection
