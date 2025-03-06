@extends('layout.main')
@section('container')
@section('css')
<link rel="stylesheet" href="{{ asset('asset/css/DataTables.css') }}">
@endsection

{{-- header --}}
<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1"><span class="ti ti-user"></span> Data {{ $title }}</h3>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Beranda</a>
                </li>
                <li class="breadcrumb-item " aria-current="page">Akademik</li>
                <li class="breadcrumb-item " aria-current="page">Data Induk</li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
        <div class="pe-1 mb-2">
            <a href="#" class="btn btn-outline-light bg-white  me-1"
                data-bs-toggle="modal" data-bs-target="#import">
                <i class="ti ti-file-arrow-left "></i> Import
            </a>
        </div>
        <div class="dropdown me-2 mb-2">
            <a href="javascript:void(0);" class="dropdown-toggle btn btn-light fw-medium d-inline-flex align-items-center " data-bs-toggle="dropdown" >
                <i class="ti ti-file-export me-2"></i>Export
            </a>
            <ul class="dropdown-menu dropdown-menu-end p-3 " style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 41px);" data-popper-placement="bottom-end">
               
                <li>
                    <a href="javascript:void(0)" onclick="exportPDF()" class="dropdown-item rounded-1"><i class="ti ti-file me-2"></i>Export
                        as PDF</a>
                </li>
                <li>
                    <a href="{{ route('studentEksportExcel') }}" class="dropdown-item rounded-1"><i class="ti ti-file-spreadsheet me-2"></i>Export
                        as Excel </a>
                </li>
            </ul>
        </div>

        <div class="mb-2">
            <a href="{{ route('dataIndukStudentAddIndex') }}" class="btn btn-primary d-flex align-items-center"><i
                    class="ti ti-square-rounded-plus me-2"></i> Peserta Didik</a>
        </div>
    </div>
</div>
{{-- End Header --}}
{{-- Jika Terjadi Kesalahan --}}
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
        <h6 class="aletr-heading mb-0 text-fixed-white"><span class="ti ti-alert-triangle"></span> Laporan Kesalahan</h6>
        <button type="button" class="btn-close p-0 text-fixed-white" data-bs-dismiss="alert" aria-label="Close"><i
                class="fas fa-xmark"></i></button>
    </div>
    <hr class="my-0">
    <div class="p-3">
        <div>{{ $gagal }}</div>

    </div>
</div>
		@endif

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap pb-0">
        <h4 class="mb-3"><span class="ti ti-user"></span> Daftar {{ $title }}</h4>
        <div class="d-flex align-items-center flex-wrap">

        </div>
    </div>
    <div class="card-body p-0 ">

        <div class="table-responsive ">
            <table class="table no-footer stripe hover " id="myTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th></th>
                        <th>NIS</th>
                        <th>Nama Peserta Didik</th>
                        <th>Jenis Kelamin</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Rombongan Belajar</th>
                        <th>Status</th>
                        <th>Tanggal Masuk</th>
                    </tr>
                </thead>
            </table>
        </div>


    </div>
</div>
@foreach ($students as $item )

<div class="modal  fade effect-super-scaled " id="delete-modal-{{ $item->id }}" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="students.html">
                <div class="modal-body text-center">
                    <span class="avatar avatar-xl bg-danger-transparent me-2 my-3 ">
                        <i class="ti ti-trash-x fs-1" ></i>
                    </span>
                    <h4>Konfirmasi Penghapusan? </h4>
                    <p>
                        Anda ingin menghapus semua item yang ditandai. Ini tidak dapat dibatalkan setelah dihapus.</p>
                    <div class="d-flex justify-content-center">
                        <a href="javascript:void(0);" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</a>
                        <a href="{{ route('studentDelete',$item->nis) }}" type="submit" class="btn btn-danger">Ya, Hapus</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<div class="modal fade effect-sign " id="import" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered text-center" role="document">
        <div class="modal-content modal-content-demo">

            <div class="modal-header">
                <h4 class="modal-title">Import Data Peserta Didik</h4><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal"></button>
            </div>
            <div class="alert alert-primary overflow-hidden p-0 m-2" role="alert">
                <div class="p-3 bg-primary text-fixed-white d-flex justify-content-between">
                    <h6 class="aletr-heading mb-0 text-fixed-white">Informasi Singkat</h6>

                </div>

                <div class="p-2" align="left">
                    <p class="my-1">Berikut ini informasi yang harus diperhatikan :</p>
                    <p class="my-1 mx-2">1. Untuk Contoh Format Dokumen anda bisa download di link ini. <a href="{{ asset('asset/import_sample/Data Siswa Sample.xlsx') }}" target="_blank" rel="noopener noreferrer"> Download </a> </p>
                    <p class="my-1 mx-2">2. File yang di Import Harus bertype .xlsx atau type file Excel</p>

                </div>
            </div>
            <form id="fileUploadForm" action="{{ route('studentImport') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body text-start">
                    <input type="file" name="file" class="form-control" required>


                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary w-100"><span class="ti ti-cloud-upload"></span> Import Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('javascript')
