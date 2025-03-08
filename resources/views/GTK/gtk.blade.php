@extends('layout.main')
@section('container')
@section('css')
<link rel="stylesheet" href="{{ asset('asset/css/DataTables.css') }}">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.0/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.0/dist/sweetalert2.all.min.js"></script>
@endsection
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
            <div class="pe-1 mb-2 mt-2">
                <button type="button" class="btn btn-outline-light bg-white  me-1" data-bs-toggle="modal" data-bs-target="#gtkModal">
                    <i class="ti ti-printer"></i> Cetak Kartu
                </button>
            </div>
        </div>
        <div class="pe-1 mb-2">
            <a href="#" class="btn btn-outline-light bg-white  me-1" data-bs-toggle="modal" data-bs-target="#import">
                <i class="ti ti-file-arrow-left "></i> Import
            </a>
        </div>
        <div class="dropdown me-2 mb-2">
            <a href="javascript:void(0);" class="dropdown-toggle btn btn-light fw-medium d-inline-flex align-items-center"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ti ti-file-export me-2"></i>Export
            </a>
            <ul class="dropdown-menu dropdown-menu-end p-3" style="">
                <li>
                    <a href="javascript:void(0)" onclick="exportPDF()" class="dropdown-item rounded-1"><i class="ti ti-file-type-pdf me-2"></i>Export
                        as PDF</a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-file-type-xls me-2"></i>Export
                        as Excel </a>
                </li>
            </ul>
        </div>
        <div class="mb-2">
            <a href="{{ route('GTKaddIndex') }}" class="btn btn-primary d-flex align-items-center" data-bs-effect="effect-scale"
                ><i
                    class="ti ti-square-rounded-plus me-2"></i>Tambah Data</a>
        </div>
    </div>
</div>
@if($errors->any())
<div class="alert alert-warning overflow-hidden p-0" role="alert">
    <div class="p-3 bg-warning text-fixed-white d-flex justify-content-between">
        <h6 class="aletr-heading mb-0 text-fixed-white"><span class="ti ti-alert-triangle"></span> Laporan Kesalahan</h6>
        <button type="button" class="btn-close p-0 text-fixed-white" data-bs-dismiss="alert" aria-label="Close"><i
                class="fas fa-xmark"></i></button>
    </div>
    <hr class="my-0">
    <div class="p-3">
        @foreach ($errors->all() as $error)
        <div>{{ $error }}</div>
        @endforeach
    </div>
</div>
@endif

@if ($gagal = Session::get('gagal'))
<div class="alert alert-danger overflow-hidden p-0" role="alert">
    <div class="p-3 bg-danger text-fixed-white d-flex justify-content-between">
        <h6 class="aletr-heading mb-0 text-fixed-white"><span class="ti ti-alert-triangle"></span> Laporan Kesalahan
        </h6>
        <button type="button" class="btn-close p-0 text-fixed-white" data-bs-dismiss="alert" aria-label="Close"><i
                class="fas fa-xmark"></i></button>
    </div>
    <hr class="my-0">
    <div class="p-3">
        <div>{{ $gagal }}</div>

    </div>
</div>
@endif
@if ($sukses = Session::get('sukses'))
<div class="alert alert-success overflow-hidden p-0" role="alert">
    <div class="p-3 bg-success text-fixed-white d-flex justify-content-between">
        <h6 class="aletr-heading mb-0 text-fixed-white"><span class="ti ti-alert-triangle"></span> Laporan Kesalahan
        </h6>
        <button type="button" class="btn-close p-0 text-fixed-white" data-bs-dismiss="alert" aria-label="Close"><i
                class="fas fa-xmark"></i></button>
    </div>
    <hr class="my-0">
    <div class="p-3">
        <div>{{ $sukses }}</div>

    </div>
