@extends('layout.main')
@section('css')
<style>

     .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            /* background-color: #fff; */

            border-radius: 10px;

            width: 100%; /* Make calendar full-width */
            box-sizing: border-box; /* Include padding and borders in the width */
        }

        .calendar-day {
            text-align: center;
            background-color: #f0f0f0;
            padding: 7px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .calendar-day:hover {
            background-color: #cce7ff;
        }

        .active-day {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            /* border: 2px solid #0056b3; */
        }
        html .darkmode .calendar-day, html[data-theme=dark] .calendar-day {
            background-color: #1b1632;

        }

        html .darkmode .active-day, html[data-theme=dark] .active-day {
            background-color: #007bff;
            color: white;
        }

        /* Responsive design for smaller screens */
        @media (max-width: 768px) {
            .calendar {
                grid-template-columns: repeat(3, 1fr); /* Show 3 days per row on smaller screens */
            }
        }

        @media (max-width: 480px) {
            .calendar {
                grid-template-columns: repeat(2, 1fr); /* Show 2 days per row on very small screens */
            }
        }

     #custom-slider {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;

            border-radius: 10px;
            /* box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); */
        }

        .icon-container .line {
            width: 3px;
            height: 50px;
            background-color: #fff; /* Warna garis putih */
            border-radius: 10px;
        }

        .text-container h4 {
            font-weight: bold;
            margin: 0;
        }

        .text-container p {
            font-size: 14px;
            margin: 0;
        }

        .image-container img {
            max-height: 50px; /* Sesuaikan ukuran logo */
        }

        .slider-container {
            position: relative;
            height: 80px; /* Sesuaikan tinggi kontainer */
            overflow: hidden;
        }



        .slider-item:nth-child(2) {
            animation-delay: 5s; /* Memberi jeda untuk slide kedua */
        }
        .slider-item {
            position: absolute;
            width: 100%;
            left: 0;
            top: 100%; /* Mulai di luar tampilan */
            animation: slideUp 10s infinite;
            cursor: grab; /* Indicate draggable behavior */
            transition: top 0.3s ease; /* Smooth transition when dragging */
            }

            @keyframes slideUp {
            0% {
                top: 100%; /* Mulai di bawah */
            }
            10% {
                top: 0%; /* Naik ke posisi tampilan */
            }
            40% {
                top: 0%; /* Tetap selama beberapa waktu */
            }
            45% {
                top: 0%; /* Tetap selama beberapa waktu */
            }
            48% {
                top: 0%; /* Tetap selama beberapa waktu */
            }
            50% {
                top: -100%; /* Naik keluar tampilan */
            }
            100% {
                top: -100%; /* Tetap di luar tampilan */
            }
            }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.2/dist/sweetalert2.min.css" rel="stylesheet">
<!-- Include SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.2/dist/sweetalert2.min.js"></script>
<style>
.fc .fc-daygrid-day.fc-day-today {
    background-color: #007bff;
    color: white;
}
.fc-day {
    background: #ffffff00;
}

    html .darkmode .fc .fc-daygrid-day-number,
    html[data-theme=dark] .fc .fc-daygrid-day-number {
        color: #ffffff;
    }
    html .darkmode .fc td,
    html[data-theme=dark] .fc td {
        border-color: #1b1632;
    }
    html .darkmode .fc th ,
    html[data-theme=dark] .fc th  {
        border-color: #1b1632;
        background: #1b1632;
    }
    html .darkmode .fc .fc-col-header-cell-cushion ,
    html[data-theme=dark] .fc .fc-col-header-cell-cushion {
        color: #fdfeff;
    }
    html .darkmode .fc-theme-standard .fc-scrollgrid ,
    html[data-theme=dark] .fc-theme-standard .fc-scrollgrid  {
        border: 1px solid #1b1632;
    }
    #custom-slider {
        padding: 6px;
    }

