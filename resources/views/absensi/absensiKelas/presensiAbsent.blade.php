@extends('layout.main')
@section('container')
{{-- header --}}
<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1">Presensi Absensi Kelas</h3>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Beranda</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="">Absensi</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="">Presensi Absensi</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
    </div>
</div>

<ul class="nav nav-tabs tab-style-1 d-sm-flex d-block" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link" href="{{ route('absentClassStudent') }}?filter=today&id_mapel={{ request('id_mapel') }}&tahun={{ request('tahun') }}&kelas={{ request('kelas') }}&tanggal={{ request('tanggal') }}"
            aria-selected="false" role="tab" tabindex="-1"><span class="ti ti-users"></span> Absensi</a>
    </li>
    <li class="nav-item " role="presentation">
        <a class="nav-link active " href="{{ route('presensiClassStudent',request('kelas')) }}?filter=today&id_mapel={{ request('id_mapel') }}&tahun={{ request('tahun') }}&kelas={{ request('kelas') }}&tanggal={{ request('tanggal') }}" aria-selected="true"
            role="tab"><span class="ti ti-list"></span> Presensi Absensi Kelas </a>
    </li>

</ul>

<div class="tab-content">
    <div class="tab-pane active show" id="orders" role="tabpanel">
        <div class="col-xxl-5 col-xl-12 d-flex">
            <div class="bg-white position-relative flex-fill border p-3 mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center row-gap-3">
                        <div class="avatar avatar-xxl rounded flex-shrink-0 me-3">
                            <img src="{{ asset('asset/img/kelas.png') }}" alt="Img">
                        </div>
                        <div class="d-block">
                            <span class="badge bg-transparent-primary text-primary mb-1">Nama Kelas :</span>
                            <h4 class="text-truncate  mb-1">{{ $title }} </h4>
                            <div class="d-flex align-items-center flex-wrap row-gap-2 ">
                                <span>Added On : {{ $class_created }}</span>

                            </div>
                        </div>
                    </div>
                    <div class="student-card-bg">
                        <img src="assets/img/bg/circle-shape.png" alt="Bg">
                        <img src="assets/img/bg/shape-02.png" alt="Bg">
                        <img src="assets/img/bg/shape-04.png" alt="Bg">
                        <img src="assets/img/bg/blue-polygon.png" alt="Bg">
                    </div>
                </div>
            </div>
        </div>

        <div class="border rounded p-3 bg-white mb-3">
            <div class="row">
                <div class="col text-center border-end">
                    <p class="mb-1 border-bottom"><b>Jumlah Siswa Hadir : </b></p>
                    @php
                        $jumlahHadirHariIni = 0;
                        $jumlahHadirMingguIni = 0;
                        $jumlahHadirBulanIni = 0;
                        $jumlah = 0;
                        $hariIni = \Carbon\Carbon::today();
                        $mingguIni = $hariIni->copy()->startOfWeek();
                        $bulanIni = $hariIni->copy()->startOfMonth();
                    @endphp
                    @foreach ($absent as $key )
                        @if($key->status == 'H')
                            @php
                            // Mengonversi tanggal dari format 'DD/MM/YYYY' menjadi objek Carbon
                            $tanggalAbsen = \Carbon\Carbon::createFromFormat('d/m/Y', $key->tanggal);
                            @endphp

                            @if($tanggalAbsen->isToday())
                            @php $jumlahHadirHariIni++; @endphp
                            @endif

                            @if($tanggalAbsen->between($mingguIni, $hariIni))
                            @php $jumlahHadirMingguIni++; @endphp
                            @endif

                            @if($tanggalAbsen->isSameMonth($hariIni))
                            @php $jumlahHadirBulanIni++; @endphp
                            @endif

                        @endif
                    @endforeach
                        {{-- hari ini --}}
                        @if(request('filter')=="today")
                            <p><h4 class="text-success">{{ $jumlahHadirHariIni }}</h4></p>
                        @endif
                        {{-- minggu ini --}}
                        @if(request('filter')=="week")
                            <p><h4 class="text-success">{{ $jumlahHadirMingguIni }}</h4></p>
                        @endif
                        {{-- bulan ini --}}
                        @if(request('filter')=="month")
                            <p><h4 class="text-success"> {{  $jumlahHadirBulanIni }}</h4></p>
                        @endif

                </div>
                <div class="col text-center border-end">
                    <p class="mb-1 border-bottom"><b>Jumlah Siswa Izin : </b></p>
                @php
                    $jumlahHadirHariIni = 0;
                    $jumlahHadirMingguIni = 0;
                    $jumlahHadirBulanIni = 0;
                    $jumlah = 0;
                    $hariIni = \Carbon\Carbon::today();
                    $mingguIni = $hariIni->copy()->startOfWeek();
                    $bulanIni = $hariIni->copy()->startOfMonth();
                @endphp
                @foreach ($absent as $key )
                    @if($key->status == 'I')
                        @php
                        // Mengonversi tanggal dari format 'DD/MM/YYYY' menjadi objek Carbon
                        $tanggalAbsen = \Carbon\Carbon::createFromFormat('d/m/Y', $key->tanggal);
                        @endphp

                        @if($tanggalAbsen->isToday())
                            @php $jumlahHadirHariIni++; @endphp
                        @endif

                        @if($tanggalAbsen->between($mingguIni, $hariIni))
                            @php $jumlahHadirMingguIni++; @endphp
                        @endif

                        @if($tanggalAbsen->isSameMonth($hariIni))
                            @php $jumlahHadirBulanIni++; @endphp
                        @endif

                    @endif
                @endforeach
                    {{-- hari ini --}}
                    @if(request('filter')=="today")
                        <p><h4 class="text-warning">{{ $jumlahHadirHariIni }}</h4></p>
                    @endif
                    {{-- minggu ini --}}
                    @if(request('filter')=="week")
                        <p><h4 class="text-warning">{{ $jumlahHadirMingguIni }}</h4></p>
                    @endif
                    {{-- bulan ini --}}
                    @if(request('filter')=="month")
                        <p><h4 class="text-warning"> {{  $jumlahHadirBulanIni }}</h4></p>
                    @endif

                </div>
                <div class="col text-center border-end">
                    <p class="mb-1 border-bottom"><b>Jumlah Siswa Alfa : </b></p>
                @php
                    $jumlahHadirHariIni = 0;
                    $jumlahHadirMingguIni = 0;
                    $jumlahHadirBulanIni = 0;
                    $jumlah = 0;
                    $hariIni = \Carbon\Carbon::today();
                    $mingguIni = $hariIni->copy()->startOfWeek();
                    $bulanIni = $hariIni->copy()->startOfMonth();
                @endphp
                @foreach ($absent as $key )
                    @if($key->status == 'A' )
                        @php
                        // Mengonversi tanggal dari format 'DD/MM/YYYY' menjadi objek Carbon
                        $tanggalAbsen = \Carbon\Carbon::createFromFormat('d/m/Y', $key->tanggal);
                        @endphp

                        @if($tanggalAbsen->isToday())
                            @php $jumlahHadirHariIni++; @endphp
                        @endif

                        @if($tanggalAbsen->between($mingguIni, $hariIni))
                            @php $jumlahHadirMingguIni++; @endphp
                        @endif

                        @if($tanggalAbsen->isSameMonth($hariIni))
                            @php $jumlahHadirBulanIni++; @endphp
                        @endif

                    @endif
                @endforeach
                    {{-- hari ini --}}
                    @if(request('filter')=="today")
                        <p><h4 class="text-danger">{{ $jumlahHadirHariIni }}</h4></p>
                    @endif
                    {{-- minggu ini --}}
                    @if(request('filter')=="week")
                        <p><h4 class="text-danger">{{ $jumlahHadirMingguIni }}</h4></p>
                    @endif
                    {{-- bulan ini --}}
                    @if(request('filter')=="month")
                        <p><h4 class="text-danger"> {{  $jumlahHadirBulanIni }}</h4></p>
                    @endif

                </div>
                <div class="col text-center">
                    <p class="mb-1 border-bottom"><b>Jumlah Siwa Sakit :</b></p>
                @php
                    $jumlahHadirHariIni = 0;
                    $jumlahHadirMingguIni = 0;
                    $jumlahHadirBulanIni = 0;
                    $jumlah = 0;
                    $hariIni = \Carbon\Carbon::today();
                    $mingguIni = $hariIni->copy()->startOfWeek();
                    $bulanIni = $hariIni->copy()->startOfMonth();
                @endphp
                @foreach ($absent as $key )
                    @if($key->status == 'S')
                        @php
                        // Mengonversi tanggal dari format 'DD/MM/YYYY' menjadi objek Carbon
                        $tanggalAbsen = \Carbon\Carbon::createFromFormat('d/m/Y', $key->tanggal);
                        @endphp

                        @if($tanggalAbsen->isToday())
                            @php $jumlahHadirHariIni++; @endphp
                        @endif

                        @if($tanggalAbsen->between($mingguIni, $hariIni))
                            @php $jumlahHadirMingguIni++; @endphp
                        @endif

                        @if($tanggalAbsen->isSameMonth($hariIni))
                            @php $jumlahHadirBulanIni++; @endphp
                        @endif

                    @endif
                @endforeach
                    {{-- hari ini --}}
                    @if(request('filter')=="today")
                        <p><h4 class="text-primary">{{ $jumlahHadirHariIni }}</h4></p>
                    @endif
                    {{-- minggu ini --}}
                    @if(request('filter')=="week")
                        <p><h4 class="text-primary">{{ $jumlahHadirMingguIni }}</h4></p>
                    @endif
                    {{-- bulan ini --}}
                    @if(request('filter')=="month")
                        <p><h4 class="text-primary"> {{  $jumlahHadirBulanIni }}</h4></p>
                    @endif
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            @php
            $today = Carbon\Carbon::today();
            // Format the dates
            $todayFormatted = $today->format('d/m/Y');
            $startOfWeekFormatted = $today->startOfWeek()->format('d/m/Y');
            $startOfMonthFormatted = $today->startOfMonth()->format('d/m/Y');
            @endphp
            <div class="col-lg-8">
                <input type="text" class="form-control" placeholder="Search..." id="siswaInput" onkeyup="cariSiswa()">
            </div>
            <nav class="nav justify-content-center mb-4">
                <a class="nav-link {{  request('filter') =='today' ?'active':''  }}"
                    href="{{ route('presensiClassStudent',request('kelas')) }}?filter=today&id_mapel={{ request('id_mapel') }}&tahun={{ request('tahun') }}&kelas={{ request('kelas') }}&tanggal={{ request('tanggal') }}">Hari Ini</a>
                <a class="nav-link {{ request('filter') =='week' ?'active':''  }}"
                    href="{{ route('presensiClassStudent',request('kelas')) }}?filter=week&id_mapel={{ request('id_mapel') }}&tahun={{ request('tahun') }}&kelas={{ request('kelas') }}&tanggal={{ request('tanggal') }}">Minggu Ini</a>
                <a class="nav-link {{ request('filter') == 'month' ?'active':''  }}"
                    href="{{ route('presensiClassStudent',request('kelas')) }}?filter=month&id_mapel={{ request('id_mapel') }}&tahun={{ request('tahun') }}&kelas={{ request('kelas') }}&tanggal={{ request('tanggal') }}">Bulan Ini</a>
            </nav>
        </div>

        <div class="table-responsive">
            <table class="table table-nowrap mb-0" id="siswaTable">
                <thead>
                    <tr>
                        <th class="bg-light-400 border" width="5%">#</th>
                        <th class="bg-light-400 border" width="10%">NIS</th>
                        <th class="bg-light-400 border" width="20%">Nama Lengkap</th>
                        <th class="bg-light-400 border" width="10%">Jenis Kelamin</th>
                        <th class="bg-light-400 border" width="10%">Tanggal Lahir</th>
                        <th class="bg-light-400 border text-center" width="5%">H</th>
                        <th class="bg-light-400 border text-center" width="5%">I</th>
                        <th class="bg-light-400 border text-center" width="5%">S</th>
                        <th class="bg-light-400 border text-center" width="5%">A</th>

                    </tr>
                </thead>
                <tbody>
                    @php
                    $no =1;
                    @endphp
                    @foreach ($students as $item )
                    <tr>
                        <td class="border">{{ $no++ }}</td>
                        <td class="text-primary">{{ $item->nis }}</a></td>
                        <td class="border"> {{ $item->rombelStudent->nama }} </td>
                        <td class="border">{{ $item->rombelStudent->gender == 'L' ? 'Laki - Laki' : 'Perempuan' }}</td>
                        <td class="border"> {{ $item->rombelStudent->tanggal_lahir }} </td>
                        <td class="border text-center">
                            @php
                            $jumlahHadirHariIni = 0;
                            $jumlahHadirMingguIni = 0;
                            $jumlahHadirBulanIni = 0;
                            $hariIni = \Carbon\Carbon::today();
                            $mingguIni = $hariIni->copy()->startOfWeek();
                            $bulanIni = $hariIni->copy()->startOfMonth();
                            @endphp

                            @foreach ($item->rombelAbsentClass as $key)
                            @if($key->status == 'H')
                            @php
                            // Mengonversi tanggal dari format 'DD/MM/YYYY' menjadi objek Carbon
                            $tanggalAbsen = \Carbon\Carbon::createFromFormat('d/m/Y', $key->tanggal);
                            @endphp

                            @if($tanggalAbsen->isToday())
                            @php $jumlahHadirHariIni++; @endphp
                            @endif

                            @if($tanggalAbsen->between($mingguIni, $hariIni))
                            @php $jumlahHadirMingguIni++; @endphp
                            @endif

                            @if($tanggalAbsen->isSameMonth($hariIni))
                            @php $jumlahHadirBulanIni++; @endphp
                            @endif
                            @endif
                            @endforeach

                            {{-- hari ini --}}
                            @if(request('filter')=="today")
                            <p>{{ $jumlahHadirHariIni }}</p>
                            @endif
                            {{-- minggu ini --}}
                            @if(request('filter')=="week")
                            <p>{{ $jumlahHadirMingguIni }}</p>
                            @endif
                            {{-- bulan ini --}}
                            @if(request('filter')=="month")
                            <p>{{ $jumlahHadirBulanIni }}</p>
                            @endif

                        </td>
                        <td class="border text-center">
                            @php
                            $jumlahHadirHariIni = 0;
                            $jumlahHadirMingguIni = 0;
                            $jumlahHadirBulanIni = 0;
                            $hariIni = \Carbon\Carbon::today();
                            $mingguIni = $hariIni->copy()->startOfWeek();
                            $bulanIni = $hariIni->copy()->startOfMonth();
                            @endphp

                            @foreach ($item->rombelAbsentClass as $key)
                            @if($key->status == 'I')
                            @php
                            // Mengonversi tanggal dari format 'DD/MM/YYYY' menjadi objek Carbon
                            $tanggalAbsen = \Carbon\Carbon::createFromFormat('d/m/Y', $key->tanggal);
                            @endphp

                            @if($tanggalAbsen->isToday())
                            @php $jumlahHadirHariIni++; @endphp
                            @endif

                            @if($tanggalAbsen->between($mingguIni, $hariIni))
                            @php $jumlahHadirMingguIni++; @endphp
                            @endif

                            @if($tanggalAbsen->isSameMonth($hariIni))
                            @php $jumlahHadirBulanIni++; @endphp
                            @endif
                            @endif
                            @endforeach

                            {{-- hari ini --}}
                            @if(request('filter')=="today")
                            <p>{{ $jumlahHadirHariIni }}</p>
                            @endif
                            {{-- minggu ini --}}
                            @if(request('filter')=="week")
                            <p>{{ $jumlahHadirMingguIni }}</p>
                            @endif
                            {{-- bulan ini --}}
                            @if(request('filter')=="month")
                            <p>{{ $jumlahHadirBulanIni }}</p>
                            @endif
                        </td>

                        <td class="border text-center">
                            @php
                            $jumlahHadirHariIni = 0;
                            $jumlahHadirMingguIni = 0;
                            $jumlahHadirBulanIni = 0;
                            $hariIni = \Carbon\Carbon::today();
                            $mingguIni = $hariIni->copy()->startOfWeek();
                            $bulanIni = $hariIni->copy()->startOfMonth();
                            @endphp

                            @foreach ($item->rombelAbsentClass as $key)
                            @if($key->status == 'S')
                            @php
                            // Mengonversi tanggal dari format 'DD/MM/YYYY' menjadi objek Carbon
                            $tanggalAbsen = \Carbon\Carbon::createFromFormat('d/m/Y', $key->tanggal);
                            @endphp

                            @if($tanggalAbsen->isToday())
                            @php $jumlahHadirHariIni++; @endphp
                            @endif

                            @if($tanggalAbsen->between($mingguIni, $hariIni))
                            @php $jumlahHadirMingguIni++; @endphp
                            @endif

                            @if($tanggalAbsen->isSameMonth($hariIni))
                            @php $jumlahHadirBulanIni++; @endphp
                            @endif
                            @endif
                            @endforeach

                            {{-- hari ini --}}
                            @if(request('filter')=="today")
                            <p>{{ $jumlahHadirHariIni }}</p>
                            @endif
                            {{-- minggu ini --}}
                            @if(request('filter')=="week")
                            <p>{{ $jumlahHadirMingguIni }}</p>
                            @endif
                            {{-- bulan ini --}}
                            @if(request('filter')=="month")
                            <p>{{ $jumlahHadirBulanIni }}</p>
                            @endif

                        </td>
                        <td class="border text-center">
                            @php
                            $jumlahHadirHariIni = 0;
                            $jumlahHadirMingguIni = 0;
                            $jumlahHadirBulanIni = 0;
                            $hariIni = \Carbon\Carbon::today();
                            $mingguIni = $hariIni->copy()->startOfWeek();
                            $bulanIni = $hariIni->copy()->startOfMonth();
                            @endphp

                            @foreach ($item->rombelAbsentClass as $key)
                            @if($key->status == 'A')
                            @php
                            // Mengonversi tanggal dari format 'DD/MM/YYYY' menjadi objek Carbon
                            $tanggalAbsen = \Carbon\Carbon::createFromFormat('d/m/Y', $key->tanggal);
                            @endphp

                            @if($tanggalAbsen->isToday())
                            @php $jumlahHadirHariIni++; @endphp
                            @endif

                            @if($tanggalAbsen->between($mingguIni, $hariIni))
                            @php $jumlahHadirMingguIni++; @endphp
                            @endif

                            @if($tanggalAbsen->isSameMonth($hariIni))
                            @php $jumlahHadirBulanIni++; @endphp
                            @endif
                            @endif
                            @endforeach

                            {{-- hari ini --}}
                            @if(request('filter')=="today")
                            <p>{{ $jumlahHadirHariIni }}</p>
                            @endif
                            {{-- minggu ini --}}
                            @if(request('filter')=="week")
                            <p>{{ $jumlahHadirMingguIni }}</p>
                            @endif
                            {{-- bulan ini --}}
                            @if(request('filter')=="month")
                            <p>{{ $jumlahHadirBulanIni }}</p>
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
    function cariSiswa() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("siswaInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("siswaTable");
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

