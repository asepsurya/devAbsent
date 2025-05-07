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
<style>
    .list-group-item.hover-zoom {
      transition: transform 0.2s ease-in-out;
      cursor: pointer;
    }

    .list-group-item.hover-zoom:hover {
      transform: scale(1.02);
      background-color: #f8f9fa; /* warna latar saat hover */
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
                                        <label class="form-label">Email, NIK atau NIS </label>
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
                                            <a data-bs-toggle="modal" data-bs-target="#kebijakanModal" class="ms-1 mb-0 ">Saya Setuju dengan Kebijakan</a>
                                        </div>
                                        <div class="text-end ">
                                            <a data-bs-toggle="modal" data-bs-target="#bantuanModal" class="link-danger">Lupa Password?</a>
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
                        <p class="mb-0 ">Copyright © 2025 - Absensi Sakti</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
    <div class="modal fade" id="bantuanModal" tabindex="-1" aria-labelledby="bantuanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content rounded-4">
            <div class="modal-header border-0">
              <h5 class="modal-title fw-bold w-100 text-center" id="bantuanModalLabel">Butuh Bantuan?</h5>
            </div>
            <div class="modal-body pt-0 m-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item hover-zoom d-flex justify-content-between align-items-start">
                        <a href="{{ route('lostPass') }}">
                        <div>
                            <div class="fw-bold">Lupa Kata Sandi</div>
                            <small class="text-muted">Saya ingin mengatur ulang kata sandi untuk mengakses Aplikasi.</small>
                        </div>
                        </a>
                      <span class="text-muted">&rsaquo;</span>
                    </li>
                    {{-- <li class="list-group-item hover-zoom d-flex justify-content-between align-items-start">
                      <div>
                        <div class="fw-bold">Lupa Akun</div>
                        <small class="text-muted">Saya lupa akun yang digunakan untuk mengakses Aplikasi.</small>
                      </div>
                      <span class="text-muted">&rsaquo;</span>
                    </li> --}}

                  </ul>

            </div>
          </div>
        </div>
      </div>
    <!-- Modal -->
    <div class="modal fade" id="kebijakanModal" tabindex="-1" aria-labelledby="kebijakanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="kebijakanModalLabel">Kebijakan Privasi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <p>Selamat datang di <strong>Absensi Sakti</strong>. Privasi Anda sangat penting bagi kami. Kebijakan privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi yang Anda berikan saat menggunakan aplikasi <strong>Absensi Sakti</strong>, sebuah sistem absensi berbasis RFID dan manajemen kelas.</p>
                </div>

                <div class="mb-3">
                    <h5>1. Informasi yang Kami Kumpulkan</h5>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-person-fill"></i> <strong>Data Pribadi:</strong> Nama, email, nomor telepon, dan data identitas lainnya.</li>
                        <li><i class="bi bi-clock-fill"></i> <strong>Data Absensi:</strong> Waktu dan lokasi kehadiran melalui perangkat RFID.</li>
                        <li><i class="bi bi-journal-bookmark-fill"></i> <strong>Data Kelas:</strong> Informasi kelas, jadwal, dan daftar siswa.</li>
                        <li><i class="bi bi-laptop-fill"></i> <strong>Data Perangkat:</strong> IP Address, jenis browser, dan perangkat.</li>
                    </ul>
                </div>

                <div class="mb-3">
                    <h5>2. Penggunaan Informasi</h5>
                    <p>Data yang kami kumpulkan digunakan untuk:</p>
                    <ul>
                        <li>Mencatat kehadiran siswa secara otomatis melalui RFID.</li>
                        <li>Mengelola jadwal dan data kelas.</li>
                        <li>Mengirimkan notifikasi absensi dan pengumuman kelas.</li>
                        <li>Meningkatkan layanan dan keamanan aplikasi.</li>
                        <li>Keperluan administrasi sekolah.</li>
                    </ul>
                </div>

                <div class="mb-3">
                    <h5>3. Keamanan Data</h5>
                    <p>Kami menjaga data Anda dengan sistem enkripsi dan pembatasan akses untuk mencegah penyalahgunaan.</p>
                </div>

                <div class="mb-3">
                    <h5>4. Pembagian Informasi</h5>
                    <p>Kami tidak membagikan data tanpa persetujuan, kecuali untuk:</p>
                    <ul>
                        <li>Kepentingan akademik internal sekolah.</li>
                        <li>Memenuhi kewajiban hukum yang berlaku.</li>
                    </ul>
                </div>

                <div class="mb-3">
                    <h5>5. Hak Pengguna</h5>
                    <ul>
                        <li>Mengakses dan memperbarui data pribadi.</li>
                        <li>Meminta penghapusan data sesuai ketentuan.</li>
                        <li>Menyampaikan pertanyaan/keluhan melalui kontak kami.</li>
                    </ul>
                </div>

                <div class="mb-3">
                    <h5>6. Perubahan Kebijakan</h5>
                    <p>Kami dapat memperbarui kebijakan ini sewaktu-waktu dan akan diinformasikan melalui aplikasi atau website resmi <strong>Absensi Sakti</strong>.</p>
                </div>

                <div class="mb-3">
                    <h5>7. Hubungi Kami</h5>
                    <ul>
                        <li><strong>Email:</strong> official@scrollwebid.com</li>
                        <li><strong>Telepon:</strong> +62 87731402487</li>
                    </ul>
                </div>

                <p class="text-muted text-end">Terakhir diperbarui: 6 Mei 2025</p>
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
