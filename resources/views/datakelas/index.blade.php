@extends('layout.main')
@section('container')
{{-- header --}}
<div class="d-md-flex d-block align-items-center justify-content-between mb-3 ">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1">{{ $title }}</h3>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Beranda</a>
                </li>

                <li class="breadcrumb-item active" aria-current="page">Kelas</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">

    </div>
</div>
{{-- End Header --}}
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap pb-0">
        <h4 class="mb-3">Daftar Kelas</h4>
        <div class="d-flex align-items-center flex-wrap">
            <div class="input-icon-start mb-3 me-2 position-relative">
                <span class="icon-addon">
                    <i class="ti ti-door"></i>
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
                        <th class="bg-light-400">Jumlah Siswa</th>

                    </tr>
                </thead>
                <tbody>
                    @php
                        $no=1;
                    @endphp
                    @foreach ($kelas as $item)

                    <tr class="odd">
                        <td>{{ $no++ }}</td>

                        <td><a href="{{ route('kelaslistdetail') }}" >{{ $item->nama_kelas }} - {{ $item->jurusanKelas->nama_jurusan }} {{ $item->sub_kelas }}</a></td>
                        <td>{{ $item->kapasitas }}</td>

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
                    <h4 class="modal-title">Tambah Kelas</h4>
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
                                    <label class="form-label">Nama Kelas</label>
                                    <input type="text" class="form-control" name="nama" required  >
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jurusan</label>
                                    <select name="id_jurusan" id="id_jurusan" class="form-control select2 " required>
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
                                    <label class="form-label">Kapasitas</label>
                                    <input type="text" class="form-control" name="kapasitas" required  >
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" id="status" class="form-control" required>
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

    <div class="modal fade" id="edit_kelas-{{ $item->id }}" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Kelas</h4>
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
                                    <select name="id_jurusan" id="id_jurusan" class="form-control select2 " required>

                                        @foreach ($jurusans as $item2)
                                            <option value="{{ $item2->id }}" @if($item->id_jurusan == $item2->id) selected @endif>{{ $item2->nama_jurusan }}</option>
                                        @endforeach
                                    </select>
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
                                    <select name="status" id="status" class="form-control" required>
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
    function myFunction() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
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
