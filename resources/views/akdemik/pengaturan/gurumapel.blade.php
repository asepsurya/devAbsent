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
                <li class="breadcrumb-item " aria-current="page">Akademik</li>
                <li class="breadcrumb-item " aria-current="page">Pengaturan</li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
        <div class="pe-1 mb-2">
            <a href="#" class="btn btn-outline-light bg-white btn-icon me-1" data-bs-toggle="tooltip"
                data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh">
                <i class="ti ti-refresh"></i>
            </a>
        </div>
        <div class="pe-1 mb-2">
            <button type="button" class="btn btn-outline-light bg-white btn-icon me-1" data-bs-toggle="tooltip"
                data-bs-placement="top" aria-label="Print" data-bs-original-title="Print">
                <i class="ti ti-printer"></i>
            </button>
        </div>

    </div>
</div>
{{-- End Header --}}
<div class="alert alert-primary overflow-hidden p-0" role="alert">
    <div class="p-3 bg-primary text-fixed-white d-flex justify-content-between">
        <h3 class="aletr-heading mb-0 text-fixed-white"><span class="ti ti-info-circle"></span> Petunjuk Singkat</h3>
        <button type="button" class="btn-close p-0 text-fixed-white" data-bs-dismiss="alert" aria-label="Close"><i
                class="fas fa-xmark"></i></button>
    </div>
    <div class="p-3">
            <p class="my-1">1. Pilih Tahun Pelajaran, Semester, dan Kelas yang akan diatur Guru Mata Pelajarannya.</p>
            <p class="my-1">2. Klik tombol "<strong>CARI DATA</strong>" untuk menampilkan data.</p>
            <p class="my-1">3. Setelah data muncul, pada kolom "<strong>GURU PENGAJAR</strong>", pilih Guru Pengajar yang sesuai dengan Mata Pelajaran di kolom "<strong>MATA PELAJARAN</strong>".</p>
            <p class="my-1">4. Data akan otomatis terpilih berdasarkan pilihan Anda.</p>

    </div>
</div>

<div class="card overflow-hidden p-0" role="alert">
    <div class="card-header p-3  d-flex justify-content-between">
        <h4 class="mb-0 "><span class="ti ti-search"></span> Form Pencarian</h4>

    </div>
    <div class="p-3 alert alert-primary overflow-hidden mb-0">
        <div class="row mb-3 ">
            <label class="col-lg-3 form-label mt-1">Tahun Pelajaran</label>
            <div class="col-lg-9">
                <select name="tahunAjar" id="tahunAjar" class="tahunAjar" onchange="copyTextValue()">
                    <option value="" selected>-- Pilih Tahun Pelajaran --</option>
                    @foreach ($tahunAjar as $item )
                    <option value="{{ $item->id }}" {{ $item->id == request('tahun') ? 'selected' : '' }}>{{
                        $item->tahun_pelajaran }} - {{ $item->semester }}
                    </option>
                    @php $a = request('tahun') @endphp
                    @endforeach
                </select>
            </div>
        </div>
        {{-- <div class="row my-2">
            <label class="col-lg-3 form-label mt-2">Semester</label>
            <div class="col-lg-9">
                <select name="semester" id="semester" class=" select2" onchange="semesterValue()">
                    <option value="" selected>-- Pilih Semester --</option>
                    <option value="Ganjil" {{ request('semester')=="Ganjil" ? 'selected' :'' }}>Ganjil</option>
                    <option value="Genap" {{ request('semester')=="Genap" ? 'selected' :'' }}>Genap</option>
                </select>
            </div>
        </div> --}}
        <div class="row mb-2">
            <label class="col-lg-3 form-label mt-2">Kelas</label>
            <div class="col-lg-9">
                <select name="kelas" id="kelas" class="Kelas" onchange="kelasValue()">
                    <option value="" selected>-- Pilih Kelas --</option>
                    @foreach ($kelas as $item )
                    <option value="{{ $item->id }}" {{ $item->id == request('kelas') ? 'selected' : '' }}>{{
                        $item->nama_kelas }} - {{
                        $item->jurusanKelas->nama_jurusan }} {{ $item->sub_kelas }}</option>
                    {{-- get Default Value --}}
                    @php $c = request('kelas') @endphp
                    @endforeach
                </select>
            </div>
        </div>

        <form action="{{ route('subject_teachers') }}" method="get" data-bs-display="static">
            @csrf
            {{-- Input Box untuk mengambil Data Default --}}
            <input type="text" name="tahun" id="id_tahun_pelajaranVal" value="{{ $a }}" hidden>
            <input type="text" name="semester" id="semesterVal" value="Ganjil" hidden>
            <input type="text" name="kelas" id="kelasVal" value="{{ $c }}" hidden>

            <div class="row my-2">
                <label class="col-lg-3 form-label mt-2"></label>
                <div class="col-lg-9">
                    <div class="btn-group mt-3">
                        <button class="btn btn-primary w-100" type="submit"><span
                                class="ti ti-search"></span> Cari
                            Data</button>
        </form>
    </div>
</div>
</div>
</div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-nowrap my-0">
            <thead>
                <tr>
                    <th class="bg-light-400" width="10%">#</th>
                    <th class="bg-light-400" width="20%">Mata Pelajaran</th>
                    <th class="bg-light-400">Guru Pengajar</th>
                </tr>
            </thead>

            <tbody>
                @php $no=1; @endphp
                @foreach ($grupMapel as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->mata_pelajaran->nama }}</td>
                    <td>
                        <form action="{{ route('subject_teachersUpdate') }}" method="post" id="myform">
                            @csrf
                            <input type="text" name="id" value="{{ $item->id }}" class="tahun" hidden>
                            <select name="id_gtk" class="select2 form-control gtk" onchange="this.form.submit()">
                                @if ($item->id_gtk == '')
                                <option value="" selected>-- Belum disetel --</option>
                                @endif
                                @foreach ($gtk as $item2)
                                <option value="{{ $item2->nik }}" {{ $item2->nik == $item->id_gtk ? 'selected' : ''
                                    }}>{{ $item2->nik }} - {{ $item2->nama }} </option>
                                @endforeach
                            </select>

                        </form>
                    </td>
                </tr>

                @endforeach
            </tbody>

        </table>
    </div>
</div>

@section('javascript')
<script>
 $('.tahunAjar').select2({
    placeholder: "Pilih Tahun Pelajaran",
    allowClear: true
    });
 $('.Kelas').select2({
    placeholder: "Pilih Kelas",
    allowClear: true
    });
 $('.gtk').select2({
    placeholder: "Belum disetel",
    allowClear: true
    });


</script>
<script>
    function copyTextValue() {
        var e = document.getElementById("tahunAjar");
        var val = e.options[e.selectedIndex].value;
        document.getElementById("id_tahun_pelajaranVal").value = val;

    }
    function semesterValue() {
        var e = document.getElementById("semester");
        var val = e.options[e.selectedIndex].value;
        document.getElementById("semesterVal").value = val;
    }
    function kelasValue() {
        var e = document.getElementById("kelas");
        var val = e.options[e.selectedIndex].value;
        document.getElementById("kelasVal").value = val;

    }
</script>
@endsection
@endsection
