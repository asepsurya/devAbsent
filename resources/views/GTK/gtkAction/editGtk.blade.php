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
    <form action="{{ route('GTKupdate') }}" method="post" enctype="multipart/form-data" >
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
@foreach ($gtk as $item )
<div class="" id="sectionOne">
    <div class="row my-3 g-3 pb-3">
        <div class="col-lg-6">
            <div class="alert alert-primary overflow-hidden p-0" role="alert">
                <div class="p-3 bg-primary text-fixed-white d-flex justify-content-between">
                    <h6 class="aletr-heading mb-0 text-fixed-white">Foto Profile
                    </h6>

                </div>
                <div class="p-3">
                        <div class="col d-flex justify-content-center">
                            @if($item->gambar)
                                <img src="/storage/{{ $item->gambar }}" class="avatar avatar-xxxl me-4 avatar-rounded" alt="foto">
                            @else
                            <img src="{{ asset('asset/img/user-default.jpg') }}" class="avatar avatar-xxxl me-4 avatar-rounded" alt="foto">
                            @endif
                            </div>
                        <div class="row">
                            <div class="my-3">
                                <label for="form-label">Pilih Gambar</label>
                                <input type="file" name="gambar" id="gambar" class="form-control">
                             </div>
                        </div>
                        <div class="my-2">
                            <label for="form-label">RFID</label>
                            <select name="id_rfid" id="id_rfid" class="form-control select2">
                                @if($item->id_rfid == "")
                                <option value=""selected>-- Pilih RFID yang tersedia --</option>
                                @else
                                <option value="{{ $item->id_rfid }}" selected>{{ $item->id_rfid }}</option>
                                @endif
                                @foreach ($rfid as $item2 )
                                    <option value="{{ $item2->id_rfid }}" >{{ $item2->id_rfid }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button class="btn btn-outline-light bg-white"><span class="ti ti-nfc"></span> Scan RFID</button>
                </div>

            </div>

        </div>
        <div class="col-lg-6">
            <div class="alert alert-danger overflow-hidden p-0" role="alert">
                <div class="p-3 bg-danger text-fixed-white d-flex justify-content-between">
                    <h6 class="aletr-heading mb-0 text-fixed-white">List Rombongan Belajar
                    </h6>
                </div>
               <div class="p-3">
                 <table class="table bg-transparent">
                        <tbody>
                            @if($item->MapelgtkList->count())
                            @foreach ($item->MapelgtkList as $a )
                            <tr>
                                <td>
                                    {{ $a->kelas->nama_kelas }} - {{ $a->kelas->jurusanKelas->nama_jurusan }} {{ $a->mata_pelajaran->nama
                                    }}<br>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td>Data tidak ditemukan</td>
                            </tr>
                            @endif

                        </tbody>
                    </table>
               </div>
            </div>

        </div>
    </div>
    <div class="col">
        <div class="mb-2">
            <label class="form-label">NIK/ No. KITAS (Untuk WNA) <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nik') is-invalid @enderror"
                    placeholder="Nomor Induk Kependudukan" name="nik" value="{{ $item->nik }}" id="nik"
                    onkeypress="return onlyNumberKey(event)" required maxlength="16">
                @error('nik')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
        </div>
    </div>
    <div class="row">
        <input type="text" name="id" id="id" value="{{ $item->nik }}" hidden>
        <input type="text" name="oldImage" value="{{ $item->gambar }}" hidden>
        <div class="col-lg-6">
            <div class="mb-2">
                <label class="form-label"> Nomor NIP </label>
                <input type="text" class="form-control @error('nip') is-invalid @enderror"
                    placeholder="Nomor Induk Pegawai Sipil " name="nip" value="{{ $item->nip }}" id="nip"
                    onkeypress="return onlyNumberKey(event)"  >
                @error('nip')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-2">
                <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                <input type="text" value="{{ $item->tempat_lahir }}"
                    class="form-control @error('tempat_lahir') is-invalid @enderror"
                    placeholder="Tasikmalaya" name="tempat_lahir" required>
                @error('tempat_lahir')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-2">
                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                <select name="gender" id="gender2"
                    class="form-control select2 @error('gender') is-invalid @enderror" required>
                    <option value="" selected>- Jenis Kelamin -
                    </option>
                    <option value="L" {{ $item->gender =='L' ? 'selected' : '' }}>Laki - Laki</option>
                    <option value="P" {{ $item->gender== 'P' ? 'selected' : '' }}>Perempuan</option>
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
                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" value="{{ $item->nama }}"
                    class="form-control @error('nama') is-invalid @enderror"
                    placeholder="Nama Lengkap Siswa" name="nama" id="nama">
                @error('nama')
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
                        value="{{ $item->tanggal_lahir }}" name="tanggal_lahir" required>
                    @error('tanggal_lahir')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="mb-2">
                <label class="form-label">Agama <span class="text-danger">*</span></label>
                <select name="agama" id="agama2"
                    class="form-control select2 @error('agama') is-invalid @enderror" required>
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
    <div class="col">
        <label class="form-label">Nomor Telepon (WhatsApp) <span class="text-danger">*</span></label>
        <input type="text" value="{{ $item->telp }}"
            class="form-control @error('telp') is-invalid @enderror" placeholder="Telepon"
            name="telp" id="telp2" required>
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
        <select name="id_jenis_gtk" id="id_jenis_gtk"
            class="form-control select2   @error('id_jenis_gtk') is-invalid @enderror" required>

            @foreach ($jnsGTK as $item2 )
                 <option value="{{ $item2->id }}" {{ $item2->id == $item->id_jenis_gtk ? 'selected' : '' }}>{{ $item2->nama }}</option>
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
            <label class="form-label">Alamat</label>
            <input type="text" value="{{ $item->alamat }}"
                class="form-control @error('alamat') is-invalid @enderror"
                placeholder="Contoh : Jl.Pegangsaan RT.02 RW.04" name="alamat" id="alamat" >
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
                <select name="id_provinsi" id="provinsi2"
                    class="form-control select2 @error('id_provinsi') is-invalid @enderror" >
                    <option value="">Pilih Provinsi</option>
                    @foreach ($provinsi as $p)
                    <option value="{{ $p->id }}" {{ $item->id_provinsi == $p->id ? 'selected' : ''
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
                <select name="id_kota" id="kabupaten2"
                    class="form-control select2  @error('id_kota') is-invalid @enderror" >
                    @if($item->id_kota)
                    <option value="{{ $item->id_kota }}" selected >{{ $item->kota->name }}</option>
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
                <label
                    class="form-label  @error('id_kecamatan') is-invalid @enderror">Kecamatan</label>
                <select name="id_kecamatan" id="kecamatan2" class="form-control select2" >
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
                <select name="id_desa" id="desa2"
                    class="form-control select2 @error('id_desa') is-invalid @enderror" >
                    @if($item->id_desa )
                    <option value="{{ $item->id_desa }}">{{ $item->desa->name }}</option>
                    @endif
                </select>
                @error('id_desa')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="col">
            <div class="mb-2">
                <label class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" value="@if( $item->userGTK->email)  {{ $item->userGTK->email }} @endif"
                    class="form-control @error('email') is-invalid @enderror"
                    placeholder="mail@example.com" name="email" id="email" required>
                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-2">
                <label class="form-label">Status GTK <span class="text-danger">*</span></label>
               <select name="status" id="status" class="form-control select2">
                <option value="1" {{ $item->status == 1 ? 'selected' :  '' }}>Aktif</option>
                <option value="2" {{ $item->status == 2 ? 'selected' :  '' }}>Tidak Aktif</option>
               </select>
                @error('status')
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
                        class="form-control datetimepicker @error('tmt') is-invalid @enderror"
                        value="{{ $item->tanggal_masuk }}" name="tanggal_masuk" >
                    @error('tmt')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>



@endforeach
</form>
@section('javascript')
<script>
    $(function(){
        $(".select2").select2();
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

            $(function (){
                $('#provinsi2').on('change',function(){
                    let id_provinsi = $('#provinsi2').val();

                    $.ajax({
                        type : 'POST',
                        url : "{{route('getkabupaten')}}",
                        data : {id_provinsi:id_provinsi},
                        cache : false,

                        success: function(msg){
                            $('#kabupaten2').removeAttr('disabled');
                            $('#kabupaten2').html(msg);
                            $('#kecamatan2').html('');
                            $('#desa2').html('');

                        },
                        error: function(data) {
                            console.log('error:',data)
                        },
                    })
                })


                $('#kabupaten2').on('change',function(){
                    let id_kabupaten = $('#kabupaten2').val();

                    $.ajax({
                        type : 'POST',
                        url : "{{route('getkecamatan')}}",
                        data : {id_kabupaten:id_kabupaten},
                        cache : false,

                        success: function(msg){
                            $('#kecamatan2').removeAttr('disabled');
                            $('#kecamatan2').html(msg);
                            $('#desa2').html('');


                        },
                        error: function(data) {
                            console.log('error:',data)
                        },
                    })
                })

                $('#kecamatan2').on('change',function(){
                    let id_kecamatan = $('#kecamatan2').val();

                    $.ajax({
                        type : 'POST',
                        url : "{{route('getdesa')}}",
                        data : {id_kecamatan:id_kecamatan},
                        cache : false,

                        success: function(msg){
                            $('#desa2').removeAttr('disabled');
                            $('#desa2').html(msg);


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
