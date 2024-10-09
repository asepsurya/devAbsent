@extends('layout.main')
@section('container')
{{-- header --}}
<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1">Data {{ $title }}</h3>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Beranda</a>
                </li>
                <li class="breadcrumb-item " aria-current="page">Akademik</li>
                <li class="breadcrumb-item " aria-current="page">Data Induk</li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">

        <div class="mb-2">
            <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-effect="effect-scale" data-bs-toggle="modal" data-bs-target="#add_kelas"><i class="ti ti-square-rounded-plus me-2"></i>Tambah Kelas</a>
            </div>
    </div>
</div>
{{-- End Header --}}
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap pb-0">
        <h4 class="mb-3">Daftar {{ $title }}</h4>
        <div class="d-flex align-items-center flex-wrap">
            <div class="input-icon-start mb-3 me-2 position-relative">
                <span class="icon-addon">
                    <i class="ti ti-search"></i>
                </span>
                <input type="text" class="form-control " placeholder="Cari Kelas.." id="myInput" onkeyup="myFunction()">
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive " >
            <table class="table table-nowrap mb-0" id="myTable" >
                <thead>
                    <tr>
                        <th class="bg-light-400">#</th>

                        <th class="bg-light-400">Nama Kelas</th>
                        <th class="bg-light-400">Kapasitas</th>
                        <th class="bg-light-400">Status</th>
                        <th class="bg-light-400">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no=1;
                    @endphp
                    @foreach ($kelas as $item)

                    <tr class="odd">
                        <td>{{ $no++ }}</td>

                        <td>{{ $item->nama_kelas }} - {{ $item->jurusanKelas->nama_jurusan }} {{ $item->sub_kelas }}</td>
                        <td>{{ $item->kapasitas }}</td>
                        <td>
                            @if ($item->status == 1)
                            <span class="badge badge-soft-success d-inline-flex align-items-center"><i
                                class="ti ti-circle-filled fs-5 me-1"></i>Aktif</span>
                            @else
                            <span class="badge badge-soft-danger d-inline-flex align-items-center"><i
                                class="ti ti-circle-filled fs-5 me-1"></i>Tidak Aktif</span>
                            @endif

                        </td>
                        <td >
                            <div class="hstack gap-2 fs-15">
                                <a data-bs-toggle="modal" data-bs-target="#edit_kelas-{{ $item->id }}" class="btn btn-icon btn-sm btn-soft-info rounded-pill"><i class="ti ti-pencil-minus"></i></a>
                                <a href="{{ route('dataIndukkelasDelete',$item->id) }}" class="btn btn-icon btn-sm btn-soft-danger rounded-pill"><i class="ti ti-trash"></i></a>
                                </div>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    {{-- modal tambah Jurusan --}}
    <div class="modal fade" id="add_kelas" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span class="ti ti-pencil-plus"></span> Tambah Kelas</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="{{ route('dataIndukkelasAdd') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nama" required  >
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jurusan <span class="text-danger">*</span></label>
                                    <select name="id_jurusan" class="form-control jurusan " required>
                                        <option value="">- Pilih Jurusan -</option>
                                        @foreach ($jurusans as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_jurusan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Sub Kelas</label>
                                    <input type="text" class="form-control" name="sub_kelas" >
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kapasitas <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="kapasitas" required  >
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control select" required>
                                        <option value="1">Aktif</option>
                                        <option value="2">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</a>
                        <button type="submit" class="btn btn-primary">Tambah</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- modal tambah edit --}}
    @foreach ($kelas as $item )

    <div class="modal fade" id="edit_kelas-{{ $item->id }}"  aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span class="ti ti-pencil"></span> Edit Kelas</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="{{ route('dataIndukkelasEdit') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="id" value="{{ $item->id }}"  hidden>
                                <div class="mb-3">
                                    <label class="form-label">Nama Kelas</label>
                                    <input type="text" class="form-control" name="nama" required value="{{ $item->nama_kelas }}" >
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jurusan</label>
                                    <select name="id_jurusan2"  class="form-control select2 " required disabled>
                                        @foreach ($jurusans as $item2)
                                            <option value="{{ $item2->id }}" @if($item->id_jurusan == $item2->id) selected @endif>{{ $item2->nama_jurusan }}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" value="{{ $item->id_jurusan }}" name="id_jurusan" hidden>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Sub Kelas</label>
                                    <input type="text" class="form-control" name="sub_kelas" value="{{ $item->sub_kelas }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kapasitas</label>
                                    <input type="text" class="form-control" name="kapasitas" required  value="{{ $item->kapasitas }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" id="status2" class="form-control select" required>
                                        <option value="1"@if($item->status == 1) Selected @endif> Aktif</option>
                                        <option value="2"@if($item->status == 2) Selected @endif>Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</a>
                        <button type="submit" class="btn btn-primary">Ubah</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    @endforeach
</div>
@section('javascript')
<script>
$(".jurusan").select2({
    dropdownParent: "#add_kelas",
    placeholder: "Pilih Jurusan",
    allowClear: true
});
</script>

<script>
    function myFunction() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[2];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
    </script>
@endsection
@endsection
