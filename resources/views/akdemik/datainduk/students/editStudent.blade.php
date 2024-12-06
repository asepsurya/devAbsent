@extends('layout.main')
@section('css')
 <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.9.4/lottie.min.js"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
 <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
 <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>

 @endsection
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
<div class="row">
    <div class="col-lg-9">
        <div  id="sectionOne">
            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-2">
                        <input type="text" value="{{ $item->id }}" name="id" hidden >
                        <label class="form-label">Nomor Induk Siswa</label>
                        <input type="text" class="form-control @error('nis') is-invalid @enderror"
                            placeholder="Nomor Induk Siswa" name="nis" value="{{ $item->nis }}" id="nis" maxlength="10"
                            onkeypress="return onlyNumberKey(event)" >
                        <input name="old_nis" value="{{ $item->nis }}" hidden >
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
                            <option value="L" {{ $item->gender== 'L' ? 'selected' : '' }}>Laki - Laki</option>
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
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" value="{{ $item->nama }}" class="form-control @error('nama') is-invalid @enderror"
                            placeholder="Nama Lengkap Siswa" name="nama" id="nama" required>
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
                                value="{{ $item->tanggal_lahir }}" name="tanggal_lahir" required>
                            @error('tanggal_lahir')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Agama</label>
                        <select name="agama" id="agama" class="form-control select 2 @error('agama') is-invalid @enderror" required>
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

                <div class="mb-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control select2 @error('status') is-invalid @enderror">
                        <option value="1" {{ $item->status =='1' ? 'selected' : '' }}>Aktif</option>
                        <option value="2" {{ $item->status =='2' ? 'selected' : '' }}>Tidak Aktif</option>
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
    </div>
    <div class="col-lg-3">
        <div class="alert alert-primary overflow-hidden p-0" role="alert">
            <div class="p-3 bg-primary text-fixed-white d-flex justify-content-between">
                <h6 class="aletr-heading mb-0 text-fixed-white">Foto Siswa
                </h6>
            </div>
            <hr class="my-0">
            <div class="p-3">
                <div class="row">
                    <div class="d-flex justify-content-center my-2">
                    @if ($item->foto)
                        <a href="/storage/{{ $item->foto }}" data-lightbox="image-{{ $item->id }}" data-title="Profile Photo">
                            <img src="/storage/{{ $item->foto }}" class="avatar avatar-xxxl" alt="foto">
                        </a>
                        @else
                        <img src="{{ asset('asset/img/user-default.jpg') }}" class="avatar avatar-xxxl me-4 avatar-rounded" alt="foto">
                    @endif

                    </div>
                    <div class="d-flex justify-content-center">
                        <a class="btn btn-outline-light bg-white mt-3 " data-toggle="modal" data-target="#fileUploadModal"><span class="ti ti-upload"></span>Change Image</a>
                        {{-- <label for="form-label">Foto</label> --}}
                        {{-- <input type="file" class="form-control" name="foto2"> --}}
                        <input type="text" name="oldImage" value="{{ $item->foto }}" hidden>
                    </div>

                </div>
            </div>
        </div>

        <div class="alert alert-primary overflow-hidden p-0" role="alert">
            <div class="p-3 bg-primary text-fixed-white d-flex justify-content-between">
                <h6 class="aletr-heading mb-0 text-fixed-white">RFID Card
                </h6>

            </div>
            <hr class="my-0">
            <div class="p-3">
                <div class="row">
                    <div class="my-3">
                        <label for="form-label">RFID</label>
                        <select name="id_rfid" id="id_rfid" class="form-control select2">
                             @if($item->id_rfid == "")
                            <option value=""selected>-- Pilih RFID yang tersedia --</option>
                            @else
                            <option value="{{ $item->id_rfid }}" selected>{{ $item->id_rfid }}</option>
                            @endif
                            @foreach ($rfid as $item2 )
                                <option value="{{ $item2->id_rfid }}" {{ $item2->id_rfid == request('key') ?'selected' : '' }}>{{ $item2->id_rfid }}</option>
                            @endforeach
                        </select>
                        <!-- Button trigger modal -->
                        <input name="old_rfid" value="{{ $item->id_rfid }}" hidden>
                        <a type="button" class="btn btn-outline-light bg-white mt-3" data-toggle="modal" data-target="#exampleModalCenter">
                            <span class="ti ti-nfc"></span> Scan RFID
                        </a>

                        {{-- <a href="exampleModal" class="btn btn-outline-light bg-white" data-toggle="modal" data-target="#exampleModal" ><span class="ti ti-nfc"></span> Scan RFID</a> --}}
                    </div>
                </div>
            </div>
        </div>
            <div class="alert alert-primary overflow-hidden p-0" role="alert">
                <div class="p-3 bg-primary text-fixed-white d-flex justify-content-between">
                    <h6 class="aletr-heading mb-0 text-fixed-white">Barcode for Absent
                    </h6>

                </div>
                <hr class="my-0">
                <div class="p-3 d-flex justify-content-center">
                    {!! QrCode::size(150)->generate($item->nis) !!}
                </div>
                <div class="d-flex justify-content-center">
                    {{-- <a href="{{ route('qr.download', ['code' => $item->nis]) }}" class="btn btn-primary">
                        Download QR Code
                    </a> --}}
                    {{-- <a type="button" href="{{ route('barcode.download', ['code' => $item->nis]) }}" class="btn btn-outline-light bg-white mt-3">
                        <span class="ti ti-download"></span> Download Code
                    </a> --}}
                </div>
            </div>


    </div>
