@extends('layout.main')
@section('css')
<style>
    
    .dropdown-menu {
        z-index: 1050; /* Atur z-index sesuai kebutuhan */
    }
</style>
@endsection
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

        <div class="pe-1 mb-2">
            <button type="button" class="btn btn-outline-light bg-white  me-1" onclick="history.back()">
                <i class="ti ti-arrow-left"></i> Kembali
            </button>
            <button type="button" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-primary">
                <i class="ti ti-plus"></i> Tambah Jam
            </button>
        </div>

    </div>
</div>
{{-- End Header --}}
<div class="card">
    <div class="card-header">
        <h3>Tabel Jam Pelajaran</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="table1">
            <thead class="thead-light">
                <tr>
                    <th class="border">#</th>
                    <th class="border" width="3%">Nama Hari</th>
                    <th class="border">Status</th>
                    <th class="border"Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no=1;
                @endphp
                @foreach ($data as $i )
                <tr>
                    <td class="border">{{ $no++ }}</td>
                    <td class="border">{{ $i->jam_ke }}</td>
                    <td class="border">
                        @if($i->status == 1)
                        <span class="badge badge-soft-success d-inline-flex align-items-center">
                            Aktif </span>
                        @else
                        <span class="badge badge-soft-danger d-inline-flex align-items-center">
                            Tidak Aktif </span>
                        @endif                     
                    </td>
                    <td class="border">
                            <a class="btn btn-icon btn-sm btn-soft-primary rounded-pill" data-bs-toggle="modal" href="#editModal-{{ $i->id }}" role="button"><i class="ti ti-list-details"></i></a>
                            <a class="btn btn-icon btn-sm btn-soft-danger rounded-pill"  href="{{ route('leasson.deletetime',$i->id) }}" role="button"><i class="ti ti-trash-x"></i></a>      
                    </td>
                </tr>                            
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@foreach ($data as $i )   

<div class="modal fade" id="editModal-{{ $i->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Ubah Jam Pelajaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-bs-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('leasson.updatetime') }}" method="POST">
                    @csrf
                    <input type="text" name="id" value="{{ $i->id }}" hidden>
                    <div class="form-group mb-3">
                        <label for="jamKe">Jam Ke</label>
                        <input type="number" class="form-control" id="jamKe" name="jam_ke" required value="{{ $i->jam_ke }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="jamMulai">Jam Mulai</label>
                        <input type="time" class="form-control" id="jamMulai" name="jam_mulai" required value="{{ $i->jam_mulai }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="jamBerakhir">Jam Berakhir</label>
                        <input type="time" class="form-control" id="jamBerakhir" name="jam_berakhir" required value="{{ $i->jam_berakhir }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="status">Status</label>
                        <select class="form-control select" id="status" name="status" required>
                            <option value="1" {{ $i->status == 1 ? 'selected' : '' }}>Aktif</option>
                            <option value="2" {{ $i->status == 2 ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Tambah Jam Pelajaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('leasson.addtime') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="jamKe">Jam Ke</label>
                        <input type="number" class="form-control" id="jamKe" name="jam_ke" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="jamMulai">Jam Mulai</label>
                        <input type="time" class="form-control" id="jamMulai" name="jam_mulai" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="jamBerakhir">Jam Berakhir</label>
                        <input type="time" class="form-control" id="jamBerakhir" name="jam_berakhir" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="status">Status</label>
                        <select class="form-control select" id="status" name="status" required>
                            <option value="1">Aktif</option>
                            <option value="2">Tidak Aktif</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Simpan Data</button>
                </form>
            </div>
        </div>
    </div>
</div>
@section('javascript')

@endsection
@endsection