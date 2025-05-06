<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Preskool - Bootstrap Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, html5, responsive, Projects">
    <meta name="author" content="Dreams technologies - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Absensi Sakti | {{ $title }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ app('settings')['site_logo'] == '' ? asset('asset/img/default-logo.png') : asset('storage/' . app('settings')['site_logo'])}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('asset/img/logo-icon.png') }}">
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
        .captcha-box {
            border: 1px solid #ddd;
            padding: 20px;

            border-radius: 8px;
            font-family: sans-serif;
            margin: 20px auto;
        }
    </style>
</head>
<body class="account-page bg-light-gradient">
    <div class="bg-holder" style="background-image:url({{ asset('landing/img/illustrations/hero-bg.png') }});background-position:top right;background-size:cover;">
    <div class="main-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5 mx-auto">

                        <div class="d-flex flex-column justify-content-between vh-100">
                            <div class=" mx-auto p-4 text-center">
                                <img src="{{ asset('asset/img/logo.png') }}" class="img-fluid" alt="Logo" width="100px">
                            </div>
                            <div class="card">
                                <div class="card-body p-4">
                                    <div class="mb-3">



                                        {{-- Logo --}}
                                        {{-- <center class="mb-3">
                                            <img src="{{ app('settings')['site_logo'] == '' ? asset('asset/img/default-logo.png') : asset('storage/' . app('settings')['site_logo'] ) }}" class="img-fluid" alt="Logo" width="50px">
                                        </center> --}}
                                        <center class="mb-5">
                                            <h3>Lupa Kata Sandi</h3>
                                            <p class="text-muted">Masukkan username/email dan kode verifikasi</p>
                                        </center>

                                        <form method="POST" action="{{ route('password.reset.submit') }}">
                                            @csrf

                                            {{-- Email --}}
                                            <div class="mb-3">
                                                <label class="form-label">Alamat Email</label>
                                                <input type="email" class="form-control" name="email" placeholder="Masukkan email" required>
                                            </div>
                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                             @enderror
                                            {{-- Captcha --}}
                                            <div class="captcha-box mb-3">
                                                <div class="captcha-img d-flex align-items-center justify-content-between mb-2">
                                                    <img src="{{ route('captcha.image') }}?{{ rand() }}" id="captcha-image" alt="Captcha">
                                                    <a href="#" class="btn btn-outline-light bg-white btn-sm" onclick="document.getElementById('captcha-image').src='{{ route('captcha.image') }}?'+Math.random(); return false;"><span class="ti ti-refresh"></span></a>
                                                </div>
                                                <input type="text" class="form-control" name="captcha_input" placeholder="Masukkan kode captcha" required>
                                            </div>
                                            @error('captcha_input')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            {{-- Pesan Feedback --}}
                                            @if(session('success'))
                                                <div class="text-success mb-2">{{ session('success') }}</div>
                                            @elseif(session('error'))
                                                <div class="text-danger mb-2">{{ session('error') }}</div>
                                            @endif

                                            {{-- Tombol Submit --}}
                                            <button type="submit" class="btn btn-primary w-100 mb-2">Reset Password</button>
                                        </form>



                                    </div>
                                    <center><small class="text-muted">Saya sudah mempunyai akun? <a href="/login" class="text-primary">Login</a></small></center>
                                </div>

                            </div>
                            <div class="p-4 text-center">
                                <p class="mb-0 ">Copyright © 2025 - Absensi Sakti</p>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
    </div>



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
