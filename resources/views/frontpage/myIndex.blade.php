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
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <style>
        .absen-table {
        table-layout: fixed;
        width: 100%;
        }

        .absen-table td:first-child {
        width: 130px;
        white-space: nowrap;
        }
        .table-wrapper {
        overflow-x: auto;
        }
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
        #reader {
            width: 300px;
            margin: auto;
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
            .card2 {
            
            transition: transform 0.3s ease, background-color 0.3s ease;
            }
            .card2 h6, .card2 h3{
            color: #fff;
            }

            .card2:hover {
            transform: scale(1.05); /* Zoom in saat hover */
            background-color: #333;  /* Ubah background saat hover (warna gelap untuk kontras) */
            }

            .card2:hover h6, .card2:hover h3 {
            color: #fff; /* Mengubah teks menjadi putih saat hover */
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
            #typing-text::after {
                content: '|';
                animation: blink 0.7s infinite;
                color: black;
                font-weight: bold;
            }

            @keyframes blink {
                0%, 100% { opacity: 1; }
                50% { opacity: 0; }
            }
            
           
    </style>
    <link href="{{ asset('landing/css/theme.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/iconfont/tabler-icons.min.css">
    <link rel="stylesheet" href="{{ asset('asset/css/customlanding.css') }}">
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


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
                    <ul class="navbar-nav ms-auto align-items-lg-center gap-2 "> {{-- fs-5 = ukuran font ideal --}}
                        {{-- Login / Profil User --}}
                        @if(auth()->user())
                        {{-- Menu Navigasi --}}
                        <li class="nav-item d-none d-md-inline">
                            <a class="nav-link px-2">
                              <span >Hallo, </span>{{ auth()->user()->nama }}
                            </a>
                          </li>
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
                          {{-- tampil di mobile saja --}}
                          <li class="nav-item ps-2 d-block d-md-none pt-3">
                              <a class="nav-link" href="{{ $link }}">
                                  <i class="ti ti-dashboard me-2"></i> Dashboard
                              </a>
                          </li>
                       
                        <li class="nav-item ps-2 d-block d-md-none ">
                            <a href="#" class="nav-link " data-bs-toggle="modal" data-bs-target="#barcodeModal">
                                <i class="ti ti-scan me-1"></i> Scan Barcode
                            </a>
                        </li>
                        <li class="nav-item ps-2 d-block d-md-none " style="margin-left:-15px;">
                            <form action="{{ route('logout') }}" method="post" class="dropdown-item m-0 p-0" >
                                @csrf
                                <button type="submit" class="btn btn-link dropdown-item">
                                    <i class="ti ti-logout me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                        {{-- end di mobile saja --}}
                        {{-- ------------------------------------------------------------- --}}
                        {{-- Profil User Dropdown --}}
                        <li class="nav-item dropdown" style="z-index: 1050;">
  
                            <a class="nav-link dropdown-toggle d-flex align-items-center px-2 d-none d-md-inline" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                @php
                                $userImg = asset('asset/img/user-default.jpg');
                                if(auth()->user()->role == 'siswa' && Auth::user()->student?->foto) {
                                $userImg = asset('storage/' . Auth::user()->student->foto);
                                } elseif(in_array(auth()->user()->role, ['guru', 'walikelas']) && Auth::user()->gtk?->gambar) {
                                $userImg = asset('storage/' . Auth::user()->gtk->gambar);
                                }
                                @endphp
                                <img src="{{ $userImg }}" class="rounded-circle me-2" width="36" height="36" alt="User">
                                
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

        <section class="py-0 bg-light-gradient" id="section1" >
            <div class="bg-holder" style="background-image:url({{ asset('landing/img/illustrations/hero-bg.png') }});background-position:top right;background-size:contain;"></div>
          
            <div class=" py-5 mt-5 px-4">
              <div class="row align-items-start">
                <!-- Left Column -->
                <div class="col-lg-7 col-md-12 mb-4"style="z-index: 10;">
                  <h4 class="mb-3">
                    <span class="ti ti-calendar-due"></span>
                    {{ Carbon\Carbon::parse(now())->translatedFormat('l, d F Y') }} |
                    <span id="jam" class="text-muted"></span>
                  </h4>
                  <h4 class="display-2 fw-bold fs-4 fs-md-5" style="line-height: 1.2;">Absensi Pintar, Kerja lebih Cerdas.</h4>
                  <h5 class="typewrite pb-3 text-muted"
                    data-period="1000"
                    data-type='[
                      "Selamat datang di Absensi Pintar! Semoga hari Anda menyenangkan.",
                      "Hallo, apa kabar? Semoga harimu produktif!",
                      "Apakah Anda sudah absen hari ini? Jangan lupa untuk mengisi absen ya!",
                      "Selamat pagi! Jangan lupa untuk absen, ya!",
                      "Selamat datang! Ayo, absensi hari ini sudah terisi?"
                    ]'>
                  </h5>
            
                  <!-- Absensi Stats Cards -->
                  <div class="row g-3">
                    <div class="col-6 col-lg-3">
                      <div class="card text-white bg-success shadow-sm card2">
                        <div class="card-body d-flex align-items-center">
                          <i class="ti ti-user-check fs-2 me-3"></i>
                          <div style="color: #fff">
                            <h6 class="mb-0">Siswa Absen</h6>
                            <h3 id="absenSiswaMasuk">0</h3>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 col-lg-3">
                      <div class="card text-white bg-danger shadow-sm card2">
                        <div class="card-body d-flex align-items-center">
                          <i class="ti ti-user-x fs-2 me-3"></i>
                          <div>
                            <h6 class="mb-0">Belum Absen</h6>
                            <h3 id="absenSiswaBelum">0</h3>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 col-lg-3">
                      <div class="card text-white bg-primary shadow-sm card2">
                        <div class="card-body d-flex align-items-center">
                          <i class="ti ti-users fs-2 me-3"></i>
                          <div>
                            <h6 class="mb-0">GTK Absen</h6>
                            <h3 id="absenGtkMasuk">0</h3>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 col-lg-3">
                      <div class="card text-white bg-warning shadow-sm card2">
                        <div class="card-body d-flex align-items-center">
                          <i class="ti ti-users fs-2 me-3"></i>
                          <div>
                            <h6 class="mb-0">GTK Belum</h6>
                            <h3 id="absenGtkBelum">0</h3>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
          
                  <!-- Riwayat Absensi -->
                  <div class="mt-4 ">
                    <h6 class="text-center"><span class="ti ti-history"></span> Riwayat Absensi</h6>
                    <div class="table-responsive bg-white scrollme table-wrapper">
                      <table class="table table-nowrap mb-0 table-fixed ">
                        <thead>
                          <tr>
                            <th class="bg-light-400">Tanggal</th>
                            <th class="bg-light-400">Nama Lengkap</th>
                            <th class="bg-light-400">Status</th>
                          </tr>
                        </thead>
                        <tbody id="myData"></tbody>
                      </table>
                      <div id="loadingSpinner" class="text-center py-2" style="display:none;">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading data...
                      </div>
                    </div>
                  </div>
                </div>
          
                <!-- Right Column -->
                <div class="col-lg-5 col-md-12">
                  <form action="/api/absent/entry" method="GET" id="absentForm" >
                    <div class="mb-3">
                        <div class="input-group">
                            <button type="button" class="input-group-text bg-primary text-white border-0" data-bs-toggle="modal" data-bs-target="#barcodeModal">
                              <i class="ti ti-scan"></i>
                            </button>
                            <input type="text" name="rfidInput2" id="rfidInput2" class="form-control form-control-lg" maxlength="10" placeholder="Tempelkan Kartu RFID Anda..">
                          </div>                          
                      <input type="text" name="rfid" id="id_rfid" class="form-control" maxlength="10" hidden>
                      <input type="text" name="type" value="device1" hidden>
                      <button hidden>a</button>
                    </div>
                  </form>
          
                  <!-- Card Mahasiswa -->
                  <div class="card shadow rounded-3 border-0">
                    <div class="card-header">
                        <span class="ti ti-user"></span> <b>Absensi Terakhir</b>
                    </div>
                    <div class="text-center p-4">
                      <img id="fotoMahasiswa"
                        src="{{ asset('asset/img/user-default.jpg') }}"
                        class="rounded-circle"
                        style="width: 140px; height: 140px; object-fit: cover; border: 4px solid #fff; box-shadow: 0 3px 8px rgba(0,0,0,0.2);"
                        alt="Foto Mahasiswa">
                    </div>
          
                    <div class="card-body pt-0 p-0 m-0 table-wrapper">
                      <h4 id="namaMahasiswa" class="card-title text-center fw-semibold mb-3">-</h4>
                      <table class="table mb-3 table-resphnsive absen-table">
                        <tbody>
                            <tr>
                              <td class="fw-medium text-muted">Jenis Kelamin</td>
                              <td id="jenisKelamin">: -</td>
                            </tr>
                            <tr>
                              <td class="fw-medium text-muted" id="labelKeterangan">Jurusan</td>
                              <td id="isiKeterangan">: -</td>
                            </tr>
                            <tr>
                              <td class="fw-medium text-muted">UID</td>
                              <td id="nim">: -</td>
                            </tr>
                            <tr>
                              <td class="fw-medium text-muted">Keterangan</td>
                              <td id="statusAbsen">: -</td>
                            </tr>
                            <tr>
                              <td class="fw-medium text-muted">Status</td>
                              <td id="status">: -</td>
                            </tr>
                          </tbody>
                      </table>
                    </div>
                  </div>
          
                </div>
              </div>
            </div>
          </section>
          

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
    <!-- Modal -->
