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

        #donutChart {
            max-width: 100%;
            max-height: 230px;
            padding: 10px;
        }
        .slider-container {
            position: relative;
            height: 80px; /* Sesuaikan tinggi kontainer */
            overflow: hidden;
            color:white;
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
@endsection
@section('container')
<div class="d-md-flex d-block align-items-center justify-content-between mb-3 border-bottom">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1"><span class="ti ti-dashboard"></span> Halaman Beranda</h3>
    </div>
    <div class="d-md-flex d-block align-items-center justify-content-between mb-3 ">
        <div class="my-auto mb-2">
            {{-- <h3 class="page-title mb-1">Beranda</h3> --}}
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a>Beranda</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard Siswa</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
@if($pengumuman->count())
<div class="slider-container rounded mb-3" style="background: url('{{ asset('asset/img/bg-announcement.jpg') }}'); no-repeat center center; background-size: cover; position: relative; color: white;">
    <!-- Slider items -->
    @foreach ($pengumuman as $item )
    <div id="custom-slider" class="d-flex align-items-center {{  $pengumuman->count() > 1 ? 'slider-item' : ''  }} ">


        <div class="mt-4 ms-5">
             <a data-bs-toggle="modal"  data-bs-target="#view_details-{{ $item->id }}" ><h3 class="text-white  " >{{ $item->title }}</h3></a>
             <div class="d-flex">
                <p class="text-light mb-0 text-white">{!! \Str::limit($item->content, 100) !!}</p>
             </div>

        </div>
        <div class="image-container ms-auto me-2">
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

@if(auth()->user()->rombelstudent || auth()->user()->rombelstudent)
    <div class="col-xl-12 d-flex">
        <div class="row flex-fill">
            <div class="col-sm-6 col-xl-3 d-flex">
                <a href="/classroom"
                    class="card border-0 border-bottom border-primary flex-fill animate-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-md rounded bg-primary me-2"><i
                                    class="ti ti-chalkboard fs-16"></i></span>
                            <h6>Kelas Saya</h6>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-xl-3 d-flex">
                <a href="{{ route('absent_list', [auth()->user()->rombelstudent->id_kelas, auth()->user()->rombelstudent->nis]) }}" class="card border-0 border-bottom border-success flex-fill animate-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-md rounded bg-success me-2"><i
                                    class="ti ti-list-details fs-16"></i></span>
                            <h6>Daftar Hadir Kelas </h6>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-xl-3 d-flex">
                <a href="{{ route('leassonView', auth()->user()->rombelstudent->id_kelas) }}"
                    class="card border-0 border-bottom border-warning flex-fill animate-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-md rounded bg-warning me-2"><i
                                    class="ti ti-calendar fs-16"></i></span>
                            <h6>Jadwal Pelajaran</h6>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-xl-3 d-flex">
                <a href="{{ route('profileIndex',auth()->user()->nomor) }}"
                    class="card border-0 border-bottom border-dark flex-fill animate-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-md rounded bg-dark me-2"><i
                                    class="ti ti-user fs-16"></i></span>
                            <h6>Profile Saya</h6>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@else
<div class="alert alert-info">
    <strong><span class="ti ti-info-circle"></span> Info:</strong> Anda belum bergabung dalam <u>kelas</u> manapun, silahkan hubungi admin untuk bergabung.
</div>
@endif
<div class="row flex-fill">
    <div class="col-xl-6 d-flex">
        <div class="flex-fill" >
            <div class="card bg-dark position-relative" >
                <div class="card-body">
                    <div class="d-flex align-items-center row-gap-3 mb-3">
                        <div class="avatar avatar-xxl rounded flex-shrink-0 me-3">
                           {{-- user siswa --}}
                        @if(auth()->user()->role == "siswa")
                        @if(Auth::user()->student == NULL)
                           <img src='{{ asset('asset/img/user-default.jpg')  }}' alt='Img' class='img-fluid'>
                        @else
                           @if(Auth::user()->student->foto == "" )
                               <img src='{{ asset('asset/img/user-default.jpg')  }}' alt='Img' class='img-fluid'>
                           @else
                                <img src="{{ asset('storage/' . Auth::user()->student->foto) }}" alt="Img" class="img-fluid">
                           @endif
                        @endif
                       @endif

                      @if(auth()->user()->role == "guru")
                        @if(Auth::user()->gtk == NULL)
                           <img src='{{ asset('asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                        @else
                           @if(Auth::user()->gtk->gambar == "" )
                               <img src='{{ asset('asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                           @else
                            <img src="{{ asset('storage/' . Auth::user()->gtk->gambar) }}" alt="Img" class="img-fluid">
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
                            <img src="{{ asset('storage/' . Auth::user()->gtk->gambar) }}" alt="Img" class="img-fluid">
                           @endif
                           @endif
                       @endif

                       @if(auth()->user()->role == "admin" || auth()->user()->role == "superadmin" )
                           <img src='{{ asset('asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                       @endif


                        </div>
                        <div class="d-block">
                            <span class="badge bg-transparent-primary text-primary mb-1">NIS : {{ auth()->user()->nomor }}</span>
                            <h3 class="text-truncate text-white mb-1">{{ auth()->user()->nama }}</h3>
                            <div class="d-flex align-items-center flex-wrap row-gap-2 text-gray-2">
                                <span class="  pe-2">
                                   Kelas :
                                </span>
                                @if(Auth::user()->rombelstudent)
                                <span>{{ Auth::user()->rombelstudent->getkelas->nama_kelas }} {{ Auth::user()->rombelstudent->getkelas->jurusanKelas->nama_jurusan }} {{ Auth::user()->rombelstudent->getkelas->sub_kelas }}</span>
                                @else
                                <span>Belum disetel</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div
                        class="d-flex align-items-center justify-content-between profile-footer flex-wrap row-gap-3 pt-4">
                        <div class="d-flex align-items-center">
                            <h6 class="text-white">Status</h6>
                            <span class="badge bg-success d-inline-flex align-items-center ms-2">{{ auth()->user()->status == '2' ?' Aktif' : 'Tidak Aktif'  }}</span>
                        </div>
                        <a href="{{ route('profileIndex',auth()->user()->nomor) }}" class="btn btn-primary"><span class="ti ti-pencil"></span>Edit Profile</a>
                    </div>
                    <div class="student-card-bg">
                        <img src="https://preskool.dreamstechnologies.com/html/template/assets/img/bg/circle-shape.png" alt="Bg">
                        <img src="https://preskool.dreamstechnologies.com/html/template/assets/img/bg/shape-02.png" alt="Bg">
                        <img src="https://preskool.dreamstechnologies.com/html/template/assets/img/bg/shape-04.png" alt="Bg">
                        <img src="https://preskool.dreamstechnologies.com/html/template/assets/img/bg/blue-polygon.png" alt="Bg">
                    </div>
                </div>
            </div>
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="col mb-3">
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
            </div>

            <div class="card flex-fill">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="card-title">Kelas Hari Ini</h4>

                </div>
                <div class="card-body"  style="max-height: 200px; overflow-y: auto;">

                    @php
                        $day_number = date('N'); // Current day number (1 = Monday, 7 = Sunday)
                        $current_time = \Carbon\Carbon::now()->format('H:i'); // Current time in 'H:i' format
                    @endphp



                   @foreach ($jadwal as $item)
                        @php
                            $day_number = date('N'); // Current day number (1 = Monday, 7 = Sunday)
                            $current_time = \Carbon\Carbon::now()->format('H:i'); // Current time in 'H:i' format
                        @endphp

                        @if($item->jadwalStudent->where('day', $day_number)->count())
                            @foreach ($item->jadwalStudent->where('day', $day_number)->sortBy('start') as $i)
                                <div class="card mb-3">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap p-3 pb-1">
                                        <div class="d-flex align-items-center flex-wrap mb-2">
                                            <span class="avatar avatar-lg flex-shrink-0 rounded me-2">
                                                @if(!empty($i->guru->gambar))
                                                    <img src="{{ asset('storage/' . $i->guru->gambar) }}" alt="Profile">
                                                @else
                                                    <img src="{{ asset('asset/img/user-default.jpg') }}" alt="Default Profile">
                                                @endif
                                            </span>
                                            <div>
                                                <h6 class="mb-1 {{ $current_time > $i->end ? 'text-decoration-line-through' : '' }}">
                                                    @if ($i->mata_pelajaran)
                                                        {{ $i->mata_pelajaran->nama ?? 'NULL' }}
                                                    @else
                                                        {{ $i->ref->ref ?? 'NULL' }}
                                                    @endif
                                                </h6>
                                                <span><i class="ti ti-clock me-2"></i>{{ $i->start }} - {{ $i->end }}</span>
                                            </div>
                                        </div>

                                        <!-- Badge based on current time -->
                                        @if($current_time < $i->end)
                                            <span class="badge badge-soft-danger shadow-none mb-2">
                                                <i class="ti ti-circle-filled fs-8 me-1"></i>On going
                                            </span>
                                        @else
                                            <span class="badge badge-soft-success shadow-none mb-2">
                                                <i class="ti ti-circle-filled fs-8 me-1"></i>Completed
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="m-5 d-flex justify-content-center">
                                <p>Belum ada jadwal yang di atur untuk hari ini</p>
                            </div>
                        @endif
                   @endforeach






                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 ">
        <div class="card flex-fill">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h4 class="card-title"><span class="ti ti-chart-infographic"></span> Grafik Presensi Absensi</h4>
                <div>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetail-{{ auth()->user()->student->id_rfid }}"><span class="ti ti-list-details"></span></button>
                </div>
            </div>
            <div class="card-body">
                <div class="attendance-chart">

                    <div class="border rounded p-3">
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
                    <div class="text-center my-3">
                        <canvas id="donutChart" ></canvas>
                    </div>
                    <div class="bg-light-300 rounded border p-3 mb-0">
                        <div class="d-flex align-items-center justify-content-between flex-wrap mb-1">
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
                </div>
            </div>
        </div>
    </div>

   <div class="row">
        <!-- Class Faculties -->
        <div class="col-xl-12">
            <div class="card flex-fill">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="card-title"><span class="ti ti-users"></span> Guru Pengajar Kelas </h4>

                    </div>
                <div class="card-body">
                    <div class=" owl-carousel owl-loaded owl-drag">
                        <div class="owl-stage-outer">
                            <div class="owl-stage"
                              >
                              @php
                              $shownTeachers = []; // Array to keep track of teachers that have been shown
                              $foundTeachers = false; // Flag to check if any teacher is found
                          @endphp

                          @if($jadwal->isEmpty())
                              <p>No data found.</p>
                          @else
                              @foreach ($jadwal as $a)
                                  @if($a->jadwalStudent->isEmpty())
                                      <p>No data found.</p>
                                  @else
                                      @foreach ($a->jadwalStudent as $guru)
                                          @if($guru->guru && !in_array($guru->guru->id, $shownTeachers))
                                              @php
                                                  $foundTeachers = true; // Mark that a teacher is found
                                              @endphp
                                              <div class="owl-item cloned" style="width:300px; margin-right: 15px;">
                                                  <div class="card bg-light-100 mb-0">
                                                      <div class="card-body">
                                                          <div class="d-flex align-items-center mb-3">
                                                              <a class="avatar avatar-lg rounded me-2">
                                                                  @if(optional($guru->guru)->gambar)
                                                                      <img src="{{ asset('storage/'.$guru->guru->gambar) }}" alt="Img" >
                                                                  @else
                                                                      <img src="{{ asset('asset/img/user-default.jpg') }}" alt="Img" >
                                                                  @endif
                                                              </a>
                                                              <div>
                                                                  <h6 class="mb-1 text-truncate">
                                                                      <a >{{ $guru->guru->nama }}</a>
                                                                  </h6>
                                                                  <p>{{  $guru->mata_pelajaran->nama ?? ''}}</p>
                                                              </div>
                                                          </div>
                                                          <div class="row gx-2">
                                                              <div class="col-6">
                                                                  <a href="mailto:{{ $guru->guru->Usergtk->email ?? '-' }}" target="_blank"
                                                                      class="btn btn-outline-light bg-white d-flex align-items-center justify-content-center fw-semibold fs-12"><i
                                                                          class="ti ti-mail me-2"></i>Email</a>
                                                              </div>
                                                              <div class="col-6">
                                                                  <a href="https://wa.me/{{ $guru->guru->telp }}" target="_blank"
                                                                      class="btn btn-outline-light bg-white d-flex align-items-center justify-content-center fw-semibold fs-12"><i
                                                                          class="ti ti-brand-whatsapp me-2"></i>WhatsApp</a>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>

                                              @php
                                                  // Add the teacher's ID to the shownTeachers array
                                                  $shownTeachers[] = $guru->guru->id;
                                              @endphp
                                          @endif
                                      @endforeach
                                  @endif
                              @endforeach

                              @if(!$foundTeachers)
                                  <p>No teachers available.</p>
                              @endif
                          @endif

                            </div>
                        </div>
                        <div class="owl-dots disabled"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Class Faculties -->

    </div>

</div>


<div class="modal fade" id="modalDetail-{{ auth()->user()->student->id_rfid }}" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
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

@section('javascript')
<script src="{{ asset('asset/js/capture_ip.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script>
    $(document).ready(function(){
        var owl = $(".owl-carousel");

        owl.owlCarousel({
            loop: true,                // Loops the slides
            margin: 15,                // Adjusts margin between items
            nav: true,                 // Adds next/previous buttons
            items: 3,                  // Number of items to show at once
            autoplay: false,            // Enables autoplay
            autoplayTimeout: 3000,     // Time between slides (in ms)
            smartSpeed: 1000,          // Speed of the transition (in ms)
            responsive: {
                0: {
                    items: 1          // 1 item at screen width 0px and up
                },
                600: {
                    items: 2          // 2 items at screen width 600px and up
                },
                1000: {
                    items: 3          // 3 items at screen width 1000px and up
                }
            }
        });

        // Reset to the first slide after the carousel finishes.
        owl.on('changed.owl.carousel', function(event) {
            if (event.item.index === event.item.count - 1) {
                // Reset to first item after reaching the last one
                owl.trigger('to.owl.carousel', [0, 1000]);
            }
        });
    });
</script>
<script>
     var body = document.body;
     body.classList.add("mini-sidebar");
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

@endsection
@endsection
