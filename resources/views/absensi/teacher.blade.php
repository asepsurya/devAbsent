@extends('layout.main')
@section('container')
@section('css')
<style>
    .btn-check:checked+.btn, .btn.active, .btn.show, .btn.show:hover, .btn:first-child:active, :not(.btn-check)+.btn:active{
        background-color: #ebebeb;
    }
</style>
@endsection
{{-- header --}}
<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1">{{ $title }}</h3>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Absensi RFID</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">

        <h4><span class="ti ti-calendar-due"></span> {{ Carbon\Carbon::parse(now())->translatedFormat('l, d F Y') }} | <span id="jam" class="text-muted"></span> </h4>
    </div>
</div>
{{-- End Header --}}
<div class="bg-white p-3 border rounded-1 d-flex align-items-center justify-content-between flex-wrap mb-4 pb-0">
    <h4 class="mb-3">Form {{ $title }}</h4>
    <div class="d-flex align-items-center flex-wrap">

        <div class="d-flex align-items-center bg-white  p-1 mb-3 me-2">

            <div class="input-icon-start me-2 position-relative">
                <span class="icon-addon">
                    <i class="ti ti-search"></i>
                </span>
                <input type="text" class="form-control " placeholder="Search" id="myInput" onkeyup="myFunction()">
            </div>

    </div>

    </div>