<div class="modal fade" id="barcodeModal" tabindex="-1" aria-labelledby="barcodeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Scan Barcode / QR Code</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
            <div id="scan-loading" style="display: none; text-align: center; margin-bottom: 10px;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div>Memproses data...</div>
            </div>

          <div id="qr-reader" style="width:100%;"></div>
          <p id="scan-result" class="mt-3 text-center"></p>
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
    {{-- barcode scanner --}}
    <script>
        let scanner;

        function startScanner() {
            if (!scanner) {
                scanner = new Html5QrcodeScanner("qr-reader", {
                    fps: 10,
                    qrbox: 250,
                    rememberLastUsedCamera: true,
                    showTorchButtonIfSupported: true,
                    showZoomSliderIfSupported: true,
                    showScanButtonIfSupported: true, // tombol "Scan from file"
                    supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA, Html5QrcodeScanType.SCAN_TYPE_FILE]
                });

                scanner.render(onScanSuccess, onScanError);
            }
        }

        function onScanSuccess(decodedText, decodedResult) {

            if (decodedText) {
                // Tampilkan loading
                const loadingElement = document.getElementById('scan-loading');
                if (loadingElement) {
                    loadingElement.style.display = 'block';
                }

                const form = document.createElement("form");
                form.method = "GET";
                form.action = "/api/absent/entry";

                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "rfid";
                input.value = decodedText;
                form.appendChild(input);

                document.body.appendChild(form);
                $('#id_rfid').val(decodedText);
                const queryString = new URLSearchParams({ rfid: decodedText }).toString();
                const url = form.action + "?" + queryString;

                fetch(url)
                    .then(response => {
                        if (!response.ok) throw new Error("Gagal mengirim data");
                        return response.text();
                    })
                    .then(data => {
                        console.log("Response dari server:", data);

                        // Sembunyikan loading
                        if (loadingElement) {
                            loadingElement.style.display = 'none';
                        }

                        // ✅ Tutup modal
                        const modalElement = document.getElementById('barcodeModal');
                        const modalInstance = bootstrap.Modal.getInstance(modalElement);
                        if (modalInstance) {
                            modalInstance.hide(); // Close modal
                        }

                        // Scanner restart otomatis saat modal dibuka lagi
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("❌ Gagal mengirim data ke server.");

                        // Sembunyikan loading juga jika gagal
                        if (loadingElement) {
                            loadingElement.style.display = 'none';
                        }
                    });

                // Hentikan scanner
                scanner.clear();
                scanner = null;
            } else {
                document.getElementById('scan-result').innerText = "❌ QR Code tidak valid.";
            }
        }



        function onScanError(errorMessage) {
            // Biarkan kosong untuk mencegah spam log
        }

        function stopScanner() {
            if (scanner) {
                scanner.clear().then(() => {
                    scanner = null;
                    document.getElementById('scan-result').innerText = '';
                });
            }
        }

        // Hubungkan ke modal
        document.getElementById('barcodeModal').addEventListener('shown.bs.modal', startScanner);
        document.getElementById('barcodeModal').addEventListener('hidden.bs.modal', stopScanner);
    </script>



   <script>
   document.getElementById('rfidInput2').addEventListener('change', function() {
        const rfid = document.getElementById('rfidInput2').value;

        if (rfid) {
            // Tampilkan loading saat mulai request
            Swal.fire({
                title: 'Memproses...',
                text: 'Silakan tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch(`/api/absent/entry?rfid=${rfid}`)
                .then(response => response.json())
                .then(data => {
                    Swal.close(); // Tutup loading saat respons diterima

                    if (data.status === 'INVALID') {
                        Swal.fire({
                            icon: 'error',
                            title: 'RFID Tidak Terdaftar',
                            text: 'Silakan daftarkan RFID terlebih dahulu!',
                            confirmButtonColor: '#d33'
                        });
                    } else if (data.status === 'RFID Not Bind') {
                        Swal.fire({
                            icon: 'error',
                            title: 'RFID Belum Tertaut',
                            text: 'Silakan hubungkan RFID dengan akun terlebih dahulu!',
                            confirmButtonColor: '#d33'
                        });
                    } else if (data.status === 'BELUM_WAKTUNYA') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Perhatian',
                            text: 'Saat ini belum waktunya pulang. Mohon tunggu hingga jam pulang tiba.',
                            confirmButtonColor: '#d33'
                        });
                    } else {
                        // Jika berhasil, bisa tampilkan info lainnya di sini
                        console.log('Data berhasil:', data);
                        Swal.fire({
                            icon: 'success',
                            title: 'Absensi Berhasil',
                            html: `<b>${data.nama}</b><br>Status: ${data.status}<br>Waktu: ${data.waktu}`,
                            confirmButtonColor: '#3085d6'
                        });
                    }
                })
                .catch(err => {
                    Swal.close(); // Tutup loading saat error juga
                    console.error('Request error:', err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Gagal menghubungi server. Coba lagi nanti.',
                        confirmButtonColor: '#d33'
                    });
                });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'RFID Kosong',
                text: 'Silakan masukkan RFID terlebih dahulu!',
                confirmButtonColor: '#d33'
            });
        }
    });


   </script>

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
