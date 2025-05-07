@extends('layout.main')
@section('container')
{{-- header --}}
<div class="d-md-flex d-block align-items-center justify-content-between mb-3 ">
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

    </div>
</div>
{{-- End Header --}}
@if (Request::is('class/time'))
<div class="alert alert-primary overflow-hidden p-0" role="alert">
    <div class="p-3 bg-primary text-fixed-white d-flex justify-content-between">
        <h3 class="aletr-heading mb-0 text-fixed-white"><span class="ti ti-info-circle"></span> Petunjuk Singkat</h3>

    </div>

    <div class="p-3">
        <p>Halaman ini disediakan untuk mengatur waktu kedatangan dan kepulangan siswa, guna menentukan apakah seorang
            siswa terlambat atau tidak.</p>
    </div>
</div>
@endif

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap pb-0">
        <h4 class="mb-3">Daftar Kelas</h4>
        <div class="d-flex align-items-center flex-wrap">
            <div class="input-icon-start mb-3 me-2 position-relative">
                <span class="icon-addon">
                    <i class="ti ti-search"></i>
                </span>
                <input type="text" class="form-control " placeholder="Cari Kelas.." id="myInput" onkeyup="myFunction()">
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive ">
            <form action="{{ route('time.update') }}" method="post">
                @csrf

                <table class="table table-nowrap mb-0" id="myTable">
                    <thead>
                        <tr>
                            <th class="bg-light-400">#</th>
                            <th class="bg-light-400" width="70%">Rombongan Belajar</th>
                            <th class="bg-light-400 border" width="10%">Jumlah Siswa</th>
                            @if (Request::is('class/time'))
                            <th class="bg-light-400 border" width="10%">Jam Masuk</th>
                            <th class="bg-light-400 border" width="10%">Jam Pulang</th>
                            @endif
                            <th class="bg-light-400">status</th>


                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no=1;
                        @endphp
                        @foreach ($kelas as $item)

                        <tr class="odd">
                            <td>{{ $no++ }}</td>

                            <td>
                                @if(Request::is('class/list'))
                                <a href="{{ route('absensiClassManagement') }}?mapel=&tahun=&kelas={{ $item->id }}"
                                    class="link-primary">{{ $item->nama_kelas }} - {{ $item->jurusanKelas->nama_jurusan
                                    }} {{ $item->sub_kelas }}</a>
                                @elseif(Request::is('class/time'))
                                <a>{{ $item->nama_kelas }} - {{ $item->jurusanKelas->nama_jurusan }} {{ $item->sub_kelas
                                    }}</a>
                                @else
                                <a href="{{ route('list',$item->id) }}" class="link-primary">{{ $item->nama_kelas }} -
                                    {{ $item->jurusanKelas->nama_jurusan }} {{ $item->sub_kelas }}</a>
                                @endif

                            </td>

                            <td class="border">
                                <center><b> {{ $item->jmlRombel->count() }}</b> <span class="ti ti-users"></span>
                                </center>
                            </td>
                            @if (Request::is('class/time'))
                            <td hidden><input type="text" name="id_kelas[]" value="{{ $item->id }}"></td>
                            <td class="border"><input type="time" name="jam_masuk[]" id="time" value="{{ $item->inOutTime->jam_masuk ?? app('settings')['start_school']}}" class="form-control"></td>
                            <td class="border"><input type="time" name="jam_keluar[]"  value="{{ $item->inOutTime->jam_pulang ?? ''}}" class="form-control"></td>
                            @endif
                            <td>
                                @if($item->status == '1')
                                <span class="badge badge-soft-success d-inline-flex align-items-center">Aktif</span>
                                @else
                                <span class="badge badge-soft-danger d-inline-flex align-items-center">Tidak
                                    Aktif</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if (Request::is('class/time'))
                <div class="d-flex justify-content-between m-2">
                    <div class="mt-2 ms-3">
                        Default Jam masuk  : 07:00 |
                        Default Jam Pulang : 16:00
                    </div>

                    <button class="btn btn-primary">Simpan Data</button>
                </div>
                @endif
            </form>
        </div>
    </div>

</div>
@section('javascript')
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