</div>
<div class="bg-white p-3 border rounded-1 d-flex align-items-center m-0 p-0">

    <div class="card-body">
        <form action="{{ route('absensiTeacher') }}" method="get" data-bs-display="static">
        <div class="row my-2">
            <label class="col-lg-2 form-label mt-2"><span class="ti ti-calendar-due me-1"></span>Pilih Tanggal</label>
            <div class="col-lg-10">
                <div class="input-group">
                        <input type="text" name="tanggal" class="form-control datetimepickerCustom" placeholder="DD/MM/YYYY"  @if(request('tanggal')) value=" {{ request('tanggal') }}" @endif >
                        <button class="btn  btn-sm me-1 bg-light primary-hover p-2"><span class="ti ti-search"></span> Cari Data</button>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-body p-0 ">
        <div class="table-responsive">
            <table class="table table-nowrap mb-0" id="myTable">
                <thead>
                    <tr >
                        <th width="1%" class="border">#</th>
                        <th width="1%" ></th>
                        <th width="3%">RFID</th>
                        <th width="50%">Nama Lengkap</th>
                        <th class="border text-center" >H</th>
                        <th class="border text-center">S</th>
                        <th class="border text-center">I</th>
                        <th class="border text-center">A</th>
                        <th></th>

                    </tr>
                </thead>
                <tbody>
                    @if(request('tanggal'))
                        @php $no = 1; @endphp
                        <form action="{{ route('absensiTeacherAdd') }}" method="post">
                            @csrf
                            @foreach ($gtk as $item)
                                <tr>
                                    <td class="border">{{ $no++ }}.</td>
                                    <td>
                                        <div class="form-check form-check-md">
                                            <input class="form-check-input mydata" name="data[]" value="{{ $item->nik }}" type="checkbox">
                                        </div>
                                    </td>
                                    <td>
                                        @if($item->id_rfid == '')
                                            Belum disetel
                                        @else
                                            <a class="link-primary" href="#">{{ $item->id_rfid }}</a>
                                        @endif
                                    </td>
                                    <td>{{ $item->nama }}</td>

                                    <td class="border">
                                        <div class="form-check form-check-md d-flex justify-content-center">
                                            <input class="form-check-input a" value="H" type="radio" name="status[{{ $item->nik }}]" id="h-{{ $item->id  }}"
                                            @if($item->absent )
                                                @foreach ($item->rombelAbsent as $ky)
                                                    {{ $ky->tanggal == request('tanggal') && $ky->status == 'H' ? 'checked' : '' }}
                                                @endforeach

                                            @endif>
                                        </div>
                                    </td>
                                    <td class="border">
                                        <div class="form-check form-check-md d-flex justify-content-center">
                                            <input class="form-check-input a" value="S" type="radio" name="status[{{   $item->nik }}]" id="s-{{ $item->id }}"
                                            @if($item->absent)
                                                @foreach ($item->rombelAbsent as $ky)
                                                    {{ $ky->tanggal == request('tanggal') && $ky->status == 'S' ? 'checked' : '' }}
                                                @endforeach
                                            @endif>
                                        </div>
                                    </td>
                                    <td class="border">
                                        <div class="form-check form-check-md d-flex justify-content-center">
                                            <input class="form-check-input a" value="I" type="radio" name="status[{{ $item->nik}}]" id="i-{{ $item->id }}"
                                            @if($item->absent)
                                                @foreach ($item->rombelAbsent as $ky)
                                                    {{ $ky->tanggal == request('tanggal') && $ky->status == 'I' ? 'checked' : '' }}
                                                @endforeach
                                            @endif>
                                        </div>
                                    </td>
                                    <td class="border">
                                        <div class="form-check form-check-md d-flex justify-content-center">
                                            <input class="form-check-input a" value="A" type="radio" name="status[{{ $item->nik}}]" id="a-{{ $item->id }}"
                                            @if($item->absent)
                                                @foreach ($item->rombelAbsent as $ky)
                                                    {{ $ky->tanggal == request('tanggal') && $ky->status == 'A' ? 'checked' : '' }}
                                                @endforeach
                                            @endif>
                                        </div>
                                    </td>
                                    <td hidden>
                                        <input type="hidden" name="id_rfid[{{ $item->nik }}]" value="{{ $item->id_rfid }}">
                                        <input type="hidden" name="nik[{{ $item->nik }}]" value="{{ $item->nik }}">
                                        <input type="hidden" name="id_rfidMulti[]" value="{{ $item->id_rfid ?? ''}}">
                                        <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">
                                    </td>
                                    <td>
                                        <a class="btn btn-outline-primary bg-white btn-sm" data-bs-toggle="modal" data-bs-target="#editAbsent-{{ $item->id }}">
                                            <span class="ti ti-eye"></span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="border"></td>
                                <input type="text" name="type" value="single" class="type" hidden>
                                <td>
                                    <div class="form-check form-check-md">
                                        <input class="form-check-input mydata" type="checkbox" id="select-all">
                                    </div>
                                </td>
                                <td colspan="2" class="border">
                                    <div class="d-flex">
                                            <select name="Mstatus" id="Mstatus" class="form-control select" >
                                                <option value="H">Hadir</option>
                                                <option value="S">Sakit</option>
                                                <option value="I">Izin</option>
                                                <option value="A">Alfa</option>
                                            </select>
                                    </div>
                                </td>
                                <td colspan="7">
                                    <button type="submit" class="btn btn-primary mx-2 w-100">Simpan</button>
                                </td>
                            </tr>
                        </form>
                    @endif
                </tbody>

            </table>

        </div>
    </div>
