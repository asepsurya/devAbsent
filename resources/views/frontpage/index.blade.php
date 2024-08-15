<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Preskool - Bootstrap Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, html5, responsive, Projects">
    <meta name="author" content="Dreams technologies - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Absensi Sakti </title>

    <link rel="shortcut icon" type="image/x-icon" href="https://preskool.dreamstechnologies.com/html/template/assets/img/favicon.png">
    {{-- <script src="asset/js/theme-script.js" type="d8aa163ebe66f835399f615d-text/javascript"></script> --}}
    <link rel="stylesheet" href="{{ asset('asset/css/boostrap.min.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.2/feather.min.js" integrity="sha512-zMm7+ZQ8AZr1r3W8Z8lDATkH05QG5Gm2xc6MlsCdBz9l6oE8Y7IXByMgSm/rdRQrhuHt99HAYfMljBOEZ68q5A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/iconfont/tabler-icons.min.css">
    <link rel="stylesheet" href="{{ asset('asset/css/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
</head>

<body>
    <div class="main-wrapper">
        <div class="header">

            <div class="header-user">
                <div class="nav user-menu">
                    <div class="header-left active">
                        <a href="index.html" class="logo logo-normal">
                            <img src="{{ asset('asset/img/logo.png') }}" alt="Logo" width="100">
                        </a>
                    </div>
                    
                    <div class="nav-item nav-search-inputs me-auto">
                      
                    </div>
        
                    <div class="d-flex align-items-center">
                     
                        <div class="pe-1">
                            <a href="chat.html" class="btn btn-outline-light bg-white btn-icon position-relative me-1">
                                <i class="ti ti-brand-hipchat"></i>
                                <span class="chat-status-dot"></span>
                            </a>
                        </div>
                        <div class="pe-1">
                            <a href="#" class="btn btn-outline-light bg-white btn-icon me-1">
                                <i class="ti ti-chart-bar"></i>
                            </a>
                        </div>
                        <div class="pe-1">
                            <a href="#" class="btn btn-outline-light bg-white btn-icon me-1" id="btnFullscreen">
                                <i class="ti ti-maximize"></i>
                            </a>
                        </div>
                        <div class="dropdown ms-1">
                            <a href="javascript:void(0);" class="dropdown-toggle d-flex align-items-center"
                                data-bs-toggle="dropdown">
                                <span class="avatar avatar-md rounded">
                                    <img src="https://preskool.dreamstechnologies.com/html/template/assets/img/profiles/avatar-27.jpg" alt="Img" class="img-fluid">
                                </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="d-block">
                                    <div class="d-flex align-items-center p-2">
                                        <span class="avatar avatar-md me-2 online avatar-rounded">
                                            <img src="https://preskool.dreamstechnologies.com/html/template/assets/img/profiles/avatar-27.jpg" alt="img">
                                        </span>
                                        <div>
                                            <h6 class>Kevin Larry</h6>
                                            <p class="text-primary mb-0">Administrator</p>
                                        </div>
                                    </div>
                                    <hr class="m-0">
                                    <a class="dropdown-item d-inline-flex align-items-center p-2" href="profile.html">
                                        <i class="ti ti-user-circle me-2"></i>My Profile</a>
                                    <a class="dropdown-item d-inline-flex align-items-center p-2"
                                        href="profile-settings.html"><i class="ti ti-settings me-2"></i>Settings</a>
                                    <hr class="m-0">
                                    <a class="dropdown-item d-inline-flex align-items-center p-2" href="login.html"><i
                                            class="ti ti-login me-2"></i>Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="dropdown mobile-user-menu">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="profile.html">My Profile</a>
                    <a class="dropdown-item" href="profile-settings.html">Settings</a>
                    <a class="dropdown-item" href="login.html">Logout</a>
                </div>
            </div>
        
        </div>

    </div>
    
    <script src="{{ asset('asset/js/jquery-3.7.1.min.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="{{ asset('asset/js/bootstrap.bundle.min.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="{{ asset('asset/js/moment.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="{{ asset('asset/Plugins/daterangepicker/daterangepicker.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="{{ asset('asset/js/bootstrap-datetimepicker.min.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="{{ asset('asset/js/feather.min.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="{{ asset('asset/js/jquery.slimscroll.min.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="{{ asset('asset/Plugins/apexchart/apexcharts.min.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="{{ asset('asset/Plugins/apexchart/chart-data.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="{{ asset('asset/js/owl.carousel.min.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="{{ asset('asset/Plugins/select2/js/select2.min.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="{{ asset('asset/Plugins/countup/jquery.counterup.min.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="{{ asset('asset/Plugins/countup/jquery.waypoints.min.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="{{ asset('asset/js/script.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <script src="{{ asset('asset/js/rocket-loader.min.js') }}" data-cf-settings="d8aa163ebe66f835399f615d-|49" defer></script>
</body>

</body>
</html>