</style>
@endsection
@section('container')


            <div class="row">
                <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
                    <h3>Halaman Beranda</h3>
                    <div class="my-auto mb-2">
                        {{-- <h3 class="page-title mb-1">Beranda</h3> --}}
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Beranda</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Dashboard Teacher</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                @if($pengumuman->count())
                <div class="slider-container rounded mb-3" style="background: url('{{ asset('asset/img/bg-announcement.jpg') }}'); no-repeat center center; background-size: cover; position: relative; color: white;">
                    <!-- Slider items -->
                    @foreach ($pengumuman as $item )
                    <div id="custom-slider" class="d-flex align-items-center {{  $pengumuman->count() > 1 ? 'slider-item' : ''  }} ">


                        <div class="mt-2 ms-5">
                             <a data-bs-toggle="modal"  data-bs-target="#view_details-{{ $item->id }}" ><h3 class="text-white  " >{{ $item->title }}</h3></a>
                             <div class="d-flex">
                                <p class="text-light mb-0 text-white">{!! \Str::limit($item->content, 100) !!}</p>
                             </div>

                        </div>
                        <div class="image-container ms-auto">
                            <img src="{{ asset('asset/img/logo-white.png') }}" alt="2025 Logo" style="height: 50px;">
                        </div>
                    </div>
                    @endforeach
                </div>
                @foreach ($pengumuman  as $item)
                <div class=" modal fade " id="view_details-{{ $item->id }}" aria-modal="true" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{ $item->title }}</h4>
                                <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="ti ti-x"></i>
                                </button>
                            </div>
                            <div class="modal-body pb-0">

                                <p>
                                    <div class="bg-light p-3 pb-2 rounded">
                                        {!! $item->content !!}
                                    </div>
                                </p>
                                <div class="mb-3">
                                    <label class="form-label d-block">Message To</label>
                                    @foreach (json_decode($item->recived) as $a)
                                        <span class="badge badge-soft-primary me-2">{{ ucfirst($a) }}</span>
                                     @endforeach

                                </div>
                                <div class="border-top pt-3">
                                    <div class="d-flex align-items-center flex-wrap">
                                        <div class="d-flex align-items-center me-4 mb-3">
                                            <span class="avatar avatar-sm bg-light me-1"><i class="ti ti-calendar text-default fs-14"></i></span>Added on: {{ \Carbon\Carbon::parse($item->date)->format('d M y') }}

                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <span class="avatar avatar-sm bg-light me-1"><i class="ti ti-user text-default fs-14"></i></span>Added By
                                            : {{ $item->author }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /View Details -->

                </div>
                @endforeach
                @endif


            @if(auth()->user()->gtk->id_rfid === '')
            <div class="alert alert-info">
                <strong><span class="ti ti-info-circle"></span> Info:</strong> Anda belum Tertaut ke <u>RFID</u> manapun, silahkan hubungi admin untuk bergabung.
            </div>
            @endif
            <div class="row">
                <div class="col-xxl-8 col-xl-12">
                    <div class="row">
                        <div class="col-xxl-7 col-xl-8 d-flex">
                            <div class="card bg-dark position-relative flex-fill">
                                <div class="card-body pb-1">
                                    <div class="d-sm-flex align-items-center justify-content-between row-gap-3">
                                        <div class="d-flex align-items-center overflow-hidden mb-3">
                                            <div
                                                class="avatar avatar-xxl rounded flex-shrink-0 border-0 border-white me-3">
                                                @if(auth()->user()->role == "guru")
                                                @if(Auth::user()->gtk == NULL)
                                                   <img src='{{ asset('asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                                                @else
                                                   @if(Auth::user()->gtk->gambar == "" )
                                                       <img src='{{ asset('asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                                                   @else
                                                       <img src="/storage/{{ Auth::user()->gtk->gambar }}" alt='Img' class='img-fluid'>
                                                   @endif
                                                @endif
                                               @endif

                                               @if( auth()->user()->role == "walikelas")
                                                   @if(Auth::user()->gtk == NULL)
                                                       <img src='{{ asset('asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                                                   @else
                                                   @if(Auth::user()->gtk->gambar == "" )
                                                       <img src='{{ asset('asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                                                   @else
                                                       <img src="/storage/{{ Auth::user()->gtk->gambar }}" alt='Img' class='img-fluid'>
                                                   @endif
                                                   @endif
                                               @endif
                                            </div>
                                            <div class="overflow-hidden">
                                                <span
                                                    class="badge bg-transparent-primary text-primary mb-1">NIK : {{ auth()->user()->nomor }}</span>
                                                <h3 class="text-white mb-1 text-truncate">{{ auth()->user()->nama }} </h3>
                                                <div
                                                    class="d-flex align-items-center flex-wrap text-light row-gap-2">
                                                    <span class="me-2">{{ auth()->user()->gtk->tempat_lahir }}, {{  auth()->user()->gtk->tanggal_lahir }}</span>
                                                    <span class="d-flex align-items-center"><i
                                                            class="ti ti-circle-filled text-warning fs-7 me-1"></i>
                                                            @if(auth()->user()->gtk->status == 1)
                                                                <span class="badge badge-success ms-2">Status : Aktif</span>
                                                            @else
                                                                <span class="badge badge-danger ms-2">Status :  Tidak Aktif</span>
                                                            @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="{{ route('profileIndex',auth()->user()->nomor) }}"
                                            class="btn btn-primary flex-shrink-0 mb-3"><span class="ti ti-pencil"></span> Edit
                                            Profile</a>
                                    </div>
                                    <div class="student-card-bg">
                                        <img src="https://preskool.dreamstechnologies.com/html/template/assets/img/bg/circle-shape.png"
                                            alt="Bg">
                                        <img src="https://preskool.dreamstechnologies.com/html/template/assets/img/bg/shape-02.png"
                                            alt="Bg">
                                        <img src="https://preskool.dreamstechnologies.com/html/template/assets/img/bg/shape-04.png"
                                            alt="Bg">
                                        <img src="https://preskool.dreamstechnologies.com/html/template/assets/img/bg/blue-polygon.png"
                                            alt="Bg">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-5 col-xl-4 d-flex">
                            <div class="card flex-fill rounded">
                                <div class="card-body">
                                    <div class="d-flex align-items-center flex-wrap mb-2">
                                    @php
                                     $hour = date('H');
                                     if ($hour < 12) { $ucapan = "Selamat Pagi!" ; } elseif ($hour < 18) { $ucapan = "Selamat Siang!" ; } else { $ucapan= "Selamat Malam!"
                                         ; } @endphp
                                     <h3 class="me-2 mb-2">Hallo, {{ $ucapan }}</h3>
                                        <p>Jadilah cahaya yang menerangi jalan, karena setiap usaha yang tulus akan berbuah hasil!</p>
                                 </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <h4 class="me-2"><span class="ti ti-school"></span> Kelas Hari ini</h4>
                                <div class="owl-nav slide-nav2 text-end nav-control"></div>
                            </div>
                            <div class="d-inline-flex align-items-center class-datepick">
                                @php
                                $currentDate = Carbon\Carbon::now();
                            @endphp

                           <strong> <p><span class="ti ti-calendar-due"></span> {{ $currentDate->isoFormat('DD MMM YYYY') }}</p></strong>
                            </div>
                        </div>
                        <div class="card-body ">
                            <div class="owl-carousel  task-slider">
                                @php
                                // Mendapatkan hari ini dalam format numerik (misal: 0 = Minggu, 1 = Senin, ..., 6 = Sabtu)
                                $today = \Carbon\Carbon::now()->dayOfWeek;
                                $found = false;  // Flag untuk mengecek apakah ada jadwal yang sesuai dengan hari ini
                            @endphp

                            @foreach ($jadwal as $item)
                                @if ($item->day == $today) <!-- Menyaring berdasarkan hari -->
                                    @php
                                        $found = true;  // Set flag ke true jika ada data yang cocok
                                    @endphp
                                    <div class="item rounded border">
                                        <div class="bg-light-400 p-3">
                                            <h5 class="mb-2">{{ $item->mata_pelajaran->nama }}</h5>
                                            @php
                                                $now = \Carbon\Carbon::now();  // Mendapatkan waktu saat ini
                                                $endTime = \Carbon\Carbon::parse($item->end);  // Parse waktu yang ada pada $item->end
                                            @endphp
                                            <span class="badge badge-sm mb-2
                                                {{ $now > $endTime ? 'badge-danger text-decoration-line-through' : 'badge-primary' }}">
                                                <i class="ti ti-clock me-1"></i> {{ $item->start }} - {{ $item->end }}
                                            </span>

                                            @if($now > $endTime)
                                                <span class="ti ti-checks text-success"></span>
                                            @endif

                                            <p class="text-dark">Kelas: <strong>{{ $item->getKelas->nama_kelas }} {{ $item->getKelas->jurusanKelas->nama_jurusan }} {{ $item->getKelas->sub_kelas }}</strong></p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            <!-- Tampilkan pesan jika tidak ada data yang ditemukan -->
                            @if (!$found)
                            <div class="card p-5">
                                <p class="text-center">Data tidak ditemukan untuk hari ini.</p>
                            </div>

                            @endif

                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-xxl-6 col-xl-6 col-md-6 d-flex">
                            <div class="card flex-fill">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h4 class="card-title">Grafik Presensi Absensi</h4>
                                    <div>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetail-{{ auth()->user()->gtk->id_rfid ?? '1'}}"><span class="ti ti-list-details"></span></button>
                                    </div>
                                </div>
                                <div class="card-body pb-0">
                                    <div class="bg-light-300 rounde border p-3 mb-3">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                                            <h6 class="mb-2">Absensi minggu ini</h6>
                                            <p id="week-range" class="fs-12 mb-2"></p>
                                        </div>
                                        <div class="d-flex align-items-center rounded gap-1 flex-wrap">
                                            <a href="javascript:void(0);" id="monday" class="badge badge-lg border">M</a>
                                            <a href="javascript:void(0);" id="tuesday" class="badge badge-lg border">T</a>
                                            <a href="javascript:void(0);" id="wednesday" class="badge badge-lg border">W</a>
                                            <a href="javascript:void(0);" id="thursday" class="badge badge-lg border">T</a>
                                            <a href="javascript:void(0);" id="friday" class="badge badge-lg border">F</a>
                                            <a href="javascript:void(0);" id="saturday" class="badge badge-lg border">S</a>
                                            <a href="javascript:void(0);" id="sunday" class="badge badge-lg border">S</a>
                                        </div>
                                    </div>
                                    <div class="border rounded p-3">
                                        <div class="row">
                                            <div class="row">
                                                <div class="col text-center border-end">
                                                    <p class="mb-1">Tepat Waktu</p>
                                                    <h5>{{ $present }}</h5>
                                                </div>
                                                <div class="col text-center border-end">
                                                    <p class="mb-1">Terlambat</p>
                                                    <h5>{{ $late }}</h5>
                                                </div>
                                                <div class="col text-center">
                                                    <p class="mb-1">Absent</p>
                                                    <h5>{{ $halfDay }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center my-3 ">
                                        <canvas id="donutChart" width="100" height="100"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xxl-6 col-xl-6 col-md-6 d-flex flex-column">
                            <div class="card">

                        <div class="col mb-3 p-3">
                            <div class="d-flex justify-content-between">
                                <h4 class="mb-2">Kalender Mingguan</h4>
                                <div>
                                    <strong>
                                        <p id="clock"> </p>
                                    </strong>
                                </div>
                            </div>

                            <div id="weekly-calendar" class="calendar "></div>
                        </div>
                            </div>
                            <div class="card flex-fill">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h4 class="card-title"><span class="ti ti-album"></span> Ruangan Kelas Saya</h4>

                                </div>
                                <div class="card-body event-scroll">
                                    @if($classRoom->count())
                                    @foreach ($classRoom as $item )
                                    <div
                                        class="d-flex align-items-center justify-content-between p-3 mb-2 border br-5">
                                        <div class="d-flex align-items-center overflow-hidden me-2">
                                            <a href="javascript:void(0);"
                                                class="avatar avatar-lg flex-shrink-0 br-6 me-2">
                                                <img src="{{ asset('asset/img/educational-video.png') }}"
                                                    alt="student">
                                            </a>
                                            <div class="overflow-hidden">
                                                <h6 class="mb-1 text-truncate"><a href="{{ route('classroom.detail',$item->class_code) }}">{{ $item->name }}</a></h6>
                                                <p>Ceated at :<span class="badge badge-soft-success d-inline-flex align-items-center ms-2"> {{ \Carbon\Carbon::parse($item->created_at)->locale('id')->isoFormat('D MMM YYYY') }}</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <img src="https://preskool.dreamstechnologies.com/html/template/assets/img/icons/medal.svg"
                                                alt="icon">
                                            <span class="badge badge-success ms-2"> {{ $item->people->count() ?? 0 }}<span class="ti ti-users text-white"></span></span>
                                        </div>
                                    </div>
                                    @endforeach
                                    @else
                                    <div class="d-flex justify-content-center align-items-start ">
                                        Anda Belum membuat Kelas
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-xxl-4 col-xl-12 d-flex ">
                    <div class="card flex-fill">

                        <div class="card-body">
                            <div id="mycalendar" class="mb-3"></div>
                            {{-- <div class="datepic"></div> --}}
                            <h4 class="mb-3">Kegiatan Mendatang</h4>

                            <div class="event-scroll">
                                @if($events->count() || count($data))
                                @foreach ($events as $a)
                                <div class="border-start border-primary border-3 shadow-sm p-3 mb-3">
                                    <div class="d-flex align-items-center  ">
                                        <span class="avatar p-1 me-2 bg-primary-transparent flex-shrink-0">
                                            <i class="ti ti-vacuum-cleaner fs-24"></i>
                                        </span>
                                        <div class="flex-fill">
                                            <h6 class="mb-1">{{ $a->title }}</h6>
                                            <p class="d-flex align-items-center"><i
                                                    class="ti ti-calendar me-1"></i>{{ \Carbon\Carbon::parse($a->start)->format('d F Y') }}
                                                    - {{ \Carbon\Carbon::parse($a->end)->format('d F Y') }}
                                                </p>
                                        </div>
                                    </div>

                                </div>
                                @endforeach

                                @foreach($data as $a)  <!-- Loop through the data returned from the API -->
                                <div class="border-start border-primary border-3 shadow-sm p-3 mb-3">
                                    <div class="d-flex align-items-center">
                                        <span class="avatar p-1 me-2 bg-primary-transparent flex-shrink-0">
                                            <i class="ti ti-vacuum-cleaner fs-24"></i>
                                        </span>
                                        <div class="flex-fill">
                                            <h6 class="mb-1">{{ $a['holiday_name'] }}</h6>
                                            <p class="d-flex align-items-center">
                                                <i class="ti ti-calendar me-1"></i>
                                                {{ \Carbon\Carbon::parse($a['holiday_date'])->format('d F Y') }} -

                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="bg-light rounded">
                                    <div class="my-5 ms-4">
                                        <p>Tidak ada event atau kegiatan pada bulan ini</p>
                                    </div>
                                </div>
                                @endif


                            </div>
                        </div>

                    </div>
                </div>

            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h4 class="card-title">Tugas Kelas</h4>
                            <span class="badge badge-primary">({{ $tasks->count() }}) Tugas</span>
                        </div>
                        <div class="card-body">
                            <div class="owl-carousel owl-theme lesson">
                                @if($tasks->count())
                                @foreach ($tasks as $a)
                                    <div class="item">
                                        <div class="card mb-0">
                                            <div class="card-body">
                                                <div
                                                    class="bg-primary-transparent rounded p-2 fw-semibold mb-3 text-center">
                                                  {{ $a->getKelas->name }}</div>
                                                <div class="border-bottom mb-3">
                                                    <h5 class="mb-3"> {{ $a->judul }}</h5>
                                                    @php
                                                        $totalSiswa = $a->getPeople->count();
                                                        $siswaMengumpulkan = $a->getFileTugas->count();
                                                        $persentase = $totalSiswa > 0 ? ($siswaMengumpulkan / $totalSiswa) * 100 : 0;
                                                     @endphp


                                                    <div class="progress progress-xs mb-3">
                                                        <div class="progress-bar bg-primary" role="progressbar"
                                                            style="width: {{ number_format($persentase, 2) }}%" aria-valuenow="25" aria-valuemin="0"
                                                            aria-valuemax="100"> </div>
                                                    </div>
                                                    {{ number_format($persentase, 2) }} %
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <a href="https://preskool.dreamstechnologies.com/html/template/schedule-classes.html"
                                                        class="fw-medium"><i class="ti ti-edit me-1"></i>Detail Tugas</a>
                                                    <a href="#" class="link-primary"><i
                                                            class="ti ti-share-3 me-1"></i>Share</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @else
                                <div class="rounded p-3 border">
                                    <p>Tidak menemukan tugas di kelasn manapun</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="modal fade" id="modalDetail-{{ auth()->user()->gtk->id_rfid ?? '1'}}" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetailLabel"><span class="ti ti-list-details"></span> Detail Presensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body m-0 p-0" style="max-height: 200px; overflow-y: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Masuk Jam</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($hadir->count())
                            @foreach ($hadir as $a)
                                <tr  class="table-row">
                                    <td>{{ $a->tanggal }}</td>
                                    <td>{{ $a->entry }}</td>
                                    <td>
                                        @php
                                        $entryTime = \Carbon\Carbon::parse($a->entry); // Convert the entry time to Carbon instance
                                        $estimasiWaktu = (int) app('settings')['estimasi_waktu_masuk']; // Ensure estimasi_waktu_masuk is an integer
                                        $thresholdTime = \Carbon\Carbon::parse($jamMasuk); // The base threshold time (7:00 AM)
                                        $twentyMinutesThreshold = $thresholdTime->copy()->addMinutes(20); // 7:20 AM, copied to avoid modification of the original threshold time
                                        $estimasiThreshold = $thresholdTime->copy()->addMinutes($estimasiWaktu); // Entry time threshold considering estimated time
                                    @endphp

                                    @if($entryTime->lte($thresholdTime))
                                        <span class="badge badge-warning"><span class="ti ti-info-circle"></span> Tepat Waktu</span>
                                    @elseif($entryTime->lte($twentyMinutesThreshold)) <!-- Entry time before or at 7:20 AM -->
                                        <span class="badge badge-success"><span class="ti ti-info-circle"></span> Tepat Waktu</span>
                                    @elseif ($entryTime->lte($estimasiThreshold))  <!-- Entry time between 7:20 AM and the estimated time -->
                                        <span class="badge badge-warning"><span class="ti ti-info-circle"></span> Setengah Hari</span>
                                    @else  <!-- Entry time after the estimated time -->
                                        <span class="badge badge-danger"><span class="ti ti-info-circle"></span> Terlambat</span>
                                    @endif


                                    </td>
                                </tr>
                            @endforeach
                            @else
                            <tr>
                                <td rowspan="3"> Anda belum melakukan Absensi</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary w-100" data-bs-dismiss="modal">Oke</button>
                </div>
            </div>
        </div>
    </div>

    <div id="no-events-message" style="display: none; text-align: center; margin-top: 20px;">
        <p>No events to display.</p>
    </div>

@section('javascript')


<script>
    document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('mycalendar');

    var noEventsEl = document.getElementById('no-events-message');  // A new div to show when there are no events

    // Show the loading indicator while fetching data


    // Get the current year
    const currentYear = new Date().getFullYear();

    // Fetch holidays from the public API using the current year
    fetch(`https://api-harilibur.netlify.app/api?year=${currentYear}`)
        .then(response => response.json())
        .then(holidays => {
            // Filter holidays where is_national_holiday is true
            const nationalHolidays = holidays.filter(holiday => holiday.is_national_holiday === true);

            // Format the national holidays into FullCalendar events
            const holidayEvents = nationalHolidays.map(holiday => ({
                title: holiday.holiday_name,  // Holiday name
                start: holiday.holiday_date,  // Holiday date
                color: 'red',  // Default holiday color
                textColor: 'white'  // Text color for the holiday event

            }));

            // Fetch events from your Laravel backend
            fetch('/events')
                .then(response => response.json())
                .then(events => {
                    // Combine the national holiday events with backend events
                    const allEvents = [
                        ...holidayEvents,  // Add holiday events
                        ...events.map(event => ({
                            id: event.id,
                            title: event.title,  // Event title
                            start: event.start,  // Event start date
                            end: event.end,  // Event end date (optional)
                            color: event.warna || '#3d5ee1',  // Set event color from 'warna' field or use default
                            textColor: 'white',  // Text color for event
                             // Ensure each event has a unique 'id' field from the backend
                        }))
                    ];

                    // Check if there are any events; if none, show a custom "No Events" message
                    if (allEvents.length === 0) {
                        noEventsEl.style.display = 'block';
                    } else {
                        noEventsEl.style.display = 'none';
                    }

                    // Initialize FullCalendar
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',  // Set initial view to multiMonthYear
                        events: allEvents,  // Combine holiday events and backend events

                        eventDisplay: 'auto',

                        // Make the calendar read-only
                        editable: false,  // Disable dragging and resizing
                        droppable: false,  // Disable dragging events onto the calendar

                        eventClick: function(info) {
                            // Format the event dates in a readable way
                            const startDate = new Intl.DateTimeFormat('id-ID', {
                                day: '2-digit',
                                month: 'long',
                                year: 'numeric'
                            }).format(info.event.start);

                            const endDate = info.event.end ? new Intl.DateTimeFormat('id-ID', {
                                day: '2-digit',
                                month: 'long',
                                year: 'numeric'
                            }).format(info.event.end) : '';

                            // SweetAlert for event details with delete option
                            Swal.fire({
                                title: info.event.title,
                                text: 'Start: ' + startDate +
                                    (endDate ? '\nEnd: ' + endDate : ''),
                                icon: 'info',
                                showCancelButton: true,
                                confirmButtonText: 'Delete Event.?',
                                cancelButtonText: 'Close',
                                preConfirm: () => {
                                    // If delete is confirmed, call the delete function
                                    deleteEvent(info.event, calendar);
                                }
                            });
                        }
                    });

                    // Render the calendar
                    calendar.render();


                })
                .catch(error => {
                    console.error('Error fetching backend events:', error);

                });
        })
        .catch(error => {
            console.error('Error fetching holidays:', error);

        });
        function getCSRFToken() {
            return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        }
    // Function to handle event deletion
    function deleteEvent(event, calendar) {
        const csrfToken = getCSRFToken();
        // Send DELETE request to the backend to delete the event
        fetch(`/events/${event.id}`, {
            method: 'get',
            headers: {
                'Content-Type': 'application/json',
                'X-XSRF-TOKEN': csrfToken // Send CSRF token with the request
                // Add any necessary authentication headers
            }
        })
        .then(response => {
            console.log(response);  // Log the response to check if it's HTML or JSON
            if (!response.ok) {
                throw new Error('Server returned an error: ' + response.status);
            }
            return response.json();  // Parse JSON response
        })
        .then(data => {
            if (data.success) {
                const calendarEvent = calendar.getEventById(event.id);
                if (calendarEvent) {
                    calendarEvent.remove();
                }
                Swal.fire({
                    title: 'Event Deleted',
                    text: 'The event has been successfully deleted.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'There was an error deleting the event. ' + data.message,
                    icon: 'error',
                    confirmButtonText: 'Close'
                });
            }
        })
        .catch(error => {
            console.error('Error deleting event:', error);
            Swal.fire({
                title: 'Error',
                text: 'Failed to delete event. ' + error.message,
                icon: 'error',
                confirmButtonText: 'Close'
            });
        });
    }
});

