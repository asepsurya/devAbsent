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
                <li class="breadcrumb-item " aria-current="page">Pengaturan</li>
                <li class="breadcrumb-item active" aria-current="page">Pengaturan Wali Kelas</li>
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
            <button type="button" class="btn btn-outline-light bg-white btn-icon me-1"
                data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Print"
                data-bs-original-title="Print">
                <i class="ti ti-printer"></i>
            </button>
        </div>
       <div class="mb-2">
            <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-effect="effect-scale" data-bs-toggle="modal" data-bs-target="#add_holiday"><i class="ti ti-square-rounded-plus me-2"></i>Tambah</a>
            </div>
    </div>
</div>
{{-- End Header --}}
<div class="card">
    <div class="card-header">
        <h4>Detail Wali Kelas</h4>
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
                        <th class="bg-light-400">Jumlah Rombel</th>
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
                        <td>{{ $item->tahun_ajar->tahun_pelajaran  }}</td>
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
                                <a data-bs-toggle="modal" data-bs-target="#edit-{{ $item->id_gtk }}" class="btn btn-icon btn-sm btn-soft-info rounded-pill"><i class="ti ti-pencil-minus"></i></a>
                                <a  data-bs-effect="effect-scale" data-bs-toggle="modal" data-bs-target="#edit-{{ $item->nik }}" class="btn btn-icon btn-sm btn-soft-danger rounded-pill"><i class="ti ti-trash"></i></a>
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
<div class="modal fade" id="add_holiday" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Setelan Wali Kelas</h4>
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
                                <select name="tahun" class="select2" required>

                                    @foreach ($tahunAjar as $item)
                                        <option value="{{ $item->id }}" >{{ $item->tahun_pelajaran }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kelas</label>
                                <select name="kelas" class="select2" required>
                                    <option value="" selected>-- Pilih Kelas --</option>
                                    @foreach ($kelas as $item)
                                        <option value="{{ $item->id }}" >{{ $item->nama_kelas }} {{ $item->jurusanKelas->nama_jurusan }} {{ $item->sub_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Wali Kelas</label>
                                <select name="id_gtk" class="select2" id="walikelas">
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
<div class="modal fade" id="edit-{{ $item2->id_gtk }}" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Setelan Wali Kelas</h4>
                <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </button>
            </div>
            <form action="{{ route('pengaturanWalikelasAdd') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Tahun Pelajaran</label>
                                <select name="tahun" class="select2" required>

                                    @foreach ($tahunAjar as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $item2->id ? 'selected' : ''}} >{{ $item->tahun_pelajaran }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kelas</label>
                                <select name="kelas" class="select2" required>
                                    <option value="" selected>-- Pilih Kelas --</option>
                                    @foreach ($kelas as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $item2->id_kelas ? 'selected' : ''}}  >{{ $item->nama_kelas }} {{ $item->jurusanKelas->nama_jurusan }} {{ $item->sub_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Wali Kelas</label>
                                <select name="id_gtk" class="select2" id="walikelas">
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
    $('.select2').select2({
        dropdownParent: $('#add_holiday')
    });
</script>
@endsection
@endsection
