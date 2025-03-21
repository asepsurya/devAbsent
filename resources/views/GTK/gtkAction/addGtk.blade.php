@extends('layout.main')
@section('container')
{{-- header --}}
<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1"><span class="ti ti-user-plus"></span> {{ $title }}</h3>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Beranda</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('GTKall') }}">Data Guru dan Tenaga Kependidikan</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Guru dan Tenaga Kependidikan </li>
            </ol>
        </nav>
    </div>
    <form action="{{ route('GTKadd') }}" method="post">
        @csrf
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
        <div class="pe-1 mb-2">
            <a href="{{ route('GTKall') }}" type="button" class="btn btn-outline-light bg-white  me-1" >
              <span class="ti ti-arrow-left"></span>  Kembali
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

<div class="" id="sectionOne">
    <div class="alert alert-primary overflow-hidden p-0" role="alert">
        <div class="p-3 bg-primary text-fixed-white d-flex justify-content-between">
            <h6 class="aletr-heading mb-0 text-fixed-white"><span class="ti ti-info-circle "> </span>Informasi Singkat
            </h6>

        </div>
        <hr class="my-0">
        <div class="p-3">
            <p class="mb-2">
                Berikut informasi singkat mengenai halaman saat ini, antara lain :</p>
                <li>Ketika data ditambahkan akan secara otomatis <b>Status : Aktif</b></li>
                <li>Untuk Informasi <u>Authentikasi</u> Data Guru dan Tenaga Kependidikan untuk menggunakan aplikasi anda bisa memasukan data sebagai Berikut :</li>
                <li>Username/Email : <u><b>Menggunakan Email dibawah Form ini</b></u></li>
                <li>Password : <u><b>Menggunakan nomor NIK/ No. KITAS (Untuk WNA)</b></u></li>

           <p class="mt-2">Isi form data dibawah ini bersarkan form yang tersedia </p>

        </div>
    </div>
    <div class="col">
        <div class="mb-2">
            <label class="form-label">NIK/ No. KITAS (Untuk WNA) <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nik') is-invalid @enderror"
                    placeholder="Nomor Induk Kependudukan" name="nik" value="{{ old('nik') }}" id="nik"
                    onkeypress="return onlyNumberKey(event)" required maxlength="16">
                @error('nik')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="mb-2">
                <label class="form-label"> Nomor NIP </label>
                <input type="text" class="form-control @error('nip') is-invalid @enderror"
                    placeholder="Nomor Induk Pegawai Sipil " name="nip" value="{{ old('nip') }}" id="nip"
                    onkeypress="return onlyNumberKey(event)" >
                @error('nip')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-2">
                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
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
                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                <select name="gender" id="gender"
                    class="form-control select2 @error('gender') is-invalid @enderror" required>

                    <option value="L" {{ old('gender')=='L' ? 'selected' : '' }}>Laki - Laki</option>
                    <option value="P" {{ old('gender')=='P' ? 'selected' : '' }}>Perempuan</option>
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
                <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                <input type="text" value="{{ old('tempat_lahir') }}"
                    class="form-control @error('tempat_lahir') is-invalid @enderror"
                    placeholder="Tasikmalaya" name="tempat_lahir" required>
                @error('tempat_lahir')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-2">
                <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                <div class="input-icon position-relative">
                    <span class="input-icon-addon">
                        <i class="ti ti-calendar"></i>
                    </span>
                    <input type="text" placeholder="Tanggal Lahir"
                        class="form-control datetimepicker @error('tanggal_lahir') is-invalid @enderror"
                        value="{{ old('tanggal_lahir') }}" name="tanggal_lahir" required>
                    @error('tanggal_lahir')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="mb-2">
                <label class="form-label">Agama <span class="text-danger">*</span></label>
                <select name="agama" id="agama"
                    class="form-control select2 @error('agama') is-invalid @enderror" required>

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
    <div class="col">
        <label class="form-label">Nomor Telepon (WhatsApp) <span class="text-danger">*</span></label>
        <input type="text" value="{{ old('telp') }}"
            class="form-control @error('telp') is-invalid @enderror" placeholder="Telepon"
            name="telp" id="telp"   required>
        @error('telp')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>
<div class="mt-4 " id="sectionTwo">

    <div class="mb-2">
        <label class="form-label">Jenis GTK <span class="text-danger">*</span></label>
        <select name="jns_gtk" id="jenis_gtk"
            class="form-control  @error('jns_gtk') is-invalid @enderror select2" required>
            @foreach ($jnsGTK as $item )
            <option value="{{ $item->id }}">{{ $item->nama }}</option>
            @endforeach
        </select>
        @error('jns_gtk')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="col">
        <div class="mb-2">
            <label class="form-label">Alamat <span class="text-danger">*</span></label>
            <input type="text" value="{{ old('alamat') }}"
                class="form-control @error('alamat') is-invalid @enderror"
                placeholder="Contoh : Jl.Pegangsaan RT.02 RW.04" name="alamat" id="alamat" required>
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
                <label class="form-label">Provinsi </label>
                <select name="id_provinsi" id="provinsi"
                    class="form-control select2 @error('id_provinsi') is-invalid @enderror" required>
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
                <label class="form-label">Kota/Kabupaten </label>

                <select name="id_kota" id="kabupaten"
                    class="form-control select2  @error('id_kota') is-invalid @enderror" required>

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
                <label
                    class="form-label  @error('id_kecamatan') is-invalid @enderror">Kecamatan </label>
                <select name="id_kecamatan" id="kecamatan" class="form-control select2" required></select>
                @error('id_kecamatan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-2">
                <label class="form-label">Kelurahan/Desa </label>
                <select name="id_desa" id="desa"
                    class="form-control select2 @error('id_desa') is-invalid @enderror" required></select>
                @error('id_desa')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="col">
            <div class="mb-2">
                <label class="form-label">Email<span class="text-danger">*</span></label>
                <input type="email" value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror"
                    placeholder="mail@example.com" name="email" id="email" required>
                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-2">
                <input type="text" name="status" value="1" hidden>
            </div>
        </div>
    </div>
</div>
</form>
@section('javascript')
<script>

    $(function(){
      //2. Получить элемент, к которому необходимо добавить маску
      $("#telp").val('+62');

    });
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
    $(".select2").select2();
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
