<!DOCTYPE html>
<html lang="en-US" dir="ltr">

  <head>
    <meta charset="utf-8">
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

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link href="{{ asset('landing/css/theme.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/iconfont/tabler-icons.min.css">
<style>
    * {
  margin: 0;
  padding: 0;
  font-family: "Poppins", sans-serif;
}

.action {

  top: 20px;
  right: 30px;
}

.action .profile {
  position: relative;
  width: 60px;
  height: 60px;
  border-radius: 50%;
  overflow: hidden;
  cursor: pointer;
}

.action .profile img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.action .menu {
  position: absolute;
  top: 120px;
  right: -10px;
  filter: drop-shadow(0 0 0.75rem rgb(230, 228, 228));
  background: rgb(255, 255, 255);
  width: 200px;
  box-sizing: 0 5px 25px rgba(0, 0, 0, 0.1);
  border-radius: 15px;
  transition: 0.5s;
  visibility: hidden;
  opacity: 0;
}

.action .menu.active {
  top: 80px;
  visibility: visible;
  opacity: 1;
}

.action .menu::before {
  content: "";
  position: absolute;
  top: -5px;
  right: 28px;
  width: 20px;
  height: 20px;
  background: #fff;
  transform: rotate(45deg);
}

.action .menu h3 {
  width: 100%;
  text-align: center;
  font-size: 18px;
  padding: 20px 0;
  font-weight: 500;
  color: #555;
  line-height: 1.5em;
}

.action .menu h3 span {
  font-size: 14px;
  color: #cecece;
  font-weight: 300;
}

.action .menu ul li {
  list-style: none;
  padding: 16px 0;
  border-top: 1px solid rgba(0, 0, 0, 0.05);
  display: flex;
  align-items: center;
}

.action .menu ul li img {
  max-width: 20px;
  margin-right: 10px;
  opacity: 0.5;
  transition: 0.5s;
}

.action .menu ul li:hover img {
  opacity: 1;
}

.action .menu ul li a {
  display: inline-block;
  text-decoration: none;
  color: #555;
  font-weight: 500;
  transition: 0.5s;
}

.action .menu ul li:hover a {
  color: #7854F7;
}

</style>
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
            <ul class="navbar-nav me-auto ms-lg-4 ms-xl-7 border-bottom border-lg-bottom-0 pt-2 pt-lg-0 g-5">
              <li class="nav-item"><a class="nav-link fw-medium active" aria-current="page" href="#section1">Beranda</a></li>
              <li class="nav-item"><a class="nav-link fw-medium" href="#section2">Berita</a></li>
              <li class="nav-item"><a class="nav-link fw-medium" href="#section3">Komunitas </a></li>

            </ul>
            @if(auth()->user())
            <div class="d-flex py-3 py-lg-0">
                <div class="action">
                    <div class="profile" onclick="menuToggle();">
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

                       @if(auth()->user()->role == "admin")
                           <img src='{{ asset('asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                       @endif

                    </span>
                    <div>
                        <h6 class>{{ auth()->user()->nama }}</h6>
                        <p class="text-primary mb-0">{{ auth()->user()->email }}</p>
                    </div>
                    </div>
                    <div class="menu">
                      <h3 class="mb-0">{{ auth()->user()->nama }}<br /><span class="text-primary">{{ auth()->user()->email }}</span></h3>
                      <ul>
                        <li>
                            @if(auth()->user()->role =="admin")
                                @php $link = route('dashboard.admin')  @endphp
                            @elseif (auth()->user()->role=="walikelas")
                                @php $link = route('dashboard.walikelas')  @endphp
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
            <form class="d-flex py-3 py-lg-0"><a class="btn btn-info order-0 me-1" href="/login" role="button"><span class="ti ti-login"></span> Masuk Aplikasi</a>
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
            <div class="col-lg-6 col-md-5 order-md-1 pt-8"><img class="img-fluid" src="{{ asset('landing/img/gallery/OrangASN.png') }}" alt="" /></div>
            <div class="col-md-7 col-lg-6 text-center text-md-start pt-5 pt-md-9">
              <h1 class="display-2 fw-bold fs-4 fs-md-5 fs-xl-6 ml-2">Absen Pintar,<br />Kerja Lebih Cerdas.</h1>

                <div class=" m-0">
                    <div class="card-body">
                        <div class="alert alert-success d-flex align-items-center mb-24" role="alert">
                            <i class="ti ti-info-square-rounded me-2 fs-14"></i>
                            <div class="fs-14">
                            These Result are obtained from the syllabus completion on the respective Class
                            </div>
                            </div>
                        <input type="text" class="form-control my-3" placeholder="Nama Siswa" value="DADANG SURJANA" readonly>
                        <input type="text" class="form-control my-3" placeholder="Kelas" value="X RPL 1" readonly>
                    </div>
                </div>

              <a class="btn btn-lg btn-info rounded-pill me-2" href="#" role="button">Start a New Store </a><span> or  </span><a class="btn btn-link ps-1 ps-md-4 ps-lg-1" href="#" role="button"> Customize &amp; Extend ›</a>
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

      <section class="bg-100 pb-0" id="section3">
        <div class="container">
          <div class="row flex-center">
            <div class="col-xl-5 text-center mb-5 z-index-1">
              <h1 class="display-3 fw-bold fs-4 fs-md-6">Supported by real people</h1>
              <p>Our team of Happiness Engineers works remotely from 58 countries providing customer support across multiple time zones.</p>
            </div>
          </div>
        </div>
        <div class="position-relative text-center">
          <div class="bg-holder" style="background-image:url(undefined);background:url({{ asset('assets/img/gallery/people-bg-shape.png') }}) no-repeat center bottom, url(assets/img/gallery/people-bg-dot.png) no-repeat center bottom;">
          </div>
          <!--/.bg-holder-->
          <img class="img-fluid position-relative z-index-1" src="{{ asset('landing/img/gallery/people.png') }}" alt="" />
        </div>
      </section>
      <section class="py-0">
        <div class="bg-holder z-index-2" style="background-image:url({{ asset('landing/img/illustrations/cta-bg.png') }});background-position:bottom right;background-size:61px 60px;margin-top:15px;margin-right:15px;margin-left:-58px;">
        </div>
        <!--/.bg-holder-->

        <div class="container-fluid px-0">
          <div class="card py-4 border-0 rounded-0 bg-primary">
            <div class="card-body">
              <div class="row flex-center">
                <div class="col-xl-9 d-flex justify-content-center mb-3 mb-xl-0">
                  <h2 class="text-light fw-bold">WooCommerce - the most customizable eCommerce<br />platform for building your online business.</h2>
                </div>
                <div class="col-xl-3 text-center"><a class="btn btn-lg btn-outline-light rounded-pill" href="#">GET STARTED</a></div>
              </div>
            </div>
          </div>
        </div>
      </section>

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

    <script src="{{ asset('landing/vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('landing/vendors/is/is.min.js') }}"></script>
    <script src="{{ asset('landing/js/theme.js') }}"></script>
    <script>
        function menuToggle() {
          const toggleMenu = document.querySelector(".menu");
          toggleMenu.classList.toggle("active");
        }
      </script>
  </body>

</html>

