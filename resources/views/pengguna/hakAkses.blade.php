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
                <li class="breadcrumb-item " aria-current="page">pengguna</li>
                <li class="breadcrumb-item active" aria-current="page">Hak Akses</li>
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
        <h4>Hak Akses</h4>
        <p>Hak akses modul untuk administrator</p>
    </div>
    <div class="card-body p-0 ">
        <div class="table-responsive">
            <table class="table table-nowrap mb-0">
                <thead>
                    <tr>
                        <th class="bg-light-400">#</th>
                        <th class="bg-light-400">Modul</th>
                        <th class="bg-light-400">Keterangan</th>
                        <th class="bg-light-400">URL</th>
                        <th class="bg-light-400">Action</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1.</td>
                        <td>
                           Guru dan Tenaga Kependidikan 
                        </td>
                        <td>Guru dan Tenaga Kependidikan</td>
                        <td>https://seller.shopee.co.id/portal/settings/shop/profile</td>
                        <td>
                            <div class="hstack gap-2 fs-15">
                                <a data-bs-toggle="modal" data-bs-target="#add_holiday" class="btn btn-icon btn-sm btn-soft-info rounded-pill"><i
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