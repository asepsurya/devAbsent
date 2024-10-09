@extends('layout.main')
@section('container')
{{-- header --}}
<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1">Data {{ $title }}</h3>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Beranda</a>
                </li>
                <li class="breadcrumb-item " aria-current="page">Pengguna</li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
        <div class="pe-1 mb-2">
            <a href="#" class="btn btn-outline-light bg-white btn-icon me-1" data-bs-toggle="tooltip"
                data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh">
                <i class="ti ti-refresh"></i>
            </a>
        </div>
        <div class="pe-1 mb-2">
            <button type="button" class="btn btn-outline-light bg-white btn-icon me-1" data-bs-toggle="tooltip"
                data-bs-placement="top" aria-label="Print" data-bs-original-title="Print">
                <i class="ti ti-printer"></i>
            </button>
        </div>

    </div>
</div>
{{-- End Header --}}
<div class="card">
    <div class="card-header">
        <h4>Daftar {{ $title }} ( Roles & Permissions List )</h4>
    </div>
    <div class="card-body p-0 ">
        <div class="table-responsive">
            <table class="table table-nowrap mb-0">
                <thead>
                    <tr>
                        <th class="bg-light-400">#</th>
                        <th class="bg-light-400">Nama Role</th>
                        <th class="bg-light-400">Created on</th>
                        <th class="bg-light-400">Action</th>

                    </tr>
                </thead>
                <tbody>
                    @php
                        $no=1;
                    @endphp
                    @foreach ( $roles as $item )

                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>
                           {{ $item->name }}
                        </td>
                        <td>{{ $item->created_at }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <a href="#" class="btn btn-outline-light bg-white btn-icon d-flex align-items-center justify-content-center rounded-circle  p-0 me-2" data-bs-toggle="modal" data-bs-target="#edit_role"><i class="ti ti-edit-circle text-primary"></i></a>
                                <a href="{{ route('usermodulesPermission') }}" class="btn btn-outline-light bg-white btn-icon d-flex align-items-center justify-content-center rounded-circle  p-0 me-2"><i class="ti ti-shield text-skyblue"></i></a>
                                <a href="#" class="btn btn-outline-light bg-white btn-icon d-flex align-items-center justify-content-center rounded-circle p-0 me-3" data-bs-toggle="modal" data-bs-target="#delete-modal"><i class="ti ti-trash-x text-danger"></i></a>
                                </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- modal tambah Hari Libur --}}
<div class="modal fade" id="add_holiday" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span class="ti ti-pencil-plus"></span> Ubah Kata Sandi</h4>
                <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </button>
            </div>
            <form action="holidays.html">
                <div class="modal-body">
                    <div class="row">
                        <form action="" method="post">
                            <div class="col-md-12">


                                <div class="mb-3">
                                    <label class="form-label">Modul</label>
                                    <div class="pass-group mb-3">
                                        <input type="text" class="pass-input form-control" placeholder="Masukan Kata Sandi">
                                        <span class="ti toggle-password ti-eye-off"></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <div class="pass-group mb-3">
                                        <input type="text" class="pass-input form-control" placeholder="Masukan Kata Sandi">
                                        <span class="ti toggle-password ti-eye-off"></span>
                                    </div>
                                </div>

                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100"><span class="ti ti-pencil-plus"></span> Ubah</button>
            </form>
        </div>

    </div>
</div>
</div>

@endsection
