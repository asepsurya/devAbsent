<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Preskool - Bootstrap Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, html5, responsive, Projects">
    <meta name="author" content="Dreams technologies - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>404 Page not found</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('asset/img/logo-icon.png') }}">
    {{-- <script src="{{ asset('asset/js/jquery-3.7.1.min.js') }}"></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="{{ asset('asset/js/lightDark.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <link rel="stylesheet" href="{{ asset('asset/css/boostrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/iconfont/tabler-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('asset/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
</head>

<body class="error-page">

    <div class="main-wrapper ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-6 col-xl-7 col-md-6">
                    <div class="d-flex flex-column justify-content-between vh-100">
                        <div class="text-center p-4">
                            <a href="/"><img src="{{ asset('asset/img/logo.png') }}" alt="img" class="img-fluid" width="120px"></a>
                        </div>
                        <div class="d-flex flex-column justify-content-center align-items-center mb-4">
                            <div class="mb-4">
                                <img src="{{ asset('asset/img/error/error-500.svg') }}" class="error-img img-fluid"
                                    alt="Img">
                            </div>
                            <h3 class="h2 mb-3">Oops, ada yang tidak beres.</h3>
                            <p class="text-center">Server Error 500. Kami mohon maaf atas ketidaknyamanan ini. Tim kami sedang bekerja keras untuk memperbaiki masalah tersebut secepat mungkin. Terima kasih atas kesabaran Anda</p>
                            <button onclick="history.back()" class="btn btn-primary d-flex align-items-center"><i
                                    class="ti ti-arrow-left me-2"></i>Kembali</button>
                        </div>
                        <div class="text-center p-4">
                            <p>Copyright &copy; 2024 - Absensi Sakti</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
