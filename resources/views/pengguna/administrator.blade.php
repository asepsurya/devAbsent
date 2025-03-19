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
  
</div>
{{-- End Header --}}
<div class="card">
    <div class="card-header">
        <h4>Daftar {{ $title }}</h4>
    </div>
    <div class="card-body p-0 ">
        <div class="table-responsive">
            <table class="table table-nowrap mb-0" id="myTable">
                <thead>
                    <tr>
                        <th class="bg-light-400">#</th>
                        <th class="bg-light-400">Nama</th>
                        <th class="bg-light-400">Username</th>
                        <th class="bg-light-400">Action</th>

                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($userAdmin as $item )
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->email}}</td>
                        <td>
                            <div class="hstack gap-2 fs-15">
                                <div class="d-flex align-items-center">
                                    <a data-bs-toggle="modal" data-bs-target="#add_holiday-{{ $item->id }}" class="btn btn-outline-light bg-white btn-icon d-flex align-items-center justify-content-center rounded-circle  p-0 me-2" data-bs-toggle="modal" data-bs-target="#edit_role"><i class="ti ti-edit-circle text-primary"></i></a>
                                    <a data-bs-toggle="modal" data-bs-target="#edit_role-{{ $item->id }}" class="btn btn-outline-light bg-white btn-icon d-flex align-items-center justify-content-center rounded-circle  p-0 me-2"><i class="ti ti-shield text-skyblue"></i></a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>@foreach ($userAdmin as $item )
{{-- modal tambah Hari Libur --}}
<div class="modal fade" id="add_holiday-{{ $item->id }}" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span class="ti ti-pencil-plus"></span> Ubah Kata Sandi</h4>
                <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </button>
            </div>
            <form action="{{ route('changePassword') }}" method="POST">
                @csrf
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" name="id" value="{{ $item->id }}" hidden>

                            <div class="mb-3">
                                <label class="form-label">Kata Sandi</label>
                                <div class="pass-group mb-3">
                                    <input type="password" class="pass-input form-control" placeholder="Masukan Kata Sandi" name="password">
                                    <span class="ti toggle-password ti-eye-off"></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ulangi Kata Sandi</label>
                                <div class="pass-group mb-3">
                                    <input type="password" class="pass-input form-control" placeholder="Masukan Kata Sandi" name="cpassword">
                                    <span class="ti toggle-password ti-eye-off"></span>
                                </div>
                            </div>

                        </div>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100"><span class="ti ti-pencil-plus"></span> Ubah</button>
                </div>
                </form>
        </div>

    </div>
</div>
@endforeach
@foreach ($userAdmin as $item )
{{-- modal tambah Hari Libur --}}
<div class="modal fade" id="edit_role-{{ $item->id }}" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span class="ti ti-pencil-plus"></span> Ubah Role Pengguna</h4>
                <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </button>
            </div>
            <form action="{{ route('changeRole') }}" method="POST">
                @csrf
    
                <div class="modal-body">
                    <input type="text" name="id" value="{{ $item->id }}" hidden>
                    <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Role Pengguna Aplikasi</label>
                                    <select name="role"  class="select">
                                        <option value="4" {{ $item->role == 'admin' ?'selected': '' }}>Administrator</option>
                                        <option value="1" {{ $item->role == 'walikelas' ?'selected': '' }}>Walikelas</option>
                                        <option value="2"{{ $item->role == 'guru' ?'selected': '' }}>Guru Pengajar</option>
                                        <option value="3"{{ $item->role == 'siswa' ?'selected': '' }}>Siswa</option>
                                    </select>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100"><span class="ti ti-pencil-plus"></span> Ubah</button>
                </div>
                </form>
        </div>
    </div>
</div>

@endforeach


@endsection
