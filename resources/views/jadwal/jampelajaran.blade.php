@extends('layout.main')
@section('css')
<style>

    .dropdown-menu {
        z-index: 1050; /* Atur z-index sesuai kebutuhan */
    }
</style>
@endsection
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

        <div class="pe-1 mb-2">
            <button type="button" class="btn btn-outline-light bg-white  me-1" onclick="history.back()">
                <i class="ti ti-arrow-left"></i> Kembali
            </button>
            <button type="button" data-bs-toggle="modal" href="#ref" class="btn btn-primary">
                <i class="ti ti-plus"></i> Tambah Referensi
            </button>
        </div>

    </div>
</div>
{{-- End Header --}}
<div class="card">
    <div class="card-header">
        <h3>Tabel Referensi</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="table1">
            <thead class="thead-light">
                <tr>
                    <th class="border">#</th>
                    <th class="border" width="3%">ID</th>
                    <th class="border">Nama Referensi</th>
                    <th class="border">Estimasi Waktu</th>
                    <th class="border">Status</th>
                    <th class="border">Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no=1;
                @endphp
                @foreach ($data as $i )
                <tr>
                    <td class="border">{{ $no++ }}</td>
                    <td class="border text-primary">{{ $i->ref_ID }}</td>
                    <td class="border">{{ $i->ref }}</td>
                    <td class="border">{{ $i->waktu }} Menit</td>
                    <td class="border">
                        @if($i->status == 1)
                        <span class="badge badge-soft-success d-inline-flex align-items-center">
                            Aktif </span>
                        @else
                        <span class="badge badge-soft-danger d-inline-flex align-items-center">
                            Tidak Aktif </span>
                        @endif


                    </td>
                    <td class="border">

                            <a class="btn btn-icon btn-sm btn-soft-primary rounded-pill" data-bs-toggle="modal" href="#edit-ref-{{ $i->ref_ID }}" role="button"><i class="ti ti-list-details"></i></a>
                            <a class="btn btn-icon btn-sm btn-soft-danger rounded-pill"  href="{{ route('referenceDelete',$i->ref_ID) }}" role="button"><i class="ti ti-trash-x"></i></a>


                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>

</div>


<div class="card">
      <div class="table-responsive">
        <form action="{{ route('setelan.schoolTime') }}" method="POST">
            @csrf
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="border">No</th>
                    <th class="border">Name</th>
                    <th class="border">Default Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border">1</td>
                    <td class="border">Setelan Jam Masuk Sekolah</td>
                    <td><input type="time" class="form-control" name="start_school" value="{{ app('settings')['start_school'] }}"></td>
                </tr>
                <tr >
                    <td class="border">2</td>
                    <td class="border">Estimasi Waktu Jam Mata Pelajaran</td>
                    <td>
                        <div class="row">
                            <div class="col-sm-5">
                                <input type="number" class="form-control" name="waktu_mapel" value="{{ app('settings')['waktu_mapel'] }}" >
                            </div>
                            <div class="col-sm-5 mt-2">Menit</div>
                        </div>

                    </td>
                </tr>
            </tbody>
        </table>
        <div class="m-2 d-flex justify-content-end">
            <button class="btn btn-primary"><span class="ti ti-settings"></span> Simpan Setelan</button>
        </div>
        </form>
      </div>
</div>


<div class="modal fade " id="ref" aria-labelledby="exampleModalToggleLabel" tabindex="-1" aria-modal="true"
    role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-body m-0 p-0">
                <form action="{{ route('reference') }}" method="post">
                    @csrf
                    <div class="bg-light">
                        <div class="mb-3 m-3">
                            <label class="form-label">Nama Refrensi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="ref" required placeholder="Example: Ishoma,Upacara Bendera">
                        </div>
                        <div class="m-3">
                            <label class="form-label">Waktu ajar <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-sm-4"><input type="number" class="form-control" name="waktu" required placeholder=""></div>
                                <div class="col-sm-4 mt-2"> Menit</div>
                            </div>

                            <button class="btn btn-primary mt-2 w-100"><span class="ti ti-device-floppy"></span> Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button data-bs-toggle="modal" href="#add_holiday" class="btn btn-outline-light me-1"> <span
                        class="ti ti-x"></span>Close
                </button>
            </div>
        </div>
    </div>
</div>

@foreach ($data as $a )
{{-- Edit referensi --}}
<div class="modal fade " id="edit-ref-{{ $a->ref_ID }}" aria-labelledby="exampleModalToggleLabel" tabindex="-1" aria-modal="true"
    role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-body m-0 p-0">
                <form action="{{ route('referenceEdit') }}" method="post">
                    @csrf
                    <div class="bg-light">

                        <div class="m-3">
                            <label class="form-label">Nama Refrensi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="ref_ID" required placeholder="Ex:Ishoma,Upacara" value="{{ $a->ref_ID }}" hidden>
                            <input type="text" class="form-control" name="ref" required placeholder="Ex:Ishoma,Upacara" value="{{ $a->ref }}">

                        </div>
                        <div class="m-3">
                            <label class="form-label">Waktu ajar <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-sm-4"><input type="number" class="form-control" name="waktu" required  value="{{ $a->waktu }}"></div>
                                <div class="col-sm-4 mt-2"> Menit</div>
                            </div>
                            <button class="btn btn-primary mt-4 w-100">Simpan</button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
@endforeach

@section('javascript')

@endsection
@endsection
