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
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ app('settings')['site_fav'] == '' ? asset('asset/img/default-logo.png') : asset('storage/' . app('settings')['site_logo']) }}">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ app('settings')['site_fav'] == '' ? asset('asset/img/default-logo.png') : asset('storage/' . app('settings')['site_logo']) }}">
    <link rel="shortcut icon" type="image/x-icon"
        href="{{ app('settings')['site_fav'] == '' ? asset('asset/img/default-logo.png') : asset('storage/' . app('settings')['site_logo'])  }}">
    <link rel="manifest" href="{{ asset('landing/img/favicons/manifest.json') }}">
    <meta name="msapplication-TileImage" content="{{ asset('landing/img/favicons/mstile-150x150.png') }}">
    <meta name="theme-color" content="#ffffff">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->

    <link href="{{ asset('landing/css/theme.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/iconfont/tabler-icons.min.css">
    <link rel="stylesheet" href="{{ asset('asset/css/customlanding.css') }}">
    <style>
        .form-control:focus {

            box-shadow: none;
            /* Menghapus efek bayangan */
            background-color: initial;
            /* Mengembalikan latar belakang ke default */
        }

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
        <nav class="navbar navbar-expand-lg navbar-light fixed-top nav user-menu"
            data-navbar-on-scroll="data-navbar-on-scroll" style="border-bottom:1px solid #e7e7e7">
            <div class="container-fluid">
                <div class="d-flex ">
                    <a class="navbar-brand" href="/"><img
                            src="{{ !empty(app('settings')['site_logo']) ? asset('storage/' . app('settings')['site_logo']) : asset('asset/img/default-logo.png') }}"
                            alt="" width="50px" /></a>

                    <h5 class=" mt-3">{{ app('settings')['site_name'] }}</h5>
                </div>
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto ms-lg-5 ms-xl-8 border-bottom border-lg-bottom-0 ">
                        <li class="nav-item"><a class="nav-link fw-medium active" aria-current="page" href="#section1">
                                Beranda</a></li>
                        <li class="nav-item"><a class="nav-link fw-medium" href="#section2">Berita</a></li>
                        <li class="nav-item"><a class="nav-link fw-medium" href="#section3">Komunitas </a></li>

                    </ul>
                    <div class="d-flex align-items-center">

                        @if(auth()->user())
                        <div class="d-flex py-3 py-lg-0">
                            <div class="action">

                                <div class="profil avatar avatar-md roundede" onclick="menuToggle();">
                                    {{-- user siswa --}}
                                    @if(auth()->user()->role == "siswa")
                                    @if(Auth::user()->student == NULL)
                                    <img src='{{ asset(' asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                                    @else
                                    @if(Auth::user()->student->foto == "" )
                                    <img src='{{ asset(' asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                                    @else
                                    <img src="{{ asset('storage/' . Auth::user()->student->foto) }}" alt="Img"
                                        class="img-fluid">
                                    @endif
                                    @endif
                                    @endif

                                    @if(auth()->user()->role == "guru")
                                    @if(Auth::user()->gtk == NULL)
                                    <img src='{{ asset(' asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                                    @else
                                    @if(Auth::user()->gtk->gambar == "" )
                                    <img src='{{ asset(' asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                                    @else
                                    <img src="{{ asset('storage/'. Auth::user()->gtk->gambar )}}" alt='Img'
                                        class='img-fluid'>
                                    @endif
                                    @endif
                                    @endif

                                    @if( auth()->user()->role == "walikelas")
                                    @if(Auth::user()->gtk == NULL)
                                    <img src='{{ asset(' asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                                    @else
                                    @if(Auth::user()->gtk->gambar == "" )
                                    <img src='{{ asset(' asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                                    @else
                                    <img src="{{ asset('storage/'. Auth::user()->gtk->gambar ) }}" alt='Img'
                                        class='img-fluid'>
                                    @endif
                                    @endif
                                    @endif

                                    @if(auth()->user()->role == "admin" || auth()->user()->role == "superadmin" )
                                    <img src='{{ asset('asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                                    @endif

                                    @if(auth()->user()->role == "guru")
                                    @if(Auth::user()->gtk == NULL)
                                    <img src='{{ asset('asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                                    @else
                                    @if(Auth::user()->gtk->gambar == "" )
                                    <img src='{{ asset('asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                                    @else
                                    <img src="{{ asset('storage/'. Auth::user()->gtk->gambar )}}" alt='Img'
                                        class='img-fluid'>
                                    @endif
                                    @endif
                                    @endif


                                    @if(auth()->user()->role == "admin")
                                    <img src='{{ asset('asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                                    @endif

                                    </span>

                                    <div>

                                    </div>
                                </div>
                                <div class="menu">
                                    <h3 class="mb-0">{{ auth()->user()->nama }}<br>
                                        <div class="px-2 pt-1">
                                            <input type="text" class="form-control" value="{{ auth()->user()->email }}"
                                                disabled>
                                        </div>

                                        <small><span class="text-primary"></span></small>
                                    </h3>
                                    <ul>
                                        <li>
                                            @if(auth()->user()->role =="admin")
                                            @php $link = route('dashboard.admin') @endphp
                                            @elseif (auth()->user()->role=="walikelas")
                                            @php $link = route('dashboard.walikelas') @endphp
                                            @elseif (auth()->user()->role=="superadmin")
                                            @php $link = route('dashboard.superadmin') @endphp
                                            @elseif (auth()->user()->role == "guru")
                                            @php $link = route('dashboard.teacher') @endphp
                                            @else
                                            @php $link = route('dashboard.student') @endphp
                                            @endif
                                            <span class="ti ti-dashboard"></span><a href="{{ $link }}" class="mx-2">
                                                Dashboard</a>
                                        </li>
                                        @if (auth()->user()->role != 'superadmin')
                                        <li>
                                            <span class="ti ti-user"></span><a
                                                href="{{ route('profileIndex',auth()->user()->nomor) }}" class="mx-2">
                                                Profile</a>
                                        </li>
                                        @endif

                                        <li>
                                            <form action="{{ route('logout') }}" method="post">
                                                @csrf
                                                <span class="ti ti-logout"></span>
                                                <button class="mx-2" style="padding: 0;border: none;background: none;">
                                                    Logout</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <form class="d-flex py-3 py-lg-0"><a class="btn btn-sm p-2 px-2 btn-info rounded-pill  me-2"
                            href="/login" role="button"><span class="ti ti-login"></span> Masuk Aplikasi</a>
                    </form>
                    @endif
                </div>
            </div>
        </nav>
        <section class="py-0 bg-light-gradient" id="section1">
            <div class="bg-holder"
                style="background-image:url({{ asset('landing/img/illustrations/hero-bg.png') }});background-position:top right;background-size:contain;">
            </div>
            <!--/.bg-holder-->

            <div class="container">

                <div class="row align-items-center">

                    <div class="col-lg-6 col-md-5 order-md-1 pt-9">

                        <center>
                            <h4 class="mb-3"><span class="ti ti-calendar-due"></span> {{
                                Carbon\Carbon::parse(now())->translatedFormat('l, d F Y') }} | <span id="jam"
                                    class="text-muted"></span> </h4>
                        </center>
                        <img class="img-fluid" src="{{ asset('landing/img/illustrations/hero.png') }}" alt="">
                        {{-- <script
                            src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs"
                            type="module"></script>
                        <dotlottie-player src="https://lottie.host/a08fe931-1e93-4930-b4b0-714be508f0fc/XZEEsrlaoz.json"
                            background="transparent" speed="1" style="width: 600px; height: 600px" direction="-1"
                            playMode="bounce" loop autoplay></dotlottie-player> --}}
                    </div>
                    <div class="col-md-7 col-lg-6 text-center text-md-start pt-md-9">
                        <h1 class="display-2 fw-bold fs-4 fs-md-5 fs-xl-6  ">Absensi Pintar, <br>Kerja lebih Cerdas.
                        </h1>
                        <h5 class=" typewrite pb-3 text-muted" data-period="2000"
                            data-type='[ "Selamat Datang di Absensi Pintar","Hallo apa kabar..? ","Apakah anda sudah Absen Hari ini..?" ]'>
                        </h5>
                        <div class=" mb-2 mt-2">
                            <div id="info"></div>
                            <form action="/api/absent/entry" method="GET" id="absentForm">
                                <div class="mb-3">
                                    <label class="form-label">UID :</label>
                                    <input type="text" name="rfid" class="form-control" id="rfidInput2" maxlength="10">
                                    <input type="text" name="type" class="form-control" value="device1" hidden>
                                    <button hidden>a</button>
                                </div>
                            </form>
                            <div class="mb-3"  hidden>

                                <select name="id_rfid" id="id_rfid" class="form-control"></select>
                                <label class="form-label my-3">Nama Lengkap :</label>
                                <input type="text" class="form-control " id="nama" disabled>

                            </div>

                            <center><label><span class="ti ti-history"></span> Riwayat Absensi</label></center>
                            <div class="table-responsive bg-white scrollme">
                                <table class="table table-nowrap mb-0 table-fixed">
                                    <thead>
                                        <tr>
                                            <th class="bg-light-400"> <span class="ti ti-calendar-event"></span> Tanggal
                                            </th>
                                            <th class="bg-light-400"> <span class="ti ti-users"></span> Nama Lengkap
                                            </th>
                                            <th class="bg-light-400">Status</th>

                                        </tr>
                                    </thead>

                                    <tbody id="myData"></tbody>
                                    <div id="loadingSpinner" class="mt-2" style="display:none;">
                                        <center><span class="spinner-border spinner-border-sm" role="status"
                                                aria-hidden="true"></span> Loading data...</center>
                                    </div>
                                </table>
                            </div>
                            <!-- Loading Spinner (Hidden by default) -->

                        </div>
                    </div>

                    {{-- <a class="btn btn-lg btn-info rounded-pill me-2" href="#" role="button">Start a New Store
                    </a><span> or </span><a class="btn btn-link ps-1 ps-md-4 ps-lg-1" href="#" role="button"> Customize
                        &amp; Extend ›</a> --}}
                </div>
            </div>
            </div>
        </section>


        <!-- ============================================-->
        <!-- <section> begin ============================-->
        <section class="py-6" id="section2">

            <div class="container">
                <div class="row flex-center">
                    <div class="col-auto text-center my-4">
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
                            <video class="img-fluid shadow-sm rounded" controls>
                                <source src="{{ $post->media_url }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            @else
                            <!-- If it's an image -->
                            <img class="img-fluid shadow-sm rounded" src="{{ $post->media_url }}" alt=""
                                loading="lazy" />
                            @endif

                            <div class="mt-3 text-center text-md-start">
                                <h5 class="display-6 fs-2 fw-bold">
                                    <!-- Display the username -->
                                    @ {{ $username }}
                                </h5>
                                <p class="mb-0">{{ \Illuminate\Support\Str::limit($post->caption, 100) }}</p>
                                <a class="btn btn-link ps-0" href="{{ $post->permalink }}" target="_BLANK"
                                    role="button"> Lebih Lanjut... ›</a>
                            </div>
                        </div>

                        @endif
                        @endforeach
                        @else
                        @if(isset($feed->error) && $feed->error->code == 400)
                        <div class="col-12 text-center">
                            <p class="h4 text-danger">Akses tidak dijinkan atau kode autentikasi salah. Coba lagi nanti.
                            </p>
                        </div>
                        @else
                        <div class="col-12 text-center">
                            <p class="h4 text-danger">Data tidak ditemukan atau terjadi kesalahan. Coba lagi nanti.</p>
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
                        <p>Our team of Happiness Engineers works remotely from 58 countries providing customer support
                            across multiple time zones.</p>
                    </div>
                </div>
            </div>
            <div class="position-relative text-center">

                <!--/.bg-holder-->
                <img class="img-fluid position-relative z-index-1" src="{{ asset('landing/img/gallery/people.png') }}"
                    alt="" />
            </div>
        </section> --}}

        {{-- <section class="py-0">

            <!--/.bg-holder-->

            <div class="container-fluid px-0">
                <div class="card py-4 border-0 rounded-0 bg-primary">
                    <div class="card-body">
                        <div class="row flex-center">
                            <div class="col-xl-9 d-flex justify-content-center  mb-xl-0">
                                <h2 class="text-light fw-bold">WooCommerce - the most customizable
                                    eCommerce<br />platform for building your online business.</h2>
                            </div>
                            <div class="col-xl-3 text-center"><a class="btn btn-lg btn-outline-light rounded-pill"
                                    href="#">GET STARTED</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}

        <!-- ============================================-->
        <!-- <section> begin ============================-->

        <section class=" pt-0 pb-0">
            <div class="container">
                {{-- <div class="row justify-content-sm-between py-6">

                </div> --}}
                {{-- <div class="row flex-center">
                    <div class="col-auto py-4"><a href="#"><img class="img-fluid"
                                src="{{ asset('asset/img/logo-white.png') }}" alt="" width="200" /></a></div>
                </div> --}}
                <hr class="opacity-25" />
                <div class="d-flex justify-content-center pb-3">
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

    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm " role="document">
            <div class="modal-content">

                <div class="modal-body " id="modalBody">
                    <div class="d-flex flex-column align-items-center text-center">
                    <div id="modalProfile">
                        <img id="modalFoto" src="asset/img/user-default.jpg" class="rounded-circle "
                            width="120" height="120" alt="foto">
                    </div>
                    <h4 class="mt-3" id="modalNama">Nama</h4>
                    <p class="text-muted" id="modalNIS">UID</p>
                    <div class="alert alert-success mt-3">
                        <h5>Sudah absen pada pukul : </h5>
                        <h1 id="modalJam" class="fw-bold">00:00</h1>
                    </div>
                    <small class="text-muted"><i>Halaman ini akan ditutup dalam <span id="countdownNumber">3</span>
                            detik...</i></small>
                    </div>
                </div>

            </div>
            {{-- <div class="modal-footer">
            </div> --}}
        </div>
    </div>
    </div>
    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script> --}}
    <script src="{{ asset('landing/vendors/is/is.min.js') }}"></script>
    <script src="{{ asset('landing/js/theme.js') }}"></script>
    <script src="{{ asset('asset/js/jquery.slimscroll.min.js') }}" type="d8aa163ebe66f835399f615d-text/javascript">
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
        document.getElementById('year').textContent = new Date().getFullYear();

        // Function to toggle menu
        function menuToggle() {
          const toggleMenu = document.querySelector(".menu");
          toggleMenu.classList.toggle("active");
        }
    </script>

   <script>
    let modalOpen = false;
    let lastData = null;

    function refreshData() {
        $.ajax({
            url: "{{ route('rfidDataGET') }}",
            method: "GET",
            cache: false,
            async: true, // Pastikan request tidak blocking
            success: function (data) {
                $('#id_rfid').html(data);
                checkRFID(); // Langsung cek RFID setelah mendapatkan data
            }
        });
    }

    function checkRFID() {
        let id_rfid = $('#id_rfid').val()?.trim(); // Gunakan optional chaining agar aman

        if (id_rfid) {
            $.ajax({
                url: "{{ route('rfidData') }}",
                method: "GET",
                cache: false,
                async: true, // Request berjalan secara asynchronous agar cepat
                data: { id_rfid: id_rfid },
                success: function (data) {
                    if (data && JSON.stringify(data) !== JSON.stringify(lastData)) {
                        $('#nama').val(data.nama);

                        if (!modalOpen) {
                            // Masukkan data ke dalam modal
                            $('#modalFoto').attr("src", data.foto ? `{{ asset('storage') }}/${data.foto}` : "{{ asset('asset/img/user-default.jpg') }}");
                            $('#modalNama').text(data.nama);
                            $('#modalNIS').text("UID: " + data.uid);
                            $('#modalJam').text(data.jam);

                            // Tampilkan modal
                            $('#successModal').modal('show');
                            modalOpen = true;

                            // Countdown timer untuk menutup modal dalam 10 detik
                            let countdown = 10;
                            let countdownInterval = setInterval(function () {
                                countdown--;
                                $('#countdownNumber').text(countdown);
                                if (countdown <= 0) {
                                    clearInterval(countdownInterval);
                                    $('#successModal').modal('hide');
                                    modalOpen = false;
                                }
                            }, 1000);

                            lastData = data;
                        }
                    }
                }
            });
        }
    }

    // Jalankan `refreshData()` lebih cepat (misalnya, setiap 2 detik)
    setInterval(refreshData, 2000);
   </script>


    <script>
        $('#loadingSpinner').show();  // Show the loading spinner when the request starts

        // Function to refresh data
        function refreshData2() {
          let content = "";  // Start with an empty content variable
          $.ajax({
            url: "{{ route('listabsents') }}",  // The URL for your AJAX request
            method: "GET",                      // HTTP method (GET or POST)
            dataType: "json",                   // Expected data type from server
            success: function (response) {
              $('#loadingSpinner').hide(); // Hide the loading spinner when the data is loaded

              if (response.length === 0) {
                content += '<tr>' +
                  '<td colspan="3">' +
                  '<center><span class="ti ti-mood-confuzed"></span><i> Belum ada riwayat absensi untuk hari ini..</i>' +
                  '</center>' +
                  '</td>' +
                  '</tr>';
              } else {
                content = '';  // Clear previous content

                // Loop through the response and generate table rows
                response.forEach(function (item) {
                  var $alert = (item.status === 'ENTRY') ? 'alert alert-success' : 'alert alert-danger';

                  content += `<tr class="${$alert}">` +
                    `<td>${item.date} <span class="ti ti-clock-hour-1"></span> ${item.time}</td>`;

                  // Check if 'student' or 'gtk' exists and generate the avatar accordingly
                  if (item.student) {
                        content += `<td>
                                        <div class="d-flex align-items-center">
                                            <a href="#" class="avatar avatar-md">
                                                ${!item.student.foto || item.student.foto.trim() === '' ?
                                                    `<img src="{{ asset('asset/img/user-default.jpg') }}" class="img-fluid rounded-circle" alt="foto">` :
                                                    `<img src="{{ asset('storage/') }}/${item.sttudent.foto}" class="img-fluid rounded-circle" alt="foto">`}
                                            </a>
                                            <div class="ms-2">
                                                <p class="mb-0">${item.student.nama}</p>
                                            </div>
                                        </div>
                                    </td>`;
                    } else {
                        content += `<td>
                <div class="d-flex align-items-center">
                    <a href="#" class="avatar avatar-md">
                        ${!item.gtk.gambar || item.gtk.gambar.trim() === '' ?
                            `<img src="{{ asset('asset/img/user-default.jpg') }}" class="img-fluid rounded-circle" alt="foto">` :
                            `<img src="{{ asset('storage/') }}/${item.gtk.gambar}" class="img-fluid rounded-circle" alt="foto">`}
                    </a>
                    <div class="ms-2">
                        <p class="mb-0">${item.gtk.nama}</p>
                    </div>
                </div>
            </td>`;
        }

                  content += `<td>${item.status}</td></tr>`;
                });
              }

              // Insert the newly built content into the table
              $('#myData').html(content);
            },
            error: function () {
              $('#loadingSpinner').hide(); // Hide the loading spinner in case of an error
              alert("Error fetching data.");
            }
          });
        }

        // Set the interval to refresh data every 5 seconds (5000ms)
        setInterval(refreshData2, 5000);

        // Initial data load when the page is first loaded
        refreshData2();
    </script>

    <script>
        // Function to update the clock every second
        function jam() {
          var e = document.getElementById('jam'),
              d = new Date(), h, m, s;
          h = d.getHours();
          m = set(d.getMinutes());
          s = set(d.getSeconds());

          e.innerHTML = `${h}:${m}:${s}`;

          setTimeout(jam, 1000);  // Update the clock every second
        }

        function set(e) {
          return e < 10 ? '0' + e : e;
        }

        // Typewriter effect
        var TxtType = function (el, toRotate, period) {
          this.toRotate = toRotate;
          this.el = el;
          this.loopNum = 0;
          this.period = parseInt(period, 10) || 2000;
          this.txt = '';
          this.tick();
          this.isDeleting = false;
        };

        TxtType.prototype.tick = function () {
          var i = this.loopNum % this.toRotate.length;
          var fullTxt = this.toRotate[i];

          if (this.isDeleting) {
            this.txt = fullTxt.substring(0, this.txt.length - 1);
          } else {
            this.txt = fullTxt.substring(0, this.txt.length + 1);
          }

          this.el.innerHTML = `<span class="wrap">${this.txt}</span>`;

          var that = this;
          var delta = 200 - Math.random() * 100;

          if (this.isDeleting) { delta /= 2; }

          if (!this.isDeleting && this.txt === fullTxt) {
            delta = this.period;
            this.isDeleting = true;
          } else if (this.isDeleting && this.txt === '') {
            this.isDeleting = false;
            this.loopNum++;
            delta = 500;
          }

          setTimeout(function () {
            that.tick();
          }, delta);
        };

        window.onload = function () {
          jam();
          var elements = document.getElementsByClassName('typewrite');
          for (var i = 0; i < elements.length; i++) {
            var toRotate = elements[i].getAttribute('data-type');
            var period = elements[i].getAttribute('data-period');
            if (toRotate) {
              new TxtType(elements[i], JSON.parse(toRotate), period);
            }
          }
          // Inject CSS for typewriter effect
          var css = document.createElement("style");
          css.type = "text/css";
          css.innerHTML = ".typewrite > .wrap { border-right: 0.08em solid #fff }";
          document.body.appendChild(css);
        };
    </script>

    <script>
        // Handle form submission via AJAX
        document.getElementById("absentForm").addEventListener("submit", function (event) {
          event.preventDefault(); // Prevent form from submitting the traditional way

          var rfidValue = document.getElementById("rfidInput2").value; // Get the RFID value from the input
          var typeValue = document.querySelector('input[name="type"]').value; // Get the hidden type field value

          var url = `${this.action}?rfid=${encodeURIComponent(rfidValue)}&type=${encodeURIComponent(typeValue)}`;  // Build the URL with query parameters

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

</body>

</html>
