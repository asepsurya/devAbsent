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
                    <a href="javascript:void(0);">Absensi</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Guru dan Tenaga Kependidikan</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">

    </div>
</div>
{{-- End Header --}}
<div class="bg-white p-3 border rounded-1 d-flex align-items-center justify-content-between flex-wrap mb-4 pb-0">
    <h4 class="mb-3">Form Absensi Guru</h4>
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
                        <th width="10%">#</th>
                        <th width="20%">RFID</th>
                        <th>Nama Lengkap</th>

                        <th class="border">H</th>
                        <th class="border">S</th>
                        <th class="border">I</th>
                        <th class="border">A</th>
                        <th></th>

                    </tr>
                </thead>
                <tbody>
                    @if(request('tanggal'))
                    @php
                        $no=1;
                    @endphp
                    @foreach ($gtk as $item)
                    @php $cek ="" @endphp

                    <tr>
                        <td>{{ $no++ }}.</td>
                        <td>{{ $item->id_rfid }}</td>
                        <td>{{ $item->nama }}</td>
                        <form action="{{ route('absensiStudentAdd') }}" method="post">
                            @csrf

                        <td class="border">

                           <div class="form-check form-check-md">
                                <input class="form-check-input" value="H"  type="radio" name="status" id="{{ $item->id }}" onclick="this.form.submit()"
                            @if($item->absent)    {{ $item->absent->tanggal == request('tanggal') ?  $item->absent->status == 'H' ? 'Checked': '' : '' }} @endif
                                >

                            </div>
                        </td>
                        <td class="border">
                            <div class="form-check form-check-md">
                                <input class="form-check-input" value="I"  type="radio" name="status" id="{{ $item->id }}" onclick="this.form.submit()"
                                @if($item->absent)  {{ $item->absent->tanggal == request('tanggal') ?  $item->absent->status == 'I' ? 'Checked': '' : '' }} @endif
                                >

                            </div>
                        </td>
                        <td class="border">

                            <div class="form-check form-check-md">
                                <input class="form-check-input" value="S" type="radio"  name="status" id="{{ $item->id }}"onclick="this.form.submit()" $cek
                                @if($item->absent)  {{ $item->absent->tanggal == request('tanggal') ?  $item->absent->status == 'S' ? 'Checked': '' : '' }} @endif
                                >

                            </div>

                            {{-- @if( $item->absent->tanggal === request('tanggal')  || $item->absent->status === "S")
                                {{ $item->absent->status }}
                                @else
                                nUL
                            @endif --}}
                        </td>
                        <td class="border">
                            <div class="form-check form-check-md">
                                <input class="form-check-input" value="A" type="radio"  name="status" id="{{ $item->id }}"onclick="this.form.submit()"
                                @if($item->absent)  {{ $item->absent->tanggal == request('tanggal') ?  $item->absent->status == 'A' ? 'Checked': '' : '' }} @endif
                                >
                            </div>
                        </td>
                        <td hidden>
                            <input type="text" name="id_rfid" value="{{ $item->id_rfid }}">
                            <input type="text" name="tanggal" value="{{ request('tanggal') }}">
                        </td>
                        </form>

                        {{-- <td>@if($item->rombelStudent->absent){{ $item->rombelStudent->absent->entry }}@else - @endif</td>
                        <td>@if($item->rombelStudent->absent){{ $item->rombelStudent->absent->out }}@else - @endif</td> --}}

                        {{-- <td>
                            @if ($absent->count())
                            @if($item->absent)
                            @foreach($item->rombelAbsent as $data)

                            @if($data->tanggal == request('tanggal') )

                                @if($data->status =="Hadir")
                                    <span class="badge badge-soft-success d-inline-flex align-items-center"><i class="ti ti-circle-filled fs-5 me-1"></i>Hadir</span>
                                @elseif ($data->status =="Sakit")
                                    <span class="badge badge-soft-warning d-inline-flex align-items-center"><i class="ti ti-circle-filled fs-5 me-1"></i>Sakit</span>
                                @elseif ($data->status =="Izin")
                                    <span class="badge badge-soft-info d-inline-flex align-items-center"><i class="ti ti-circle-filled fs-5 me-1"></i>Izin</span>
                                @else
                                    <span class="badge badge-soft-danger d-inline-flex align-items-center"><i class="ti ti-circle-filled fs-5 me-1"></i>Tidak Hadir</span>
                                @endif
                            @endif
                            @endforeach
                            @else
                            <span class="badge badge-soft-info d-inline-flex align-items-center"><i
                                class="ti ti-circle-filled fs-5 me-1"></i>Belum Absen</span>
                            @endif
                            @else
                            <span class="badge badge-soft-info d-inline-flex align-items-center"><i
                                class="ti ti-circle-filled fs-5 me-1"></i>Belum Absen</span>
                            @endif


                        </td> --}}
                        <td><button class="btn btn-outline-primary bg-white btn-sm " data-bs-toggle="modal" data-bs-target="#editAbsent-{{ $item->id }}"><span class="ti ti-settings"></span>Aksi Kehadiran</button></td>
                    </tr>
                    @endforeach
                </tbody>
                @endif
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
            <form action="{{ route('absensiStudentAdd') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal <span class="ti ti-calendar-due"></span></label>
                                        <input type="text" class="form-control" name="tanggal" value="{{ request('tanggal') }}" readonly required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">RFID <span class="ti ti-nfc"></span></label>
                                        <input type="text" class="form-control" name="id_rfid" value="{{ $item->id_rfid }}" readonly required>
                                    </div>
                                </div>
                            </div>


                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama" value="{{ $item->nama }}" readonly>
                            </div>
                            <div class="mb-3">

                                <label class="form-label">Status Kehadiran</label><br>
                               <div class="btn-group w-100">
                               <input type="radio" class="btn-check a" name="status" id="option1{{ $item->id }}" autocomplete="off" value="Hadir" required  >
                                <label class="btn btn-outline-light" for="option1{{ $item->id }}" >Hadir</label>

                                <input type="radio" class="btn-check b" name="status" id="option2{{ $item->id }}" autocomplete="off" value="Sakit" required >
                                <label class="btn btn btn-outline-light" for="option2{{ $item->id }}">Sakit</label>

                                <input type="radio" class="btn-check c" name="status" id="option3{{ $item->id }}" autocomplete="off" value="Izin" >
                                <label class="btn btn btn-outline-light" for="option3{{ $item->id }}">Izin</label>

                                <input type="radio" class="btn-check d" name="status" id="option4{{ $item->id }}" autocomplete="off" value="Tidak Hadir" required >
                                <label class="btn btn btn-outline-light" for="option4{{ $item->id }}">Tidak Hadir</label>
                               </div>

                            </div>
                            <div class="row inOut" >
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Entry</label>
                                        <input type="time" class="form-control entry" name="entry" @if($item->absent) value="{{ $item->absent->entry }}" @endif >
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Out</label>
                                        <input type="time" class="form-control out" name="out" @if($item->absent) value="{{ $item->absent->out }}" @endif >
                                    </div>
                                </div>

                            </div>
                            <div class="mb-3 ket"  id="">
                                <label class="form-label">Deskripsi</label>
                                <textarea rows="4" class="form-control keterangan" name="keterangan" placeholder="Keterangan Sakit/izin/Tidak Hadir">@if($item->absent) {{ $item->absent->keterangan }} @endif</textarea>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="submit" class="btn btn-primary w-100">Update</button>

                </div>
            </form>
        </div>
    </div>
</div>

@endforeach
@section('javascript')

<script>
      $(".inOut").hide();
      $(".ket").hide();
     $(".a").click(function(){
        $(".inOut").show();
        $(".ket").hide();
        $(".keterangan").val('');
     });
     $(".b").click(function(){
        $(".entry").val('');
        $(".out").val('');
        $(".inOut").hide();
        $(".ket").show();
     });
     $(".c").click(function(){
        $(".entry").val('');
        $(".out").val('');
        $(".inOut").hide();
        $(".ket").show();
     });
     $(".d").click(function(){
        $(".entry").val('');
        $(".out").val('');
        $(".inOut").hide();
        $(".ket").hide();
     });

     if ($('.a').is(':checked')) {
        $(".inOut").show();
        $(".ket").hide();
     }else if($('.b').is(':checked')){
        $(".inOut").hide();
        $(".ket").show();
     }else if($('.c').is(':checked')){
        $(".inOut").hide();
        $(".ket").show();
     }else if($('.c').is(':checked')){
        $(".inOut").hide();
        $(".ket").hide();
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

</script>
@endsection
@endsection
