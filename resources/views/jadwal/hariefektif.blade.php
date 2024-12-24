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
                    <th class="border" width="1%">#</th>
                    <th class="border">Nama Hari</th>
                    <th class="border">Status</th>
                    <th class="border">Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no=1;
                @endphp
                @foreach ($data as $i )
                <tr>
                    <td class="border">{{ $no++ }}</td>
                    <td class="border">
                        @switch($i->id_hari)
                            @case(1)
                                Senin
                                @break
                            @case(2)
                                Selasa
                                @break
                            @case(3)
                                Rabu
                                @break
                            @case(4)
                                Kamis
                                @break
                            @case(5)
                                Jumat
                                @break
                            @case(6)
                                Sabtu
                                @break
                            @case(7)
                                Minggu
                                @break
                            @default
                                Tidak Diketahui
                        @endswitch
                    </td>
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
                            <a class="btn btn-icon btn-sm btn-soft-danger rounded-pill"  href="{{ route('leasson.delete',$i->id) }}" role="button"><i class="ti ti-trash-x"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@foreach ($data as $setelanHari )

<div class="modal fade" id="editModal-{{ $setelanHari->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Ubah Jam Pelajaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-bs-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('leasson.update') }}" method="POST">
                    @csrf
                    @method('POST')
                    <input type="text" name="id" id="id" value="{{ $setelanHari->id }}" hidden>
                    <div class="form-group mb-3">
                        <label for="id_hari">Pilih Hari</label>
                        <select name="id_hari"  class="form-control select" required>
                            <option value="">-- Pilih Hari --</option>
                            <option value="1" {{ $setelanHari->id_hari == 1 ? 'selected' : '' }}>Senin</option>
                            <option value="2" {{ $setelanHari->id_hari == 2 ? 'selected' : '' }}>Selasa</option>
                            <option value="3" {{ $setelanHari->id_hari == 3 ? 'selected' : '' }}>Rabu</option>
                            <option value="4" {{ $setelanHari->id_hari == 4 ? 'selected' : '' }}>Kamis</option>
                            <option value="5" {{ $setelanHari->id_hari == 5 ? 'selected' : '' }}>Jumat</option>
                            <option value="6" {{ $setelanHari->id_hari == 6 ? 'selected' : '' }}>Sabtu</option>
                            <option value="7" {{ $setelanHari->id_hari == 7 ? 'selected' : '' }}>Minggu</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="status">Status</label>
                        <select class="form-control select"  name="status" required>
                            <option value="1" {{ $setelanHari->status == 1 ? 'selected' : '' }}>Aktif</option>
                            <option value="2" {{ $setelanHari->status == 2 ? 'selected' : '' }}>Tidak Aktif</option>
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
                <form action="{{ route('leasson.add') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="jamKe">Pilih Hari</label>
                       <select name="id_hari" id="id_hari" class="select">
                        <option value="">-- Pilih Hari --</option>
                            <option value="1">Senin</option>
                            <option value="2">Selasa</option>
                            <option value="3">Rabu</option>
                            <option value="4">Kamis</option>
                            <option value="5">Jumat</option>
                            <option value="6">Sabtu</option>
                            <option value="7">Minggu</option>

                       </select>
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
