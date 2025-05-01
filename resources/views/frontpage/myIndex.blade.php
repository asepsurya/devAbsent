<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>{{ app('settings')['site_name'] }} - {{ app('settings')['slogan'] }}</title>
    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('asset/img/logo-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ app('settings')['site_fav'] == '' ? asset('asset/img/default-logo.png') : asset('storage/' . app('settings')['site_logo']) }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ app('settings')['site_fav'] == '' ? asset('asset/img/default-logo.png') : asset('storage/' . app('settings')['site_logo']) }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ app('settings')['site_fav'] == '' ? asset('asset/img/default-logo.png') : asset('storage/' . app('settings')['site_logo'])  }}">
    <link rel="manifest" href="{{ asset('landing/img/favicons/manifest.json') }}">
    <meta name="msapplication-TileImage" content="{{ asset('landing/img/favicons/mstile-150x150.png') }}">
    <meta name="theme-color" content="#ffffff">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/jsqr/dist/jsQR.js"></script>

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <style>
        .scan-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .scan-box {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 200px;
            height: 200px;
            transform: translate(-50%, -50%);
            border: 2px solid lime;
            box-shadow: 0 0 10px lime;
        }

        .topbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1050;
            transition: top 0.3s;
        }

        /* Navbar Styling */
        .navbar {
            z-index: 1000;
            background-color: white;
            transition: margin-top 0.3s;
        }

        .mt-5 {
            margin-top: 50px !important;
        }

        .nav-link.active {
            border-bottom: 3px solid #5F37EF;
            border-radius: 0.375rem;
            /* rounded-md */
        }

        body {

            font-family: 'Inter', sans-serif;
        }

        .media-fixed-size {
            width: 100%;
            height: 300px;
            /* Atur tinggi sesuai kebutuhan */
            object-fit: cover;
            /* Agar gambar/video mengisi kotak dengan baik */
            border-radius: 8px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }
        .photo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ddd;
            margin-bottom: 15px;
        }
        .card-img-top {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin: 20px auto 10px;
            display: block;
            border: 4px solid #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            }
            .table-borderless tbody tr td {
            border-bottom: 1px solid #ddd;
            padding: 8px;
            }
        .placeholder {
            display: inline-block;
            width: 100px;
            height: 1em;
            background-color: #e0e0e0;
            border-radius: 0.25rem;
            animation: placeholder-glow 1.5s infinite;
            }

            @keyframes placeholder-glow {
            0% {
                opacity: .6;
            }
            50% {
                opacity: .3;
            }
            100% {
                opacity: .6;
            }
            }
            .table-borderless td:first-child {
            width: 130px;
            }

            .table td {
  padding: 0.5rem 0.75rem;
  border-bottom: 1px solid #eee;
}

.table td:first-child {
  color: #555;
}

.badge-status {
  padding: 0.4em 0.8em;
  border-radius: 0.5rem;
  font-size: 0.85rem;
}

.badge-hadir {
  background-color: #198754;
  color: #fff;
}

.badge-tidak {
  background-color: #dc3545;
  color: #fff;
}

/* shimmer loading */
.skeleton {
  display: inline-block;
  height: 14px;
  width: 100px;
  background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 37%, #f0f0f0 63%);
  background-size: 400% 100%;
  animation: shimmer 1.2s ease-in-out infinite;
}

@keyframes shimmer {
  0% { background-position: 200% 0; }
  100% { background-position: -200% 0; }
}
#rfidInput2:focus {
    box-shadow: none;
    border-color: #ced4da; /* atau warna border default */
}
    </style>
    <link href="{{ asset('landing/css/theme.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/iconfont/tabler-icons.min.css">
    <link rel="stylesheet" href="{{ asset('asset/css/customlanding.css') }}">

    </style>
