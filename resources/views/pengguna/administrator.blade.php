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
        <div class="mb-2">
            <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-effect="effect-scale"
                data-bs-toggle="modal" data-bs-target="#add_holiday"><i
                    class="ti ti-square-rounded-plus me-2"></i>Tambah</a>
        </div>
    </div>
</div>
{{-- End Header --}}
<div class="card">
    <div class="card-header">
        <h4>Daftar {{ $title }}</h4>
    </div>
    <div class="card-body p-0 ">
        <div class="table-responsive">
            <table class="table table-nowrap mb-0">
                <thead>
                    <tr>
                        <th class="bg-light-400">#</th>
                        <th class="bg-light-400">Nama Lengkap</th>
                        <th class="bg-light-400">Email</th>
                        <th class="bg-light-400">Grup</th>
                        <th class="bg-light-400">Action</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1.</td>
                        <td>
                            Abdul
                        </td>
                        <td>abdul@gmail.com</td>
                        <td>GRUP 1</td>
                        <td>
                            <div class="hstack gap-2 fs-15">
                                <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-soft-info rounded-pill"><i
                                        class="ti ti-pencil-minus"></i></a>
                                <a href="javascript:void(0);"
                                    class="btn btn-icon btn-sm btn-soft-danger rounded-pill"><i
                                        class="ti ti-trash"></i></a>
                            </div>
                        </td>
                    </tr>

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
                <h4 class="modal-title"><span class="ti ti-pencil-plus"></span> Pengguna Administrator</h4>
                <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </button>
            </div>
            <form action="{{ route('userAdministratorAdd') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="title" required placeholder="Nama Lengkap">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <div class="input-icon mb-3 position-relative">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-mail"></i>
                                        </span>
                                        <input type="text" value="" class="form-control" placeholder="admin@mail.com">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kata Sandi</label>
                                    <div class="pass-group mb-3">
                                        <input type="password" class="pass-input form-control" placeholder="Masukan Kata Sandi">
                                        <span class="ti toggle-password ti-eye-off"></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Grup</label>
                                    <select name="grup" id="grup" class="select2 form-control">
                                        <option value="1">Administrator</option>
                                        <option value="2">Wali Kelas</option>
                                        <option value="3">Guru</option>
                                        <option value="3">Siswa</option>
                                    </select>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="submit" class="btn btn-primary w-100">Tambah</button>
            </form>
        </div>

    </div>
</div>
</div>

@endsection
