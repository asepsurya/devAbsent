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
    {{-- <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('asset/img/logo-icon.png') }}"> --}}
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
            padding-top: 120px;
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

    </style>
    <link href="{{ asset('landing/css/theme.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/iconfont/tabler-icons.min.css">
    <link rel="stylesheet" href="{{ asset('asset/css/customlanding.css') }}">
    <style>
        /* Gallery style */
        .instagram-feed {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 16px;
            margin: 0 auto;
            padding: 20px;
            max-width: 1000px;
        }

        .post {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .post img {
            width: 100%;
            height: auto;
            display: block;
        }

        .post p {
            padding: 10px;
            font-size: 14px;
            color: #333;
            margin: 0;
            text-align: center;
        }

        .post a {
            display: block;
        }

    </style>
</head>
<body>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->

    <main class="main" id="top">
        <div id="topbar" class="topbar py-1 text-center text-white bg-primary">
            <small>🔔 Selamat datang di sistem absensi - {{ app('settings')['site_name'] }} </small>
            <button class="btn-close btn-close-white" id="closeTopbar" aria-label="Close" hidden></button>
        </div>
        <nav id="mainNavbar" class="navbar navbar-expand-lg navbar-light fixed-top nav user-menu mt-5" data-navbar-on-scroll="data-navbar-on-scroll">

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
                            <a class="nav-link px-2" href="#section1">
                                <i class="ti ti-home me-1"></i> Beranda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-2" href="#section2">
                                <i class="ti ti-news me-1"></i> Berita
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-2" href="#section4">
                                <i class="ti ti-building me-1"></i> Sekolah
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-2" href="https://www.instagram.com/sakt.iproject/" target="_BLANK">
                                <i class="ti ti-users me-1"></i> Komunitas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-2" href="#section5">
                                <i class="ti ti-photo me-1"></i> Dokumentasi
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

            <div class="container">

                <div class="row align-items-center">

                    <div class="col-lg-6 col-md-5 order-md-1 " >
                        <!-- Carousel -->
                    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                        <!-- Gambar Slide -->
                        <div class="carousel-item active">
                            <img src="{{ asset('landing/img/illustrations/hero.png') }}" class="d-block w-100 img-fluid" alt="Hero Image">
                        </div>

                        <!-- Lottie Animation Slide -->
                        <div class="carousel-item">
                            <img src="{{ asset('landing/img/illustrations/hero.png') }}" class="d-block w-100 img-fluid" alt="Hero Image">
                            {{-- <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
                            <dotlottie-player src="https://lottie.host/a08fe931-1e93-4930-b4b0-714be508f0fc/XZEEsrlaoz.json"
                            background="transparent" speed="1" style="width: 600px; height: 600px" direction="-1" playMode="bounce" loop autoplay>
                            </dotlottie-player> --}}
                        </div>
                        </div>

                        <!-- Controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                    </div>

                    <div class="col-md-7 col-lg-6 text-center text-md-start pt-3">

                        <h4 class="mb-3"><span class="ti ti-calendar-due"></span> {{ Carbon\Carbon::parse(now())->translatedFormat('l, d F Y') }} | <span id="jam" class="text-muted"></span> </h4>
                        <h1 class="display-2 fw-bold fs-4 fs-md-5 fs-xl-6  " style="line-height: 1.2;">Absensi Pintar, <br>Kerja lebih Cerdas.</h1>
                        <h5 class=" typewrite pb-3 text-muted" data-period="1000" data-type='[
                        "Selamat datang di Absensi Pintar! Semoga hari Anda menyenangkan.",
                        "Hallo, apa kabar? Semoga harimu produktif!",
                        "Apakah Anda sudah absen hari ini? Jangan lupa untuk mengisi absen ya!",
                        "Selamat pagi! Jangan lupa untuk absen, ya!",
                        "Selamat datang! Ayo, absensi hari ini sudah terisi?"
                    ]
                    '></h5>
                        <div class=" mb-2 mt-2">
                            <div id="info"></div>
                            <div class="mb-3" hidden>
                                <label class="form-label">UID :</label>
                                <select name="id_rfid" id="id_rfid" class="form-control" disabled></select>
                                <label class="form-label my-3">Nama Lengkap :</label>
                                <input type="text" class="form-control " id="nama" disabled>

                            </div>


                    </div>

                    <a class="btn btn-lg btn-info rounded-pill me-2" href="/login" role="button">Get Started </a><span> or  </span><a class="btn btn-link ps-1 ps-md-4 ps-lg-1" href="/register" role="button"> Customize &amp; Extend ›</a>
                </div>
            </div>
            </div>
        </section>


        <!-- ============================================-->
        <!-- <section> begin ============================-->
        <section class="py-6" id="section2">

            <div class="container">
                <div class="row flex-center">
                    <div class="col-auto text-center my-">
                        <h1 class="display-3 fw-bold">Berita Terbaru</h1>
                    </div>
                </div>


                <div class="row">
                    @if (!empty($feed->data) && count($feed->data) > 0)
                    @foreach($feed->data as $index => $post)
                    @if ($index < 3) <!-- Limit to 3 posts -->
                        <div class="col-md-4 mb-5 mb-md-0">
                            <!-- Check if the media is an image or a video -->
                            @if(Str::contains($post->media_url, '.mp4') || Str::contains($post->media_url, '.mov'))
                            <!-- If it's a video -->
                            <video class="media-fixed-size" controls>
                                <source src="{{ $post->media_url }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            @else
                            <!-- If it's an image -->
                            <img class="media-fixed-size" src="{{ $post->media_url }}" alt="" loading="lazy" />
                            @endif

                            <div class="mt-3 text-center text-md-start">
                                <h5 class="display-6 fs-2 fw-bold">
                                    <!-- Display the username -->
                                    @ {{ $username }}
                                </h5>
                                <p class="mb-0">{{ \Illuminate\Support\Str::limit($post->caption, 100) }}</p>
                                <a class="btn btn-link ps-0" href="{{ $post->permalink }}" target="_BLANK" role="button"> Lebih Lanjut... ›</a>
                            </div>
                        </div>

                        @endif
                        @endforeach
                        @else
                        @if(isset($feed->error) && $feed->error->code == 400)
                            <div class="col-12 text-center">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-circle me-2"></i>
                                    <strong>Error!</strong> Akses tidak dijinkan atau kode autentikasi salah. Coba lagi nanti.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        @else
                            <div class="col-12 text-center pt-3">
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <i class="bi bi-cloud-slash me-2"></i>
                                    <strong>Peringatan!</strong> Data tidak ditemukan atau tidak terhubung dengan Internet. Coba lagi nanti.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        @endif

                        @endif



                </div>
            </div><!-- end of .container-->

        </section>
        <!-- <section> close ============================-->
        <!-- ============================================-->

        {{-- <section class="bg-100 pb-0 mb-0" id="section3">
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
        window.addEventListener('scroll', function() {
            const topbar = document.getElementById('topbar');
            const navbar = document.getElementById('mainNavbar');

            if (window.scrollY > 50) {
                topbar.style.top = "-50px"; // hide topbar
                navbar.classList.remove('mt-5'); // hilangkan margin-top navbar
            } else {
                topbar.style.top = "0"; // tampilkan topbar
                navbar.classList.add('mt-5'); // kasih margin-top navbar
            }
        });
        document.getElementById('closeTopbar').addEventListener('click', function() {
            const topbar = document.getElementById('topbar');
            const navbar = document.getElementById('mainNavbar');

            topbar.style.display = 'none';


           // Hapus class mt-5 dari navbar
            navbar.classList.remove('mt-5');
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
