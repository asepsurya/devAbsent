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

@if(Request::is('absensi/student'))
<div class="bg-white border rounded-1 p-4" >

    <div class="card-body ">
        <form action="{{ route('absensiStudent') }}" method="get" data-bs-display="static">

        <div class="row ">
            <label class="col-lg-3 form-label mt-1">Tahun Pelajaran</label>
            <div class="col-lg-9">
                {{-- this.form.submit() --}}
                <select name="tahun" id="tahunAjar" class="form-control select2"   onchange="">

                    @foreach ($tahunAjar as $item )
                    <option value="{{ $item->id }}" {{ $item->id == request('tahun') ? 'selected' : '' }}>{{
                        $item->tahun_pelajaran }} - {{ $item->semester }}
                    </option>
                    @php $a = request('tahun') @endphp
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row my-2">
            <label class="col-lg-3 form-label mt-2">Kelas</label>
            <div class="col-lg-9">
                <select name="kelas" id="kelas" class="form-control select2"  onchange="">
                    <option value="all" selected>Tampikan Semua</option>
                    @foreach ($kelas as $item )
                    <option value="{{ $item->id }}" {{ $item->id == request('kelas') ? 'selected' : '' }}>{{
                        $item->nama_kelas }} - {{
                        $item->jurusanKelas->nama_jurusan }} {{ $item->sub_kelas }} </option>
                    {{-- get Default Value --}}

                    @php $c = request('kelas');  @endphp
                    @endforeach
                </select>
            </div>

        </div>
        @if(request('kelas') != "all")
        <div class="row my-2">
            <label class="col-lg-3 form-label mt-2">Wali Kelas</label>
            <div class="col-lg-9">
                <input type="text" class="form-control" id="walikelas" name="walikelas"  value="{{ request('walikelas') }}">
            </div>
        </div>
        @endif

        <div class="row my-2">
            <label class="col-lg-3 form-label mt-2">Tanggal</label>
            <div class="col-lg-9">
                <input type="text" name="tanggal" class="form-control datetimepickerCustom" placeholder="DD/MM/YYYY"  @if(request('tanggal')) value=" {{ request('tanggal') }}" @endif  >
            </div>
        </div>

            <div class="row mt-2">
                <div class="col-lg-3"></div>
                <div class="col-lg-9"> <button class="btn btn-primary "><span class="ti ti-search"></span> Cari Data</button></div>
            </div>

        </form>
    </div>
