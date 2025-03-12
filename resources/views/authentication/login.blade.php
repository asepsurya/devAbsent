<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Preskool - Bootstrap Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, html5, responsive, Projects">
    <meta name="author" content="Dreams technologies - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ app('settings')['site_name'] }} | {{ $title }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ app('settings')['site_logo'] == '' ? asset('asset/img/default-logo.png') : asset('storage/' . app('settings')['site_logo'])}}">
    <script src="{{ asset('asset/js/lightDark.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <link rel="stylesheet" href="{{ asset('asset/css/boostrap.min.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.2/feather.min.js"
        integrity="sha512-zMm7+ZQ8AZr1r3W8Z8lDATkH05QG5Gm2xc6MlsCdBz9l6oE8Y7IXByMgSm/rdRQrhuHt99HAYfMljBOEZ68q5A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/iconfont/tabler-icons.min.css">
    <link rel="stylesheet" href="{{ asset('asset/css/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
<style>
.spinner-border {
    margin-right: 5px; /* Jarak antara teks dan spinner */
}
</style>
<body class="account-page bg-light-gradient">
    <div class="bg-holder" style="background-image:url({{ asset('landing/img/illustrations/hero-bg.png') }});background-position:top right;background-size:cover;">
    <div class="main-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5 mx-auto">

                    <div class="d-flex flex-column justify-content-between vh-100">
                        <div class=" mx-auto p-4 text-center">

                        </div>
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="mylogo">
                                <div class="dark-logo">
                                    <img src="{{ asset('asset/img/logo-white.png') }}" class="img-fluid" alt="Logo" width="100">
                                </div>
                                <div class="logo-normal">
                                    <img src="{{ asset('asset/img/logo.png') }}" class="img-fluid" alt="Logo" width="100">
                                </div>
                            </div>
                                <div class=" mb-4">
                                    <h2 class="mb-2">Selamat Datang</h2>
                                    <p class="mb-0">Masukan detail akunmu untuk login </p>
                                </div>
                                {{-- alert --}}
                                @if(session()->has('loginError'))
                                <div class="alert alert-danger alert-dismissible fade show custom-alert-icon shadow-sm d-flex align-items-centers"
                                    role="alert">
                                    <i class="ti ti-exclamation-circle flex-shrink-0 me-2"></i>
                                    {{session('loginError')}}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i
                                            class="ti ti-x"></i></button>
                                </div>
                                @endif
                                {{-- End --}}
                                <form action="{{ route('loginAction') }}" method="post" id="loginForm">
                                    @csrf
                                    <div class="mb-3 ">
                                        <label class="form-label">Username</label>
                                        <div class="input-icon mb-3 position-relative">
                                            <span class="input-icon-addon">
                                                <i class="ti ti-mail"></i>
                                            </span>
                                            <input type="text"
                                                class="form-control @error('email') is-invalid @enderror "
                                                placeholder="Username" name="email" id="email">
                                            @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <label class="form-label">Kata Sandi</label>
                                        <div class="pass-group">
                                            <input type="password"
                                                class="pass-input form-control @error('password') is-invalid @enderror"
                                                placeholder="Masukan password kamu" name="password" id="password">
                                            <span class="ti toggle-password ti-eye-off"></span>
                                            @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        {{-- start Chatcha --}}
                                        <div class="mt-3">
                                            {!! NoCaptcha::renderJs() !!}
                                            {!! NoCaptcha::display() !!}
                                        </div>
                                        @if ($errors->has('g-recaptcha-response'))
                                        <span class="help-block">
                                            <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                                        </span>
                                        @endif
                                        {{-- end --}}
                                    </div>
                                    <div class="form-wrap form-wrap-checkbox mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="form-check form-check-md mb-0">
                                                <input class="form-check-input mt-0" type="checkbox" checked>
                                            </div>
                                            <p class="ms-1 mb-0 ">Remember Me</p>
                                        </div>
                                        <div class="text-end ">
                                            <a href="forgot-password.html" class="link-danger">Lupa Password?</a>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary w-100"><span id="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span> Masuk</button>
                                </form>
                            </div>
                            <div class="text-center">
                                <h6 class="fw-normal text-dark mb-0">Belum mempunyai akun? <a href="/register"
                                        class="hover-a "> Buat Akun</a>
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 text-center">
                        <p class="mb-0 ">Copyright © 2024 - Absensi Sakti</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
    <script>
        document.getElementById('loginForm').addEventListener('submit', function() {
            // Tampilkan spinner
            document.getElementById('loading').style.display = 'inline-block';
            // Nonaktifkan tombol untuk mencegah pengiriman ganda
            document.getElementById('loginButton').disabled = true;
        });
    </script>
    <script src="asset/js/jquery-3.7.1.min.js" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="asset/js/bootstrap.bundle.min.js" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="asset/js/moment.js" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="asset/Plugins/daterangepicker/daterangepicker.js" type="d8aa163ebe66f835399f615d-text/javascript">
    </script>
    <script src="asset/js/bootstrap-datetimepicker.min.js" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="asset/js/feather.min.js" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="asset/js/jquery.slimscroll.min.js" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="asset/Plugins/apexchart/apexcharts.min.js" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="asset/Plugins/apexchart/chart-data.js" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="asset/js/owl.carousel.min.js" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="asset/Plugins/select2/js/select2.min.js" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="asset/Plugins/countup/jquery.counterup.min.js" type="d8aa163ebe66f835399f615d-text/javascript">
    </script>
    <script src="asset/Plugins/countup/jquery.waypoints.min.js" type="d8aa163ebe66f835399f615d-text/javascript">
    </script>
    <script src="asset/js/script.js" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="asset/js/rocket-loader.min.js" data-cf-settings="d8aa163ebe66f835399f615d-|49" defer></script>
</body>

</html>
