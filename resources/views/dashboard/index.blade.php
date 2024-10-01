@extends('layout.main')
@section('container')
<div class="row">
    <div class="col-md-12">
        {{-- <div class="alert-message">
            <div class="alert alert-success rounded-pill d-flex align-items-center justify-content-between border-success mb-4"
                role="alert">
                <div class="d-flex align-items-center">
                    <span class="me-1 avatar avatar-sm flex-shrink-0"><img
                            src="https://preskool.dreamstechnologies.com/html/template/assets/img/profiles/avatar-27.jpg"
                            alt="Img" class="img-fluid rounded-circle"></span>
                    <p>Fahed III,C has paid Fees for the <strong class="mx-1">“Term1”</strong></p>
                </div>
                <button type="button" class="btn-close p-0" data-bs-dismiss="alert" aria-label="Close"><span><i
                            class="ti ti-x"></i></span></button>
            </div>
        </div> --}}
        <div class="card bg-dark">
            <div class="overlay-img">
                <img src="https://preskool.dreamstechnologies.com/html/template/assets/img/bg/shape-04.png" alt="img"
                    class="img-fluid shape-01">
                <img src="https://preskool.dreamstechnologies.com/html/template/assets/img/bg/shape-01.png" alt="img"
                    class="img-fluid shape-02">
                <img src="https://preskool.dreamstechnologies.com/html/template/assets/img/bg/shape-02.png" alt="img"
                    class="img-fluid shape-03">
                <img src="https://preskool.dreamstechnologies.com/html/template/assets/img/bg/shape-03.png" alt="img"
                    class="img-fluid shape-04">
            </div>
            <div class="card-body">
                <div class="d-flex align-items-xl-center justify-content-xl-between flex-xl-row flex-column">
                    <div class="mb-3 mb-xl-0">
                        <div class="d-flex align-items-center flex-wrap mb-2">
                            <h1 class="text-white me-2">Selamat Datang, {{ auth()->user()->nama }}</h1>
                            <a href="https://preskool.dreamstechnologies.com/html/template/profile.html"
                                class="avatar avatar-sm img-rounded bg-gray-800 dark-hover"><i
                                    class="ti ti-edit text-white"></i></a>
                        </div>
                        <p class="text-white">Semoga Gajimu Naik Bro</p>
                    </div>
                    <p class="text-white"><i class="ti ti-refresh me-1"></i><i>Updated at {{ date("D d M Y, h:m:s")
                            }}</i>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
        <div class="my-auto mb-2">
            <h3 class="page-title mb-1">Beranda</h3>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="index.html">Beranda</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Beranda</li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- Card --}}
    <div class="col-xxl-4 col-sm-4 d-flex">
        <div class="card flex-fill animate-card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-xl  me-2 p-1">
                        <img src="{{ asset('asset/img/peserta-didik.png') }}" alt="img">
                    </div>
                    <div class="overflow-hidden flex-fill">
                        <div class="d-flex align-items-center justify-content-between">
                            <h2 class="counter">3654</h2>
                        </div>
                        <p>Peserta Didik</p>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between border-top mt-3 pt-3">
                    <p class="mb-0">Aktif : <span class="text-dark fw-semibold">3643</span></p>
                    <span class="text-light">|</span>
                    <p>Tidak Aktif : <span class="text-dark fw-semibold">11</span></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-4 col-sm-4 d-flex">
        <div class="card flex-fill animate-card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-xl me-2 p-1">
                        <img src="{{ asset('asset/img/gtk.png') }}" alt="img">
                    </div>
                    <div class="overflow-hidden flex-fill">
                        <div class="d-flex align-items-center justify-content-between">
                            <h2 class="counter">284</h2>
                        </div>
                        <p>GTK</p>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between border-top mt-3 pt-3">
                    <p class="mb-0">Aktif : <span class="text-dark fw-semibold">254</span></p>
                    <span class="text-light">|</span>
                    <p>Tidak Aktif : <span class="text-dark fw-semibold">30</span></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-4 col-sm-4 d-flex">
        <div class="card flex-fill animate-card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-xl me-2  p-1">
                        <img src="{{ asset('asset/img/rombongan-belajar.png') }}" alt="img">
                    </div>
                    <div class="overflow-hidden flex-fill">
                        <div class="d-flex align-items-center justify-content-between">
                            <h2 class="counter">162</h2>
                        </div>
                        <p>Rombongan Belajar</p>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between border-top mt-3 pt-3">
                    <p class="mb-0">Aktif : <span class="text-dark fw-semibold">161</span></p>
                    <span class="text-light">|</span>
                    <p>Tidak Aktif : <span class="text-dark fw-semibold">02</span></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-4 col-sm-4 d-flex">
        <div class="card flex-fill animate-card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-xl me-2  p-1">
                        <img src="{{ asset('asset/img/kelas.png') }}" alt="img">
                    </div>
                    <div class="overflow-hidden flex-fill">
                        <div class="d-flex align-items-center justify-content-between">
                            <h2 class="counter">82</h2>
                            {{-- <span class="badge bg-success">1.2%</span> --}}
                        </div>
                        <p>Kelas</p>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between border-top mt-3 pt-3">
                    <p class="mb-0">Aktif : <span class="text-dark fw-semibold">81</span></p>
                    <span class="text-light">|</span>
                    <p>Tidak Aktif : <span class="text-dark fw-semibold">01</span></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-4 col-sm-4 d-flex">
        <div class="card flex-fill animate-card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-xl me-2 p-1">
                        <img src="{{ asset('asset/img/masuk.png') }}" alt="img">
                    </div>
                    <div class="overflow-hidden flex-fill">
                        <div class="d-flex align-items-center justify-content-between">
                            <h2 class="counter">82</h2>
                            {{-- <span class="badge bg-success">1.2%</span> --}}
                        </div>
                        <p>Absen Masuk</p>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between border-top mt-3 pt-3">
                    <p class="mb-0">Sudah : <span class="text-dark fw-semibold">81</span></p>
                    <span class="text-light">|</span>
                    <p>Belum : <span class="text-dark fw-semibold">01</span></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-4 col-sm-4 d-flex">
        <div class="card flex-fill animate-card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-xl me-2 p-1">
                        <img src="{{ asset('asset/img/pulang.png') }}" alt="img">
                    </div>
                    <div class="overflow-hidden flex-fill">
                        <div class="d-flex align-items-center justify-content-between">
                            <h2 class="counter">82</h2>
                            {{-- <span class="badge bg-success">1.2%</span> --}}
                        </div>
                        <p>Absen Pulang</p>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between border-top mt-3 pt-3">
                    <p class="mb-0">Sudah : <span class="text-dark fw-semibold">81</span></p>
                    <span class="text-light">|</span>
                    <p>Belum : <span class="text-dark fw-semibold">01</span></p>
                </div>
            </div>
        </div>
    </div>
    {{-- End Card --}}

    <div class="row">
        {{-- Rombongan Belajar --}}
        <div class="col-xxl-4 col-xl-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header  d-flex align-items-center justify-content-between">
                    <h4 class="card-title">Rombongan Belajar</h4>
                </div>
                <div class="card-body">
                    <div class="d-md-flex align-items-center justify-content-between">
                        <div class="me-md-3 mb-3 mb-md-0 w-100">
                            <div
                                class="border border-dashed p-3 rounded d-flex align-items-center justify-content-between mb-1">
                                <p class="mb-0 me-2"><i class="ti ti-arrow-badge-down-filled me-2 text-primary"></i>X
                                    Farmasi Klinis & Komunitas</p>
                                <h5>45</h5>
                            </div>
                            <div
                                class="border border-dashed p-3 rounde d-flex align-items-center justify-content-between mb-1">
                                <p class="mb-0 me-2"><i class="ti ti-arrow-badge-down-filled me-2 text-warning"></i>X
                                    Asisten Keperawatan
                                </p>
                                <h5>11</h5>
                            </div>
                            <div
                                class="border border-dashed p-3 rounded d-flex align-items-center justify-content-between mb-0">
                                <p class="mb-0 me-2"><i class="ti ti-arrow-badge-down-filled me-2 text-danger"></i>X
                                    Seni Pertunjukan
                                </p>
                                <h5>02</h5>
                            </div>
                            <div
                                class="border border-dashed p-3 rounded d-flex align-items-center justify-content-between mb-1">
                                <p class="mb-0 me-2"><i class="ti ti-arrow-badge-down-filled me-2 text-primary"></i>XI
                                    Farmasi Klinis & Komunitas</p>
                                <h5>45</h5>
                            </div>
                            <div
                                class="border border-dashed p-3 rounde d-flex align-items-center justify-content-between mb-1">
                                <p class="mb-0 me-2"><i class="ti ti-arrow-badge-down-filled me-2 text-warning"></i>XI
                                    Asisten Keperawatan
                                </p>
                                <h5>11</h5>
                            </div>
                            <div
                                class="border border-dashed p-3 rounded d-flex align-items-center justify-content-between mb-0">
                                <p class="mb-0 me-2"><i class="ti ti-arrow-badge-down-filled me-2 text-danger"></i>XI
                                    Seni Pertunjukan
                                </p>
                                <h5>02</h5>
                            </div>
                            <div
                                class="border border-dashed p-3 rounded d-flex align-items-center justify-content-between mb-1">
                                <p class="mb-0 me-2"><i class="ti ti-arrow-badge-down-filled me-2 text-primary"></i>XII
                                    Farmasi Klinis & Komunitas</p>
                                <h5>45</h5>
                            </div>
                            <div
                                class="border border-dashed p-3 rounde d-flex align-items-center justify-content-between mb-1">
                                <p class="mb-0 me-2"><i class="ti ti-arrow-badge-down-filled me-2 text-warning"></i>XII
                                    Asisten Keperawatan
                                </p>
                                <h5>11</h5>
                            </div>
                            <div
                                class="border border-dashed p-3 rounded d-flex align-items-center justify-content-between mb-0">
                                <p class="mb-0 me-2"><i class="ti ti-arrow-badge-down-filled me-2 text-danger"></i>XII
                                    Seni Pertunjukan
                                </p>
                                <h5>02</h5>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{-- End Rombongan Belajar --}}
        {{-- Riwayat Absen --}}
        <div class="col-xxl-4 col-xl-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header  d-flex align-items-center justify-content-between">
                    <h4 class="card-title">Riwayat Absen</h4>
                    <div>
                        <i class="ti ti-calendar me-2"></i>Hari ini
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush todo-list">
                        <li class="list-group-item py-3 px-0 pt-0">
                            <div class="d-sm-flex align-items-center justify-content-between border rounded p-3">
                                <div class="d-flex align-items-center overflow-hidden me-2 ">
                                    <div class=" d-flex overflow-hidden justify-content-beetwen">
                                        <span class="avatar avatar-lg flex-shrink-0 rounded me-2">
                                            <img src="{{ asset('asset/img/pulang.png') }}" alt="student">
                                        </span>
                                        <div class="mt-1">
                                            <h6 class="mb-1 text-truncate">Arif Muhammad</h6>
                                            <p>15:00</p>
                                        </div>
                                    </div>
                                </div>
                                <span class="badge badge-soft-danger mt-2 mt-sm-0">Pulang</span>
                            </div>
                        </li>
                        <li class="list-group-item py-3 px-0 pt-0">
                            <div class="d-sm-flex align-items-center justify-content-between border rounded p-3">
                                <div class="d-flex align-items-center overflow-hidden me-2 ">
                                    <div class=" d-flex overflow-hidden justify-content-beetwen">
                                        <span class="avatar avatar-lg flex-shrink-0 rounded me-2">
                                            <img src="{{ asset('asset/img/masuk.png') }}" alt="student">
                                        </span>
                                        <div class="mt-1">
                                            <h6 class="mb-1 text-truncate">Arif Muhammad</h6>
                                            <p>07:00</p>
                                        </div>
                                    </div>
                                </div>
                                <span class="badge badge-soft-success mt-2 mt-sm-0">Masuk</span>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        {{-- End Riwayat Absen --}}
    </div>

    {{-- Agenda Sekolah --}}
    <div class="card flex-fill">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h4 class="card-title">Agenda Sekolah</h4>
        </div>
        <div class="card-body">

        </div>
    </div>
    {{-- End Agenda Sekolah --}}

</div>
@section('javascript')
<script src="{{ asset('asset/Plugins/countup/jquery.counterup.min.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
<script src="{{ asset('asset/Plugins/countup/jquery.waypoints.min.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
{{-- <script src="{{ asset('asset/Plugins/apexchart/apexcharts.min.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
<script src="{{ asset('asset/Plugins/apexchart/chart-data.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script> --}}

@endsection
@endsection