</div>
@endif
<div class="card">
    <div class="card-body p-0 ">
        <div class="table-responsive">
            <table class="table table-nowrap mb-0" id="myTable">
                <thead>
                    <tr >
                        <th width="1%" class="border">#</th>
                        <th width="1%" >
                            <div class="form-check form-check-md">
                            <input class="form-check-input" type="checkbox" id="select-all">
                            </div></th>
                        <th width="3%">NIS</th>
                        <th width="50%">Nama Lengkap</th>
                        <th class="border" >H</th>
                        <th class="border">S</th>
                        <th class="border">I</th>
                        <th class="border">A</th>
                        <th></th>

                    </tr>
                </thead>
                <tbody>
                    {{-- <form action="{{ route('absensiStudentAdd') }}" method="post" id="2" >
                        @csrf --}}
                    @if(request('tanggal'))
                    @php $no=1; @endphp
                    @foreach ($rombel as $item )

                     <tr>
                        <td class="border">{{ $no++ }}.</td>
                        <td>
                                <div class="form-check form-check-md">
                                    <input class="form-check-input" name="data[]" value="{{ $item->id_rfid }}" type="checkbox">
                                </div>
                        </td>
                        <td class="text-primary">
                            {{ $item->nis }}
                        </td>
                        <td>{{ $item->rombelStudent->nama }}</td>
                        <form action="{{ route('absensiStudentAdd') }}" method="post" >
                            @csrf

                            <td class="border">
                           <div class="form-check form-check-md">
                                <input class="form-check-input a" value="H"  type="radio" name="status" id="{{ $item->id }}" onclick="this.form.submit()"
                            @if($item->id_rfid != '')
                                @foreach ($item->rombelAbsent as $ky ){{ $ky->tanggal == request('tanggal') ?  $ky->status == 'H' ? 'Checked': '' : '' }}    @endforeach
                            @else{
                                @foreach ($item->notRFID as $ky ){{ $ky->tanggal == request('tanggal') ?  $ky->status == 'H' ? 'Checked': '' : '' }}    @endforeach
                            }
                            @endif >
                            </div>
                                </td>
                            <td class="border">
                            <div class="form-check form-check-md">
                                <input class="form-check-input a" value="S"  type="radio" name="status" id="{{ $item->id }}" onclick="this.form.submit()"
                                @if($item->id_rfid != '')
                                    @foreach ($item->rombelAbsent as $ky ){{ $ky->tanggal == request('tanggal') ?  $ky->status == 'S' ? 'Checked': '' : '' }}    @endforeach
                                @else
                                    @foreach ($item->notRFID as $ky ){{ $ky->tanggal == request('tanggal') ?  $ky->status == 'S' ? 'Checked': '' : '' }}    @endforeach
                                @endif
                                    >
                            </div>
                                </td>
                            <td class="border">
                            <div class="form-check form-check-md">
                                <input class="form-check-input a" value="I" type="radio"  name="status" id="{{ $item->id }}"onclick="this.form.submit()" $cek
                                @if($item->id_rfid != '')
                                    @foreach ($item->rombelAbsent as $ky ){{ $ky->tanggal == request('tanggal') ?  $ky->status == 'I' ? 'Checked': '' : '' }}    @endforeach
                                @else
                                    @foreach ($item->notRFID as $ky ){{ $ky->tanggal == request('tanggal') ?  $ky->status == 'I' ? 'Checked': '' : '' }}    @endforeach
                                @endif
                                >
                            </div>
                                </td>
                            <td class="border">
                            <div class="form-check form-check-md">
                                <input class="form-check-input a" value="A" type="radio"  name="status" id="{{ $item->id }}"onclick="this.form.submit()"
                                @if($item->id_rfid != '')
                                    @foreach ($item->rombelAbsent as $ky ){{ $ky->tanggal == request('tanggal') ?  $ky->status == 'A' ? 'Checked': '' : '' }}    @endforeach
                                @else
                                   @foreach ($item->notRFID as $ky ){{ $ky->tanggal == request('tanggal') ?  $ky->status == 'A' ? 'Checked': '' : '' }}    @endforeach
                                @endif
                                   >
                            </div>
                                </td>
                            <td hidden>
                            @if ($item->id_rfid == '')
                                <input type="text" name="id_rfid" value="{{ $item->nis }}">
                            @else
                                <input type="text" name="id_rfid" value="{{ $item->id_rfid }}">
                            @endif
                            <input type="text" name="tanggal" value="{{ request('tanggal') }}">
                                </td>
                        </form>

                        <td><button class="btn btn-outline-primary bg-white btn-sm " data-bs-toggle="modal" data-bs-target="#editAbsent-{{ $item->id }}"><span class="ti ti-eye"></span> </button></td>
                    </tr>
                        @endforeach
                        {{-- <button type="submit" formaction="{{ route('absensiStudentAdd') }}">Simpan</button>
                    </form> --}}
                    @endif
                </tbody>
            </table>
            <div class="d-flex justify-content-end m-2">
                {{  $rombel->links() }}
            </div>
        </div>
    </div>
</div>