</head>
<body>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->

    <main class="main" id="top">

        <nav id="mainNavbar" class="navbar navbar-expand-lg navbar-light fixed-top nav user-menu " data-navbar-on-scroll="data-navbar-on-scroll">

            <div class="container-fluid">

                {{-- Logo --}}
                <a class="navbar-brand d-flex align-items-center" href="/">
                    <img src="{{ !empty(app('settings')['site_logo']) ? asset('storage/' . app('settings')['site_logo']) : asset('asset/img/default-logo.png') }}" alt="Logo" width="50px" />
                    <h5 class="mb-0 ms-2 mt-1">{{ app('settings')['site_name'] }}</h5>
                </a>

                {{-- Toggler (Mobile) --}}
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                {{-- Navbar Right Side --}}
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto align-items-lg-center gap-3 "> {{-- fs-5 = ukuran font ideal --}}

                        {{-- Menu Navigasi --}}
                        <li class="nav-item">
                            <a class="nav-link px-2 active" href="#section1">
                                <i class="ti ti-home me-1"></i> SELAMAT DATANG DI APLIKASI ABSENSI SISWA
                            </a>
                        </li>


                        {{-- Login / Profil User --}}
                        @if(auth()->user())
                        <li class="nav-item ps-2 d-block d-md-none">
                            <a href="#" class="nav-link " data-bs-toggle="modal" data-bs-target="#barcodeModal">
                                <i class="ti ti-scan me-1"></i> Scan Barcode
                            </a>
                        </li>
                        {{-- Profil User Dropdown --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center px-2" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                @php
                                $userImg = asset('asset/img/user-default.jpg');
                                if(auth()->user()->role == 'siswa' && Auth::user()->student?->foto) {
                                $userImg = asset('storage/' . Auth::user()->student->foto);
                                } elseif(in_array(auth()->user()->role, ['guru', 'walikelas']) && Auth::user()->gtk?->gambar) {
                                $userImg = asset('storage/' . Auth::user()->gtk->gambar);
                                }
                                @endphp
                                <img src="{{ $userImg }}" class="rounded-circle me-2" width="36" height="36" alt="User">
                                {{-- <span class="fw-semibold">{{ auth()->user()->nama }}</span> --}}
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end mt-2 shadow-sm" aria-labelledby="userDropdown">
                                @php
                                $role = auth()->user()->role;
                                $link = match($role) {
                                'admin' => route('dashboard.admin'),
                                'walikelas' => route('dashboard.walikelas'),
                                'superadmin' => route('dashboard.superadmin'),
                                'guru' => route('dashboard.teacher'),
                                default => route('dashboard.student')
                                };
                                @endphp
                                <li>
                                    <a class="dropdown-item" href="{{ $link }}">
                                        <i class="ti ti-dashboard me-2"></i> Dashboard
                                    </a>
                                </li>
                                @if ($role != 'superadmin')
                                <li>
                                    <a class="dropdown-item" href="{{ route('profileIndex',auth()->user()->nomor) }}">
                                        <i class="ti ti-user me-2"></i> Profile
                                    </a>
                                </li>
                                @endif
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="post" class="dropdown-item m-0 p-0">
                                        @csrf
                                        <button type="submit" class="btn btn-link dropdown-item">
                                            <i class="ti ti-logout me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item ps-2 d-none d-md-block">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#barcodeModal">
                                <img src="{{ asset('landing/img/qr.webp') }}" alt="" width="30">
                            </a>
                        </li>


                        @else
                        {{-- Tombol Login --}}

                        <li class="nav-item">
                            <a class="btn btn-primary btn-sm px-3 py-2 fw-semibold ms-2 shadow-sm" href="/login" role="button">
                                Login Aplikasi
                            </a>
                        </li>


                        @endif

                    </ul>
                </div>

            </div>
        </nav>

        <section class="py-0 bg-light-gradient" id="section1">
            <div class="bg-holder" style="background-image:url({{ asset('landing/img/illustrations/hero-bg.png') }});background-position:top right;background-size:contain;">
            </div>



            <!--/.bg-holder-->

            <div class="container py-5">

                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-5 order-md-1 " >
                        <h4 class="mb-3"><span class="ti ti-calendar-due"></span> {{ Carbon\Carbon::parse(now())->translatedFormat('l, d F Y') }} | <span id="jam" class="text-muted"></span> </h4>
                        <h4  class="display-2 fw-bold fs-4 fs-md-5 fs-xl-5  " style="line-height: 1.2;">Absensi Pintar, Kerja lebih Cerdas.</h4>
                        <h5 class=" typewrite pb-3 text-muted" data-period="1000" data-type='[
                            "Selamat datang di Absensi Pintar! Semoga hari Anda menyenangkan.",
                            "Hallo, apa kabar? Semoga harimu produktif!",
                            "Apakah Anda sudah absen hari ini? Jangan lupa untuk mengisi absen ya!",
                            "Selamat pagi! Jangan lupa untuk absen, ya!",
                            "Selamat datang! Ayo, absensi hari ini sudah terisi?"
                        ]
                        '></h5>

                        <center><label><span class="ti ti-history"></span> Riwayat Absensi</label></center>
                        <div class="table-responsive bg-white scrollme">
                            <table class="table table-nowrap mb-0 table-fixed">
                                <thead>
                                    <tr>
                                        <th class="bg-light-400"> <span class="ti ti-calendar-event"></span> Tanggal</th>
                                        <th class="bg-light-400"> <span class="ti ti-users"></span> Nama Lengkap</th>
                                        <th class="bg-light-400">Status</th>
                                    </tr>
                                </thead>

                                <tbody id="myData"></tbody>
                                <idv id="loadingSpinner" class="mt-2" style="display:none;">
                                    <center><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading data...</center>
                                </div>
                            </table>
                        </div>
                        {{-- <div class="card shadow" style="width: 18rem;">
                            <!-- Gambar Foto -->
                            <img src="https://via.placeholder.com/100" alt="Foto Siswa" class="photo mx-auto d-block">
                            <div class="card-body text-center">
                                <h5 class="card-title">John Doe</h5>
                                <p class="card-text">
                                    <strong>NIS:</strong> 123456789<br>
                                    <strong>Jenis Kelamin:</strong> Laki-laki<br>
                                    <strong>Jurusan:</strong> Teknik Informatika
                                </p>
                            </div>
                        </div> --}}
                        {{-- <img class="img-fluid" src="{{ asset('landing/img/illustrations/hero.png') }}" alt=""> --}}
                        {{-- <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script><dotlottie-player src="https://lottie.host/a08fe931-1e93-4930-b4b0-714be508f0fc/XZEEsrlaoz.json" background="transparent" speed="1" style="width: 600px; height: 600px" direction="-1" playMode="bounce" loop autoplay></dotlottie-player> --}}
                    </div>
                    <div class=" pt-6">

                        <div class="row pt-2">
                            <!-- Sudah Absen Siswa -->
                            <div class="col-md-6 col-lg-3 mb-3">
                              <div class="card text-white bg-success shadow-sm">
                                <div class="card-body d-flex align-items-center">
                                  <i class="ti ti-user-check" style="font-size: 40px; margin-right: 15px;"></i>
                                  <div>
                                    <h6 class="mb-0"style="color: #fff">Siswa Sudah Absen</h6>
                                    <h3 id="absenSiswaMasuk"style="color: #fff">0</h3>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <!-- Belum Absen Siswa -->
                            <div class="col-md-6 col-lg-3 mb-3">
                              <div class="card text-white bg-danger shadow-sm">
                                <div class="card-body d-flex align-items-center">
                                  <i class="ti ti-user-x" style="font-size: 40px; margin-right: 15px;"></i>
                                  <div>
                                    <h6 class="mb-0" style="color: #fff">Siswa Belum Absen</h6>
                                    <h3 id="absenSiswaBelum" style="color: #fff">0</h3>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <!-- Sudah Absen GTK -->
                            <div class="col-md-6 col-lg-3 mb-3">
                              <div class="card text-white bg-primary shadow-sm">
                                <div class="card-body d-flex align-items-center">
                                  <i class="ti ti-users" style="font-size: 40px; margin-right: 15px;"></i>
                                  <div>
                                    <h6 class="mb-0" style="color: #fff">GTK Sudah Absen</h6>
                                    <h3 id="absenGtkMasuk" style="color: #fff">0</h3>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <!-- Belum Absen GTK -->
                            <div class="col-md-6 col-lg-3 mb-3">
                              <div class="card text-white bg-warning shadow-sm">
                                <div class="card-body d-flex align-items-center">
                                  <i class="ti ti-users" style="font-size: 40px; margin-right: 15px;"></i>
                                  <div>
                                    <h6 class="mb-0" style="color: #fff">GTK Belum Absen</h6>
                                    <h3 id="absenGtkBelum" style="color: #fff">0</h3>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>


                      </div>


                    <div class="col-md-7 col-lg-6 text-center text-md-start ">

                        <div class="container">
                                <form action="/api/absent/entry" method="GET" id="absentForm">
                                    <div class="mb-3">

                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-primary text-white">
                                              <i class="ti ti-scan"></i>
                                            </span>
                                            <input type="text" name="rfidInput2" class="form-control form-control-lg" id="rfidInput2" maxlength="10" placeholder="Silahkan Tempelkan Kartu RFID anda..">
                                          </div>

                                        <input type="text" name="rfid" class="form-control" id="id_rfid" maxlength="10" placeholder="Masukan ID Kartu anda" hidden>

                                        <input type="text" name="type" class="form-control" value="device1" hidden>
                                        <button hidden>a</button>
                                    </div>
                                </form>


                            <div class="row">
                              <!-- Card Mahasiswa -->
                              <div class="col">

                                <div id="absenCard" class="card shadow rounded-3 border-0">
                                    <div class="text-center p-4">
                                      <img id="fotoMahasiswa"
                                        src="{{ asset('asset/img/user-default.jpg') }}" loading="lazy"
                                        class="rounded-circle"
                                        style="width: 140px; height: 140px; object-fit: cover; border: 4px solid #fff; box-shadow: 0 3px 8px rgba(0,0,0,0.2);"
                                        alt="Foto Mahasiswa">
                                    </div>

                                    <div class="card-body pt-0 p-0 m-0">
                                      <h4 id="namaMahasiswa" class="card-title text-center fw-semibold mb-3">-</h4>

                                      <table class="table mb-3">
                                        <tbody>
                                          <tr>
                                            <td style="width: 130px;" class="fw-medium text-muted">Jenis Kelamin</td>
                                            <td id="jenisKelamin">: -</td>
                                          </tr>
                                          <tr>
                                            <td style="width: 130px;" class="fw-medium text-muted" id="labelKeterangan">Jurusan</td>
                                            <td id="isiKeterangan">: -</td>
                                          </tr>
                                          <tr>
                                            <td style="width: 130px;" class="fw-medium text-muted">UID</td>
                                            <td id="nim">: -</td>
                                          </tr>
                                          <tr>
                                            <td style="width: 130px;" class="fw-medium text-muted">Keterangan</td>
                                            <td id="statusAbsen">: -</td>
                                          </tr>
                                          <tr>
                                            <td style="width: 130px;" class="fw-medium text-muted">Status</td>
                                            <td id="status">: -</td>
                                          </tr>
                                        </tbody>
                                      </table>

                                    </div>
                                  </div>




                        {{-- <div class=" my-5 mt-2">
                            <div id="info"></div>
                            <div class="mb-3" hidden>
                                <label class="form-label">UID :</label>
                                <select name="id_rfid" id="id_rfid" class="form-control" disabled></select>
                                <label class="form-label my-3">Nama Lengkap :</label>
                                <input type="text" class="form-control " id="nama" disabled>

                            </div>

                            <center><label><span class="ti ti-history"></span> Riwayat Absensi</label></center>
                            <div class="table-responsive bg-white scrollme">
                                <table class="table table-nowrap mb-0 table-fixed">
                                    <thead>
                                        <tr>
                                            <th class="bg-light-400"> <span class="ti ti-calendar-event"></span> Tanggal</th>
                                            <th class="bg-light-400"> <span class="ti ti-users"></span> Nama Lengkap</th>
                                            <th class="bg-light-400">Status</th>

                                        </tr>
                                    </thead>

                                    <tbody id="myData"></tbody>
                                    <div id="loadingSpinner" class="mt-2" style="display:none;">
                                        <center><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading data...</center>
                                    </div>
                                </table>
                            </div>
                            <!-- Loading Spinner (Hidden by default) -->

                        </div> --}}
                    </div>

                    {{-- <a class="btn btn-lg btn-info rounded-pill me-2" href="#" role="button">Start a New Store </a><span> or  </span><a class="btn btn-link ps-1 ps-md-4 ps-lg-1" href="#" role="button"> Customize &amp; Extend ›</a> --}}
                </div>
            </div>
            </div>
        </section>


        <!-- <section> close ============================-->
        <!-- ============================================-->

        {{-- <section class="bg-100 pb-0 mb-0" id="section3" style="background-color: #fff">
        <div class="container">
          <div class="row flex-center">
            <div class="col-xl-5 text-center mb-5 z-index-1">
              <h1 class="display-3 fw-bold fs-4 fs-md-6">Supported by real people</h1>
              <p>Our team of Happiness Engineers works remotely from 58 countries providing customer support across multiple time zones.</p>
            </div>
          </div>
        </div>
        <div class="position-relative text-center">

          <!--/.bg-holder-->
          <img class="img-fluid position-relative z-index-1" src="{{ asset('landing/img/gallery/people.png') }}" alt="" />
        </div>
        </section> --}}

        <section class="py-0">

            <!--/.bg-holder-->

            <div class="container-fluid px-0" style="margin-bottom:-40px">
                <div class="card py-4 border-0 rounded-0 bg-primary">
                    <div class="card-body">
                        <div class="row flex-center">
                            <div class="col-xl-9 d-flex justify-content-center  mb-xl-0">
                                <h2 class="text-light fw-bold">Track Attendance Effortlessly with Modern Technology.<br />A Modern Approach to Seamless Attendance</h2>
                            </div>
                            <div class="col-xl-3 text-center"><a class="btn btn-lg btn-outline-light rounded-pill" href="/login">GET STARTED</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============================================-->
        <!-- <section> begin ============================-->

        <section class=" pt-0 pb-0" style="background-color: #421ec0; color: white;">
            <div class="container">
                <div class="row flex-center">

                </div>
                {{-- <div class="row flex-center">
            <div class="col-auto py-4"><a href="#"><img class="img-fluid" src="{{ asset('asset/img/logo-white.png') }}" alt="" width="200" /></a>
            </div>
            </div> --}}
            {{-- <hr class="opacity-25" /> --}}
            <div class="d-flex justify-content-center py-3">
                <p>&copy; <span id="year"></span> Absensi Sakti. All rights reserved.</p>
            </div>
            </div><!-- end of .container-->

        </section>
        <!-- <section> close ============================-->
        <!-- ============================================-->



        <!-- ============================================-->
        <!-- <section> begin ============================-->

        <!-- <section> close ============================-->
        <!-- ============================================-->

    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    {{-- <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header  ">
                    <h5 class="modal-title" id="exampleModalLabel">Absensi Berhasil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body " id="modalBody">
                    ...


                </div>

            </div>
        </div>
    </div> --}}

    <!-- Modal -->
    <div class="modal fade" id="barcodeModal" tabindex="-1" aria-labelledby="barcodeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Scan QR Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body position-relative">
                    <video id="video" class="w-100 rounded" autoplay></video>

                    <!-- Kotak Fokus -->
                    <div class="scan-overlay">
                        <div class="scan-box"></div>
                    </div>

                    <div class="mt-3 text-center">
                        <div id="message" class="text-muted">Arahkan QR code ke kotak...</div>
                        <div id="result" class="fw-bold text-success mt-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> --}}
    <script src="{{ asset('landing/vendors/is/is.min.js') }}"></script>
    <script src="{{ asset('landing/js/theme.js') }}"></script>
    <script src="{{ asset('asset/js/jquery.slimscroll.min.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>

    <script>
        // Handle form submission via AJAX
        document.getElementById("absentForm").addEventListener("submit", function (event) {
          event.preventDefault(); // Prevent form from submitting the traditional way

          var rfidValue = document.getElementById("rfidInput2").value; // Get the RFID value from the input
          var typeValue = document.querySelector('input[name="type"]').value; // Get the hidden type field value

          var url = `/api/absent/entry?rfid=${rfidValue}`;  // Build the URL with query parameters

          fetch(url, {
            method: 'GET',
            headers: {
              'Accept': 'application/json'  // Assuming the server responds with JSON
            }
          })
            .then(response => response.json())  // Assuming the response is JSON
            .then(data => {
              document.getElementById("rfidInput2").value = '';  // Clear the RFID input field
            });
        });
    </script>
    <script>

        document.addEventListener('DOMContentLoaded', function () {
          const inputElement = document.getElementById("rfidInput2");
        //   $('#successModal').modal('show');
          // Focus the input when the page is loaded
          inputElement.focus();

          // Prevent input from losing focus when clicking elsewhere
          inputElement.addEventListener('blur', function (event) {
            inputElement.focus();  // Prevent losing focus
          });
        });
    </script>
    <script>
        window.addEventListener('scroll', function() {
            const topbar = document.getElementById('topbar');
            const navbar = document.getElementById('mainNavbar');

        });

        // aktifkan link saat scroll
        window.addEventListener('scroll', () => {
            const sections = document.querySelectorAll('section');
            const navLinks = document.querySelectorAll('.nav-link');

            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                if (pageYOffset >= sectionTop - 60) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + current) {
                    link.classList.add('active');
                }
            });
        });

    </script>
    <script>
        let scanning = true;
        let lastScanTime = 0;

        // Akses elemen video dan result
        const video = document.getElementById('video');
        const resultElement = document.getElementById('result');
        const messageElement = document.getElementById('message');

        // Fungsi untuk memulai scan menggunakan webcam
        function startScanner() {
            // Meminta izin untuk menggunakan kamera
            navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: "environment"
                    }
                })
                .then(stream => {
                    video.srcObject = stream;
                    video.setAttribute("playsinline", true); // Untuk iPhone
                    video.play();
                    requestAnimationFrame(scanBarcode);
                })
                .catch(err => {
                    messageElement.textContent = "Gagal mengakses kamera: " + err.message;
                });
        }

        // Fungsi untuk memindai QR Code
        function scanBarcode() {
            const currentTime = Date.now();
            // Batasi pemindaian setiap 100ms
            if (currentTime - lastScanTime < 100) {
                requestAnimationFrame(scanBarcode);
                return;
            }

            lastScanTime = currentTime;

            if (video.videoWidth === 0 || video.videoHeight === 0) {
                requestAnimationFrame(scanBarcode);
                return;
            }

            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');

            // Mengurangi resolusi agar pemindaian lebih cepat
            const downscaleFactor = 0.5;
            canvas.width = video.videoWidth * downscaleFactor;
            canvas.height = video.videoHeight * downscaleFactor;

            // Menggambar gambar video pada canvas
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Tentukan ukuran dan posisi area yang akan dipindai (kotak hijau)
            const scanWidth = 220;
            const scanHeight = 220;
            const scanX = (canvas.width - scanWidth) / 2;
            const scanY = (canvas.height - scanHeight) / 2;

            // Ambil data gambar dari area yang ditentukan
            const imageData = context.getImageData(scanX, scanY, scanWidth, scanHeight);

            // Coba scan barcode menggunakan jsQR
            const code = jsQR(imageData.data, scanWidth, scanHeight, {
                inversionAttempts: "dontInvert"
            , });

            if (code) {
                resultElement.textContent = code.data; // Menampilkan hasil barcode
                scanning = false; // Hentikan pemindaian
                video.srcObject.getTracks().forEach(track => track.stop()); // Stop webcam
            } else {
                messageElement.textContent = "Mencari QR code...";
                requestAnimationFrame(scanBarcode); // Lanjutkan pemindaian
            }
        }

        // Start scanner ketika modal dibuka
        $('#barcodeModal').on('shown.bs.modal', function() {
            startScanner();
        });

        // Hentikan scan saat modal ditutup
        $('#barcodeModal').on('hidden.bs.modal', function() {
            const stream = video.srcObject;
            const tracks = stream.getTracks();
            tracks.forEach(track => track.stop());
        });

    </script>
    <script>
        document.getElementById('year').textContent = new Date().getFullYear();

        function menuToggle() {
            const toggleMenu = document.querySelector(".menu");
            toggleMenu.classList.toggle("active");
        }

    </script>

    <script>

    let lastRfid = null;
    let lastData = null;

    // Ambil data RFID tiap detik (global polling)
    function getRfidData() {
        $.ajax({
            url: "{{ route('rfidDataGET') }}",
            method: "GET",
            cache: false,
            success: function(data) {
                if (data && data !== lastRfid) {
                    $('#id_rfid').val(data);
                    lastRfid = data;
                    getDataDetail(data);
                }
            },
            error: function() {
                console.log("Gagal ambil data RFID");
            }
        });
    }

    // Polling tiap 1 detik
    setInterval(getRfidData, 1000);
    function setSkeletonCard() {
        $('#namaMahasiswa').html('<div class="skeleton"></div>');
        $('#jenisKelamin').html('<div class="skeleton"></div>');
        $('#isiKeterangan').html('<div class="skeleton"></div>');
        $('#nim').html('<div class="skeleton"></div>');
        $('#statusAbsen').html('<div class="skeleton"></div>');
        $('#status').html('<div class="skeleton"></div>');
    }

    function playVoice(message) {
        const synth = window.speechSynthesis;
        const utterThis = new SpeechSynthesisUtterance(message);
        utterThis.lang = 'id-ID'; // Bahasa Indonesia
        synth.speak(utterThis);
    }
    // Ambil detail user by RFID
    function getDataDetail(rfidInput2) {
    if (!rfidInput2) return;

    // Set ke loading dulu
    setSkeletonCard(); // Menampilkan loading sebelum data diterima

    $.ajax({
        url: "{{ route('rfidData') }}",
        method: "GET",
        cache: false,
        data: { id_rfid: rfidInput2 },
        success: function(data) {
            if (data && JSON.stringify(data) !== JSON.stringify(lastData)) {

                // Ganti foto
                $('#fotoMahasiswa').attr('src', data.foto
                    ? `{{ asset('storage') }}/${data.foto}`
                    : `{{ asset('asset/img/user-default.jpg') }}`);

                // Ganti nama
                $('#namaMahasiswa').text(data.nama);

                // Jenis kelamin
                let jenisKelamin = data.jenis_kelamin === 'P' ? 'Perempuan' : 'Laki-laki';
                $('#jenisKelamin').html(`: ${jenisKelamin}`);

                // UID
                $('#nim').html(`: ${data.id}`);

                // Status absen dan badge
                let statusText = '';
                let badgeColor = '';
                let statusIcon = '';
                let statusVoiceText = '';
                let terlambatText = '';

                if (data.status === 'ENTRY') {
                    statusText = 'Absent Masuk';
                    badgeColor = 'success';
                    statusIcon = '<i class="bi bi-box-arrow-in-right me-1"></i>';
                    statusVoiceText = `Terima kasih ${data.nama}, sudah absensi hari ini.`;
                } else if (data.status === 'EXIT') {
                    statusText = 'Absent  Keluar';
                    badgeColor = 'danger';
                    statusIcon = '<i class="bi bi-box-arrow-left me-1"></i>';
                    statusVoiceText = `Terima kasih ${data.nama}, hati-hati di jalan.`;
                } else {
                    statusText = 'Tidak Diketahui';
                    badgeColor = 'secondary';
                    statusIcon = '<i class="bi bi-question-circle me-1"></i>';
                }

                // Status absen
                $('#statusAbsen').html(`
                    : <span class="fw-bold">${statusText}</span>
                    <span class="badge bg-${badgeColor} ms-2" style="font-size: 0.9rem;">
                        ${statusIcon}${data.jam}
                    </span>
                `);

                // Ganti label dan isi keterangan (Jabatan untuk guru, Jurusan untuk siswa)
                if (data.tipe === 'Guru') {
                    $('#labelKeterangan').text('Jabatan');
                    $('#isiKeterangan').html(`: ${data.keterangan ?? '-'}`);
                } else {
                    $('#labelKeterangan').text('Jurusan');
                    $('#isiKeterangan').html(`: ${data.keterangan ?? '-'}`);
                }

                function formatTerlambat(menit) {
                    // Paksa ke bilangan positif dan bulat
                    menit = Math.abs(Math.round(menit));

                    if (menit < 60) {
                        return `${menit} menit`;
                    } else {
                        let jam = Math.floor(menit / 60);
                        let sisaMenit = menit % 60;
                        return `${jam} jam${sisaMenit > 0 ? ' ' + sisaMenit + ' menit' : ''}`;
                    }
                }
                if (data.status === 'ENTRY') {
                    if (data.terlambat !== null) {
                        let terlambatDisplay = formatTerlambat(data.terlambat);
                        let terlambatText = `<span class="text-danger">Terlambat ${terlambatDisplay}</span>`;
                        $('#status').html(`: <span>${terlambatText}</span>`);

                        // Optional: voice notif
                        playVoice(`Kamu terlambat ${terlambatDisplay}`);
                    } else {
                        $('#status').html(`: <span class="text-success">Tepat Waktu</span>`);
                    }
                } else {
                    // Untuk EXIT
                    $('#status').html(`: -`);
                }


                // Mainkan suara
                playVoice(statusVoiceText);

                // Simpan data terakhir untuk validasi perubahan
                lastData = data;
            }
        }
    });
}
    </script>
    <script>
        $('#loadingSpinner').show(); // Show the loading spinner when the request starts
        // Function to refresh data
        function refreshdata2() {
            var content = ""; // Start with an empty content variable
            $.ajax({
                url: "{{ route('listabsents') }}", // The URL for your AJAX request
                method: "GET", // HTTP method (GET or POST)
                dataType: "json", // Expected data type from server
                success: function(response) {
                    // Hide the loading spinner when the data is loaded
                    $('#loadingSpinner').hide();

                    if (response.length === 0) {
                        // If no data is returned, show a no data message
                        content += '<tr>' +
                            '<td colspan="3">' +
                            '<center><span class="ti ti-mood-confuzed"></span><i> Belum ada riwayat absensi untuk hari ini..</i>' +
                            '</center>' +
                            '</td>' +
                            '</tr>';
                    } else {
                        // Directly update the table with the response data
                        content = ''; // Clear previous content

                        // We assume 'response' is an array of objects
                        response.forEach(function(item) {
                            var $alert = (item.status === 'ENTRY') ? 'alert alert-success' : 'alert alert-danger';

                            content += '<tr class="' + $alert + '">';
                            content += '<td>' + item.date + ' <span class="ti ti-clock-hour-1"></span> ' + item.time + '</td>';

                            // Check if 'student' or 'gtk' exists and generate the avatar accordingly
                            if (item.student) {
                                content += '<td>' +
                                    '<div class="d-flex align-items-center">' +
                                    '<a href="#" class="avatar avatar-md">';
                                if (!item.student.foto || item.student.foto.trim() === '') {
                                    content += '<img src="{{ asset("asset/img/user-default.jpg") }}" class="img-fluid rounded-circle" alt="foto" loading="lazy">';
                                } else {
                                    content += `<img src="{{ asset('storage/') }}/${item.student.foto}" class="img-fluid rounded-circle" alt="foto" loading="lazy">`;

                                }
                                content += '</a>' +
                                    '<div class="ms-2">' +
                                    '<p class="mb-0">' + item.student.nama + '</p>' +
                                    '</div>' +
                                    '</div>' +
                                    '</td>';
                            } else {
                                content += '<td>' +
                                    '<div class="d-flex align-items-center">' +
                                    '<a href="#" class="avatar avatar-md">';
                                        if (!item.gtk?.gambar || item.gtk.gambar.trim() === '') {
                                        content += '<img src="{{ asset("asset/img/user-default.jpg") }}" class="img-fluid rounded-circle" alt="foto">';
                                    } else {
                                        content += `<img src="{{ asset('storage/') }}/${item.gtk.gambar}" class="img-fluid rounded-circle" alt="foto">`;
                                    }
                                content += '</a>' +
                                    '<div class="ms-2">' +
                                    '<p class="mb-0">' + item.gtk.nama + '</p>' +
                                    '</div>' +
                                    '</div>' +
                                    '</td>';
                            }
                            content += '<td>' + item.status + '</td></tr>';

                        });
                    }

                    // Insert the newly built content into the table
                    $('#myData').html(content);
                }
                , error: function() {
                    // Hide the loading spinner in case of an error
                    $('#loadingSpinner').hide();
                    alert("Error fetching data.");
                }
            });
        }

        // Set the interval to refresh data every 5 seconds (5000ms)
        setInterval(refreshdata2, 5000);

        // Initial data load when the page is first loaded
        refreshdata2();

    </script>
   <script>
    function loadAbsenSummary() {
        $.ajax({
            url: "{{ route('absen.summary') }}",
            method: "GET",
            cache: false,
            success: function(data) {
                $('#absenSiswaMasuk').text(data.sudah_absen_student);
                $('#absenSiswaBelum').text(data.belum_absen_student);
                $('#absenGtkMasuk').text(data.sudah_absen_gtk);
                $('#absenGtkBelum').text(data.belum_absen_gtk);
            },
            error: function() {
                console.error("Gagal mengambil data rekap absensi.");
            }
        });
    }

    $(document).ready(function() {
        loadAbsenSummary();

        // Auto refresh setiap 5 detik (5000 ms)
        setInterval(function() {
            loadAbsenSummary();
        }, 2000);
    });