</script>
<script>
    // Function to format the time
function formatTime(hours, minutes, seconds) {
    return (hours < 10 ? '0' : '') + hours + ':' +
           (minutes < 10 ? '0' : '') + minutes + ':' +
           (seconds < 10 ? '0' : '') + seconds;
}

// Function to update the clock
function updateClock() {
    var now = new Date();  // Get the current date and time
    var hours = now.getHours();
    var minutes = now.getMinutes();
    var seconds = now.getSeconds();

    // Format the time
    var timeString = formatTime(hours, minutes, seconds);

    // Set the time in the HTML element with ID 'clock'
    document.getElementById('clock').innerText = timeString;
}

// Update the clock every 1000 milliseconds (1 second)
setInterval(updateClock, 1000);

// Initial call to display the time as soon as the page loads
updateClock();

function generateWeekCalendar() {
const today = new Date();
const currentDay = today.getDate(); // Get the current day of the month
const startOfWeek = today.getDate() - today.getDay(); // Sunday is the first day of the week
const weekDays = [];

for (let i = 0; i < 7; i++) {
    const day = new Date(today.getFullYear(), today.getMonth(), startOfWeek + i);
    weekDays.push(day);
}

const calendarContainer = document.getElementById('weekly-calendar');
calendarContainer.innerHTML = ''; // Clear previous calendar if any

weekDays.forEach(day => {
    const dayElement = document.createElement('div');
    dayElement.classList.add('calendar-day'); // Add a class for each day

    // Mark today as active
    if (
        day.getFullYear() === today.getFullYear() &&
        day.getMonth() === today.getMonth() &&
        day.getDate() === today.getDate()
    ) {
        dayElement.classList.add('active-day'); // Add active class for today
    }

    const dayName = day.toLocaleString('id-ID', { weekday: 'long' }); // Get the day name in Indonesian
    const dayDate = day.getDate();

    dayElement.innerHTML = `
        <div class="day-name">${dayName}</div>
        <div class="day-date">${dayDate}</div>
    `;

    calendarContainer.appendChild(dayElement);
});
}

