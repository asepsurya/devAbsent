@extends('layout.main')
@section('container')
{{-- header --}}
<div class="d-md-flex d-block align-items-center justify-content-between mb-3 border-bottom">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1">{{ $title }}</h3>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Beranda</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Profile Saya</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">

    </div>
</div>
@foreach ($user as $item )
    @if(auth()->user()->role == "siswa")
        @php  $relation = 'student';$img ='foto'; @endphp
    @elseif (auth()->user()->role == "guru")
         @php $relation = 'gtk'; $img ='gambar'; @endphp
    @elseif (auth()->user()->role == "walikelas")
         @php $relation = 'gtk'; $img ='gambar'; @endphp
    @elseif (auth()->user()->role == "admin")
         @php $relation = 'gtk'; $img ='gambar'; @endphp
    @endif

    <div class="d-md-flex d-block mt-3">
        <div class="settings-right-sidebar me-md-3 border-0">
            <div class="card">
                <div class="card-header">
                    <h5>Personal Information</h5>
                </div>
                <div class="card-body">
                    <div class="settings-profile-upload p-3" >
                        <span class="profile-pic">

                        @if($item->$relation->$img)
                            <img src="/storage/{{ $item->$relation->$img }}"  alt="foto"  >
                        @else
                            <img src="{{ asset('asset/img/user-default.jpg') }}"  alt="foto">
                        @endif
                        </span>
                    <form action="{{ route('imageProfile') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="title-upload">
                            <h5>Edit Your Photo</h5>
                            <a href="#" class="me-2">Delete </a>
                            <a href="#" class="text-primary" id="ubahfoto">Update</a>
                            <input type="submit" class=" btn text-primary" value="Update" id="submitfoto">
                        </div>
                    </div>
                    <div class="profile-uploader profile-uploader-two mb-0" id="form-input">
                        <span class="upload-icon"><i class="ti ti-upload"></i></span>
                        <div class="drag-upload-btn bg-transparent me-0 border-0">
                            <p class="upload-btn"><span>Click to Upload</span> or drag and drop
                            </p>
                            <h6>JPG or PNG</h6>
                            <h6>(Max 450 x 450 px)</h6>
                        </div>
                        <input type="text" name="oldImage" value="{{ $item->$relation->$img }}" hidden>
                        <input type="text" name="id" value="{{ $item->nomor }}" hidden>
                        @if(auth()->user()->role == "walikelas" || auth()->user()->role == "guru" )
                            <input type="file" name="gambar" class="form-control"  id="image_sign" required>
                        @else
                            <input type="file" name="foto" class="form-control"  id="image_sign" required>
                        @endif
                        <div id="frames"></div>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <div class="flex-fill ps-0 border-0">

                <div class="d-md-flex">
                    <div class="flex-fill">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5>Personal Information</h5>

                            </div>
                            <div class="card-body">
                                <div class="d-block d-xl-flex">
                                    <div class="mb-3 flex-fill me-xl-3 me-0">
                                        <label class="form-label">ID</label>
                                        <input type="text" class="form-control" placeholder="Enter First Name" readonly value="{{ $item->nomor }}" disabled>
                                    </div>
                                    <div class="mb-3 flex-fill">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" placeholder="Enter Last Name" value="{{ $item->nama }}" disabled>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="email" class="form-control" placeholder="Enter Email" value="{{ $item->email }}" disabled>
                                </div>
                                <div class="d-block d-xl-flex">
                                    <div class="mb-3 flex-fill me-xl-3 me-0">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <input type="email" class="form-control" placeholder="Enter User Name" value="{{ $item->$relation->gender == "L" ? 'Laki - Laki' : 'Perempuan' }}" disabled>
                                    </div>
                                    <div class="mb-3 flex-fill">
                                        <label class="form-label">Tanggal Lahir</label>
                                        <input type="email" class="form-control" placeholder="Enter Phone Number" value="{{ $item->$relation->tanggal_lahir }}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('profileUpdate') }}" method="post">
                            @csrf
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5>Address Information</h5>
                                <a class="btn btn-primary btn-sm" id="edit" ><i class="ti ti-edit me-2"></i>Edit</a>
                                <a class="btn btn-primary btn-sm" id="batal" ><i class="ti ti-edit me-2"></i>Batal</a>
                            </div>
                            <div class="card-body">
                                <input type="text" name="id" value="{{ $item->nomor }}" hidden>
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Enter Address" value="{{ $item->$relation->alamat }}">
                                </div>
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label class="form-label">Provinsi</label>
                                        <select name="id_provinsi" id="provinsi2" class=" select2 @error('id_provinsi') is-invalid @enderror">
                                            <option value="">Pilih Provinsi</option>
                                            @foreach ($provinsi as $p)
                                            <option value="{{ $p->id }}" {{ $item->$relation->id_provinsi == $p->id ? 'selected' : ''
                                                }}>{{ $p->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('id_provinsi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Kota/Kabupaten</label>
                                        <select name="id_kota" id="kabupaten2"
                                            class="select2  @error('id_kota') is-invalid @enderror" >
                                            @if($item->$relation->id_kota)
                                            <option value="{{ $item->$relation->id_kota }}" selected >{{ $item->$relation->kota->name }}</option>
                                            @endif
                                        </select>
                                        @error('id_kota')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row g-3 mt-1">
                                    <div class="col-sm-6">
                                        <label
                                        class="form-label  @error('id_kecamatan') is-invalid @enderror">Kecamatan</label>
                                    <select name="id_kecamatan" id="kecamatan2" class=" select2">
                                        @if($item->$relation->id_kecamatan)
                                        <option value="{{ $item->$relation->id_kecamatan }}" selected>{{ $item->$relation->kecamatan->name }}</option>
                                        @endif
                                    </select>
                                    @error('id_kecamatan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Kelurahan/Desa</label>
                                        <select name="id_desa" id="desa2"
                                            class=" select2 @error('id_desa') is-invalid @enderror" >
                                            @if($item->$relation->id_desa )
                                            <option value="{{ $item->$relation->id_desa }}">{{ $item->$relation->desa->name }}</option>
                                            @endif
                                        </select>
                                        @error('id_desa')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <button class="btn btn-primary w-100" id="submit">Simpan</button>
                                </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

        </div>
    </div>

    {{-- Modal --}}

    @endforeach
    @section('javascript')
    <script>
        $('.select2').select2();
       document.getElementById("submitfoto").hidden = true;
       document.getElementById("form-input").hidden = true;
       document.getElementById("alamat").disabled = true;
       document.getElementById("provinsi2").disabled = true;
       document.getElementById("kabupaten2").disabled = true;
       document.getElementById("kecamatan2").disabled = true;
       document.getElementById("desa2").disabled = true;
       document.getElementById("batal").hidden = true;
       document.getElementById("submit").hidden = true;
       $("#edit").click(function(){
            document.getElementById("alamat").disabled = false;
            document.getElementById("provinsi2").disabled = false;
            document.getElementById("kabupaten2").disabled = false;
            document.getElementById("kecamatan2").disabled = false;
            document.getElementById("desa2").disabled = false;
            document.getElementById("batal").hidden = false;
            document.getElementById("edit").hidden = true;
            document.getElementById("submit").hidden = false;
       });
       $("#batal").click(function(){
        document.getElementById("alamat").disabled = true;
       document.getElementById("provinsi2").disabled = true;
       document.getElementById("kabupaten2").disabled = true;
       document.getElementById("kecamatan2").disabled = true;
       document.getElementById("desa2").disabled = true;
       document.getElementById("batal").hidden = true;
       document.getElementById("edit").hidden = false;
       document.getElementById("submit").hidden = true;

       });
       $("#ubahfoto").click(function(){
        document.getElementById("submitfoto").hidden = false;
        document.getElementById("form-input").hidden = false;
        document.getElementById("ubahfoto").hidden = true;
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
    @endsection
@endsection
