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
       <div class="mb-2">
            <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-effect="effect-scale" data-bs-toggle="modal" data-bs-target="#add_holiday"><i class="ti ti-square-rounded-plus me-2"></i>Tambah Wali Kelas</a>
            </div>
    </div>
</div>
{{-- End Header --}}
<div class="card">
    <div class="card-header">
        <h4>Daftar {{ $title }}</h4>
    </div>
    <div class="card-body p-0 ">
        <div class="table-responsive">
            <table class="table table-nowrap mb-0">
                <thead>
                    <tr >
                        <th class="bg-light-400">#</th>
                        <th class="bg-light-400">Tahun Pelajaran</th>
                        <th class="bg-light-400">Kelas</th>
                        <th class="bg-light-400">Wali Kelas</th>
                        <th class="bg-light-400">Jumlah</th>
                        <th class="bg-light-400">Action</th>

                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($walikelas as $item)

                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->tahun_ajar->tahun_pelajaran  }} - {{ $item->tahun_ajar->semester }}</td>
                        <td>{{ $item->kelas->nama_kelas }} {{ $item->kelas->jurusanKelas->nama_jurusan }} {{  $item->kelas->sub_kelas }}</td>
                        <td>{{ $item->gtk->nik }} - {{ $item->gtk->nama }}</td>
                        <td>
                            <center>
                            <span class="badge badge-soft-success d-inline-flex align-items-center">
                                {{ $item->kelas->jmlRombel->count() }} Siswa
                            </span>
                            </center>

                        </td>
                        <td>
                            <div class="hstack gap-2 fs-15">
                                <a data-bs-toggle="modal" data-bs-target="#edit-{{ $item->id }}" class="btn  btn-soft-info rounded-pill"><i class="ti ti-pencil-minus"></i> Edit</a>

                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- modal tambah Hari Libur --}}
<div class="modal fade add_holiday" id="add_holiday" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span class="ti ti-pencil-plus"></span>Setelan Wali Kelas</h4>
                <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </button>
            </div>
            <form action="{{ route('pengaturanWalikelasAdd') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <form action="" method="post">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Tahun Pelajaran</label>
                                <select name="tahun" class="select" required>

                                    @foreach ($tahunAjar as $item)
                                        <option value="{{ $item->id }}" >{{ $item->tahun_pelajaran }} - {{ $item->semester }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kelas</label>
                                <select name="kelas" class="selectkelas" required>
                                    <option value="" selected>-- Pilih Kelas --</option>
                                    @foreach ($kelas as $item)
                                        <option value="{{ $item->id }}" >{{ $item->nama_kelas }} {{ $item->jurusanKelas->nama_jurusan }} {{ $item->sub_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Wali Kelas</label>
                                <select name="id_gtk" class="selectwalikelas" >
                                    <option value="" selected required>-- Pilih Wali Kelas --</option>
                                    @foreach ($gtk as $item )
                                    <option value="{{ $item->nik }}">{{ $item->nik }} - {{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="submit" class="btn btn-primary w-100">Tambah</button>
                </form>
                </div>
            </form>
        </div>
    </div>
</div>
@foreach ($walikelas as $item2 )
<div class="modal fade edit" id="edit-{{ $item2->id }}" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span class="ti ti-pencil"></span> Edit Wali Kelas</h4>
                <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </button>
            </div>
            <form action="{{ route('pengaturanWalikelasEdit') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <input type="text" value="{{ $item2->id }}" name="id" hidden>
                        <input type="text" value="{{ $item2->id_gtk }}" name="id_gtk_default" hidden>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Tahun Pelajaran</label>
                                <select name="tahun" class="select" required>
                                    @foreach ($tahunAjar as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $item2->id ? 'selected' : ''}} >{{ $item->tahun_pelajaran }} -  {{ $item->semester }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kelas</label>
                                <select name="kelas" class="EditKelas" required>
                                    <option value="" selected>-- Pilih Kelas --</option>
                                    @foreach ($kelas as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $item2->id_kelas ? 'selected' : ''}}  >{{ $item->nama_kelas }} {{ $item->jurusanKelas->nama_jurusan }} {{ $item->sub_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Wali Kelas</label>
                                <select name="id_gtk" class="EditWalikelas" >
                                    <option value="" selected required>-- Pilih Wali Kelas --</option>
                                    @foreach ($gtk as $item )
                                    <option value="{{ $item->nik }}" {{ $item->nik == $item2->gtk->nik ? 'selected' : ''}}>{{ $item->nik }} - {{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="submit" class="btn btn-primary w-100">Tambah</button>
             </form>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@section('javascript')
<script>
    $('.selectkelas').select2({
        dropdownParent: $('.add_holiday'),
        placeholder: "Pilih Kelas",
        allowClear: true
    });
    $('.selectwalikelas').select2({
        dropdownParent: $('.add_holiday'),
        placeholder: "Pilih Wali Kelas",
        allowClear: true
    });
    $('.EditKelas').select2({
        dropdownParent: $('.edit'),
    });
    $('.EditWalikelas').select2({
        dropdownParent: $('.edit'),
    });


</script>
@endsection
@endsection
