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
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Data Induk</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Mata Pelajaran</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
        <div class="mb-2">
            <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-effect="effect-scale" data-bs-toggle="modal" data-bs-target="#add_mapel"><i class="ti ti-square-rounded-plus me-2"></i>Tambah Mata Pelajaran</a>
            </div>
    </div>
</div>
{{-- End Header --}}
<div class="card">
     <div class="card-header d-flex align-items-center justify-content-between flex-wrap pb-0">
        <h4 class="mb-3">Mata Pelajaran</h4>
        <div class="d-flex align-items-center flex-wrap">
            <div class="input-icon-start mb-3 me-2 position-relative">
                <span class="icon-addon">
                    <i class="ti ti-search"></i>
                </span>
                <input type="text" class="form-control " placeholder="Cari Mata Pelajaran.." id="myInput" onkeyup="myFunction()">
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive " >
            <table class="table table-nowrap mb-0"  id="myTable">
                <thead>
                    <tr>
                        <th class="bg-light-400">#</th>

                        <th class="bg-light-400">Nama Mata Pelajaran</th>
                        <th class="bg-light-400">Jumlah Jam</th>
                        <th class="bg-light-400">Type</th>
                        <th class="bg-light-400">Status</th>
                        <th class="bg-light-400">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no=1;
                    @endphp
                    @foreach ($mapel as $item )

                    <tr class="odd">
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->jml_jam }}</td>
                        <td>{{ $item->type }}</td>
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
                                <a data-bs-toggle="modal" data-bs-target="#edit_mapel-{{ $item->id }}" class="btn btn-icon btn-sm btn-soft-info rounded-pill"><i class="ti ti-pencil-minus"></i></a>
                                <a href="{{ route('dataIndukMapelDelete',$item->id) }}" class="btn btn-icon btn-sm btn-soft-danger rounded-pill"><i class="ti ti-trash"></i></a>
                                </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end m-2">
                {{ $mapel->links() }}
            </div>
        </div>
    </div>
    {{-- modal tambah Mapel --}}
    <div class="modal fade" id="add_mapel" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span class="ti ti-pencil-plus"></span> Tambah Mata Pelajaran</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="{{ route('dataIndukMapelAdd') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="col-md-12">

                            <div class="mb-3">
                                <label class="form-label">Nama Mata Pelajaran</label>
                                <input type="text" class="form-control" name="nama">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jumlah Jam</label>
                                <input type="number" inputmode="numeric" class="form-control" name="jml_jam" value="1">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tipe</label>
                                <select class="form-control select " name="type">
                                    <option value="">Pilih</option>
                                    <option value="Umum">Umum</option>
                                    <option value="Kejuruan">Kejuruan</option>
                                </select>
                            </div>
                           <div class="mb-3" >
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control select">
                                <option value="1">Aktif</option>
                                <option value="2">Tidak Aktif</option>
                            </select>
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
    {{-- edit Mapel --}}
    @foreach ($mapel as $item)

    <div class="modal fade" id="edit_mapel-{{ $item->id }}" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span class="ti ti-pencil"></span> Edit Mata Pelajaran</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="{{ route('dataIndukMapelUpdate') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="col-md-12">
                         <input type="text" value="{{ $item->id }}" hidden name="id">
                            <div class="mb-3">
                                <label class="form-label">Nama Mata Pelajaran</label>
                                <input type="text" class="form-control" name="nama" value="{{ $item->nama }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jumlah Jam</label>
                                <input type="number" inputmode="numeric" class="form-control" name="jml_jam" value="{{ $item->jml_jam }}">
                            </div>
                            <div class="mb-3" data-select2-id="select2-data-20-aec1">
                                <label class="form-label">Tipe</label>
                                <select class="form-control select" name="type">
                                    <option value="">Pilih</option>
                                    <option value="Umum" @if($item->type == 'Umum') Selected @endif>Umum</option>
                                    <option value="Kejuruan" @if($item->type == 'Kejuruan') Selected @endif>Kejuruan</option>
                                </select>
                            </div>
                           <div class="mb-3" >
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control select">
                                <option value="1" @if($item->status == '1') Selected @endif >Aktif</option>
                                <option value="2" @if($item->status == '2') Selected @endif>Tidak Aktif</option>
                            </select>
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
