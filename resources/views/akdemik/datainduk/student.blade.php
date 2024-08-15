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
        <div class="mb-2">
            <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-effect="effect-scale"
                data-bs-toggle="modal" data-bs-target="#add_student"><i
                    class="ti ti-square-rounded-plus me-2"></i>Peserta Didik</a>
        </div>
    </div>
</div>
{{-- End Header --}}

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap pb-0">
        <h4 class="mb-3">Daftar Peserta Didik</h4>
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
                        <th class="bg-light-400">NIS</th>
                        <th class="bg-light-400">Nama Peserta Didik</th>
                        <th class="bg-light-400">Jenis Kelamin</th>
                        <th class="bg-light-400">Tempat Lahir</th>
                        <th class="bg-light-400">Tanggal Lahir</th>
                        <th class="bg-light-400">Rombongan Belajar</th>

                        <th class="bg-light-400">Status</th>
                        <th class="bg-light-400">Tanggal Masuk</th>
                        <th class="bg-light-400">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no=1 @endphp
                    @foreach ($students as $item )
                    <tr class="odd">
                        <td>{{ $no++ }}</td>
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
                        <td>{{ date('d F Y', strtotime($item->created_at)) }}</td>
                        <td>
                            <div class="hstack gap-2 fs-15">
                                <a href="javascript:void(0);"
                                    class="btn btn-icon btn-sm btn-soft-success rounded-pill"><i
                                        class="ti ti-brand-whatsapp"></i></a>
                                <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-soft-info rounded-pill"><i
                                        class="ti ti-pencil-minus"></i></a>
                                <a href="javascript:void(0);"
                                    class="btn btn-icon btn-sm btn-soft-danger rounded-pill"><i
                                        class="ti ti-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
        <div class="d-flex justify-content-end m-3"> {{ $students->links() }}</div>

    </div>