</script>

    <script>
        function jam() {
            var e = document.getElementById('jam')
                , d = new Date()
                , h, m, s;
            h = d.getHours();
            m = set(d.getMinutes());
            s = set(d.getSeconds());

            e.innerHTML = h + ':' + m + ':' + s;

            setTimeout('jam()', 1000);
        }

        function set(e) {
            e = e < 10 ? '0' + e : e;
            return e;
        }


        var TxtType = function(el, toRotate, period) {
            this.toRotate = toRotate;
            this.el = el;
            this.loopNum = 0;
            this.period = parseInt(period, 10) || 2000;
            this.txt = '';
            this.tick();
            this.isDeleting = false;
        };

        TxtType.prototype.tick = function() {
            var i = this.loopNum % this.toRotate.length;
            var fullTxt = this.toRotate[i];

            if (this.isDeleting) {
                this.txt = fullTxt.substring(0, this.txt.length - 1);
            } else {
                this.txt = fullTxt.substring(0, this.txt.length + 1);
            }

            this.el.innerHTML = '<span class="wrap">' + this.txt + '</span>';

            var that = this;
            var delta = 200 - Math.random() * 100;

            if (this.isDeleting) {
                delta /= 2;
            }

            if (!this.isDeleting && this.txt === fullTxt) {
                delta = this.period;
                this.isDeleting = true;
            } else if (this.isDeleting && this.txt === '') {
                this.isDeleting = false;
                this.loopNum++;
                delta = 500;
            }

            setTimeout(function() {
                that.tick();
            }, delta);
        };

        window.onload = function() {
            jam();
            var elements = document.getElementsByClassName('typewrite');
            for (var i = 0; i < elements.length; i++) {
                var toRotate = elements[i].getAttribute('data-type');
                var period = elements[i].getAttribute('data-period');
                if (toRotate) {
                    new TxtType(elements[i], JSON.parse(toRotate), period);
                }
            }
            // INJECT CSS
            var css = document.createElement("style");
            css.type = "text/css";
            css.innerHTML = ".typewrite > .wrap { border-right: 0.08em solid #fff}";
            document.body.appendChild(css);
        };

    </script>
</body>

</html>
