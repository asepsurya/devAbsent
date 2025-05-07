<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Preskool - Bootstrap Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, html5, responsive, Projects">
    <meta name="author" content="Dreams technologies - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Absensi Sakti | Reset Password</title>
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
    {{-- <style>
        .password-rules {

            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 12px 16px;

        }
        .password-rules .rule-item {
            display: flex;
            align-items: center;
            margin-bottom: 6px;
            font-size: 14px;
        }
        .password-rules .rule-item .icon {
            width: 20px;
            display: inline-flex;
            justify-content: center;
            margin-right: 8px;
            font-size: 16px;
        } --}}
    </style>
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
                                    <h4 class="mb-4 text-center">Reset Password</h4>
                                    @if ($errors->any())
                                        <div class="card border-danger mb-3">
                                            <div class="card-header bg-danger text-white">Ada Kesalahan</div>
                                            <div class="card-body">
                                                <ul class="mb-0">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    @endif

                                    <form action="/reset-password" method="POST">
                                        @csrf
                                        <input type="hidden" name="token" value="{{ $token }}">
                                        <input type="hidden" name="email" value="{{ $email->email }}">

                                        <div class="mb-3">
                                            <label class="form-label">Password Baru</label>
                                            <div class="pass-group position-relative">
                                                <input type="password" class="pass-input form-control @error('password') is-invalid @enderror" placeholder="Masukan password kamu" name="password" id="password">
                                                <span class="ti ti-eye-off toggle-password position-absolute" data-target="#password" style="top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer;"></span>
                                            </div>
                                            @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Konfirmasi Password</label>
                                            <div class="pass-group position-relative">
                                                <input type="password" class="pass-input form-control @error('password_confirm') is-invalid @enderror"
                                                    placeholder="Masukan kembali password kamu" name="password_confirm" id="password_confirm">
                                                <span class="ti ti-eye-off toggle-password position-absolute" data-target="#password_confirm" style="top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer;"></span>
                                            </div>
                                            @error('password_confirm')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div id="password-rules" class="password-rules">
                                            <div id="rule-length" class="rule-item text-danger">
                                                <span class="icon">✖</span> Minimal 8 karakter
                                            </div>
                                            <div id="rule-upper" class="rule-item text-danger">
                                                <span class="icon">✖</span> Mengandung huruf besar
                                            </div>
                                            <div id="rule-lower" class="rule-item text-danger">
                                                <span class="icon">✖</span> Mengandung huruf kecil
                                            </div>
                                            <div id="rule-number" class="rule-item text-danger">
                                                <span class="icon">✖</span> Mengandung angka
                                            </div>
                                            <div id="rule-symbol" class="rule-item text-danger">
                                                <span class="icon">✖</span> Mengandung simbol (@$!%*#?&)
                                            </div>
                                        </div>
                                         {{-- start Chatcha --}}
                                         <div class="my-3">
                                            {!! NoCaptcha::renderJs() !!}
                                            {!! NoCaptcha::display() !!}
                                        </div>
                                        @if ($errors->has('g-recaptcha-response'))
                                        <span class="help-block">
                                            <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                                        </span>
                                        @endif
                                        <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                                    </form>


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
    <script>

        const passwordInput = document.getElementById('password');
        const ruleLength = document.getElementById('rule-length');
        const ruleUpper = document.getElementById('rule-upper');
        const ruleLower = document.getElementById('rule-lower');
        const ruleNumber = document.getElementById('rule-number');
        const ruleSymbol = document.getElementById('rule-symbol');

        passwordInput.addEventListener('input', function () {
            const value = this.value;

            // Cek panjang
            ruleLength.innerHTML = (value.length >= 8) ? '✔ Minimal 8 karakter' : '✖ Minimal 8 karakter';
            ruleLength.className = (value.length >= 8) ? 'text-success' : 'text-danger';

            // Cek huruf besar
            ruleUpper.innerHTML = /[A-Z]/.test(value) ? '✔ Mengandung huruf besar' : '✖ Mengandung huruf besar';
            ruleUpper.className = /[A-Z]/.test(value) ? 'text-success' : 'text-danger';

            // Cek huruf kecil
            ruleLower.innerHTML = /[a-z]/.test(value) ? '✔ Mengandung huruf kecil' : '✖ Mengandung huruf kecil';
            ruleLower.className = /[a-z]/.test(value) ? 'text-success' : 'text-danger';

            // Cek angka
            ruleNumber.innerHTML = /[0-9]/.test(value) ? '✔ Mengandung angka' : '✖ Mengandung angka';
            ruleNumber.className = /[0-9]/.test(value) ? 'text-success' : 'text-danger';

            // Cek simbol
            ruleSymbol.innerHTML = /[@$!%*#?&]/.test(value) ? '✔ Mengandung simbol (@$!%*#?&)' : '✖ Mengandung simbol (@$!%*#?&)';
            ruleSymbol.className = /[@$!%*#?&]/.test(value) ? 'text-success' : 'text-danger';
        });

        function updateRule(id, isValid) {
            const el = document.getElementById(id);
            el.querySelector('.icon').textContent = isValid ? '✔' : '✖';
            el.className = 'rule-item ' + (isValid ? 'text-success' : 'text-danger');
        }

        passwordInput.addEventListener('input', function () {
            const value = this.value;

            updateRule('rule-length', value.length >= 8);
            updateRule('rule-upper', /[A-Z]/.test(value));
            updateRule('rule-lower', /[a-z]/.test(value));
            updateRule('rule-number', /[0-9]/.test(value));
            updateRule('rule-symbol', /[@$!%*#?&]/.test(value));
        });

    </script>

    <script>

        document.querySelectorAll('.toggle-password').forEach(item => {
            item.addEventListener('click', function() {
                const target = document.querySelector(this.getAttribute('data-target'));
                if (target.type === 'password') {
                    target.type = 'text';
                    this.classList.remove('ti-eye-off');
                    this.classList.add('ti-eye');
                } else {
                    target.type = 'password';
                    this.classList.remove('ti-eye');
                    this.classList.add('ti-eye-off');
                }
            });
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