generateWeekCalendar();

</script>
<script>
    function getCurrentWeekRange() {
    const currentDate = new Date(); // Get today's date

    // Get the current day of the week (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
    const currentDay = currentDate.getDay();

    // Calculate the difference to the previous Monday (start of the week)
    const diffToMonday = currentDay === 0 ? 6 : currentDay - 1;
    const startOfWeek = new Date(currentDate);  // Start with today's date
    startOfWeek.setDate(currentDate.getDate() - diffToMonday);  // Set it to the previous Monday

    // Calculate the end of the week (next Sunday)
    const endOfWeek = new Date(startOfWeek);
    endOfWeek.setDate(startOfWeek.getDate() + 6);  // Add 6 days to the start of the week to get Sunday

    // Format the dates in 'dd MMM yyyy' format (e.g., "01 Jan 2025")
    const formatDate = (date) => {
        const day = String(date.getDate()).padStart(2, '0');
        const month = date.toLocaleString('default', { month: 'short' });
        const year = date.getFullYear();
        return `${day} ${month} ${year}`;
    };

    // Get the formatted dates for the start and end of the week
    const startFormatted = formatDate(startOfWeek);
    const endFormatted = formatDate(endOfWeek);

    // Display the week range in the <p> element
    document.getElementById('week-range').textContent = `${startFormatted} - ${endFormatted}`;
}