</div>
{{-- modal tambah Peserta Didik --}}
<div class="modal fade" id="add_student" aria-modal="true" role="dialog" style="overflow:hidden;">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span class="ti ti-ti ti-pencil-plus"></span> Tambah Peserta Didik</h4>
                <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{ route('dataIndukStudentAdd') }}" method="post">
                    @csrf
                    <div class=" " id="sectionOne">
                        <div class="alert alert-primary overflow-hidden p-0" role="alert">
                            <div class="p-3 bg-primary text-fixed-white d-flex justify-content-between">
                                <h6 class="aletr-heading mb-0 text-fixed-white">Informasi Singkat
                                </h6>

                            </div>
                            <hr class="my-0">
                            <div class="p-3">
                                <p class="mb-0">Isi form data dibawah ini bersarkan form yang tersedia, Untuk lebih
                                    lanjut hubungi <a href="javascript:void(0);"
                                        class="fw-semibold text-decoration-underline text-primary">Administrator</a></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-2">
                                    <label class="form-label">Nomor Induk Siswa</label>
                                    <input type="text" class="form-control @error('nis') is-invalid @enderror"
                                        placeholder="Nomor Induk Siswa" name="nis" value="{{ old('nis') }}" id="nis"
                                        maxlength="10" onkeypress="return onlyNumberKey(event)">
                                    @error('nis')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" value="{{ old('tempat_lahir') }}"
                                        class="form-control @error('tempat_lahir') is-invalid @enderror"
                                        placeholder="Tasikmalaya" name="tempat_lahir">
                                    @error('tempat_lahir')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <select name="gender" id="gender"
                                        class="form-control select2 @error('gender') is-invalid @enderror">
                                        <option value="" selected>- Jenis Kelamin -
                                        </option>
                                        <option value="1" {{ old('gender')==1 ? 'selected' : '' }}>Laki - Laki</option>
                                        <option value="2" {{ old('gender')==2 ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('gender')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="mb-2">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" value="{{ old('nama') }}"
                                        class="form-control @error('nama') is-invalid @enderror"
                                        placeholder="Nama Lengkap Siswa" name="nama" id="nama">
                                    @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <div class="input-icon position-relative">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-calendar"></i>
                                        </span>
                                        <input type="text" placeholder="Tanggal Lahir"
                                            class="form-control datetimepicker @error('tanggal_lahir') is-invalid @enderror"
                                            value="{{ old('tanggal_lahir') }}" name="tanggal_lahir">
                                        @error('tanggal_lahir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Agama</label>
                                    <select name="agama" id="agama"
                                        class="form-control select 2 @error('agama') is-invalid @enderror">
                                        <option value="" selected>- Pilih Agama -
                                        </option>
                                        <option value="Islam" {{ old('agama')=='Islam' ? 'selected' : '' }}>Islam
                                        </option>
                                        <option value="Kristen" {{ old('agama')=='Kristen' ? 'selected' : '' }}>Kristen
                                        </option>
                                        <option value="Katolik" {{ old('agama')=='Katolik' ? 'selected' : '' }}>Katolik
                                        </option>
                                        <option value="Hindu" {{ old('agama')=='Hindu' ? 'selected' : '' }}>Hindu
                                        </option>
                                        <option value="Buddha" {{ old('agama')=='Buddha' ? 'selected' : '' }}>Buddha
                                        </option>
                                        <option value="Khonghucu" {{ old('agama')=='Khonghucu' ? 'selected' : '' }}>
                                            Khonghucu</option>
                                    </select>
                                    @error('agama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="mt-4 " id="sectionTwo">
                        <div class="col">
                            <div class="mb-2">
                                <label class="form-label">Alamat</label>
                                <input type="text" value="{{ old('alamat') }}"
                                    class="form-control @error('alamat') is-invalid @enderror"
                                    placeholder="Contoh : Jl.Pegangsaan RT.02 RW.04" name="alamat" id="alamat">
                                @error('alamat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-2">
                                    <label class="form-label">Provinsi</label>
                                    <select name="id_provinsi" id="provinsi"
                                        class="form-control select2 @error('id_provinsi') is-invalid @enderror">
                                        <option value="">Pilih Provinsi</option>
                                        @foreach ($provinsi as $p)
                                        <option value="{{ $p->id }}" {{ old('id_provinsi')==$p->id ? 'selected' : ''
                                            }}>{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_provinsi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Kota/Kabupaten</label>
                                    <select name="id_kota" id="kabupaten"
                                        class="form-control select2  @error('id_kota') is-invalid @enderror"></select>
                                    @error('id_kota')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-2">
                                    <label
                                        class="form-label  @error('id_kecamatan') is-invalid @enderror">Kecamatan</label>
                                    <select name="id_kecamatan" id="kecamatan" class="form-control select2"></select>
                                    @error('id_kecamatan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Kelurahan/Desa</label>
                                    <select name="id_desa" id="desa"
                                        class="form-control select2 @error('id_desa') is-invalid @enderror"></select>
                                    @error('id_desa')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary w-100">Tambah</button>
                </form>
            </div>

        </div>
    </div>
</div>
@section('javascript')

<script>
    
$('#add_student').modal('show');
    $(document).ready(function() {
      $(".select2").select2({
        dropdownParent: $("#add_student")
      });
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
<script>
    $(function(){
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });
        $('#kabupaten').attr('disabled','disabled');
        $('#kecamatan').attr('disabled','disabled');
        $('#desa').attr('disabled','disabled');

        $(function (){
            $('#provinsi').on('change',function(){
                let id_provinsi = $('#provinsi').val();
                
                $.ajax({
                    type : 'POST',
                    url : "{{route('getkabupaten')}}",
                    data : {id_provinsi:id_provinsi},
                    cache : false,

                    success: function(msg){
                        $('#kabupaten').removeAttr('disabled');
                        $('#kabupaten').html(msg);
                        $('#kecamatan').html('');
                        $('#desa').html('');
                        
                    },
                    error: function(data) {
                        console.log('error:',data)
                    },
                })
            })


            $('#kabupaten').on('change',function(){
                let id_kabupaten = $('#kabupaten').val();
              
                $.ajax({
                    type : 'POST',
                    url : "{{route('getkecamatan')}}",
                    data : {id_kabupaten:id_kabupaten},
                    cache : false,

                    success: function(msg){
                        $('#kecamatan').removeAttr('disabled');
                        $('#kecamatan').html(msg);
                        $('#desa').html('');
                       
                        
                    },
                    error: function(data) {
                        console.log('error:',data)
                    },
                })
            })

            $('#kecamatan').on('change',function(){
                let id_kecamatan = $('#kecamatan').val();
               
                $.ajax({
                    type : 'POST',
                    url : "{{route('getdesa')}}",
                    data : {id_kecamatan:id_kecamatan},
                    cache : false,

                    success: function(msg){
                        $('#desa').removeAttr('disabled');
                        $('#desa').html(msg);
                       
                        
                    },
                    error: function(data) {
                        console.log('error:',data)
                    },
                })
            })
        })
    });
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