@extends('layout.main')
@section('container')
@section('css')
<link rel="stylesheet" href="{{ asset('asset/css/DataTables.css') }}">
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
                <li class="breadcrumb-item active" aria-current="page">Registrasi RFID</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">

    </div>
</div>
{{-- End Header --}}
<div class="alert alert-primary overflow-hidden p-0" role="alert">
    <div class="p-3 bg-primary text-fixed-white d-flex justify-content-between">
        <h3 class="aletr-heading mb-0 text-fixed-white"><span class="ti ti-info-circle"></span> Petunjuk Singkat</h3>
        <button type="button" class="btn-close p-0 text-fixed-white" data-bs-dismiss="alert" aria-label="Close"><i class="fas fa-xmark"></i></button>
    </div>
    <div class="p-3">
        <li>Pilih <strong>Tahun Pelajaran</strong>, <strong>Semester</strong>, dan <strong>Kelas</strong> yang akan
            diatur Guru Mata Pelajarannya, kemudian klik tombol <strong>"CARI DATA"</strong></li>
        <li>Setelah data tampil, pada kolom <strong>"GURU PENGAJAR"</strong> silahkan dipilih Guru Pengajar sesuai Mata
            Pelajaran di kolom <strong>"MATA PELAJARAN"</strong> </li>
           <li>Maka akan secara <b>otomatis</b> terpilih sesuai Data yang anda pilih</li>

    </div>
</div>
<div class="card">
    <div class="card-header">
        <h4>List Data RFID</h4>
    </div>
    <div class="card-body p-0 ">
        <div class="table-responsive  m-2">
               {{-- <div id="mydata"> --}}
                <table class="table no-footer " id="rfid-table">
                    <thead>
                        <tr>
                            <th class="bg-light-400" width="5%">#</th>
                            <th class="bg-light-400" width="5%"></th>
                            <th class="bg-light-400">RFID</th>
                            <th class="bg-light-400">Status</th>
                        </tr>
                    </thead>
                </table>
        </div>
    </div>
</div>
@section('javascript')
<script src="{{ asset('asset/js/DataTables.js') }}"></script>

<script>
    $(function() {
        var table = new DataTable('#rfid-table', {
            processing: true,
            order: [[1, 'desc']],
            serverSide: true,
            ajax: '{!! route('rfid') !!}', // memanggil route yang menampilkan data json
            columns: [{ // mengambil & menampilkan kolom sesuai tabel database
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'id',
                    sortable: false,
                    render: function(data, type, row, meta){
                        if(type === 'display'){
                        data = '<a class="btn btn-icon btn-sm btn-soft-danger rounded-pill" href="/rfid/delete' + data + '"><i class="ti ti-trash"></i></a>'
                        }
                        return data;
                    },
                    targets: -1
                 },
                {
                    data: 'id_rfid',
                    name: 'id_rfid'
                },
                {
                    data: 'status',
                    render:function(data){
                    if(data === '2'){
                        data = '<span class="badge badge-soft-success d-inline-flex align-items-center">Tertaut</span>'
                    }else{
                        data = '<span class="badge badge-soft-danger d-inline-flex align-items-center">Tidak Tertaut</span>'
                    }
                    return data;
                   }
                },


            ]
        });


    });
</script>
{{--
    <script>
        function refreshdata(){

        var content="";
        $.ajax({
            url:"{{ route('rfidDataGET') }}",
            method:"GET",
            dataType:"json",
            success: function(data){
                content+=' <table class="table table-nowrap mb-0">'+
                    '<thead>'+
                        '<tr>'+
                            '<th class="bg-light-400" width="5%">#</th>'+
                            '<th class="bg-light-400" width="5%"></th>'+
                            '<th class="bg-light-400">RFID</th>'+
                            '<th class="bg-light-400">Status</th>'+

                            '</tr></thead>'

                for(i=1;i<data.length;i++){
                    content +='<tr>'+
                        '<td>' +i+ '.</td>'+
                        '<td><a class="btn btn-icon btn-sm btn-soft-danger rounded-pill" href=/rfid/delete'+data[i].id+'><i class="ti ti-trash"></i></a></td>'+
                        '<td>'+data[i].id_rfid+'</td>'+

                        '<td>'
                if(data[i].status == '2'){
                    content +='<span class="badge badge-soft-success d-inline-flex align-items-center">Tertaut</span>'
                }else{
                    content +='<span class="badge badge-soft-danger d-inline-flex align-items-center">Tidak Tertaut</span>'
                }'</td>'
                    content+='</tr>'
                }
                content +='</table> '
                $('#mydata').html(content);
            }
        });
    }
        setInterval(refreshdata,2000);
    </script> --}}
@endsection
@endsection
