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
        <h4 class="mb-3"> Siswa yang sudah Lulus</h4>
        <div class="d-flex align-items-center flex-wrap mb-2">
            <div class="d-flex me-3">
                <label for="kelasFilter" class="me-2">Filter by Kelas:</label>
                <input type="text" id="kelasFilter" placeholder="Search Kelas" class="form-control">
            </div>
            <div class="d-flex ms-2">
                <label for="tahunLulusFilter" class="me-2">Filter by Tahun Lulus:</label>
                <input type="text" id="tahunLulusFilter" placeholder="Search Tahun Lulus" class="form-control">
            </div>
        </div>
    </div>
    <div class="card-body p-0 ">

        <div class="table-responsive ">
            <table class="table no-footer stripe hover " id="myTable">
                <thead>
                    <tr>
                        <th>#</th>
                    
                        <th>NIS</th>
                        <th>Nama Peserta Didik</th>
                        <th>Jenis Kelamin</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Rombongan Belajar</th>
                        <th>Status</th>
                        <th>Tahun</th>
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

@section('javascript')
<script src="{{ asset('asset/js/DataTables.js') }}"></script>
<!-- Custom Script -->

<script>
    function exportPDF() {
        window.open("{{ route('export.students') }}", '_blank');
    }
</script>
<script>
   $(document).ready(function() {
    // Hancurkan instance DataTable yang ada sebelumnya jika ada
    if ($.fn.dataTable.isDataTable('#myTable')) {
        $('#myTable').DataTable().destroy();
    }

    // Memanggil AJAX sekali untuk mendapatkan data
    $.ajax({
        url: '{!! route('dataIndukStudentlulusan') !!}', // Pastikan URL ini mengembalikan JSON
        type: 'GET',
        dataType: 'json',
        success: function(response) {
    
            // Data untuk tabel kedua (myTable)
            var table = $('#myTable').DataTable({
                data: response.data,  // data dari AJAX response
                processing: true,
                order: [[1, 'desc']],
                columns: [
                    {
                        data: 'DT_RowIndex',
                        sortable: false,
                        target: [1],
                        searchable: false,
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nis',
                        name: 'nis'
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
                        data: 'rombel',
                        render: function(data) {
                            return data ? data : 'belum disetel';
                        }
                    },
                    {
                        data: 'status',
                        render: function(data) {
                            if(data === '1'){
                                return '<span class="badge badge-soft-success d-inline-flex align-items-center">Aktif</span>';
                            } else if(data === '3'){
                                return '<span class="badge badge-soft-success d-inline-flex align-items-center">Lulus</span>';
                            } else {
                                return '<span class="badge badge-soft-danger d-inline-flex align-items-center">Tidak Aktif</span>';
                            }
                        }
                    },
                    {
                        data: 'tahun_lulus',
                        render: function(data) {
                            return data ? data : 'Belum disetel';
                        }
                    }
                ]
            });

            // Apply filter for Kelas
            $('#kelasFilter').on('keyup change', function() {
                table.columns(6).search(this.value).draw(); // Apply filter to the "rombel" column (assumed to be index 6)
            });

            // Apply filter for Tahun Lulus
            $('#tahunLulusFilter').on('keyup change', function() {
                table.columns(8).search(this.value).draw(); // Apply filter to the "tahun_lulus" column (assumed to be index 8)
            });

        },
        error: function(xhr, status, error) {
            console.error("Error fetching data: " + error);
        }
    });
});

</script>

@endsection
@endsection