</div>
@endif
{{-- End Header --}}
<div class="card">

    <div class="card-body p-0 ">
        <div class="table-responsive">
            <table class="table table-nowrap mb-0" id="myTable">
                <thead class="thead-light">
                    <tr>

                        <th width="1%"></th>
                        <th>#</th>
                        <th>NIK / No. KITAS (Untuk WNA)</th>
                        <th>Nama Lengkap</th>

                        <th>Gender</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Status</th>
                        <th>TMT</th>

                    </tr>
                </thead>
            </table>

        </div>

    </div>
</div>

<div class="modal fade effect-sign " id="import" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered text-center" role="document">
        <div class="modal-content modal-content-demo">

            <div class="modal-header">
                <h4 class="modal-title"><span class="ti ti-file"></span> Import Data Guru dan Tenaga Kependidikan</h4><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal"></button>
            </div>
            <div class="alert alert-primary overflow-hidden p-0 m-2" role="alert">
                <div class="p-3 bg-primary text-fixed-white d-flex justify-content-between">
                    <h6 class="aletr-heading mb-0 text-fixed-white">Informasi Singkat</h6>

                </div>

                <div class="p-2" align="left">
                    <p class="my-1">Berikut ini informasi yang harus diperhatikan :</p>
                    <p class="my-1 mx-2">1. Untuk Contoh Format Dokumen anda bisa download di link ini. <a href="{{ asset('asset/import_sample/Data Guru.xlsx') }}" target="_blank" rel="noopener noreferrer"> Download </a> </p>
                    <p class="my-1 mx-2">2. File yang di Import Harus bertype .xlsx atau type file Excel</p>

                </div>
            </div>
            <form id="fileUploadForm" action="{{ route('GTKimport') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body text-start">
                    <label for="file" class="form-label">Pilih File</label>
                    <input type="file" name="file"  id="file" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary w-100"><span class="ti ti-cloud-upload"></span> Import Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach ($gtk as $item)

<div class="modal fade" id="delete-modal-{{ $item->nik }}" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="students.html">
                <div class="modal-body text-center">
                    <span class="avatar avatar-xl bg-danger-transparent me-2 my-3 ">
                        <i class="ti ti-trash-x fs-1" ></i>
                    </span>
                    <h4>Confirm Deletion</h4>
                    <p>You want to delete all the marked items, this cant be undone once you delete.</p>
                    <div class="d-flex justify-content-center">
                        <a href="javascript:void(0);" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</a>
                        <a href="{{ route('GTKdelete',$item->nik) }}" type="submit" class="btn btn-danger">Yes, Delete</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@include('GTK.gtkAction.modalcard')
@endforeach
@section('javascript')

<script src="{{ asset('asset/js/DataTables.js') }}"></script>

<script>
    function exportPDF() {
        window.open("{{ route('export.gtks') }}", '_blank');
    }
</script>

