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
        <div class="pe-1 mb-2">
            <a href="#" class="btn btn-outline-light bg-white btn-icon me-1" data-bs-toggle="tooltip"
                data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh">
                <i class="ti ti-refresh"></i>
            </a>
        </div>
        <div class="pe-1 mb-2">
            <button type="button" class="btn btn-outline-light bg-white btn-icon me-1"
                data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Print"
                data-bs-original-title="Print">
                <i class="ti ti-printer"></i>
            </button>
        </div>
       <div class="mb-2">
            <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-effect="effect-scale" data-bs-toggle="modal" data-bs-target="#add_holiday"><i class="ti ti-square-rounded-plus me-2"></i>Hari Libur</a>
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
                    <tr >
                        <th class="bg-light-400">#</th>
                        <th class="bg-light-400">Keterangan</th>
                        <th class="bg-light-400">Tanggal</th>
                        <th class="bg-light-400">Deskripsi</th>
                        <th class="bg-light-400">Status</th>
                        <th class="bg-light-400">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><a href="#" class="link-primary">H752762</a></td>
                        <td>
                            Hari meperingati ulang tahun Asep
                        </td>
                        <td>01 Jan 2024</td>
                        <td>First day of the new year</td>
                        <td>
                            <span class="badge badge-soft-danger d-inline-flex align-items-center"><i class="ti ti-circle-filled fs-5 me-1"></i>
                                6 hari lagi
                            </span>
                        </td>
                        <td>
                            <div class="hstack gap-2 fs-15">
                                <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-soft-info rounded-pill"><i class="ti ti-pencil-minus"></i></a>
                                <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-soft-danger rounded-pill"><i class="ti ti-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><a href="#" class="link-primary">H752762</a></td>
                        <td>
                            New Year
                        </td>
                        <td>01 Jan 2024</td>
                        <td>First day of the new year</td>
                        <td>
                            <span class="badge badge-soft-success d-inline-flex align-items-center"><i class="ti ti-circle-filled fs-5 me-1"></i>
                                selesai
                            </span>
                        </td>
                        <td>
                            <div class="hstack gap-2 fs-15">
                                <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-soft-info rounded-pill"><i class="ti ti-pencil-minus"></i></a>
                                <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-soft-danger rounded-pill"><i class="ti ti-trash"></i></a>
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
                <h4 class="modal-title">Tambah Hari Libur</h4>
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
                                <label class="form-label">Keterangan</label>
                                <input type="text" class="form-control" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" class="form-control" name="date" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea rows="4" class="form-control" required name="description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</a>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
