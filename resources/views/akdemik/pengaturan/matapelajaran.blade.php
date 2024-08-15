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
                <li class="breadcrumb-item active" aria-current="page">Guru dan Tenaga Kependidikan</li>
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
        <button type="button" class="btn-close p-0 text-fixed-white" data-bs-dismiss="alert" aria-label="Close"><i
                class="fas fa-xmark"></i></button>
    </div>

    <div class="p-3">
        <p>Menu ini digunakan untuk mengatur daftar Mata Pelajaran pada tiap semester. Pastikan sebelum proses
            pembelajaran dimulai sudah mengatur daftar Mata Pelajaran yang akan diajarkan dengan cara sebagai berikut :
        </p>
        <li>Pilih Mata Pelajaran dengan cara menceklis daftar Mata Pelajaran pada tabel disebelah kiri.</li>
        <li>Pilih <b>Tahun Pelajaran, Semester</b>, dan <b>Kelas</b> pada tabel di sebelah kanan sebagai target
            penyimpanan Mata Pelajaran yang terpilih / terceklis.</li>
        <li>Klik tombol <b>"SIMPAN KE DAFTAR MATA PELAJARAN"</b>.</li><br>
        <p>Jika ingin menduplikasi Mata Pelajaran pada Tahun Pelajaran, semester, dan kelas sebelumnya, pada bagian
            <b>"Copy Data"</b> silahkan pilih <b>Ya</b>, kemudian pilih/ceklis Mata Pelajaran dari Tahun Pelajaran,
            Semester, dan Kelas yang akan diduplikasi.</p>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3><span class="ti ti-settings"></span> Pilih Mata Pelajaran</h3>
                <div>
                    <div class="input-icon-start me-2 position-relative">
                        <span class="icon-addon">
                            <i class="ti ti-users"></i>
                        </span>
                        <input type="text" class="form-control " placeholder="Search" id="myInput" onkeyup="myFunction()">
                    </div>
                </div>
            </div>
            <div class="card-body p-0 ">

                <div class="table-responsive">
                    <table class="table table-nowrap mb-0" id="myTable">
                        <thead>
                            <tr>
                                <th class="bg-light-400" width="10%">#</th>
                                <th class="bg-light-400">Mata Pelajaran</th>
                                <th class="bg-light-400" width="10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- <form action="{{ route('pengaturanMapelAdd') }}" method="post">
                                @csrf
                                <input type="text" name="id_tahun_pelajaran" id="GetTahunPelajaran" hidden>
                                <input type="text" name="id_semester" id="GetSemester" hidden>
                                <input type="text" name="id_kelas" id="GetKelas" hidden>

                            </form> --}}
                            @php
                            $no=1;
                            @endphp
                            @foreach ($mapel as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->nama }}</td>
                                <th>
    
                                    <form action="{{ route('pengaturanMapelAdd') }}" method="post">
                                        @csrf
                                        <input type="text" name="id_mapel" id="MapelVal" value="{{ $item->id }}" hidden>
                                        <button type="submit"
                                            class="btn btn-icon btn-sm btn-soft-success rounded-pill"><i
                                                class="ti ti-arrows-right"></i></button>

                                    </form>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <form action="{{ route('pengaturanMapelUpdate') }}" method="post">
                @csrf
                <div class="card-body p-0 ">
                    <div class="alert alert-success overflow-hidden p-0 mb-0" role="alert">
                        <div class="p-3 bg-success text-fixed-white d-flex justify-content-between">
                            <h4 class="alert-heading mb-0 text-fixed-white"> <span
                                    class="ti ti-filter"></span>Pengaturan Mata Pelajaran</h3>

                            <div>
                                <button class="btn btn-soft-light rounded-pill"><span class="ti ti-upload"></span> Apply
                                    dan Simpan</button>
                            </div>

                        </div>
                        <hr class="my-0">
                        <div class="p-3">
                            <p class="mb-0">
                            <div>
                                <div class="row ">
                                    <label class="col-lg-3 form-label mt-1">Tahun Pelajaran</label>
                                    <div class="col-lg-9">
                                        <select name="tahunAjar" id="tahunAjar" class="form-control select2"
                                            onchange="copyTextValue()">
                                            @foreach ($tahunAjar as $item )
                                            <option value="{{ $item->id }}" selected>{{ $item->tahun_pelajaran }}
                                            </option>
                                            {{-- get Default Value --}}
                                            @php $a = $item->id @endphp
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-lg-3 form-label mt-2">Semester</label>
                                    <div class="col-lg-9">
                                        <select name="semester" id="semester" class="form-control select2"
                                            onchange="semesterValue()">
                                            @foreach ($tahunAjar as $item )
                                            <option value="{{ $item->semester }}" selected>{{ $item->semester }}
                                            </option>
                                            {{-- get Default Value --}}
                                            @php $b = $item->semester @endphp
                                            @endforeach

                                        </select>
                                    </div>

                                </div>
                                <div class="row mb-2">
                                    <label class="col-lg-3 form-label mt-2">Kelas</label>
                                    <div class="col-lg-9">
                                        <select name="kelas" id="kelas" class="form-control select2"
                                            onchange="kelasValue()">
                                            @foreach ($kelas as $item )
                                            <option value="{{ $item->id }}" selected>{{ $item->nama_kelas }} - {{
                                                $item->jurusanKelas->nama_jurusan }} {{ $item->sub_kelas }}</option>
                                            {{-- get Default Value --}}
                                            @php $c = $item->id @endphp
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- Input Box untuk mengambil Data Default --}}
                                <input type="text" id="id_tahun_pelajaranVal" value="{{ $a }}" hidden>
                                <input type="text" id="semesterVal" value="{{ $b }}" hidden>
                                <input type="text" id="kelasVal" value="{{ $c }}" hidden>

                            </div>
                            </p>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0" >
                            <thead>
                                <tr>
                                    <th class="bg-light-400" width="10%">#</th>
                                    <th class="bg-light-400" width="10%"></th>

                                    <th class="bg-light-400">Mata Pelajaran</th>
                                    <th class="bg-light-400">Guru Pengajar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $no=1;
                                @endphp
                                @foreach ($grupMapel as $item)
                                <thead @if($item->status == '1') class="bg-danger" @endif>
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>
                                            <a href="{{ route('pengaturanMapelDelete',$item->id) }}"
                                                class="btn btn-icon btn-sm btn-soft-danger rounded-pill"><i
                                                    class="ti ti-trash"></i></a>
                                        </td>
                                        <td>{{ $item->mata_pelajaran->nama }}</td>
                                        <td>
                                          Belum disetel
                                        </td>

                                    </tr>
                                </thead>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
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
                                    <label class="form-label">Kata Sandi</label>
                                    <div class="pass-group mb-3">
                                        <input type="password" class="pass-input form-control"
                                            placeholder="Masukan Kata Sandi">
                                        <span class="ti toggle-password ti-eye-off"></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ulangi Kata Sandi</label>
                                    <div class="pass-group mb-3">
                                        <input type="password" class="pass-input form-control"
                                            placeholder="Masukan Kata Sandi">
                                        <span class="ti toggle-password ti-eye-off"></span>
                                    </div>
                                </div>

                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100"><span class="ti ti-pencil-plus"></span>
                        Ubah</button>
            </form>
        </div>

    </div>
