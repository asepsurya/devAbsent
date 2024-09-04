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
                <li class="breadcrumb-item active" aria-current="page">Student</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">

    </div>
</div>
{{-- End Header --}}

<div class="card ">
    <div class="card-header ">
        <h3><span class="ti ti-settings"></span> Pilih Kelas</h3>
    </div>
    <div class="card-body ">
        <form action="{{ route('absensiStudent') }}" method="get" data-bs-display="static">

        <div class="row ">
            <label class="col-lg-3 form-label mt-1">Tahun Pelajaran</label>
            <div class="col-lg-9">
                <select name="tahun" id="tahunAjar" class="form-control select2"   onchange="this.form.submit()">
                    <option value="" selected>--Tahun Ajaran--</option>
                    @foreach ($tahunAjar as $item )
                    <option value="{{ $item->id }}" {{ $item->id == request('tahun') ? 'selected' : '' }}>{{
                        $item->tahun_pelajaran }}
                    </option>
                    @php $a = request('tahun') @endphp
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row my-2">
            <label class="col-lg-3 form-label mt-2">Kelas</label>
            <div class="col-lg-9">
                <select name="kelas" id="kelas" class="form-control select2"  onchange="this.form.submit()">
                    <option value="" selected>-- Pilih Kelas --</option>
                    @foreach ($kelas as $item )
                    <option value="{{ $item->id }}" {{ $item->id == request('kelas') ? 'selected' : '' }}>{{
                        $item->nama_kelas }} - {{
                        $item->jurusanKelas->nama_jurusan }} {{ $item->sub_kelas }}</option>
                    {{-- get Default Value --}}
                    @php $c = request('kelas') @endphp
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row my-2">
            <label class="col-lg-3 form-label mt-2">Tanggal</label>
            <div class="col-lg-9">
                <input type="text" name="tanggal" class="form-control datetimepickerCustom" placeholder="DD/MM/YYYY"  @if(request('tanggal')) value=" {{ request('tanggal') }}" @endif  >
            </div>
        </div>

            <div class="row mt-2">
                <div class="col-lg-3"></div>
                <div class="col-lg-9"> <button class="btn btn-soft-success w-100"><span class="ti ti-search"></span> Cari Data</button></div>
            </div>

        </form>
    </div>
</div>
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h4><span class="ti ti-settings"></span> Daftar Hadir</h4>
        <div>
            <div class="input-icon-start me-2 position-relative">
                <span class="icon-addon">
                    <i class="ti ti-search"></i>
                </span>
                <input type="text" class="form-control " placeholder="Search" id="myInput" onkeyup="myFunction()">
            </div>
        </div>
    </div>
    <div class="card-body p-0 ">
        <div class="table-responsive">
            <table class="table table-nowrap mb-0" id="myTable">
                <thead>
                    <tr >
                        <th class="bg-light-400" width="5%">#</th>
                        <th class="bg-light-400" width="5%"><input type="checkbox" name="" id="as" class="checkbox"></th>
                        <th class="bg-light-400" width="20%">RFID</th>
                        <th class="bg-light-400">Nama Lengkap</th>

                        <th class="bg-light-400">Status</th>
                        <th class="bg-light-400"></th>

                    </tr>
                </thead>
                <tbody>
                    @php
                        $no=1;
                    @endphp
                    @foreach ($rombel as $item)

                    <tr>
                        <td>{{ $no++ }}.</td>
                        <td><input type="checkbox" name="" id="as" class="checkbox"></td>
                        <td>{{ $item->rombelStudent->id_rfid }}</td>
                        <td>{{ $item->rombelStudent->nama }}</td>
                        <td>
                            {{-- jika data ada --}}

                                @foreach($item->rombelAbsent as $data)

                                    @if($data->tanggal == request('tanggal') )
                                        {{-- menentukan Jenis Badge --}}
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




                        </td>

                        <td><button class="btn btn-outline-primary bg-white btn-sm " data-bs-toggle="modal" data-bs-target="#editAbsent-{{ $item->id }}"><span class="ti ti-settings"></span>Aksi Kehadiran</button></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
                                        <input type="text" class="form-control" name="id_rfid" value="{{ $item->rombelStudent->id_rfid }}" readonly required>
                                    </div>
                                </div>
                            </div>


                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama" value="{{ $item->rombelStudent->nama }}" readonly>
                            </div>
                            <div class="mb-3">

                                <label class="form-label">Status Kehadiran</label><br>
                               <div class="btn-group w-100">


                                        <input type="radio" class="btn-check a" name="status" id="option1{{ $item->id }}" autocomplete="off" value="Hadir"
                                       @if( $item->rombelStudent->absent) {{ $item->rombelStudent->absent->status == "Hadir" ? 'checked' :''}}@endif
                                        required >
                                        <label class="btn btn-outline-light" for="option1{{ $item->id }}" >Hadir</label>

                                        <input type="radio" class="btn-check b" name="status" id="option2{{ $item->id }}" autocomplete="off" value="Sakit"
                                        @if( $item->rombelStudent->absent){{ $item->rombelStudent->absent->status == "Sakit" ? 'checked' :''}}@endif required >
                                        <label class="btn btn btn-outline-light" for="option2{{ $item->id }}">Sakit</label>

                                        <input type="radio" class="btn-check c" name="status" id="option3{{ $item->id }}" autocomplete="off" value="Izin"
                                        @if( $item->rombelStudent->absent) {{ $item->rombelStudent->absent->status == "Izin" ? 'checked' :''}} @endif required   >
                                        <label class="btn btn btn-outline-light" for="option3{{ $item->id }}">Izin</label>

                                        <input type="radio" class="btn-check d" name="status" id="option4{{ $item->id }}" autocomplete="off" value="Tidak Hadir"
                                        @if( $item->rombelStudent->absent){{$item->rombelStudent->absent->status == "Tidak Hadir"  ? 'checked' :''}}  @endif required >
                                        <label class="btn btn btn-outline-light" for="option4{{ $item->id }}">Tidak Hadir</label>

                            </div>

                            </div>
                            <div class="row inOut" >
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Entry</label>
                                        <input type="time" class="form-control entry" name="entry" @if($item->rombelStudent->absent) value="{{ $item->rombelStudent->absent->entry }}" @endif >
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Out</label>
                                        <input type="time" class="form-control out" name="out" @if($item->rombelStudent->absent) value="{{ $item->rombelStudent->absent->out }}" @endif >
                                    </div>
                                </div>

                            </div>
                            <div class="mb-3 ket"  id="">
                                <label class="form-label">Deskripsi</label>
                                <textarea rows="4" class="form-control keterangan" name="keterangan" placeholder="Keterangan Sakit/izin/Tidak Hadir">@if($item->rombelStudent->absent) {{ $item->rombelStudent->absent->keterangan }} @endif</textarea>
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

</script>
@endsection
@endsection
