<!DOCTYPE html>
<html lang="en-US" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>SMK SATYA BAKTI</title>
    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('asset/img/logo-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('asset/img/logo-icon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('asset/img/logo-icon.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('asset/img/logo-icon.png') }}">
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
  </head>
  <body>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
      <nav class="navbar navbar-expand-lg navbar-light fixed-top nav user-menu" data-navbar-on-scroll="data-navbar-on-scroll">
        <div class="container-fluid"><a class="navbar-brand" href="#"><img src="{{ asset('asset/img/logo.png') }}" alt="" width="169" /></a>
          <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto ms-lg-5 ms-xl-8 border-bottom border-lg-bottom-0 ">
              <li class="nav-item"><a class="nav-link fw-medium active" aria-current="page" href="#section1"> Beranda</a></li>
              <li class="nav-item"><a class="nav-link fw-medium" href="#section2">Berita</a></li>
              <li class="nav-item"><a class="nav-link fw-medium" href="#section3">Komunitas </a></li>

            </ul>
            <div class="d-flex align-items-center">

            @if(auth()->user())
            <div class="d-flex py-3 py-lg-0">
                <div class="action">

                    <div class="profile" onclick="menuToggle();">
                        {{-- user siswa --}}
                        @if(auth()->user()->role == "siswa")
                         @if(Auth::user()->student == NULL)
                            <img src='{{ asset('asset/img/user-default.jpg')  }}' alt='Img' class='img-fluid'>
                         @else
                            @if(Auth::user()->student->foto == "" )
                                <img src='{{ asset('asset/img/user-default.jpg')  }}' alt='Img' class='img-fluid'>
                            @else
                                <img src="/storage/{{ Auth::user()->student->foto }}" alt='Img' class='img-fluid'>
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
                            <input type="text" class="form-control" value="{{ auth()->user()->email }}" disabled>
                        </div>

                        <small><span class="text-primary"></span></small></h3>
                      <ul>
                        <li>
                            @if(auth()->user()->role =="admin")
                                @php $link = route('dashboard.admin')  @endphp
                            @elseif (auth()->user()->role=="walikelas")
                                @php $link = route('dashboard.walikelas')  @endphp
                            @elseif (auth()->user()->role=="superadmin")
                                @php $link = route('dashboard.superadmin')  @endphp
                            @elseif (auth()->user()->role == "guru")
                                @php $link = route('dashboard.teacher')  @endphp
                            @else
                                @php $link = route('dashboard.student')  @endphp
                             @endif
                          <span class="ti ti-dashboard"></span><a href="{{ $link }}" class="mx-2"> Dashboard</a>
                        </li>
                        @if (auth()->user()->role != 'admin')
                        <li>
                            <span class="ti ti-user"></span><a href="{{ route('profileIndex',auth()->user()->nomor) }}" class="mx-2"> Profile</a>
                        </li>
                        @endif

                        <li>
                            <form action="{{ route('logout') }}" method="post">
                             @csrf
                                <span class="ti ti-logout"></span>
                               <button class="mx-2" style="padding: 0;border: none;background: none;"> Logout</button>
                            </form>
                        </li>
                      </ul>
                    </div>
                  </div>
              </div>
            </div>
            @else
            <form class="d-flex py-3 py-lg-0"><a class="btn btn-lg btn-info rounded-pill me-2" href="/login" role="button"><span class="ti ti-login"></span> Masuk Aplikasi</a>
            </form>
                @endif
          </div>
        </div>
      </nav>
      <section class="py-0 bg-light-gradient" id="section1">

        <div class="bg-holder" style="background-image:url({{ asset('landing/img/illustrations/hero-bg.png') }});background-position:top right;background-size:contain;">
        </div>
        <!--/.bg-holder-->

        <div class="container">

          <div class="row align-items-center">

            <div class="col-lg-6 col-md-5 order-md-1 pt-9">

                <center><h4 class="mb-3"><span class="ti ti-calendar-due"></span> {{ Carbon\Carbon::parse(now())->translatedFormat('l, d F Y') }} | <span id="jam" class="text-muted"></span> </h4></center>
                {{-- <img class="img-fluid" src="{{ asset('landing/img/illustrations/hero.png') }}" alt=""> --}}
                <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script><dotlottie-player src="https://lottie.host/a08fe931-1e93-4930-b4b0-714be508f0fc/XZEEsrlaoz.json" background="transparent" speed="1" style="width: 600px; height: 600px" direction="-1" playMode="bounce" loop autoplay></dotlottie-player>
            </div>
            <div class="col-md-7 col-lg-6 text-center text-md-start pt-md-9">
                <h1 class="display-2 fw-bold fs-4 fs-md-5 fs-xl-6  ">Absensi Pintar,  <br>Kerja lebih Cerdas.</h1>
                <h5 class=" typewrite pb-3 text-muted" data-period="2000" data-type='[ "Selamat Datang di Absensi Pintar","Hallo apa kabar..? ","Apakah anda sudah Absen Hari ini..?" ]'></h5>
                <div class=" mb-2 mt-2">
                        <div id="info"></div>
                        <div class="mb-3">
                            <label class="form-label">UID :</label>
                            <select name="id_rfid" id="id_rfid" class="form-control" disabled></select>
                            <label class="form-label my-3">Nama Lengkap :</label>
                            <input type="text" class="form-control " id="nama"  disabled>

                        </div>

                        <center><label><span class="ti ti-history"></span> Riwayat Absensi</label></center>
                        <div class="table-responsive bg-white scrollme">
                            <table class="table table-nowrap mb-0 table-fixed"  >
                                <thead>
                                    <tr >
                                        <th class="bg-light-400"> <span class="ti ti-calendar-event"></span> Tanggal</th>
                                        <th class="bg-light-400"> <span class="ti ti-users"></span> Nama Lengkap</th>
                                        <th class="bg-light-400">Status</th>

                                    </tr>
                                </thead>

                                    <tbody id="myData"></tbody>


                            </table>
                        </div>

                    </div>
                </div>

              {{-- <a class="btn btn-lg btn-info rounded-pill me-2" href="#" role="button">Start a New Store </a><span> or  </span><a class="btn btn-link ps-1 ps-md-4 ps-lg-1" href="#" role="button"> Customize &amp; Extend ›</a> --}}
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
            <div class="col-md-4 mb-5 mb-md-0"><img class="img-fluid shadow-sm" src="{{ asset('landing/img/gallery/feature-1.png') }}" alt="" />
              <div class="mt-3 text-center text-md-start">
                <h4 class="display-6 fs-2 fs-lg-3 fw-bold">All You Need to Start</h4>
                <p class="mb-0">Add WooCommerce plugin to any WordPress site and set up a new store in minutes.</p><a class="btn btn-link ps-0" href="#" role="button"> Ecommerce Wordpress ›</a>
              </div>
            </div>
            <div class="col-md-4 mb-5 mb-md-0"><img class="img-fluid shadow-sm" src="{{ asset('landing/img/gallery/feature-2.png') }}" alt="" />
              <div class="mt-3 text-center text-md-start">
                <h4 class="display-6 fs-2 fs-lg-3 fw-bold">Customize and Extend</h4>
                <p class="mb-0">From subscriptions to gym classes to luxury cars, WooCommerce is fully customizable.</p><a class="btn btn-link ps-0" href="#" role="button"> Browse Extensions › </a>
              </div>
            </div>
            <div class="col-md-4 mb-5 mb-md-0"><img class="img-fluid shadow-sm" src="{{ asset('landing/img/gallery/feature-3.png') }}" alt="" />
              <div class="mt-3 text-center text-md-start">
                <h4 class="display-6 fs-2 fs-lg-3 fw-bold">Active Community</h4>
                <p class="mb-0">WooCommerce is one of the fastest-growing eCommerce communities. </p><a class="btn btn-link ps-0" href="#" role="button"> Check our Forums ›</a>
              </div>
            </div>
          </div>
        </div><!-- end of .container-->

      </section>
      <!-- <section> close ============================-->
      <!-- ============================================-->

      <section class="bg-100 pb-0 mb-0" id="section3">
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
      </section>

      {{-- <section class="py-0">

        <!--/.bg-holder-->

        <div class="container-fluid px-0">
          <div class="card py-4 border-0 rounded-0 bg-primary">
            <div class="card-body">
              <div class="row flex-center">
                <div class="col-xl-9 d-flex justify-content-center  mb-xl-0">
                  <h2 class="text-light fw-bold">WooCommerce - the most customizable eCommerce<br />platform for building your online business.</h2>
                </div>
                <div class="col-xl-3 text-center"><a class="btn btn-lg btn-outline-light rounded-pill" href="#">GET STARTED</a></div>
              </div>
            </div>
          </div>
        </div>
      </section> --}}

      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <section class="bg-info pt-0 pb-0">
        <div class="container">
          <div class="row justify-content-sm-between py-6">
            <div class="col-auto mb-2">
              <div class="d-flex">
                <svg class="bi bi-check-circle" xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="#ffffff" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"></path>
                </svg>
                <p class="mb-0 text-light ms-2">30 day money back guarantee</p>
              </div>
            </div>
            <div class="col-auto mb-2">
              <div class="d-flex">
                <svg class="bi bi-gear-wide-connected" xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="#ffffff" viewBox="0 0 16 16">
                  <path d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434l.071-.286zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5zm0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78h4.723zM5.048 3.967c-.03.021-.058.043-.087.065l.087-.065zm-.431.355A4.984 4.984 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8 4.617 4.322zm.344 7.646l.087.065-.087-.065z"></path>
                </svg>
                <p class="mb-0 text-light ms-2">Support teams across the world</p>
              </div>
            </div>
            <div class="col-auto">
              <div class="d-flex">
                <svg class="bi bi-shield-lock-fill" xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="#ffffff" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.777 11.777 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7.159 7.159 0 0 0 1.048-.625 11.775 11.775 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.541 1.541 0 0 0-1.044-1.263 62.467 62.467 0 0 0-2.887-.87C9.843.266 8.69 0 8 0zm0 5a1.5 1.5 0 0 1 .5 2.915l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99A1.5 1.5 0 0 1 8 5z"></path>
                </svg>
                <p class="mb-0 text-light ms-2">Safe &amp; Secure online payment</p>
              </div>
            </div>
          </div>
          <div class="row flex-center">
            <div class="col-auto py-4"><a href="#"><img class="img-fluid" src="{{ asset('landing/img/icons/f-logo.png') }}" alt="" /></a></div>
          </div>
          <hr class="opacity-25" />
          <div class="row justify-content-lg-around">
            <div class="col-6 col-sm-4 col-lg-auto mb-3 order-0">
              <h6 class="text-light lh-lg text-uppercase">Who we Are</h6>
              <ul class="list-unstyled mb-md-4 mb-lg-0">
                <li class="lh-lg"><a class="text-light fs--1 text-decoration-none" href="#!">About</a></li>
                <li class="lh-lg"><a class="text-light fs--1 text-decoration-none" href="#!">Team</a></li>
                <li class="lh-lg"><a class="text-light fs--1 text-decoration-none" href="#!">Work With Us</a></li>
              </ul>
            </div>
            <div class="col-6 col-sm-4 col-lg-auto mb-3 order-4 order-lg-1">
              <h6 class="text-light lh-lg text-uppercase"> Woocommerce </h6>
              <ul class="list-unstyled mb-md-4 mb-lg-0">
                <li class="lh-lg"><a class="text-light fs--1 text-decoration-none" href="#!">Features</a></li>
                <li class="lh-lg"><a class="text-light fs--1 text-decoration-none" href="#!">Payments </a></li>
                <li class="lh-lg"><a class="text-light fs--1 text-decoration-none" href="#!">Marketing</a></li>
                <li class="lh-lg"><a class="text-light fs--1 text-decoration-none" href="#!">Shipping</a></li>
                <li class="lh-lg"><a class="text-light fs--1 text-decoration-none" href="#!">Extension</a></li>

              </ul>
            </div>
            <div class="col-6 col-sm-4 col-lg-auto mb-3 order-1 order-lg-2">
              <h6 class="text-light lh-lg text-uppercase">Other products </h6>
              <ul class="list-unstyled mb-md-4 mb-lg-0">
                <li class="lh-lg"><a class="text-light fs--1 text-decoration-none" href="#!">Storefront</a></li>
                <li class="lh-lg"><a class="text-light fs--1 text-decoration-none" href="#!">WooSlider</a></li>
                <li class="lh-lg"><a class="text-light fs--1 text-decoration-none" href="#!">Sensei</a></li>
                <li class="lh-lg"><a class="text-light fs--1 text-decoration-none" href="#!">Sensei Extensions</a></li>
              </ul>
            </div>
            <div class="col-6 col-sm-4 col-lg-auto mb-3 order-3 order-lg-3">
              <h6 class="text-light lh-lg text-uppercase">Support</h6>
              <ul class="list-unstyled mb-md-4 mb-lg-0">
                <li class="lh-lg"><a class="text-light fs--1 text-decoration-none" href="#!">Documentation</a></li>
                <li class="lh-lg"><a class="text-light fs--1 text-decoration-none" href="#!">Customizations</a></li>
                <li class="lh-lg"><a class="text-light fs--1 text-decoration-none" href="#!">Support Policy</a></li>
                <li class="lh-lg"><a class="text-light fs--1 text-decoration-none" href="#!">Contact </a></li>
                <li class="lh-lg"><a class="text-light fs--1 text-decoration-none" href="#!">COVID-19 Resources</a></li>
                <li class="lh-lg"><a class="text-light fs--1 text-decoration-none" href="#!">Privacy Notice for </a></li>
                <li class="lh-lg"><a class="text-light fs--1 text-decoration-none" href="#!">California Users</a></li>
              </ul>
            </div>
            <div class="col-6 col-sm-4 col-lg-auto mb-3 order-2 order-lg-4">
              <h6 class="text-light lh-lg text-uppercase">We recommend</h6>
              <ul class="list-unstyled mb-md-4 mb-lg-0">
                <li class="lh-lg"><a class="text-light fs--1 text-decoration-none" href="#!">WooExperts</a></li>
                <li class="lh-lg"><a class="text-light fs--1 text-decoration-none" href="#!">Hosting Solutions</a></li>
                <li class="lh-lg"><a class="text-light fs--1 text-decoration-none" href="#!">Pre-sales FAQ</a></li>
                <li class="lh-lg"><a class="text-light fs--1 text-decoration-none" href="#!">Success Stories</a></li>
                <li class="lh-lg"><a class="text-light fs--1 text-decoration-none" href="#!">Design Feedback Group</a></li>
              </ul>
            </div>
          </div>
        </div><!-- end of .container-->

      </section>
      <!-- <section> close ============================-->
      <!-- ============================================-->

<!-- Modal -->
<div class="modal fade" id="info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Hallo Selamat Selamat Datang
        </div>

      </div>
    </div>
  </div>


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

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="{{ asset('landing/vendors/is/is.min.js') }}"></script>
    <script src="{{ asset('landing/js/theme.js') }}"></script>
     <script src="{{ asset('asset/js/jquery.slimscroll.min.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>

    <script>
        function menuToggle() {
          const toggleMenu = document.querySelector(".menu");
          toggleMenu.classList.toggle("active");
        }
      </script>

</script>
   <script>
        function refreshdata(){
            $.ajax({
                url:"{{ route('rfidDataGET') }}",
                method:"GET",
                cache:false,
                success: function(data){
                    $('#id_rfid').html(data);
                }
            });


        let id_rfid = $('#id_rfid').val();
        var e = document.getElementById("id_rfid");
            function onChange() {
            var value = e.value;
            $.ajax({
                url:"{{ route('rfidData') }}",
                method:"GET",
                cache:false,
                data : {id_rfid:id_rfid},
                success: function(data){
                    $('#nama').val(data);
                    if(data){
                    $('#info').html(
                        '<div class="alert alert-primary" role="alert">'+
                        'Halo '+data+',<br>Terimakasih telah mengisi absen hari ini. Semoga harimu menyenangkan dan tetap semangat belajar! '+
                        '</div>'
                    );
                    }else{
                        $('#info').html('');
                    }
                }
            });

            }
            e.onchange = onChange;
            onChange();
            }
            setInterval(refreshdata,2000);
    </script>
    </script>

        <script>
            function refreshdata2(){

            var content="";
            $.ajax({
                url:"{{ route('listabsents') }}",
                method:"GET",
                dataType:"json",
                success: function(response){
                    if(response.length === 0){
                        content+='<tr>'+
                                    '<td colspan="3">'+
                                        '<center> <span class="ti ti-mood-confuzed"></span><i> Belum ada riwayat absensi untuk hari ini..</i>'+
                                            '</center>'+
                                        '</td>'+
                                    '</tr>'
                    }else{

                        for(i=0;i<response.length;i++){
                            content+= '<tr><td>'+response[i].date+' <span class="ti ti-clock-hour-1"></span> '+response[i].time+'</td>'
                        if(response[i].student){
                            content += '<td>'+response[i].student.nama+ '</td>'
                        }else{
                            content += '<td>'+response[i].gtk.nama+ '</td>'
                        }
                        content+= '<td>'+response[i].status+'</td></tr>'
                        // console.log(value['fname']);
                    }
                    }

                    $('#myData').html(content);
                }
            });
        }
            setInterval(refreshdata2,2000);

        </script>

<script>
function jam() {
        var e = document.getElementById('jam'),
        d = new Date(), h, m, s;
        h = d.getHours();
        m = set(d.getMinutes());
        s = set(d.getSeconds());

        e.innerHTML = h +':'+ m +':'+ s;

        setTimeout('jam()', 1000);
    }

    function set(e) {
        e = e < 10 ? '0'+ e : e;
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

    this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';

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

    setTimeout(function() {
    that.tick();
    }, delta);
    };

    window.onload = function() {
     jam();
    var elements = document.getElementsByClassName('typewrite');
    for (var i=0; i<elements.length; i++) {
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

