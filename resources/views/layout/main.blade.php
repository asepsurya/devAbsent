<!DOCTYPE html>
<html lang="id" data-theme="light" data-sidebar="light" data-color="primary" data-topbar="white" data-layout="default">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Absensi Sakti adalah aplikasi absensi pintar yang dirancang untuk memudahkan proses pencatatan kehadiran karyawan, siswa, atau anggota organisasi secara cepat, akurat, dan real-time.">
    <meta name="keywords" content="admin, estimates, bootstrap, business, html5, responsive, Projects">
    <meta name="author" content="Tasik Base Technology">
    <meta name="robots" content="noindex, nofollow">

    <title>{{ app('settings')['site_name'] }} | {{ $title }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ app('settings')['site_fav'] == '' ? asset('asset/img/default-logo.png') : asset('storage/' . app('settings')['site_fav']) }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('asset/js/lightDark.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <link rel="stylesheet" href="{{ asset('asset/css/boostrap.min.css') }}">
    <script src="{{ asset('asset/js/feather.min.js') }}" ></script>
    <link rel="stylesheet" href="{{ asset('asset/css/tabler-icon/tabler-icons.css') }}"/>
    <link rel="stylesheet" href="{{ asset('asset/css/daterangepicker.css') }}">
    <!-- SweetAlert2 CDN -->
    <script src="{{ asset('asset/js/sweet-alert.js') }}"></script>
    <link href="{{ asset('asset/Plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('asset/Plugins/select2/js/select2.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('asset/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
    <style>
        .search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: white;
            border: 1px solid #ddd;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            display: none;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
        }

        .search-suggestions div {
            padding: 10px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
        }

        .search-suggestions div:hover {
            background: #f8f9fa;
        }
    </style>
    @yield('css')
</head>

<body >

    <div class="main-wrapper">
        @include('partial.header')
        @include('partial.sidebar')
        <div class="page-wrapper">
            <div class="content blank-page">
                {{-- main Content --}}

                @if ($updateAvailable)
                <div id="updateAlert" class="alert alert-primary d-flex align-items-center justify-content-between" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-info-circle me-2"></i>
                        <div class="text-primary">
                            <strong>Update Tersedia!</strong>
                            <p class="mb-0">Versi baru telah tersedia. Update sekarang?</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('update.app') }}" id="updateForm">
                        @csrf
                        <button type="submit" id="updateButton" class="btn btn-primary">Update Now</button>
                    </form>
                </div>


                <script>
                    document.getElementById('updateForm').addEventListener('submit', function (e) {
                        e.preventDefault();  // Mencegah form submit default

                        const updateButton = document.getElementById('updateButton');
                        const updateAlert = document.getElementById('updateAlert');

                        // Menonaktifkan tombol dan menambahkan spinner
                        updateButton.disabled = true;
                        updateButton.innerHTML = 'Updating... <i class="fas fa-spinner fa-spin"></i>';

                        fetch("{{ route('update.app') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                // Menampilkan alert sukses
                                updateAlert.classList.remove('alert-primary');
                                updateAlert.classList.add('alert-success');
                                updateAlert.innerHTML = `
                                      <div class="d-flex align-items-center">
                                            <i class="ti ti-info-circle me-2"></i>
                                                <div class="text-success">
                                                    <strong>Update Berhasil!</strong>
                                                    <p class="mb-0">Terimakasih telah update aplikasi kami. Tunggu update selanjutnya</p>
                                                </div>
                                        </div>
                                `;

                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Aplikasi berhasil diperbarui.',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload();  // Reload halaman untuk memuat pembaruan
                                });
                            } else {
                                // Jika gagal, kembalikan tampilan tombol
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Gagal memperbarui aplikasi. Coba lagi nanti.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    updateButton.disabled = false;
                                    updateButton.innerHTML = 'Update Now';
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi kesalahan. Coba lagi nanti.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                updateButton.disabled = false;
                                updateButton.innerHTML = 'Update Now';
                            });
                        });
                    });
                </script>
            @endif


                @yield('container')
                @include('sweetalert::alert')
            </div>
        </div>

    </div>
    @include('layout.ubahpassword')

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
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

</body>

</html>
