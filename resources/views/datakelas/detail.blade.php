@extends('layout.main')
@section('container')
{{-- header --}}
<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1">{{ $title }}</h3>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Beranda</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
    </div>
</div>

<ul class="nav nav-tabs tab-style-1 d-sm-flex d-block" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#orders" aria-current="page" href="#orders"
            aria-selected="false" role="tab" tabindex="-1"><span class="ti ti-users"></span> Data Siswa</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link " data-bs-toggle="tab" data-bs-target="#accepted" href="#accepted" aria-selected="true"
            role="tab"><span class="ti ti-list"></span> Absensi </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" data-bs-toggle="tab" data-bs-target="#declined" href="#declined" aria-selected="false"
            role="tab" tabindex="-1">Declined</a>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane active show" id="orders" role="tabpanel">
        <div class="table-responsive">
            <table class="table table-nowrap mb-0">
                <thead>
                    <tr>
                        <th class="bg-light-400">#</th>
                        <th class="bg-light-400">NIS</th>
                        <th class="bg-light-400">Nama Lengkap</th>
                        <th class="bg-light-400">Jenis Kelamin</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><a href="#">1</a></td>
                        <td><a href="#" class="link-primary">H752762</a></td>
                        <td>
                            Hari meperingati ulang tahun Asep
                        </td>
                        <td>01 Jan 2024</td>

                    </tr>

                </tbody>
            </table>
        </div>
    </div>
    <div class="tab-pane " id="accepted" role="tabpanel">
        <div class="col-xxl-5 col-xl-12 d-flex">
            <div class="bg-white position-relative flex-fill border p-3 mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center row-gap-3">
                        <div class="avatar avatar-xxl rounded flex-shrink-0 me-3">
                            <img src="{{ asset('asset/img/kelas.png') }}" alt="Img">
                        </div>
                        <div class="d-block">
                            <span class="badge bg-transparent-primary text-primary mb-1">#P124556</span>
                            <h4 class="text-truncate  mb-1">Thomas Bown</h4>
                            <div class="d-flex align-items-center flex-wrap row-gap-2 ">
                                <span>Added On : 25 Mar 2024</span>
                                <span>Child : Janet</span>
                            </div>
                        </div>
                    </div>
                    <div class="student-card-bg">
                        <img src="assets/img/bg/circle-shape.png" alt="Bg">
                        <img src="assets/img/bg/shape-02.png" alt="Bg">
                        <img src="assets/img/bg/shape-04.png" alt="Bg">
                        <img src="assets/img/bg/blue-polygon.png" alt="Bg">
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
      <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded mb-3 " role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" data-bs-toggle="tab" role="tab" href="#home1" aria-selected="false" tabindex="-1">Hari Ini</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link " data-bs-toggle="tab" role="tab" href="#about1" aria-selected="true">Minggu ini</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" data-bs-toggle="tab" role="tab" href="#service1" aria-selected="false"
                    tabindex="-1">Bulan ini</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" data-bs-toggle="tab" role="tab" href="#license1" aria-selected="false"
                    tabindex="-1">License</a>
            </li>
        </ul>
    </div>
        <div class="border rounded p-3 bg-white">
            <div class="row">
                <div class="col text-center border-end">
                    <p class="mb-1">Jumlah Siswa Hadir</p>
                    <h5 class="text-success">25</h5>
                </div>
                <div class="col text-center border-end">
                    <p class="mb-1">Jumlah Siswa Izin</p>
                    <h5 class="text-warning">2</h5>
                </div>
                <div class="col text-center border-end">
                    <p class="mb-1">Jumlah Siswa Alfa</p>
                    <h5 class="text-danger">0</h5>
                </div>
                <div class="col text-center">
                    <p class="mb-1">Jumlah Siwa Sakit</p>
                    <h5 class="text-info">1</h5>
                </div>
            </div>
        </div>

      <div class="tab-content mt-3">
            <div class="tab-pane  active show" id="home1" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th class="bg-light-400">#</th>
                                <th class="bg-light-400">NIS</th>
                                <th class="bg-light-400">Nama Lengkap</th>
                                <th class="bg-light-400">Jenis Kelamin</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="#">1</a></td>
                                <td><a href="#" class="link-primary">H752762</a></td>
                                <td>
                                    Hari meperingati ulang tahun Asep
                                </td>
                                <td>01 Jan 2024</td>

                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane text-muted " id="about1" role="tabpanel">
                Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots
                in a piece of classical Latin literature from 45 BC, <b>Making it over 2000
                    years old</b>. Richard McClintock, a Latin professor at Hampden-Sydney
                College in Virginia, looked up one of the more obscure Latin words, consectetur.
            </div>
            <div class="tab-pane text-muted" id="service1" role="tabpanel">
                There are many variations of passages of <b>Lorem Ipsum available</b>, but the
                majority have suffered alteration in some form, by injected humour, or
                randomised words which don't look even slightly believable. If you are going to
                use a passage of Lorem Ipsum, you need to be sure there isn't anything.
            </div>
            <div class="tab-pane text-muted" id="license1" role="tabpanel">
                It is a long established fact that a reader will be distracted by the
                <b><i>Readable content</i></b> of a page when looking at its layout. The point
                of using Lorem Ipsum is that it has a more-or-less normal distribution of
                letters, as opposed to using 'Content here, content here', making it look like
                readable English.
            </div>
        </div>
    </div>
    <div class="tab-pane" id="declined" role="tabpanel">
        <div class="text-muted">There are many variations of passages of Lorem
            Ipsum available, but the majority have suffered alteration in some form,
            <b>by injected humour</b>, or randomised words which don't look even
            slightly believable
        </div>
    </div>
</div>
@endsection
