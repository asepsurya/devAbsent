@extends('layout.main')
@section('container')
@section('css')
<link rel="stylesheet" href="{{ asset('asset/css/DataTables.css') }}">
@endsection
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
        <h4>Daftar {{ $title }}</h4>
    </div>
    <div class="card-body p-0 ">
        <div class="p-2">
            @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show custom-alert-icon shadow-sm d-flex align-items-centers m-3" role="alert">
                        <i class="feather-alert-octagon flex-shrink-0 me-2"></i>
                        {!! implode('', $errors->all('<div>:message</div>')) !!}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="fas fa-xmark"></i></button>
                    </div>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table table-nowrap mb-0" id="myTable">
                <thead>
                    <tr>
                        <th class="bg-light-400">#</th>
                        <th class="bg-light-400">NIK / No. KITAS (Untuk WNA)</th>
                        <th class="bg-light-400">Nama Lengkap</th>
                        <th class="bg-light-400">Status</th>
                        <th class="bg-light-400">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@foreach ($gtks as $item )
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
@foreach ($gtks as $item )
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
            <form action="{{ route('changePassword') }}" action="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <form action="" method="post">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Role Pengguna Aplikasi</label>
                                    <select name="role"  class="select">
                                        <option value="admin" {{ $item->role == 'admin' ?'selected': '' }}>Administrator</option>
                                        <option value="walikelas" {{ $item->role == 'walikelas' ?'selected': '' }}>Walikelas</option>
                                        <option value="guru"{{ $item->role == 'guru' ?'selected': '' }}>Guru Pengajar</option>
                                        <option value="siswa"{{ $item->role == 'siswa' ?'selected': '' }}>Siswa</option>
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

@section('javascript')
<script src="{{ asset('asset/js/DataTables.js') }}"></script>
<script>
    $(function() {
        var table = new DataTable('#myTable', {
            layout:{
                topEnd:{
                    search:{
                        placeholder:'Search',
                        text:'<span class="ti ti-search"></span> _INPUT_'
                    }
                }
            },
            processing: true,
            order: [[1, 'desc']],
            serverSide: true,
            ajax: '{!! route('useremployeesIndex') !!}', // memanggil route yang menampilkan data json
            columns: [

                { // mengambil & menampilkan kolom sesuai tabel database
                    data: 'DT_RowIndex',
                    sortable: false,
                    target:[1],
                    searchable:false,
                    name: 'DT_RowIndex'
                },

                {
                    data: 'nomor',
                    name: 'nomor'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },

                {
                    data: 'status',
                    render:function(data){
                    if(data === '2'){
                        data = '<span class="badge badge-soft-success d-inline-flex align-items-center">Aktif</span>'
                    }else{
                        data = '<span class="badge badge-soft-danger d-inline-flex align-items-center">Tidak Aktif</span>'
                    }
                    return data;
                   }
                },
                {
                    data: 'id',
                    sortable: false,
                    render: function(data, type, row, meta){
                        if(type === 'display'){
                            data =
                            '<div class="d-flex align-items-center">'+
                            '<a data-bs-toggle="modal" data-bs-target="#add_holiday-'+ data +'" class="btn btn-outline-light bg-white btn-icon d-flex align-items-center justify-content-center rounded-circle  p-0 me-2" data-bs-toggle="modal" data-bs-target="#edit_role"><i class="ti ti-edit-circle text-primary"></i></a>'+
                            '<a data-bs-toggle="modal" data-bs-target="#edit_role-'+ data +'" class="btn btn-outline-light bg-white btn-icon d-flex align-items-center justify-content-center rounded-circle  p-0 me-2"><i class="ti ti-shield text-skyblue"></i></a>'+
                             '</div>'
                        }
                        return data;
                    },
                    targets: -1
                 },


            ]
        });


    });
</script>
@endsection
@endsection
