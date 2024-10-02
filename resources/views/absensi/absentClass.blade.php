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

                <li class="breadcrumb-item active" aria-current="page">Data Kelas</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">

    </div>
</div>
{{-- End Header --}}
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
        <div class="table-responsive " >
            <table class="table table-nowrap mb-0" id="myTable" >
                <thead>
                    <tr>
                        <th class="bg-light-400">#</th>

                        <th class="bg-light-400" width="70%">Rombongan Belajar</th>
                        <th class="bg-light-400" width="70%">Mata Pelajaran</th>
                        <th class="bg-light-400 border" width="10%">Jumlah Siswa</th>
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
                            <a href='/absent/class/student?id_mapel={{ $item->mata_pelajaran->id }}&tahun={{ $item->id_tahun_pelajaran }}&kelas={{ $item->id_kelas }}&tanggal={{ date('d/m/Y') }}' class="link-primary">
                                {{ $item->kelas->nama_kelas }} - {{ $item->kelas->jurusanKelas->nama_jurusan }} {{ $item->sub_kelas }}
                            </a>
                        </td>
                        <td>{{ $item->mata_pelajaran->nama }}</td>
                        <td class="border">
                           <center><b> {{ $item->kelas->jmlRombel->count() }}</b> <span class="ti ti-users"></span></center></td>
                        <td>
                            @if($item->status == '2')
                            <span class="badge badge-soft-success d-inline-flex align-items-center">Aktif</span>
                            @else
                            <span class="badge badge-soft-danger d-inline-flex align-items-center">Tidak Aktif</span>
                            @endif
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
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