@foreach ($rombel as $item)
{{-- modal Edit --}}
<div class="modal fade" id="editAbsent-{{ $item->id }}" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span class="ti ti-user"></span>{{ $item->rombelStudent->nama }}</h4>
                <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </button>
            </div>
            <form action="{{ route('absensiStudentAdd') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col d-flex justify-content-center mb-3">
                            @if($item->rombelStudent->foto)
                            <img src="/storage/{{ $item->rombelStudent->foto }}"
                                class="avatar avatar-xxxl me-4 img-thumbnail rounded-pill" alt="foto">
                            @else
                            <img src="{{ asset('asset/img/user-default.jpg') }}"
                                class="avatar avatar-xxxl me-4 img-thumbnail rounded-pill" alt="foto">
                            @endif
                        </div>
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
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">RFID <span class="ti ti-nfc"></span></label>
                                        <input type="text" class="form-control" name="id_rfid"
                                            value="{{ $item->id_rfid }}" readonly required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama" value="{{ $item->rombelStudent->nama }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status Kehadiran</label><br>
                                <div class="btn-group w-100 " >
                                    <input type="radio" class="btn-check " value="H"
                                    @if($item->id_rfid != '')
                                     @foreach ($item->rombelAbsent as $ky ){{ $ky->tanggal == request('tanggal') ?
                                     $ky->status == 'H' ? 'Checked': '' : '' }} @endforeach disabled
                                    @else
                                    @foreach ($item->notRFID as $ky ){{ $ky->tanggal == request('tanggal') ?
                                     $ky->status == 'H' ? 'Checked': '' : '' }} @endforeach disabled
                                    @endif
                                    >
                                    <label class="btn btn-outline-light" for="z{{ $item->id }}">Hadir</label>

                                    <input type="radio" class="btn-check a " value="S"
                                    @if($item->id_rfid != '')
                                       @foreach ($item->rombelAbsent as $ky ){{ $ky->tanggal == request('tanggal') ?
                                    $ky->status == 'S' ? 'Checked': '' : '' }} @endforeach  disabled
                                    @else
                                    @foreach ($item->notRFID as $ky ){{ $ky->tanggal == request('tanggal') ?
                                    $ky->status == 'S' ? 'Checked': '' : '' }} @endforeach  disabled
                                    @endif
                                    >
                                    <label class="btn btn btn-outline-light" for="z{{ $item->id }}">Sakit</label>
                                    <input type="radio" class="btn-check  a" value="I"
                                    @if($item->id_rfid != '')
                                        @foreach ($item->rombelAbsent as $ky ){{ $ky->tanggal == request('tanggal') ?
                                    $ky->status == 'I' ? 'Checked': '' : '' }} @endforeach disabled
                                    @else
                                    @foreach ($item->notRFID as $ky ){{ $ky->tanggal == request('tanggal') ?
                                    $ky->status == 'I' ? 'Checked': '' : '' }} @endforeach disabled
                                    @endif
                                    >
                                    <label class="btn btn btn-outline-light" for="z{{ $item->id }}">Izin</label>

                                    <input type="radio" class="btn-check a "  value="A"
                                    @if($item->id_rfid != '')
                                        @foreach ($item->rombelAbsent as $ky ){{ $ky->tanggal == request('tanggal') ?
                                    $ky->status == 'A' ? 'Checked': '' : '' }} @endforeach disabled
                                    @else
                                    @foreach ($item->notRFID as $ky ){{ $ky->tanggal == request('tanggal') ?
                                    $ky->status == 'A' ? 'Checked': '' : '' }} @endforeach disabled
                                    @endif
                                    >
                                    <label class="btn btn btn-outline-light" for="z{{ $item->id }}">Tidak Hadir</label>
                                </div>
                            </div>
                            @foreach ($item->rombelAbsent as $ky )
                            <input type="text" name="status" hidden @foreach ($item->rombelAbsent as $ky ){{ $ky->tanggal == request('tanggal') ? $ky->status ? 'value='.$ky->status.'': '' : '' }} @endforeach>
                            @if ($ky->tanggal == request('tanggal'))
                            @if ($ky->status == 'H')
                            <div class="row inOut">
                                <div class="col-lg-6">
                                    <div class="mb-3">

                                        <label class="form-label">Entry</label>
                                        <div class="date-pic">
                                            <input type="text" class="form-control entry timepicker" name="entry" @foreach ($item->rombelAbsent as $ky ){{ $ky->tanggal == request('tanggal') ? $ky->entry  ? 'value='.$ky->entry.'' : '' : '' }} @endforeach >
                                            <span class="cal-icon"><i class="ti ti-clock"></i></span>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Out</label>
                                        <div class="date-pic">
                                            <input type="text" class="form-control out timepicker" name="out" @foreach ($item->rombelAbsent as $ky ){{ $ky->tanggal == request('tanggal') ? $ky->out  ? 'value='.$ky->out.'' : '' : '' }}  @endforeach>
                                            <span class="cal-icon"><i class="ti ti-clock"></i></span>
                                        </div>

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
    $(document).ready(function() {
         $('.select2').select2();
    });
</script>
<script>
    $(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            $(function (){
                $('#kelas').on('change',function(){
                    let id_kelas = $('#kelas').val();

                    $.ajax({
                        type : 'POST',
                        url : "{{route('getwalikelas')}}",
                        data : {id_kelas:id_kelas},
                        cache : false,

                        success: function(msg){
                            $('#walikelas').val(msg);
                        },
                        error: function(data) {
                            console.log('error:',data)
                        },
                    })
                })
            });
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

<script>
    // set Defalult select ke dala input Box
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