</div>
@foreach ($gtk as $item)
{{-- modal Edit --}}
<div class="modal fade" id="editAbsent-{{ $item->id }}" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span class="ti ti-user"></span>{{ $item->nama }}</h4>
                <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </button>
            </div>
            <form action="{{ route('absensiTeacherAdd') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col d-flex justify-content-center mb-3">
                            @if($item->gambar)
                            <img src="{{ asset('storage/' . ($item->gambar ?? 'default-avatar.jpg')) }}"
                                class="avatar avatar-xxxl me-4 img-thumbnail rounded-pill" alt="foto">
                            @else
                            <img src="{{ asset('asset/img/user-default.jpg') }}"
                                class="avatar avatar-xxxl me-4 img-thumbnail rounded-pill" alt="foto">
                            @endif
                        </div>
                        <input type="text" name="type" value="ubahKeterangan" hidden>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal <span
                                                class="ti ti-calendar-due"></span></label>
                                        <input type="text" class="form-control" name="tanggal"
                                            value="{{ request('tanggal') }}" readonly required>
                                    </div>
                                </div>

                                <div class="col-lg-6" >
                                    <div class="mb-3">
                                        <label class="form-label">Nomor Induk <span class="ti ti-nfc"></span></label>
                                        <input type="text" class="form-control" name="nik"
                                            value="{{ $item->nik }}" readonly required>

                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama" value="{{ $item->nama }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status Kehadiran</label><br>
                                <div class="btn-group w-100 " >
                                    <input type="radio" class="btn-check " value="H"
                                        @foreach ($item->rombelAbsent as $ky ){{ $ky->tanggal == request('tanggal') ?
                                    $ky->status == 'H' ? 'Checked': '' : '' }} @endforeach disabled >
                                    <label class="btn btn-outline-light" for="z{{ $item->id }}">Hadir</label>

                                    <input type="radio" class="btn-check a " value="S"
                                        @foreach ($item->rombelAbsent as $ky ){{ $ky->tanggal == request('tanggal') ?
                                    $ky->status == 'S' ? 'Checked': '' : '' }} @endforeach  disabled>

                                    <label class="btn btn btn-outline-light" for="z{{ $item->id }}">Sakit</label>
                                    <input type="radio" class="btn-check  a" value="I"
                                        @foreach ($item->rombelAbsent as $ky ){{ $ky->tanggal == request('tanggal') ?
                                    $ky->status == 'I' ? 'Checked': '' : '' }} @endforeach disabled>
                                    <label class="btn btn btn-outline-light" for="z{{ $item->id }}">Izin</label>

                                    <input type="radio" class="btn-check a "  value="A"
                                        @foreach ($item->rombelAbsent as $ky ){{ $ky->tanggal == request('tanggal') ?
                                    $ky->status == 'A' ? 'Checked': '' : '' }} @endforeach disabled>
                                    <label class="btn btn btn-outline-light" for="z{{ $item->id }}">Tidak Hadir</label>
                                </div>
                            </div>
                            @foreach ($item->rombelAbsent as $ky )
                            @if ($ky->tanggal == request('tanggal'))
                            @if ($ky->status == 'H')
                            <div class="row inOut">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <input type="text" name="status" hidden @foreach ($item->rombelAbsent as $ky ){{ $ky->tanggal ==
                                        request('tanggal') ? $ky->status ? 'value='.$ky->status.'': '' : '' }} @endforeach>
                                        <label class="form-label">Entry</label>
                                        <input type="time" class="form-control entry" name="entry" @foreach ($item->rombelAbsent as $ky ){{ $ky->tanggal == request('tanggal') ? $ky->entry  ? 'value='.$ky->entry.'' : '' : '' }} @endforeach >
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Out</label>
                                        <input type="time" class="form-control out" name="out" @foreach ($item->rombelAbsent as $ky ){{ $ky->tanggal == request('tanggal') ? $ky->out  ? 'value='.$ky->out.'' : '' : '' }}  @endforeach>
                                    </div>
                                </div>

                            </div>
                            @endif
                            @endif
                            @endforeach
                            <div class="mb-3 ket" id="">
                                <label class="form-label">Keterangan</label>
                                <textarea rows="4" class="form-control keterangan" name="keterangan"
                                    placeholder="Keterangan Sakit/izin/Tidak Hadir">@foreach ($item->rombelAbsent as $ky ){{ $ky->tanggal == request('tanggal') ? $ky->keterangan  ? $ky->keterangan : '' : '' }} @endforeach</textarea>
                            </div>
                            <button class="btn btn-primary w-100">Simpan</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
</div>

@endforeach
@section('javascript')

<script>
    $(".a").click(function(){
        $(".type").val('single');
    });

   $(".mydata").click(function() {
    if ($(this).is(":checked")) {
        $(".type").val('multiple'); // Set to 'multiple' if checked
    }
    });

</script>

<script type="text/javascript">
        window.onload = function() { jam(); }

        function jam() {
            var e = document.getElementById('jam'),
            d = new Date(), h, m, s;
            h = d.getHours();
            m = set(d.getMinutes());
            s = set(d.getSeconds());

            e.innerHTML = h +':'+ m +':'+ s;

            setTimeout('jam()', 1000);
        }

        function set(e) {
            e = e < 10 ? '0'+ e : e;
            return e;
        }
    </script>

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

@endsection
@endsection
