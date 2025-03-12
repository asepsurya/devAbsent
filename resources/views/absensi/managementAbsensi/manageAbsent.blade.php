@extends('layout.main')
@section('container')
@section('css')
<style>
    .btn-check:checked+.btn, .btn.active, .btn.show, .btn.show:hover, .btn:first-child:active, :not(.btn-check)+.btn:active{
        background-color: #cdcdcd;
    }
    html .darkmode .nav-tabs li a,
    html[data-theme=dark] .nav-tabs li a {
        color: #0f0c1c;
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
                    <a href="javascript:void(0);">Absensi</a>
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

<ul class="nav nav-tabs tab-style-1 d-sm-flex d-block" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#orders" aria-current="page" href="#orders"
            aria-selected="false" role="tab" tabindex="-1"><span class="ti ti-users"></span> Absensi</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link " href="{{ route('presensiClassStudent',request('kelas')) }}?filter=today&id_mapel={{ request('id_mapel') }}&tahun={{ request('tahun') }}&kelas={{ request('kelas') }}&tanggal={{ request('tanggal') }}" aria-selected="true"
            role="tab"><span class="ti ti-list"></span> Presensi Absensi Kelas </a>
    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane active show" id="orders" role="tabpanel">
        <div class="bg-white p-3 border rounded-1 d-flex align-items-center justify-content-between flex-wrap mb-4 pb-0">
           <div >
          <h3>Management Absensi Kelas {{ $namakelas }} </h3>
           </div>
            <div class="d-flex align-items-center flex-wrap">
                <div class="d-flex align-items-center bg-white  p-1 mb-3 me-2">
                    <div class="input-icon-start me-2 position-relative">
                        <span class="icon-addon">
                            <i class="ti ti-search"></i>
                        </span>
                        <input type="text" class="form-control " placeholder="Search" id="myInput"
                            onkeyup="myFunction()">
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="card-body">
                <form action="{{ route('absensiClassManagement') }}" method="get">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal Absensi</label>
                        <input type="text" name="tanggal" class="form-control datetimepickerCustom" placeholder="DD/MM/YYYY" value="{{ request('tanggal') ? request('tanggal') : date('d/m/Y') }}">
                    </div>
                    <div class="mb-3">
                        <label for="tahun" class="form-label">Tahun Pelajaran</label>
                        <select name="tahun" id="tahun" class="form-control select" >
                            @foreach ($tahunAjar as $item )
                            <option value="{{ $item->id }}" {{ $item->id == request('tahun') ? 'selected' : '' }}>{{ $item->tahun_pelajaran }} - {{ $item->semester }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="mapel" class="form-label">Mata Pelajaran / Guru Ajar:</label>

                        <input type="text" name="kelas" value="{{ request('kelas') }}" hidden>

                        <select name="id_mapel" id="mapel" class="mapel" >
                            <option value="">-Pilih Mata Pelajaran-</option>

                            @foreach ($mapel as $item)
                                @if($item->mata_pelajaran && $item->guru)
                                    <option value="{{ $item->id_mapel }}" {{ request('id_mapel') == $item->id_mapel ? 'selected' : '' }}>
                                        {{ $item->mata_pelajaran->nama }} - {{ $item->guru->nama }} ({{ $item->guru->nik }})
                                    </option>
                                @endif
                            @endforeach

                        </select>
                        {{-- for get --}}
                        <input type="text" name="gtk" value="{{ request('gtk') }}" class="gtk" hidden >
                        <button class="btn btn-primary mt-3"><span class="ti ti-search"></span> Lakukan Absensi</button>
                </form>
            </div>
        </div>
        </div>
        <div class="card">
            <div class="card-body p-0 ">
                <div class="table-responsive">
                    <table class="table table-nowrap mb-0" id="myTable">
                        <thead>
                            <tr>
                                <th width="1%" class="border">#</th>
                                <th width="1%"> </th>
                                <th width="3%">NIS</th>
                                <th width="50%">Nama Lengkap</th>
                                <th class="border text-center">H</th>
                                <th class="border text-center">S</th>
                                <th class="border text-center">I</th>
                                <th class="border text-center">A</th>
                                <th></th>

                            </tr>
                        </thead>
                        @if(request('kelas') != 0)
                        <form action="{{ route('absensiClassStudent') }}" method="post">
                            @csrf
                        <tbody>
                            @if(request('tanggal'))
                                @php $no=1; @endphp
                                @foreach ($rombel as $item)
                                    <tr>
                                        <td class="border">{{ $no++ }}.</td>
                                        <td class="border">
                                            <div class="form-check form-check-md">
                                                <input class="form-check-input mydata" name="data[]" value="{{ $item->nis }}" type="checkbox">
                                            </div>
                                        </td>
                                        <td class="text-primary">{{ $item->nis }}</td>
                                        <td>{{ $item->rombelStudent->nama }}</td>

                                        <td class="border ">
                                            <div class="form-check form-check-md d-flex justify-content-center align-items-center">
                                                <input class="form-check-input a" value="H" type="radio" name="status[{{ $item->nis }}]"
                                                id="h-{{ $item->id }}"
                                                @if($absent->count() && $item->rombelAbsentClass->where('tanggal', request('tanggal'))->where('id_mapel', request('id_mapel'))->first()->status == 'H') checked @endif>
                                            </div>
                                        </td>
                                        <td class="border">
                                            <div class="form-check form-check-md d-flex justify-content-center align-items-center">
                                                <input class="form-check-input a" value="S" type="radio" name="status[{{ $item->nis }}]"
                                                id="s-{{ $item->id }}"

                                                @if($absent->count() && $item->rombelAbsentClass->where('tanggal', request('tanggal'))->where('id_mapel', request('id_mapel'))->first()->status == 'S') checked @endif>
                                            </div>
                                        </td>
                                        <td class="border">
                                            <div class="form-check form-check-md d-flex justify-content-center align-items-center">
                                                <input class="form-check-input a" value="I" type="radio" name="status[{{ $item->nis }}]"
                                                id="i-{{ $item->id }}"
                                                @if($absent->count() && $item->rombelAbsentClass->where('tanggal', request('tanggal'))->where('id_mapel', request('id_mapel'))->first()->status == 'I') checked @endif>
                                            </div>
                                        </td>
                                        <td class="border">
                                            <div class="form-check form-check-md d-flex justify-content-center align-items-center">
                                                <input class="form-check-input a" value="A" type="radio" name="status[{{ $item->nis }}]"
                                                id="a-{{ $item->id }}"
                                                @if($absent->count() && $item->rombelAbsentClass->where('tanggal', request('tanggal'))->where('id_mapel', request('id_mapel'))->first()->status == 'A') checked @endif>
                                            </div>
                                        </td>
                                        <td hidden >

                                            <input type="text" name="id_mapel[]" value="{{ request('id_mapel') }}">
                                            <input type="text" name="id_kelas[]" value="{{ request('kelas') }}">
                                            <input type="text" name="nis[]" value="{{ $item->nis }}">
                                            <input type="text" name="id_gtk"  id="id_gtk" class="gtk" value="{{ request('gtk') }}">
                                            <input type="text" name="tanggal[]" value="{{ request('tanggal') }}">
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
                            @endif
                        </tbody>
                        </form>
                        @endif
                    </table>
                    <div class="d-flex justify-content-end m-2">
                        {{ $rombel->links() }}
                    </div>
                </div>
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
            <form action="{{ route('absensiClassStudent') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col d-flex justify-content-center mb-3">
                            @if($item->rombelStudent->foto)
                                <img src="{{ asset('storage/' . optional($item->rombelStudent)->foto) }}"
                                class="avatar avatar-xxxl me-4 img-thumbnail rounded-pill" alt="foto">
                            @else
                            <img src="{{ asset('asset/img/user-default.jpg') }}"
                                class="avatar avatar-xxxl me-4 img-thumbnail rounded-pill" alt="foto">
                            @endif
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <input type="text" name="type" value="ubahKeterangan" class="type" hidden>
                                <input type="text" name="id_mapel" value="{{ request('id_mapel') }}" hidden>
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
                                        <label class="form-label">Nomor Induk Siswa ( NIS ) <span class="ti ti-nfc"></span></label>
                                        <input type="text" class="form-control" name="nis[]"
                                            value="{{ $item->nis }}" readonly required>
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
                                    @if($item->nis != '')
                                    @foreach ($item->rombelAbsentClass as $ky ){{ $ky->tanggal == request('tanggal') ?  $ky->status == 'H' ? 'Checked': '' : '' }} @endforeach  disabled
                                    @endif>
                                    <label class="btn btn-outline-light" for="z{{ $item->id }}"> Hadir</label>

                                    <input type="radio" class="btn-check a " value="S"
                                    @if($item->nis != '')
                                    @foreach ($item->rombelAbsentClass as $ky ){{ $ky->tanggal == request('tanggal') ?  $ky->status == 'S' ? 'Checked': '' : '' }} @endforeach  disabled
                                    @endif
                                    >
                                    <label class="btn btn btn-outline-light" for="z{{ $item->id }}">Sakit</label>
                                    <input type="radio" class="btn-check  a" value="I"
                                    @if($item->nis != '')
                                    @foreach ($item->rombelAbsentClass as $ky ){{ $ky->tanggal == request('tanggal') ?  $ky->status == 'I' ? 'Checked': '' : '' }} @endforeach disabled
                                    @endif
                                    >
                                    <label class="btn btn btn-outline-light" for="z{{ $item->id }}">Izin</label>

                                    <input type="radio" class="btn-check a "  value="A"
                                    @if($item->nis != '')
                                    @foreach ($item->rombelAbsentClass as $ky ){{ $ky->tanggal == request('tanggal') ?  $ky->status == 'A' ? 'Checked': '' : '' }} @endforeach disabled
                                    @endif
                                    >
                                    <label class="btn btn btn-outline-light" for="z{{ $item->id }}">Tidak Hadir</label>
                                </div>
                            </div>
                            @foreach ($item->rombelAbsentClass as $ky )
                            @if ($ky->tanggal == request('tanggal'))
                            <input type="text" name="status" hidden  @foreach ($item->rombelAbsentClass as $ky ){{ $ky->tanggal ==  request('tanggal') ? $ky->status ? 'value='.$ky->status.'': '' : '' }} @endforeach>
                            @if ($ky->status == 'H')
                            <div class="inOut">
                                    <div class="mb-3">
                                        <label class="form-label">Entry</label>
                                        <div class="date-pic">
                                            <input type="text" class="form-control entry timepicker" name="entry" readonly @foreach ($item->rombelAbsentClass as $ky ){{ $ky->tanggal == request('tanggal') ? $ky->entry  ? 'value='.$ky->entry.'' : '' : '' }} @endforeach >
                                            <span class="cal-icon"><i class="ti ti-clock"></i></span>
                                        </div>
                                    </div>
                            </div>
                            @endif
                            @endif
                            @endforeach
                            <div class="mb-3 ket" id="">
                                <label class="form-label">Keterangan1</label>
                                <textarea rows="4" class="form-control keterangan" name="keterangan"
                                    placeholder="Keterangan Sakit/izin/Tidak Hadir">@foreach ($item->rombelAbsentClass as $ky ){{ $ky->tanggal == request('tanggal') ? $ky->keterangan  ? $ky->keterangan : '' : '' }} @endforeach</textarea>
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

@if(session('refresh'))
    <script>
        toastr.success('Berhasil Disimpan');
        window.location.reload(); // Refresh the page
    </script>
@endif

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
<script>
    $(document).ready(function() {
         $('.mapel').select2({
            placeholder:'Pilih Mata Pelajaran '
         });
    });
</script>

<script>
     $(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            $(function (){
                $('#mapel').on('change',function(){
                    let id_mapel = $('#mapel').val();
                    const urlParams = new URLSearchParams(window.location.search);
                    let id_kelas = urlParams.get('kelas');
                    $.ajax({
                        type : 'POST',
                        url : "{{route('getgtk')}}",
                        data : {
                            id_mapel:id_mapel,
                            id_kelas:id_kelas,
                        },
                        cache : false,

                        success: function(msg){
                            $('.gtk').val(msg.c);
                        },
                        error: function(data) {
                            console.log('error:',data)
                        },
                    })
                })
            });
     });

</script>

{{-- <script>
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
</script> --}}

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
<script>
    function cariSiswa() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("siswaInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("siswaTable");
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
