@extends('layout.main')
@section('container')
{{-- header --}}
<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1"><span class="ti ti-users"></span> {{ $title }}</h3>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Beranda</a>
                </li>
                <li class="breadcrumb-item " aria-current="page">Akademik</li>
                <li class="breadcrumb-item " aria-current="page">pengaturan</li>
                <li class="breadcrumb-item active" aria-current="page">Rombongan Belajar</li>
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
<div class="alert alert-primary overflow-hidden p-0" role="alert">
    <div class="p-3 bg-primary text-fixed-white d-flex justify-content-between">
        <h3 class="aletr-heading mb-0 text-fixed-white"><span class="ti ti-info-circle"></span> Petunjuk Singkat</h3>

    </div>

    <div class="p-3">
        <p>Menu ini digunakan untuk mengatur daftar Mata Pelajaran pada tiap semester. Pastikan sebelum proses
            pembelajaran dimulai sudah mengatur daftar Mata Pelajaran yang akan diajarkan dengan cara sebagai berikut :
        </p>
        <li>Pilih Mata Pelajaran dengan cara mengklik tombol panah hijau, dan akan otomatis menambah data ke sebelah
            kanan tabel</li>

        <li>Kemudian Pilih <b>Tahun Pelajaran, Semester</b>, dan <b>Kelas</b> pada tabel di sebelah kanan sebagai target
            penyimpanan Mata Pelajaran yang terpilih.</li>
        <li>Klik tombol <b>"Apply dan Simpan"</b> untuk menyimpan ke daftar Mata pelajaran</b>.</li><br>
        <p> <b>Perlu diperhatikan</b> pada tabel <u>pengaturan mata pelajaran</u> pada tabel di bawah terdapat tanda
            warna merah samping tabel yang mengartikan bahwa data belum sepenuhnya tersimpan.</p>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h4><span class="ti ti-settings"></span> Kelas Asal</h4>
                <div>
                    <div class="input-icon-start me-2 position-relative">
                        <span class="icon-addon">
                            <i class="ti ti-search"></i>
                        </span>
                        <input type="text" class="form-control " placeholder="Search" id="myInput"
                            onkeyup="myFunction()">
                    </div>
                </div>
            </div>
            <div class="card-body p-0 mb-0">
                <div class="alert alert-primary overflow-hidden p-0 mb-0">
                    <form action="{{ route('PengaturaRombel') }}" method="get">
                        {{-- this.form.submit() --}}
                        <input type="text" value="{{ request('id_tahun_pelajaran') }}" name="id_tahun_pelajaran" hidden>
                        <input type="text" value="{{ request('id_tahun_pelajaran') }}" name="id_kelas_tujuan" hidden>

                        <div class="col m-3">
                            <label class="form-label">Kelas Asal <span class="text-danger">*</span></label>
                            <select name="id_kelas_asal" id="kelasAsal" class="form-control select2" onchange="this.form.submit()">
                                <option value="" selected>-- Pilih Kelas --</option>
                                <option value="belumDiatur" {{ request('id_kelas_asal')=='belumDiatur' ? 'selected' : ''
                                    }}>Belum Diatur</option>
                                <option value="all" {{ request('id_kelas_asal')=='all' ? 'selected' : '' }}>Tampilkan
                                    Semua</option>
                                @foreach ($kelas as $item )
                                <option value="{{ $item->id }}" {{ request('id_kelas_asal')==$item->id ? 'selected' : ''
                                    }} >{{ $item->nama_kelas }} - {{
                                    $item->jurusanKelas->nama_jurusan }} {{ $item->sub_kelas }}</option>
                                @endforeach
                            </select>
                        </div>

                        @if(request('id_kelas_asal')=="belumDiatur" || request('id_kelas_asal')=="all" )
                        @else
                        <div class="col m-3">
                            <label class="form-label ">Tahun Pelajaran <span class="text-danger">*</span></label>
                            <select name="tahunAjarAsal" id="tahunAsal" class="form-control select2" onchange="this.form.submit()">
                                <option value="" selected>-- Tahun Pelajaran --</option>
                                @foreach ($tahunAjar as $item )
                                <option value="{{ $item->id }}" {{ $item->id ==
                                    request('tahunAjarAsal') ?
                                    'selected' :
                                    '' }}>{{ $item->tahun_pelajaran }} - {{ $item->semester }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-nowrap mb-0" id="myTable">
                        <thead>
                            <tr>
                                <th class="bg-light-400" width="3%">
                                    <div class="form-check form-check-md">
                                        <input class="form-check-input" type="checkbox" id="select-all">
                                        </div>
                                </th>

                                <th class="bg-light-400">NIS</th>
                                <th class="bg-light-400">Nama Lengkap</th>
                                <th class="bg-light-400" width="10%"></th>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                            $no=1;
                            @endphp
                            @foreach ($students as $item)
                            <tr>
                                <td>
                                    <div class="form-check form-check-md">
                                        <input class="form-check-input" type="checkbox">
                                        </div>
                                </td>

                                <td class="text-primary">{{ $item->nis }}</td>
                                <td>
                                    @if(request('id_kelas_asal')=="belumDiatur" || request('id_kelas_asal')=="all" )
                                    {{ $item->nama }}
                                    @else
                                    {{ $item->rombelStudent->nama }}
                                    @endif
                                </td>
                                <th>
                                    <form action="{{ route('PengaturaRombelUpdate') }}" method="post">
                                        @csrf
                                        <input type="text" name="id_kelas_asal" value="{{ request('id_kelas_asal') }}"  hidden>
                                        <input type="text" name="tahunAjarAsal" value="{{ request('tahunAjarAsal') }}" hidden>
                                        <input type="text" name="id_rfid"  value="{{ $item->id_rfid }}" hidden >
                                        <input type="text" name="nis" value="{{ $item->nis }}" value="{{ old('nis') }}" hidden>
                                        <input type="text" name="id_kelas" class="GetKelas" value="{{ request('id_kelas_tujuan') }}" hidden >
                                        <input type="text" name="id_tahun_pelajaran" class="GetTahunPelajaran" value="{{ request('id_tahun_pelajaran') }}" hidden >
                                        <button type="submit" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            title="Pindah" class="btn btn-icon btn-sm btn-soft-success rounded-pill"><i
                                                class="ti ti-arrows-right"></i></button>
                                        {{-- old --}}

                                    </form>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $students->links() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card mb-0">
            <div class="card-body p-0 ">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4><span class="ti ti-settings"></span> Kelas Tujuan</h4>
                    <div>
                        <div class="input-icon-start me-2 position-relative">
                            <span class="icon-addon">
                                <i class="ti ti-search"></i>
                            </span>
                        <input type="text" class="form-control " placeholder="Search" id="myInput1"
                        onkeyup="myFunction1()">
                        </div>
                    </div>
                    </div>
                </div>
                <div class="alert alert-success overflow-hidden p-0 mb-0" role="alert">
                    <hr class="my-0">
                    <div class="p-3">
                        <form action="{{ route('PengaturaRombel') }}" method="get">
                        <p class="mb-0">
                            <input type="text" id="id_kelas_awal" value="{{ request('id_kelas_asal') }}"  name="id_kelas_asal" hidden>
                            <input type="text" id="id_ajaran_awal" value="{{ request('tahunAjarAsal') }}" name="tahunAjarAsal" hidden>
                            <div>
                                <div class="col mb-2">
                                    <label class=" form-label ">Tahun Pelajaran</label>
                                    <select name="id_tahun_pelajaran" id="tahunAjar" class="form-control select2" onchange="TahunAjarValue();this.form.submit()" >
                                        <option value="" selected>-- Pilih Kelas --</option>
                                        @foreach ($tahunAjar as $item )
                                        <option value="{{ $item->id }}"  {{ $item->id ==
                                            request('id_tahun_pelajaran') ?
                                            'selected' :
                                            '' }}>{{ $item->tahun_pelajaran }} - {{ $item->semester }}
                                        </option>
                                        @php
                                        if(request('id_tahun_pelajaran')){
                                        $a = request('id_tahun_pelajaran');
                                        }else{
                                        $a = '';
                                        }
                                        @endphp
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col mb-2">
                                    <label class="form-label">Pilih Kelas Tujuan</label>
                                    <select name="id_kelas_tujuan" id="kelas" class="form-control select2" onchange="KelasValue();this.form.submit() ">
                                        <option value="" selected>-- Pilih Kelas --</option>
                                        @foreach ($kelas as $item )
                                        <option value="{{ $item->id }}"

                                            @if(request('id_kelas_tujuan'))
                                            {{ $item->id == request('id_kelas_tujuan') ?
                                            'selected' : '' }}
                                            @else
                                            {{  $item->id ==  old('id_kelas_tujuan')  ? 'selected' : ''}}
                                            @endif
                                            >{{ $item->nama_kelas }} - {{
                                            $item->jurusanKelas->nama_jurusan }} {{ $item->sub_kelas }}</option>
                                        {{-- get Default Value --}}
                                        @php
                                        if(request('id_kelas_tujuan')){
                                        $c = request('id_kelas_tujuan');
                                        }else{
                                        $c = '';
                                        }
                                        @endphp
                                        @endforeach
                                    </select>

                                </div>

                                </p>
                            </div>
                        </form>

                    </div>

                    <input type="text" id="id_kelas_tujuan" value="{{ $c }}" hidden >
                    <input type="text" id="tahun_ajaran_tujuan" value="{{ $a }}" hidden>

                </div>
            </div>

            <div class="table-responsive mt-0">
                <table class="table table-nowrap mb-0" id="table">
                    <thead>
                        <tr>
                            <th class="bg-light-400" width="10%">#</th>
                            <th class="bg-light-400">NIS</th>
                            <th class="bg-light-400">Nama Lengkap</th>

                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no=1;
                        @endphp
                        @foreach ($studentsClass as $item)
                        <tr>
                            <td>{{ $no++ }}.</td>
                            <td class="link-primary">{{ $item->nis}}</td>
                            <td>{{ $item->rombelStudent->nama}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    {{ $studentsClass->links() }}
                </div>
            </div>
        </div>

    </div>
</div>
</div>
</div>
@section('javascript')
{{-- <script>
    $(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            $(function (){
                $('#kelasAsal').on('change',function(){
                    let kelasAsal = $('#kelasAsal').val();
                    $.ajax({
                        type : 'POST',
                        url : "{{route('getkelasAwal')}}",
                        data : {
                            kelasAsal:kelasAsal
                        },
                        cache : false,
                        success: function(msg){
                            $('#id_kelas_awal').val(msg);

                        },
                        error: function(data) {
                            console.log('error:',data)
                        },
                    })
                })

                $('#tahunAsal').on('change',function(){
                    let tahunAsal = $('#tahunAsal').val();
                    $.ajax({
                        type : 'POST',
                        url : "{{route('gettahunajaranawal')}}",
                        data : {
                            tahunAsal:tahunAsal
                        },
                        cache : false,
                        success: function(msg){
                            $('#id_ajaran_awal').val(msg);
                        },
                        error: function(data) {
                            console.log('error:',data)
                        },
                    })
                })
            });
    });
</script> --}}

<script>
    function TahunAjarValue() {
        var e = document.getElementById("tahunAjar");
        var val = e.options[e.selectedIndex].value;
        document.getElementById("tahun_ajaran_tujuan").value = val;
        $(".GetTahunPelajaran").val(val);

     }
    function KelasValue() {
        var e = document.getElementById("kelas");
        var val = e.options[e.selectedIndex].value;
        document.getElementById("id_kelas_tujuan").value = val;
        $(".GetKelas").val(val);

    }



    // $(".GetKelas").val(document.getElementById("id_kelas_tujuan").value) ;
    // $(".GetTahunPelajaran").val(document.getElementById("tahun_ajaran_tujuan").value);

</script>
<script>
    function myFunction1() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("myInput1");
      filter = input.value.toUpperCase();
      table = document.getElementById("table");
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
</script>
@endsection
@endsection
