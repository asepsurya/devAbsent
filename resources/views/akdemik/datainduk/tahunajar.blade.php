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
                <li class="breadcrumb-item active" aria-current="page">Tahun Pelajaran</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
       <div class="mb-2">
            <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-effect="effect-scale" data-bs-toggle="modal" data-bs-target="#add_tahunAjar"><i class="ti ti-square-rounded-plus me-2"></i>Tambah Tahun Pelajaran</a>
            </div>
    </div>
</div>
{{-- End Header --}}
<div class="card">
    <div class="card-header">
        <h4>Tahun Ajaran</h4>
    </div>
    <div class="card-body p-0 ">
        <div class="table-responsive">
            <table class="table table-nowrap mb-0">
                <thead>
                    <tr >
                        <th class="bg-light-400">#</th>
                        <th class="bg-light-400">Tahun Pelajaran</th>
                        <th class="bg-light-400">Semester</th>
                        <th class="bg-light-400">Status</th>
                        <th class="bg-light-400">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no=1;
                    @endphp
                    @foreach ($tahunAjar as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->tahun_pelajaran }}</td>
                        <td>{{ $item->semester }}</td>
                        <td>
                            @if ($item->status ==  1)
                            <span class="badge badge-soft-success d-inline-flex align-items-center"><i class="ti ti-circle-filled fs-5 me-1"></i>
                               Aktif
                            </span>
                            @else
                            <span class="badge badge-soft-danger d-inline-flex align-items-center"><i class="ti ti-circle-filled fs-5 me-1"></i>
                                Tidak Aktif
                             </span>
                            @endif

                        </td>
                        <td>
                            <div class="hstack gap-2 fs-15">
                                <a data-bs-toggle="modal" data-bs-target="#edit_tahunAjar-{{ $item->id }}" class="btn btn-icon btn-sm btn-soft-info rounded-pill"><i class="ti ti-pencil-minus"></i></a>
                                <a href="{{ route('dataIndukTahunajarDelete',$item->id) }}" class="btn btn-icon btn-sm btn-soft-danger rounded-pill"><i class="ti ti-trash"></i></a>
                            </div>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- modal tambah tahun Ajar --}}
<div class="modal fade" id="add_tahunAjar" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span class="ti ti-pencil-plus"></span> Tambah Tahun Pelajaran</h4>
                <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </button>
            </div>
            <form action="{{ route('dataIndukTahunajarAdd') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Tahun Pelajaran</label>
                                <input type="text" class="form-control" name="tahun_pelajaran" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Semester</label>
                                <select name="semester"  class="form-control select" required>
                                    <option value="Ganjil">Ganjil</option>
                                    <option value="Genap">Genap</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control select" required>
                                    <option value="1">Aktif</option>
                                    <option value="2">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</a>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- modal Edit tahun Ajar --}}
@foreach ($tahunAjar as $item )
<div class="modal fade" id="edit_tahunAjar-{{ $item->id }}" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span class="ti ti-pencil"></span>Edit Tahun Pelajaran</h4>
                <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </button>
            </div>
            <form action="{{ route('dataIndukTahunajarUpdate') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" name="id" value="{{ $item->id }}" hidden>
                            <div class="mb-3">
                                <label class="form-label">Tahun Pelajaran</label>
                                <input type="text" class="form-control" name="tahun_pelajaran" required value="{{ $item->tahun_pelajaran }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Semester</label>
                                <select name="semester"  class="form-control select" required >
                                    <option value="Ganjil"@if($item->semester == 'Ganjil') Selected @endif>Ganjil</option>
                                    <option value="Genap" @if($item->semester == 'Genap') Selected @endif>Genap</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control select" required>
                                    <option value="1" @if($item->status == '1') Selected @endif>Aktif</option>
                                    <option value="2" @if($item->status == '2') Selected @endif>Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection
