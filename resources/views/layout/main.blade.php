<!DOCTYPE html>
<html lang="id" data-theme="light" data-sidebar="light" data-color="primary" data-topbar="white" data-layout="default">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

    <meta name="description" content="Preskool - Bootstrap Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, html5, responsive, Projects">
    <meta name="author" content="Dreams technologies - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">

    <title>{{ app('settings')['site_name'] }} | {{ $title }}</title>
    <link rel="shortcut icon" type="image/x-icon"
      href="{{ app('settings')['site_fav'] == '' ? asset('asset/img/default-logo.png') : asset('storage/' . app('settings')['site_fav']) }}">
    {{-- <script src="{{ asset('asset/js/jquery-3.7.1.min.js') }}"></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    {{-- <script src="{{ asset('asset/js/theme.js') }}"></script> --}}
    <script src="{{ asset('asset/js/lightDark.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <link rel="stylesheet" href="{{ asset('asset/css/boostrap.min.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.2/feather.min.js" integrity="sha512-zMm7+ZQ8AZr1r3W8Z8lDATkH05QG5Gm2xc6MlsCdBz9l6oE8Y7IXByMgSm/rdRQrhuHt99HAYfMljBOEZ68q5A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/iconfont/tabler-icons.min.css">
    <link rel="stylesheet" href="{{ asset('asset/css/daterangepicker.css') }}">

    <link href="{{ asset('asset/Plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('asset/Plugins/select2/js/select2.min.js') }}"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('asset/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">

    @yield('css')
</head>

<body >

    <div class="main-wrapper">
        @include('partial.header')
        @include('partial.sidebar')
        <div class="page-wrapper">
            <div class="content blank-page">
                {{-- main Content --}}
                @yield('container')
                @include('sweetalert::alert')
            </div>
        </div>

    </div>
    @include('layout.ubahpassword')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    @yield('javascript');
    <script src="{{ asset('asset/js/feather.min.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="{{ asset('asset/js/jquery.slimscroll.min.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="{{ asset('asset/js/owl.carousel.min.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="{{ asset('asset/js/rocket-loader.min.js') }}" data-cf-settings="d8aa163ebe66f835399f615d-|49" defer></script>

    <script src="{{ asset('asset/js/moment.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="{{ asset('asset/js/feather.min.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="{{ asset('asset/Plugins/daterangepicker/daterangepicker.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="{{ asset('asset/js/bootstrap-datetimepicker.min.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="{{ asset('asset/js/script.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script>
          // Setting data attributes and classes
        //   document.documentElement.setAttribute('data-layout', 'mini');
        //   $("#toggle_btn").click(function(){
        //     document.body.classList.add("mini-sidebar");
        //     document.body.classList.remove("layout-box-mode");
        //     // Saving to localStorage
        //     localStorage.setItem('theme', theme);
        //     localStorage.setItem('sidebarTheme', sidebarTheme);
        //     localStorage.setItem('color', color);
        //     localStorage.setItem('data-layout', 'mini');
        //     localStorage.setItem('topbar', topbar);
        //   });


    </script>
</body>

</html>
