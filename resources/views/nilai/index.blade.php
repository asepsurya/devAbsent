@extends('layout.main')
@section('container')

<div class="card p-4  border-0 mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <h5 class="mb-0 mt-1" style="background: linear-gradient(45deg, #1e3c72, #2a5298); -webkit-background-clip: text; color: transparent;">Penilaian Siswa</h5>
        <div class="d-flex gap-3 w-100">
            <select name="kelas" id="kelas" class="form-select">
                <option value="1">Kelas 1</option>
                <option value="2">Kelas 2</option>
                <option value="3">Kelas 3</option>
            </select>

            <select name="semester" id="semester" class="form-select">
                <option value="1">Semester 1</option>
                <option value="2">Semester 2</option>
            </select>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-light d-flex align-items-center">
        <i class="ti ti-calendar me-2 text-primary "></i>
        <h6 class="mb-0">Filter Periode</h6>
    </div>
    <div class="card-body">
<!-- Nav Tabs -->
<ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">
            <i class="ti ti-school me-1"></i> Nilai
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
            <i class="ti ti-list me-1"></i> List
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">
            <i class="ti ti-file-description me-1"></i> Laporan
        </button>
    </li>
</ul>

<!-- Tab Content -->
<div class="tab-content  border rounded shadow-sm">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="card-header  d-flex align-items-center">
             
                <h6 class="mb-0">Data Siswa</h6>
                <div class="d-flex align-items-center flex-wrap ms-auto">
                    <!-- Show filter -->
                    <div class="mb-3 me-2">Show:</div>
                    <div class="mb-3 me-2">
                        <select id="pageLength" class="form-control" aria-label="Rows per page">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <!-- Search input -->
                    <div class="input-icon-start mb-3 me-2 position-relative">
                        <span class="icon-addon">
                            <i class="ti ti-search"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Cari Nama ..." id="customSearch">
                    </div>
                    <!-- Export PDF Button -->
                    <a href="/report/absent/kelas?month=05&year=2025&tahunajar=&kelas=&mapel=" class="btn btn-outline-light bg-white mb-3 px-4 py-2 fw-bold shadow-sm" target="_blank">
                        <span class="ti ti-file-type-pdf"></span> Export PDF
                    </a>
                </div>
            </div>
        
            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>John Doe</td>
                            <td>85</td>
                        </tr>
                        <tr>
                            <td>Jane Smith</td>
                            <td>92</td>
                        </tr>
                        <tr>
                            <td>Michael Johnson</td>
                            <td>78</td>
                        </tr>
                        <tr>
                            <td>Emily Davis</td>
                            <td>88</td>
                        </tr>
                        <!-- Tambahkan baris lainnya sesuai kebutuhan -->
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
    {{-- <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <h5 class="mb-3">List</h5>
        <p>Daftar nilai siswa akan ditampilkan di sini...</p>
    </div>
    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
        <h5 class="mb-3">Laporan</h5>
        <p>Laporan penilaian siswa akan ditampilkan di sini...</p>
    </div> --}}
</div>
    </div>
    
</div>


@endsection