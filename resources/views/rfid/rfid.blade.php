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
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">

    </div>
</div>
{{-- End Header --}}
<div class="card">
    <div class="card-header">
        <h4>Daftar {{ $title }}</h4>
    </div>
    <div class="card-body p-0 ">
        <div class="table-responsive  m-2">
               {{-- <div id="mydata"> --}}
                <table class="table no-footer " id="rfid-table">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="5%"></th>
                            <th>RFID</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                </table>
        </div>
    </div>
</div>
@foreach ($rfid as $item)
@if( $item->rfidStudent || $item->rfidGTK)
<div class="modal fade" id="detail-{{ $item->id_rfid }}" aria-labelledby="exampleModalToggleLabel" tabindex="-1"
     aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel"><span class="ti ti-user"></span> Detail Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="bg-light-300 rounded-2 p-3 mb-3">
                        <div class="d-flex align-items-center">
                            <a href="student-details.html" class="avatar avatar-lg flex-shrink-0">
                            @if($item->rfidStudent)
                                @if($item->rfidStudent->foto != NULL )
                                    <img src="{{ asset('storage/' . $item->rfidStudent->foto) }}" alt='Img' class='img-fluid rounded-circle'>
                                @else
                                    <img src='{{ asset('asset/img/user-default.jpg')  }}' alt='Img' class='img-fluidimg-fluid rounded-circle'>
                                @endif
                            @elseif ($item->rfidGTK)
                                @if($item->rfidGTK->gambar != '' )
                                    <img src="{{ asset('storage/' . $item->rfidGTK->gambar) }}" alt='Img' class='img-fluid rounded-circle'>
                                @else
                                    <img src='{{ asset('asset/img/user-default.jpg')  }}' alt='Img' class='img-fluidimg-fluid rounded-circle'>
                                @endif
                            @else
                                 <img src='{{ asset('asset/img/user-default.jpg')  }}' alt='Img' class='img-fluidimg-fluid rounded-circle'>
                            @endif

                            </a>
                            <div class="ms-2">
                                <p class="text-dark mb-0">
                                  Tertaut a/n:
                                </p>
                                <h5 class="mb-0">
                                        @if($item->rfidStudent)
                                            {{ $item->rfidStudent->nama }}

                                            @php $gender = $item->rfidStudent->gender; $role = $item->rfidStudent->studentUser->role ?? ''; @endphp
                                        @endif
                                        @if($item->rfidGTK)
                                            {{ $item->rfidGTK->nama }}
                                            @php $gender = $item->rfidGTK->gender;  $role = 'Guru dan Tenaga Kependidikan' @endphp
                                        @endif
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between gx-2">
                        <div>
                            <p class="mb-0">ID</p>
                            <p class="text-dark"><b>{{ $item->id_rfid }}</b></p>
                        </div>
                        <div>
                            <p class="mb-0">Jenis Kelamin</p>
                            <p class="text-dark">{{ $gender == 'L' ? 'Laki-Laki' : 'Perempuan' }}</p>
                        </div>
                        <div>
                            <p class="mb-0">Status</p>
                            <p class="text-dark">
                                <span class="badge badge-soft-success d-inline-flex align-items-center">Role : {{ $role }}</span>
                            </p>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endif
@endforeach
@section('javascript')
<script src="{{ asset('asset/js/DataTables.js') }}"></script>

<script>

    $(function() {
        var table = new DataTable('#rfid-table', {
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
            ajax: '{!! route('rfid') !!}', // memanggil route yang menampilkan data json
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
                            '<a class="btn btn-icon btn-sm btn-soft-danger rounded-pill" href="/rfid/delete' + data + '"><i class="ti ti-trash"></i></a>'
                        }
                        if(row.status === '2'){
                           data = '<a class="btn btn-icon btn-sm btn-soft-primary rounded-pill"  data-bs-toggle="modal" href="#detail-'+row.id_rfid+'" role="button" ><i class="ti ti-list-details"></i></a></div>'
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
