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
            <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-effect="effect-scale" data-bs-toggle="modal" data-bs-target="#add_jurusan"><i class="ti ti-square-rounded-plus me-2"></i>Tambah Jurusan</a>
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
                <input type="text" class="form-control " placeholder="Cari Jurusan.." id="myInput" onkeyup="myFunction()">
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive " >
            <table class="table table-nowrap mb-0" id="myTable">
                <thead>
                    <tr>
                        <th class="bg-light-400">#</th>

                        <th class="bg-light-400">Nama Jurusan</th>
                        <th class="bg-light-400">Kurikulum</th>
                        <th class="bg-light-400">Status</th>
                        <th class="bg-light-400">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no=1;
                    @endphp
                    @foreach ($jurusans as $item )

                    <tr class="odd">
                        <td>{{ $no++ }}</td>

                        <td>{{ $item->nama_jurusan }}</td>
                        <td>{{ $item->kurikulum }}</td>
                        <td>
                            @if($item->status == 1)
                            <span class="badge badge-soft-success d-inline-flex align-items-center"><i
                                class="ti ti-circle-filled fs-5 me-1"></i>Active</span>
                            @else
                            <span class="badge badge-soft-danger d-inline-flex align-items-center"><i
                                class="ti ti-circle-filled fs-5 me-1"></i>Tidak Aktif</span>
                            @endif
                        </td>
                        <td >
                            <div class="hstack gap-2 fs-15">
                                <a  data-bs-toggle="modal" data-bs-target="#edit_jurusan-{{ $item->id }}" class="btn btn-icon btn-sm btn-soft-info rounded-pill"><i class="ti ti-pencil-minus"></i></a>
                                <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hapus" href="{{ route('dataIndukJurusanDelete',$item->id) }}" class="btn btn-icon btn-sm btn-soft-danger rounded-pill"><i class="ti ti-trash"></i></a>
                                </div>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
{{-- edit --}}
@foreach ($jurusans as $item)
    <div class="modal fade" id="edit_jurusan-{{ $item->id }}" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span class="ti ti-pencil"></span> Edit Jurusan</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                    <div class="modal-body">
                        <div class="row">
                            <form action="{{ route('dataIndukJurusanUpdate') }}" method="post">
                                @csrf
                                <input type="text" hidden class="form-control" name="id"  value="{{ $item->id }}">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Nama Jurusan</label>
                                    <input type="text" class="form-control" name="nama" required placeholder="Nama Jurusan" value="{{ $item->nama_jurusan }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kurikulum</label>
                                    <input type="text" class="form-control" name="nama" required placeholder="Nama Jurusan" value="{{ $item->kurikulum }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status"  class="form-control select">
                                        <option value="1" @if($item->status== 1) selected  @endif>Aktif</option>
                                        <option value="2"  @if($item->status== 2) selected @endif>Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</a>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </form>
                    </div>

            </div>
        </div>
    </div>

@endforeach
    {{-- modal tambah Jurusan --}}
    <div class="modal fade" id="add_jurusan" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span class="ti ti-pencil-plus"></span> Tambah Jurusan</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>

                    <div class="modal-body">
                        <div class="row">
                            <form action="{{ route('dataIndukJurusanAdd') }}" method="post">
                                @csrf
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Nama Jurusan</label>
                                    <input type="text" class="form-control" name="nama" required placeholder="Nama Jurusan">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kurikulum</label>
                                    <input type="text" class="form-control" name="kurikulum" required placeholder="Kurikulum">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status"  class="form-control select">
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
                    </form>
                    </div>

            </div>
        </div>
    </div>
</div>
@section('javascript')
<script>$(".select2").select2({ dropdownParent: "#add_jurusan" });</script>
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