<script>
    $(function() {
        var table = new DataTable('#myTable', {
            layout:{
                topEnd:{
                    search:{
                        placeholder:'',
                        text:'<span class="ti ti-search"></span> _INPUT_'
                    }
                }
            },
            processing: true,
            order: [[1, 'desc']],
            serverSide: true,
            ajax: '{!! route('GTKall') !!}', // memanggil route yang menampilkan data json
            columns: [
                {
                    data: 'id',

                    sortable: false,
                    render: function(data, type, row, meta){
                        if(type === 'display'){
                            data =
                            '<div class="d-flex align-items-center">'+
                            '<a href="#" class="btn btn-outline-light bg-white btn-icon d-flex align-items-center justify-content-center rounded-circle  p-0 me-2"><i class="ti ti-printer"></i></a>'+
                            '<a  href="https://wa.me/'+row.telp+'" target="_blank" class="btn btn-outline-light bg-white btn-icon d-flex align-items-center justify-content-center rounded-circle  p-0 me-2"><i class="ti ti-brand-whatsapp"></i></a>'+


                            '<div class="dropdown">'+
                                '<a href="#" class="btn btn-white btn-icon btn-sm d-flex align-items-center justify-content-center rounded-circle p-0" data-bs-toggle="dropdown" aria-expanded="false">'+
                                    '<i class="ti ti-dots-vertical fs-14"></i>'+
                                    '</a>'+
                            '<ul class="dropdown-menu dropdown-menu-right p-3" style="">'+
                                '<li>'+
                                    '<a class="dropdown-item rounded-1" href="/gtk/cetak?data='+row.id+'" target="_BLANK" ><i class="ti ti-menu me-2"></i>Cetak Kartu</a>'+
                                    '</li>'+
                                 '<li>'+
                                    '<a class="dropdown-item rounded-1" href="/gtk/update/'+ row.id +'" ><i class="ti ti-menu me-2"></i>Edit</a>'+
                                    '</li>'+
                                    '<li>'+
                                        '<a class="dropdown-item rounded-1" href="#" data-bs-toggle="modal" data-bs-target="#delete-modal-'+row.nik+'"><i class="ti ti-trash-x me-2"></i>Delete</a>'+
                                     '</li>'+
                            '</ul></div>'+
                             '</div>'

                        }
                        return data;
                    },
                    targets: -1
                 },
                { // mengambil & menampilkan kolom sesuai tabel database
                    data: 'DT_RowIndex',
                    sortable: false,
                    target:[1],
                    searchable:false,
                    name: 'DT_RowIndex'
                },

                {
                    data: 'nik',
                    name: 'nik'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'gender',
                    render: function(data, type, row, meta){
                        if(data === 'L'){
                            data = 'Laki - Laki'
                        }else{
                            data = 'Perempuan'
                        }
                        return data;
                    },
                    targets: -1
                },
                {
                    data: 'tempat_lahir',
                    name: 'tempat_lahir'
                },
                {
                    data: 'tanggal_lahir',
                    name: 'tanggal_lahir'
                },

                {
                    data: 'status',
                    render:function(data){
                    if(data === '1'){
                        data = '<span class="badge badge-soft-success d-inline-flex align-items-center">Aktif</span>'
                    }else{
                        data = '<span class="badge badge-soft-danger d-inline-flex align-items-center">Tidak Aktif</span>'
                    }
                    return data;
                   }
                },
                {
                    data: 'tanggal_masuk',
                    render:function(data){
                    if(data){
                        data = data
                    }else{
                        data = 'Belum disetel'
                    }
                    return data;
                   }
                },




            ]
        });


    });

    $(function() {
        var table = new DataTable('#tabelguru', {
            layout:{
                topEnd:{
                    search:{
                        placeholder:'',
                        text:'<span class="ti ti-search"></span> _INPUT_'
                    }
                }
            },
            processing: true,
            order: [[1, 'desc']],
            serverSide: true,
            ajax: '{!! route('GTKall') !!}', // memanggil route yang menampilkan data json
            columns: [

                 { // Checkbox column to select rows
                            data: 'id',
                            sortable: false,
                            searchable: false,
                            render: function(data, type, row, meta) {
                                return '<div class="form-check form-check-md"><input type="checkbox" name="id[]" class="select-row form-check-input" value="'+ row.id +'"></div>';
                            },
                            targets: 0
                        },

                {
                    data: 'nik',
                    name: 'nik'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'gender',
                    render: function(data, type, row, meta){
                        if(data === 'L'){
                            data = 'Laki - Laki'
                        }else{
                            data = 'Perempuan'
                        }
                        return data;
                    },
                    targets: -1
                },





            ]
        });


    });
</script>
{{-- <script>
    function myFunction() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[2];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
</script> --}}

<script>
    function detailssubmit() {
            alert("Your details were Submitted");
        }
        function onlyNumberKey(evt) {

            // Only ASCII character in that range allowed
            let ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }
</script>
@endsection
@endsection
