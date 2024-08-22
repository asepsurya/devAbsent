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
        <h4>Lis Data RFID</h4>
    </div>
    <div class="card-body p-0 ">
        <div class="row m-3">
            <form action="{{ route('rfidadd') }}" method="post">
                @csrf
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">ID RFID</label>
                    <input type="text" class="form-control" name="id_rfid" required readonly id="rfid">
                    <small>Akan terisi otoamatis ketika scan RFID</small>
                    <div class="my-3">
                        <button class="btn btn-primary soft w-100">Simpan</button>
                    </div>

                </div>
            </div>
            </form>
        </div>
        <div class="table-responsive">
               <div id="mydata">
                    {{-- @foreach ($rfid as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>
                           {{ $item->id_rfid }}
                        </td>
                    </tr>
                    @endforeach --}}

        </div>
    </div>
</div>
@section('javascript')
    <script>
        function cekrfid(){
            $.ajax({
                type : "GET",
                url: "{{ route('rfidData') }}",
                cache:false,
                success:function(response){
                    console.log(response);
                    $("#rfid").val(response)
                }
            });
        }
        // setiap 2 detik
        setInterval(cekrfid,2000);
    </script>
    <script>
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
                            '<th class="bg-light-400">RFID</th>'+
                            '</tr></thead>'
                for(i=0;i<data.length;i++){
                    content +='<tr>'+
                        '<td>'+data[i].id+'.</td>'+
                        '<td>'+data[i].id_rfid+'</td></tr>'

                }
                content +='</table>'
                $('#mydata').html(content);
            }
        });
    </script>
@endsection
@endsection
