<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="shortcut icon" type="image/x-icon"
        href="https://preskool.dreamstechnologies.com/html/template/assets/img/favicon.png">
    <script src="{{ asset('asset/js/lightDark.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
    <link rel="stylesheet" href="{{ asset('asset/css/boostrap.min.css') }}">
    <script src="{{ asset('asset/js/jquery.js') }}"></script>
    {{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.2/feather.min.js"
        integrity="sha512-zMm7+ZQ8AZr1r3W8Z8lDATkH05QG5Gm2xc6MlsCdBz9l6oE8Y7IXByMgSm/rdRQrhuHt99HAYfMljBOEZ68q5A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/iconfont/tabler-icons.min.css">
    <link rel="stylesheet" href="{{ asset('asset/css/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('asset/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
</head>
<body>
    <body class="account-page">
        <div class="main-wrapper">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-7">
                        {{-- <form action="login-3.html"> --}}
                            <div class="d-flex flex-column justify-content-between vh-100">
                                <div class=" mx-auto p-4 text-center">

                                </div>
                                <div class="card">
                                    <div class="card-body p-4">
                                        <img src="{{ asset('asset/img/logo.png') }}" class="img-fluid" alt="Logo"
                                            width="100">
                                        <div class=" mb-4">
                                            <h2 class="mb-2">Mendaftar Akun Baru</h2>
                                            <p class="mb-0">Masukan Indentitas kamu sesuai form yang tersedia</p>
                                        </div>
                                       
                                        <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded mb-3" role="tablist">
                                            <li class="nav-item" role="presentation"><a class="nav-link active"
                                                    href="#solid-rounded-tab1" data-bs-toggle="tab" aria-selected="true"
                                                    role="tab"><span class="ti ti-users"></span> Mendaftar sebagai Siswa</a></li>
                                            <li class="nav-item" role="presentation"><a class="nav-link"
                                                    href="#solid-rounded-tab2" data-bs-toggle="tab"
                                                    aria-selected="false" role="tab" tabindex="-1"><span class="ti ti-school"></span> Mendaftar sebagai
                                                    Guru</a></li>

                                        </ul>

                                        @if ($errors->any())
                                        <div class="alert alert-danger border border-danger my-2 p-3">
                                            <div class="d-flex align-items-start">
                                                <div class="me-2">
                                                    <i class="ti ti-exclamation-circle flex-shrink-0"></i>
                                                </div>
                                                <div class="text-danger w-100">
                                                    <div class="fw-semibold d-flex justify-content-between">Mohon Diperhatikan<button type="button" class="btn-close p-0" data-bs-dismiss="alert" aria-label="Close"><i
                                                                class="ti ti-x"></i></button></div>
                                                             @foreach ($errors->all() as $error)
                                                                <div>{{$error}}</div>
                                                            @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="tab-content">
                                            <div class="tab-pane active show" id="solid-rounded-tab1" role="tabpanel">
                                                <form action="{{ route('registerInput') }}" method="post">
                                                    @csrf
                                                    <div class="mt-4 " id="sectionOne">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-2">
                                                                    <label class="form-label">Nomor Induk Siswa</label>
                                                                    <input type="text" class="form-control @error('nis') is-invalid @enderror"
                                                                        placeholder="Nomor Induk Siswa" name="nis" value="{{ old('nis') }}" 
                                                                        id="nis" maxlength="10"  onkeypress="return onlyNumberKey(event)">
                                                                        @error('nis')
                                                                        <div class="invalid-feedback">
                                                                            {{ $message }}
                                                                        </div>
                                                                        @enderror
                                                                </div>
                                                                <div class="mb-2">
                                                                    <label class="form-label">Tempat Lahir</label>
                                                                    <input type="text" value="{{ old('tempat_lahir') }}" class="form-control @error('tempat_lahir') is-invalid @enderror"
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
                                                                        <option value="1" {{ old('gender') == 1 ? 'selected' : '' }}>Laki - Laki</option>
                                                                        <option value="2" {{ old('gender') == 2 ? 'selected' : '' }}>Perempuan</option>
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
                                                                    <input type="text" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror"
                                                                        placeholder="Nama Lengkap Kamu" name="nama"
                                                                        id="nama" >
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
                                                                        <input type="text" placeholder="Tanggal Lahir" class="form-control datetimepicker @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir') }}" name="tanggal_lahir" >
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
                                                                        <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                                                        <option value="Kristen"{{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                                                        <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                                                        <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                                                        <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                                                        <option value="Khonghucu" {{ old('agama') == 'Khonghucu' ? 'selected' : '' }}>Khonghucu</option>
                                                                    </select>
                                                                    @error('agama')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="my-3 ">
                                                                <a class="btn btn-primary w-100"
                                                                    id="sectionOneBtn" >Berikutnya <span
                                                                        class="ti ti-arrow-narrow-right"></span></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-4 " id="sectionTwo">
                                                        <div class="col">
                                                            <div class="mb-2">
                                                                <label class="form-label">Alamat</label>
                                                                <input type="text" value="{{ old('alamat') }}" class="form-control @error('alamat') is-invalid @enderror"
                                                                    placeholder="Ex : Jl.Pegangsaan Rt.02 Rw.04"
                                                                    name="alamat" id="alamat" >
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
                                                                                <option value="{{ $p->id }}"{{ old('id_provinsi') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
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
                                                                    <label class="form-label  @error('id_kecamatan') is-invalid @enderror">Kecamatan</label>
                                                                    <select name="id_kecamatan" id="kecamatan"
                                                                        class="form-control select2"></select>
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
                                                            <div class="my-3 ">
                                                                <a class="btn btn-primary w-100"
                                                                    id="sectionTwoBtn">Berikutnya <span
                                                                        class="ti ti-arrow-narrow-right"></span></a>
                                                                <div class="mt-2">
                                                                    <a class="btn btn-outline-light w-100"
                                                                        id="sectionbackOne"><span
                                                                            class="ti ti-arrow-narrow-left"></span>
                                                                        Kembali
                                                                </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-4 " id="sectionThree">
                                                        <div class="mb-2">
                                                            <label class="form-label">Email</label>
                                                            <div class="input-icon mb-3 position-relative">
                                                                <span class="input-icon-addon">
                                                                    <i class="ti ti-mail"></i>
                                                                </span>
                                                                <input type="email" value="{{ old('email') }}" placeholder="example@mail.com" class="form-control @error('email') is-invalid @enderror"  name="email" id="email">
                                                                @error('email')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div>
                                                          
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="form-label">Password</label>
                                                            <div class="pass-group mb-3">
                                                                <input type="password" placeholder="Masukan Password" class="pass-input form-control  @error('password') is-invalid @enderror" name="password" id="password">
                                                                <span class="ti toggle-password ti-eye-off"></span>
                                                                @error('password')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                                @enderror
                                                                
                                                            </div>
                                                          
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="form-label">Masukan Ulang Password</label>
                                                            <div class="pass-group mb-3">
                                                                <input type="password" placeholder="Masukan Ulang Password" class="pass-input form-control @error('Cpassword') is-invalid @enderror" name="Cpassword" id="Cpassword">
                                                                <span class="ti toggle-password ti-eye-off"></span>
                                                                @error('Cpassword')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div>
                                                         
                                                        </div>
                                                        <button type="submit" class="btn btn-primary w-100">Mendaftar
                                                            <span class="ti ti-arrow-narrow-right"></span></button>

                                                        <div class="my-2">
                                                            <a class="btn btn-outline-light w-100"
                                                                id="sectionbackTwo"><span
                                                                    class="ti ti-arrow-narrow-left"></span> Kembali
                                                        </a>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane" id="solid-rounded-tab2" role="tabpanel">
                                                Tab content 2 --
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <h6 class="fw-normal text-dark mb-0">Sudah mempunyai akun?<a href="/login"
                                                    class="hover-a "> Masuk</a>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 text-center">
                                    <p class="mb-0 ">Copyright © 2024 - Absensi Sakti</p>
                                </div>
                            </div>
                            {{--
                        </form> --}}
                    </div>
                </div>
            </div>
        </div>
       
        <script src="{{ asset('asset/js/bootstrap.bundle.min.js') }}" type="d8aa163ebe66f835399f615d-text/javascript">
        </script>

       
        <script src="{{ asset('asset/js/jquery.slimscroll.min.js') }}" type="d8aa163ebe66f835399f615d-text/javascript">
        </script>
        <script src="{{ asset('asset/js/owl.carousel.min.js') }}" type="d8aa163ebe66f835399f615d-text/javascript">
        </script>
        <script src="{{ asset('asset/Plugins/select2/js/select2.min.js') }}"
            type="d8aa163ebe66f835399f615d-text/javascript"> </script>
        <script src="{{ asset('asset/js/rocket-loader.min.js') }}" data-cf-settings="d8aa163ebe66f835399f615d-|49"
            defer></script>
        <script src="{{ asset('asset/Plugins/countup/jquery.counterup.min.js') }}"
            type="d8aa163ebe66f835399f615d-text/javascript"></script>
        <script src="{{ asset('asset/Plugins/countup/jquery.waypoints.min.js') }}"
            type="d8aa163ebe66f835399f615d-text/javascript"></script>

            <script src="{{ asset('asset/js/moment.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
            <script src="{{ asset('asset/js/feather.min.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
            <script src="{{ asset('asset/Plugins/daterangepicker/daterangepicker.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
            <script src="{{ asset('asset/js/bootstrap-datetimepicker.min.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
        <script src="{{ asset('asset/js/script.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
          {{-- Regency --}}
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
        </script>
        <script>
            $("#sectionTwo").hide();
            $("#sectionThree").hide();
            $("#sectionOneBtn").click(function(){
                var nis=$("#nis").val();
                var nama=$("#nama").val();
                var gender=$("#gender").val();
                var tempat_lahir=$("#tempat_lahir").val();
                var tanggal_lahir=$("#tanggal_lahir").val();
                var agama=$("#agama").val();
                if (nis=="" || nama=="" || gender =="" || tempat_lahir =="" || tanggal_lahir =="" || agama ==""){
                    alert("Isi data dengan lengkap");             
                }else{
                    $("#sectionOne").hide();  
                    $("#sectionTwo").show();  
                }
               
           }); 
            $("#sectionTwoBtn").click(function(){
                var alamat=$("#alamat").val();
                var provinsi=$("#provinsi").val();
                var kota=$("#kota").val();
                var kecamatan=$("#kecamatan").val();
                var desa=$("#desa").val();
                if (alamat=="" || provinsi=="" || kota =="" || desa =="" || kecamatan ==""){
                    alert("Isi data dengan lengkap");             
                }else{
                    $("#sectionOne").hide();  
                    $("#sectionTwo").hide(); 
                    $("#sectionThree").show();   
                }
              
           }); 
        //    tombol Back
        $("#sectionbackOne").click(function(){
            $("#sectionOne").show();  
            $("#sectionTwo").hide();  
        }); 
        $("#sectionbackTwo").click(function(){ 
            $("#sectionTwo").show();  
            $("#sectionThree").hide();  
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
    </body>
</body>

</html>