</div>
</div>
@section('javascript')

{{-- <script>
    // set Defalult select ke dala input Box
    function copyTextValue() {
        var e = document.getElementById("tahunAjar");
        var val = e.options[e.selectedIndex].value;
        document.getElementById("id_tahun_pelajaranVal").value = val;
        document.getElementById("GetTahunPelajaran").value = val;
    }
    function semesterValue() {
        var e = document.getElementById("semester");
        var val = e.options[e.selectedIndex].value;
        document.getElementById("semesterVal").value = val;
        document.getElementById("GetSemester").value = val;
    }
    function kelasValue() {
        var e = document.getElementById("kelas");
        var val = e.options[e.selectedIndex].value;
        document.getElementById("kelasVal").value = val;
        document.getElementById("GetKelas").value = val;
    }
    // tangkap Data Data Input Box
    document.getElementById("GetTahunPelajaran").value = document.getElementById("id_tahun_pelajaranVal").value;
    document.getElementById("GetSemester").value = document.getElementById("semesterVal").value;
    document.getElementById("GetKelas").value = document.getElementById("kelasVal").value;
    // get id
    $("#submit").click(function(){
        document.getElementById("GetMapel").value = document.getElementById("MapelVal").value;
    }); 
</script> --}}
<script>
    function myFunction() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
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