// Call the function to display the current week's range
getCurrentWeekRange();
</script>
<script>
    const absenceData = @json($absenceData);

    // Function to apply the correct badge color based on absence count
    function updateBadgeColors() {
        // Get today's date
        const today = new Date();

        // Loop over each day and apply the appropriate color based on absence data
        Object.keys(absenceData).forEach(day => {
            const badge = document.getElementById(day); // Get badge element by ID

            // Convert the day to a JavaScript Date object for comparison
            const date = new Date(today);  // Clone today's date
            date.setDate(today.getDate() - (today.getDay() - getDayIndex(day))); // Set to the target day of the week (e.g., Monday)

            // If the absence data for the day is greater than 0, mark as active (bg-success)
            if (absenceData[day] > 0) {
                badge.classList.add('bg-success', 'text-white');
                badge.classList.remove('bg-danger', 'bg-white', 'text-default', 'text-gray-1');
            } else if (absenceData[day] === 0) {
                // If no attendance record for the day, mark as inactive (bg-white)
                badge.classList.remove('bg-success', 'bg-danger', 'text-white');
                badge.classList.add('bg-white', 'text-default');
            }

            // Add bg-danger if the date is before today

        });
    }

    // Helper function to get index of the day (e.g., "monday" => 1, "sunday" => 7)
    function getDayIndex(day) {
        const dayNames = {
            "monday": 1,
            "tuesday": 2,
            "wednesday": 3,
            "thursday": 4,
            "friday": 5,
            "saturday": 6,
            "sunday": 7
        };
        return dayNames[day.toLowerCase()];
    }

    // Call the function to update badge colors based on absence data
    updateBadgeColors();
</script>

<script>
    const ctx = document.getElementById('donutChart').getContext('2d');
    const data = {
        labels: ['Tepat Waktu', 'Terlambat', 'Absent'],
        datasets: [{
            data: [{{ $present }}, {{ $late }}, {{ $halfDay }}],
            backgroundColor: ['rgb(17, 112, 228)', 'rgb(232, 38, 70)', 'rgb(26, 190, 23)'],
            hoverOffset: 4
        }]
    };

    const config = {
        type: 'doughnut',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    enabled: true
                }
            },
            cutout: '50%', // Adjusts the donut hole size
        },
    };

    new Chart(ctx, config);
</script>
<script>
    var body = document.body;
    body.classList.add("mini-sidebar");
</script>
@endsection
@endsection