<script src="{{ asset('asset/js/DataTables.js') }}"></script>

<script>
    function exportPDF() {
        window.open("{{ route('export.students') }}", '_blank');
    }
</script>

<script>
    $(function() {
        var table = new DataTable('#myTable', {
            layout:{
                topEnd:{
                    search:{
                        placeholder:'Search...',
                        text:'_INPUT_'
                    }
                }
            },
            processing: true,
            order: [[1, 'desc']],
            serverSide: true,
            ajax: '{!! route('dataIndukStudent') !!}', // memanggil route yang menampilkan data json
            columns: [
                { // mengambil & menampilkan kolom sesuai tabel database
                    data: 'DT_RowIndex',
                    sortable: false,
                    target:[1],
                    searchable:false,
                    name: 'DT_RowIndex'
                },
                {
                    data: 'id',
                    sortable: false,
                    render: function(data, type, row, meta){
                        if(type === 'display'){
                            data = '<div class="hstack gap-2 fs-15">'+
                                '<a  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Cetak Kartu Siswa" href="/akademik/datainduk/studentcard?data='+data+'" target="_BLANK" class="btn btn-icon btn-sm btn-soft-success rounded-pill"><i class="ti ti-cards"></i></a>'+
                                '<a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit" href="/akademik/datainduk/studentEdit/'+data+'"  class="btn btn-icon btn-sm btn-soft-info rounded-pill">'+
                                    '<i class="ti ti-pencil-minus"></i></a>'+
                                '<a  data-bs-toggle="modal" data-bs-target="#delete-modal-'+data+'" class="btn btn-icon btn-sm btn-soft-danger rounded-pill" data-bs-toggle="tooltip" title="Delete"><i class="ti ti-trash"></i></a>'+
                            '</div>'

                        }
                        return data;
                    },
                    targets: -1
                 },
                {
                    data: 'nis',
                    name: 'nis'
                },
                {
                    data: 'nama',
                    render: function(data, type, row, meta) {
                        let avatarImage = ''; // Initialize the avatar image HTML

                        // Check if there is a valid 'gambar' or not
                        if (row.foto && row.foto !== '') {
                            avatarImage = '<img src="/storage/' + row.foto + '" class="img-fluid rounded-circle" alt="foto">';
                        } else {
                               // If no custom image exists, use initials as avatar
                                // Split the name into initials
                                let initials = data.split(' ').map(word => word.charAt(0).toUpperCase()).join('');

                                // Create a circle with the initials inside
                                avatarImage = '<div class="avatar avatar-md" style="background-color: #506ee4; display: flex; justify-content: center; align-items: center; border-radius: 50%;">' +
                                                '<span style="color: white; font-size: 10px; font-weight: bold;">' + initials + '</span>' +
                                            '</div>';
                        }

                        // Build and return the complete HTML for the column
                        return '<div class="d-flex align-items-center">' +
                                '<a href="#" class="avatar avatar-md">' +
                                    avatarImage +
                                '</a>' +
                                '<div class="ms-2">' +
                                    '<p class="mb-0">' + data + '</p>' +
                                '</div>' +
                            '</div>';
                    }
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
                    data: 'rombel',
                    render:function(data){
                    if(data){
                        data = data
                    }else{
                        data = 'belum disetel'
                    }
                    return data;
                    }
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
</script>

{{-- <script>
    function myFunction() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[3];
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

@endsection
@endsection