</form>

<!-- Modal for Image Upload -->
<div class="modal fade" id="fileUploadModal" tabindex="-1" aria-labelledby="fileUploadModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="fileUploadModalLabel">Upload Foto Profile</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="studentForm" action="{{ route('dataIndukStudentfoto') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="text" value="{{ $id }}" name="id" hidden >
                <input type="text" name="oldImage" value="{{ $item->foto }}"  hidden>
                <input type="hidden" name="croppedFoto" id="croppedFoto"> <!-- Cropped Base64 image -->

                <label for="image-input">Upload Photo:</label>
                <input type="file" id="image-input" accept="image/*" class="form-control">

                <img id="preview" style="display:none; max-width:700px;" alt="Preview">
                <div id="loading-indicator" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.8); z-index: 9999; text-align: center; line-height: 100vh;">
                    <span class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></span>
                    <p>Uploading...</p>
                </div>
                <div class="buttons mt-2">
                  <button type="button" class="btn btn-primary" id="crop-btn" style="display: none;"><span class="ti ti-crop"></span> Crop</button>
                  <button type="submit" class="btn btn-primary" id="submit-btn" disabled><span class="ti ti-device-floppy"></span> Save</button>
                </div>
              </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endforeach

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><i>Waiting... Scan the card using the device.</i></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="GET">
          <div class="modal-body m-0 p-0 ">
              <div class="alert-primary p-4">
                  <div class=" ">
                      <h4 class="mb-2">RFID Scanner</h4>
                      <!-- RFID Input Box -->
                      <input id="rfid-input" name="key" placeholder="Scan your RFID card" autofocus class="form-control" readonly>
                      <button id="submit-rfid"  class="btn btn-primary  mt-3 w-100" style="margin-top: 10px;">Pilih</button>
                      <br>
                      <small> Jika data ini sudah terisi, maka data RFID tersebut belum terikat atau tertaut berdasarkan data terakhir yang diinput.</small>
                      <div id="response"></div> <!-- Area to show server response -->
                  </div>
              </div>

              <div class="d-flex justify-content-center">
                  <div id="anime-lottie"></div>
              </div>
          </div>
      </form>
    </div>
  </div>
</div>


@section('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
<script>
    document.getElementById('studentForm').addEventListener('submit', function () {
        document.getElementById('loading-indicator').style.display = 'block';
        document.getElementById('submit-btn').disabled = true;
    });
</script>
<!-- Custom JS for Dropzone and Cropper -->
<script>
const imageInput = document.getElementById('image-input');
const preview = document.getElementById('preview');
const cropBtn = document.getElementById('crop-btn');
const submitBtn = document.getElementById('submit-btn');
const croppedFotoInput = document.getElementById('croppedFoto');
let cropper;

// Handle image input change
imageInput.addEventListener('change', (e) => {
  const file = e.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = () => {
      preview.src = reader.result;
      preview.style.display = 'block';
      cropBtn.style.display = 'inline';
      submitBtn.disabled = true;

      // Initialize cropper
      if (cropper) cropper.destroy();
      cropper = new Cropper(preview, {
        aspectRatio: 463 / 451, // Set aspect ratio for the desired dimensions
        viewMode: 1,            // Restrict crop box within the canvas
        autoCropArea: 1         // Maximize the crop box within the canvas
      });
    };
    reader.readAsDataURL(file);
  }
});

// Handle cropping
cropBtn.addEventListener('click', () => {
  const canvas = cropper.getCroppedCanvas({
    width: 463,  // Set width to 463px
    height: 451, // Set height to 451px
  });

  // Convert to Blob and Base64
  canvas.toBlob((blob) => {
    const reader = new FileReader();
    reader.onloadend = () => {
      croppedFotoInput.value = reader.result; // Base64 data for form
      preview.src = reader.result;
      cropper.destroy();
      cropBtn.style.display = 'none';
      submitBtn.disabled = false;
    };
    reader.readAsDataURL(blob);
  }, 'image/jpeg', 1.0); // Set image quality to 100%
});

</script>
<script>
    // Load the Lottie Animation
    lottie.loadAnimation({
      container: document.getElementById('anime-lottie'), // The container where animation will be rendered
      renderer: 'svg', // Render as SVG
      loop: true, // Make it loop
      autoplay: true, // Play automatically
      path: '{{ asset('/asset/img/rfid.json') }}' // Example Lottie animation path (replace with your JSON URL)
    });
  </script>
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


<script>
    let id_rfid = $('#rfid-input').val();
    function refreshdata() {
          $.ajax({
            url: "{{ route('processRfid') }}",
            method: "GET",
            cache: false,
            data: { id_rfid: id_rfid },
            success: function (data) {
                $('#rfid-input').val(data);
            }
        });
    }
    setInterval(refreshdata, 2000);
    </script>
@endsection

@endsection
