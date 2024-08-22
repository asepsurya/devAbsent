@extends('layout.main')
@section('container')

{{-- header --}}
<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1"><span class="ti ti-user"></span> {{ $title }}</h3>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Beranda</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Data Induk</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Peserta Didik</li>
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
        <div class="pe-1 mb-2">
            <button type="button" class="btn btn-outline-light bg-white btn-icon me-1" data-bs-toggle="tooltip"
                data-bs-placement="top" aria-label="Import data" data-bs-original-title="Impor Data">
                <i class="ti ti-file-spreadsheet"></i>
            </button>
        </div>
        <div class="mb-2">
            <a href="{{ route('dataIndukStudentAddIndex') }}" class="btn btn-primary d-flex align-items-center" ><i
                    class="ti ti-square-rounded-plus me-2"></i> Peserta Didik</a>
        </div>
    </div>
</div>
{{-- End Header --}}

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap pb-0">
        <h4 class="mb-3"><span class="ti ti-user"></span> Daftar Peserta Didik</h4>
        <div class="d-flex align-items-center flex-wrap">
            <div class="input-icon-start mb-3 me-2 position-relative">
                <span class="icon-addon">
                    <i class="ti ti-users"></i>
                </span>
                <input type="text" class="form-control " placeholder="Cari Peserta Didik.." id="myInput"
                    onkeyup="myFunction()">
            </div>
        </div>
    </div>
    <div class="card-body p-0 ">

        <div class="table-responsive ">
            <table class="table table-nowrap mb-0" id="myTable">
                <thead>
                    <tr>
                        <th class="bg-light-400">#</th>
                        <th class="bg-light-400"></th>
                        <th class="bg-light-400">NIS</th>
                        <th class="bg-light-400">Nama Peserta Didik</th>
                        <th class="bg-light-400">Jenis Kelamin</th>
                        <th class="bg-light-400">Tempat Lahir</th>
                        <th class="bg-light-400">Tanggal Lahir</th>
                        <th class="bg-light-400">Rombongan Belajar</th>

                        <th class="bg-light-400">Status</th>
                        <th class="bg-light-400">Tanggal Masuk</th>

                    </tr>
                </thead>
                <tbody>
                    @php $no=1 @endphp
                    @foreach ($students as $item )
                    <tr class="odd">
                        <td>{{ $no++ }}.</td>
                        <td>
                            <div class="hstack gap-2 fs-15">
                                <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit" href="{{ route('studentEditIndex',encrypt($item->id)) }}"  class="btn btn-icon btn-sm btn-soft-info rounded-pill"><i
                                        class="ti ti-pencil-minus"></i></a>
                                <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hapus"  href="javascript:void(0);"
                                    class="btn btn-icon btn-sm btn-soft-danger rounded-pill"><i
                                        class="ti ti-trash"></i></a>
                            </div>
                        </td>
                        <td><a href="student-details.html" class="link-primary">{{ $item->nis }}</a></td>
                        <td>
                            {{ $item->nama }}
                        </td>
                        <td>
                            @if ($item->gender == 1)
                            Laki - Laki
                            @else
                            Perempuan
                            @endif
                        </td>
                        <td>{{ $item->tempat_lahir }}</td>
                        <td>{{date('d F Y', strtotime($item->tanggal_lahir)) }}</td>
                        <td>Farmasi Klinis & Komunitas</td>
                        <td>
                            @if ($item->status == 1)
                            <span class="badge badge-soft-success d-inline-flex align-items-center"><i
                                    class="ti ti-circle-filled fs-5 me-1"></i>Aktif</span>
                            @else
                            <span class="badge badge-soft-danger d-inline-flex align-items-center"><i
                                    class="ti ti-circle-filled fs-5 me-1"></i>Tidak Aktif</span>
                            @endif

                        </td>
                        <td>
                            @if($item->tanggal_masuk)
                            {{ date('d F Y', strtotime($item->tanggal_masuk)) }}
                            @else
                            Belum disetel
                            @endif
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        <div class="d-flex justify-content-end m-3"> {{ $students->links() }}</div>
    </div>
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
        td = tr[i].getElementsByTagName("td")[3];
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
<script>
    function detailssubmit() {
        alert("Your details were Submitted");
    }
    function onlyNumberKey(evt) {

        // Only ASCII character in that range allowed
        let ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }
</script>
@endsection
@endsection
