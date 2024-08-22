@extends('layout.main')
@section('container')
{{-- header --}}
<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1"><span class="ti ti-pencil-plus"></span> {{ $title }}</h3>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Beranda</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/akademik/datainduk/student">Data Peserta Didik</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Peserta Didik</li>
            </ol>
        </nav>
    </div>
    <form action="{{ route('dataIndukStudentEdit') }}" method="post" enctype="multipart/form-data">
        @csrf
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
        <div class="pe-1 mb-2">
            <a href="{{ route('dataIndukStudent') }}" type="button" class="btn btn-outline-light bg-white  me-1" >
                Kembali
            </a>
        </div>
        <div class="mb-2">
            <button href="#" class="btn btn-primary d-flex align-items-center" data-bs-effect="effect-scale"
                ><i
                    class="ti ti-square-rounded-plus me-2"></i>Simpan Data</button>
        </div>
    </div>
</div>
{{-- End Header --}}
@foreach ($students as $item )

<div  id="sectionOne">
    <div class="alert alert-primary overflow-hidden p-0" role="alert">
        <div class="p-3 bg-primary text-fixed-white d-flex justify-content-between">
            <h6 class="aletr-heading mb-0 text-fixed-white">Informasi Data Peserta Didik
            </h6>

        </div>
        <hr class="my-0">
        <div class="p-3">
            <div class="row">
                <div class="d-flex justify-content-center my-2">
                    @if ($item->foto)
                    <img src="/storage/{{ $item->foto }}" class="avatar avatar-xxxl me-4 avatar-rounded" alt="foto">
                    @else
                    <img src="{{ asset('asset/img/user-default.jpg') }}" class="avatar avatar-xxxl me-4 avatar-rounded" alt="foto">
                    @endif

                </div>
                <div class="col-xxl-2">
                    <label for="form-label">Foto</label>
                    <input type="file" class="form-control" name="foto">
                    <input type="text" name="oldImage" value="{{ $item->foto }}" hidden>
                    <div class="mt-2">
                        <label for="form-label">RFID</label>
                        <select name="id_rfid" id="id_rfid" class="form-control select2">
                            <option value="1" selected>1</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="mb-2">
                <input type="text" value="{{ $item->id }}" name="id" hidden >
                <label class="form-label">Nomor Induk Siswa</label>
                <input type="text" class="form-control @error('nis') is-invalid @enderror"
                    placeholder="Nomor Induk Siswa" name="nis" value="{{ $item->nis }}" id="nis" maxlength="10"
                    onkeypress="return onlyNumberKey(event)">
                @error('nis')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-2">
                <label class="form-label">Tempat Lahir</label>
                <input type="text" value="{{ $item->tempat_lahir }}"
                    class="form-control @error('tempat_lahir') is-invalid @enderror" placeholder="Tasikmalaya"
                    name="tempat_lahir">
                @error('tempat_lahir')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-2">
                <label class="form-label">Jenis Kelamin</label>
                <select name="gender" id="gender" class="form-control select2 @error('gender') is-invalid @enderror">
                    <option value="" selected>- Jenis Kelamin -
                    </option>
                    <option value="1" {{ $item->gender==1 ? 'selected' : '' }}>Laki - Laki</option>
                    <option value="2" {{ $item->gender==2 ? 'selected' : '' }}>Perempuan</option>
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
                <input type="text" value="{{ $item->nama }}" class="form-control @error('nama') is-invalid @enderror"
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
                        value="{{ $item->tanggal_lahir }}" name="tanggal_lahir">
                    @error('tanggal_lahir')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="mb-2">
                <label class="form-label">Agama</label>
                <select name="agama" id="agama" class="form-control select 2 @error('agama') is-invalid @enderror">
                    <option value="" selected>- Pilih Agama -
                    </option>
                    <option value="Islam" {{ $item->agama =='Islam' ? 'selected' : '' }}>Islam
                    </option>
                    <option value="Kristen" {{ $item->agama =='Kristen' ? 'selected' : '' }}>Kristen
                    </option>
                    <option value="Katolik" {{ $item->agama =='Katolik' ? 'selected' : '' }}>Katolik
                    </option>
                    <option value="Hindu" {{ $item->agama =='Hindu' ? 'selected' : '' }}>Hindu
                    </option>
                    <option value="Buddha" {{ $item->agama =='Buddha' ? 'selected' : '' }}>Buddha
                    </option>
                    <option value="Khonghucu" {{ $item->agama =='Khonghucu' ? 'selected' : '' }}>
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
            <input type="text" value="{{ $item->alamat }}" class="form-control @error('alamat') is-invalid @enderror"
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
                <select name="id_provinsi"
                    class="form-control select2 provinsiClass @error('id_provinsi') is-invalid @enderror">
                    <option value="">Pilih Provinsi</option>
                    @foreach ($provinsi as $p)
                    <option value="{{ $p->id  }}" {{ $item->id_provinsi == $p->id ? 'selected' : ''
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
                <select name="id_kota" class="select2 kabupatenClass  @error('id_kota') is-invalid @enderror">
                   @if($item->id_kota)
                    <option value="{{ $item->id_kota }}" selected>{{ $item->kota->name }}</option>
                   @endif
                </select>
                @error('id_kota')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-2">
                <label class="form-label  @error('id_kecamatan') is-invalid @enderror">Kecamatan</label>
                <select name="id_kecamatan" class="kecamatanClass select2 ">
                    @if($item->id_kecamatan)
                    <option value="{{ $item->id_kecamatan }}" selected>{{ $item->kecamatan->name }}</option>
                    @endif
                </select>
                @error('id_kecamatan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-2">
                <label class="form-label">Kelurahan/Desa</label>
                <select name="id_desa" class="form-control select2 desaClass @error('id_desa') is-invalid @enderror">
                    @if($item->id_desa)
                    <option value="{{ $item->id_desa }}" selected>{{ $item->desa->name }}</option>
                    @endif
                </select>
                @error('id_desa')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

        </div>
        <div class="mb-3">
            <label class="form-label">RFID</label>
            <select name="id_rfid" id="id_rfid" class="form-control select2">
                <option value=""selected>-- Pilih RFID yang tersedia --</option>
                @foreach ($rfid as $item )
                    <option value="{{ $item->id }}">{{ $item->id_rfid }}</option>
                @endforeach
            </select>

        </div>
        <div class="mb-2">
            <label class="form-label">Status</label>
            <select name="status" class="form-control select2 @error('status') is-invalid @enderror">
                <option value="1" {{ $item->status =='1' ? 'selected' : '' }}>Aktif</option>
                <option value="2" {{ $item->agama =='2' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
            @error('id_desa')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="mb-2">
            <label class="form-label">Tanggal Masuk</label>
            <div class="input-icon position-relative">
                <span class="input-icon-addon">
                    <i class="ti ti-calendar"></i>
                </span>
                <input type="text" placeholder="Tanggal Masuk"
                    class="form-control datetimepicker @error('tanggal_masuk') is-invalid @enderror"
                    value="{{ $item->tanggal_masuk }}" name="tanggal_masuk">
                @error('tanggal_masuk')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
    </div>
</div>
</form>
@endforeach
@section('javascript')
<script>
    $(function(){
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });
        // $('.kabupatenClass').attr('disabled','disabled');
        // $('.kecamatanClass').attr('disabled','disabled');
        // $('.desaClass').attr('disabled','disabled');

        $(function (){
            $('.provinsiClass').on('change',function(){
                let id_provinsi = $('.provinsiClass').val();

                $.ajax({
                    type : 'POST',
                    url : "{{route('getkabupaten')}}",
                    data : {id_provinsi:id_provinsi},
                    cache : false,

                    success: function(msg){
                        $('.kabupatenClass').removeAttr('disabled');
                        $('.kabupatenClass').html(msg);
                        $('.kecamatanClass').html('');
                        $('.desaClass').html('');

                    },
                    error: function(data) {
                        console.log('error:',data)
                    },
                })
            })

            $('.kabupatenClass').on('change',function(){
                let id_kabupaten = $('.kabupatenClass').val();

                $.ajax({
                    type : 'POST',
                    url : "{{route('getkecamatan')}}",
                    data : {id_kabupaten:id_kabupaten},
                    cache : false,

                    success: function(msg){
                        $('.kecamatanClass').removeAttr('disabled');
                        $('.kecamatanClass').html(msg);
                        $('.desaClass').html('');


                    },
                    error: function(data) {
                        console.log('error:',data)
                    },
                })
            })

            $('.kecamatanClass').on('change',function(){
                let id_kecamatan = $('.kecamatanClass').val();

                $.ajax({
                    type : 'POST',
                    url : "{{route('getdesa')}}",
                    data : {id_kecamatan:id_kecamatan},
                    cache : false,

                    success: function(msg){
                        $('.desaClass').removeAttr('disabled');
                        $('.desaClass').html(msg);


                    },
                    error: function(data) {
                        console.log('error:',data)
                    },
                })
            })
        })
    });
</script>
@endsection
@endsection
