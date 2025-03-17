@extends('layout.main')
@section('css')
<style>
    .container {
        margin: 0px;
    }
</style>
@endsection

@section('container')
<div class="row">
    <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
        <div class="my-auto mb-2">
            <h3 class="page-title mb-1">Manajemen Import Data Siswa dan Guru</h3>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="#">Beranda</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Import Data</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">

        </div>
    </div>
    <div class="col-md-8">


        @if($errors->any())
        <div class="alert alert-warning overflow-hidden p-0" role="alert">
            <div class="p-3 bg-warning text-fixed-white d-flex justify-content-between">
                <h6 class="aletr-heading mb-0 text-fixed-white"><span class="ti ti-alert-triangle"></span> Laporan
                    Kesalahan</h6>
                <button type="button" class="btn-close p-0 text-fixed-white" data-bs-dismiss="alert"
                    aria-label="Close"><i class="fas fa-xmark"></i></button>
            </div>
            <hr class="my-0">
            <div class="p-3">
                @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
        @endif

        @if ($gagal = Session::get('gagal'))
        <div class="alert alert-danger overflow-hidden p-0" role="alert">
            <div class="p-3 bg-dangers  d-flex justify-content-between">
                <h6 class="alert-heading mb-0 "><span class="ti ti-alert-triangle"></span> Laporan
                    Kesalahan</h6>
                <button type="button" class="btn-close p-0 text-fixed-white" data-bs-dismiss="alert"
                    aria-label="Close"><i class="fas fa-xmark"></i></button>
            </div>
            <hr class="my-0">
            <div class="p-3">
                <div>{{ $gagal }}</div>

            </div>
        </div>
        @endif
        <form id="fileUploadForm" action="{{ route('studentImport') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3 ">
                <div class="input-group mb-3 b">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">Table Name :</span>
                    </div>
                    <input type="text" class="form-control" placeholder="Students" value="" disabled id="table-name">
                </div>

            </div>

            <div class="mb-3">
                <label class="form-label">File Type</label>
                <select class="form-select select">
                    <option>.xlsx, .csv </option>
                </select>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Jenis Data Untuk : </label>
                        <div>
                            <input type="radio" name="data_location" value="student" checked checked
                                onclick="updateTableName(this.value)"> Siswa
                            <input type="radio" name="data_location" value="gtk" class="ms-3"
                                onclick="updateTableName(this.value)"> Guru
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">File</label>
                        <input type="file" name="file" class="form-control" required accept=".xlsx, .csv">
                        <small>( Supperted file Format : .xlsx atau file excel)</small>
                    </div>

                    <!-- Progress Bar dan Progress Text -->
                    <div class="progress mt-2" style="display: none;">
                        <div class="progress-bar" role="progressbar" style="width: 0%;" id="uploadProgress">0%</div>
                    </div>
                    <p id="progressText" style="display: none; text-align: center; font-weight: bold;">Uploading... 0%
                    </p>
                </div>
            </div>

            <div class="alert alert-secondary" role="alert">
                Mohon diperhatikan format data terlebih dahulu, sebelum melakukan import data. contoh data sudah
                tersedia disamping kanan
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary w-100"><span class="ti ti-upload"></span> Import
                    Data</button>
            </div>
        </form>

    </div>

    <div class="col-md-4">
        <h4>Informasi Fitur</h4>
        <p>itur Import Data ini merupakan fungsi unggah dan pemrosesan data dari file eksternal <code>(seperti .xlsx atau .csv)</code> ke dalam sistem. Fitur ini memungkinkan pengguna untuk memasukkan data dalam jumlah besar dengan cepat, tanpa harus menginput satu per satu secara manual.</p>
        <div class="alert alert-primary overflow-hidden p-0 m-2" role="alert">
            <div class="p-3 bg-primary text-fixed-white d-flex justify-content-between">
                <h6 class="aletr-heading mb-0 text-fixed-white">Informasi Singkat</h6>
            </div>
            <div class="p-2" align="left">
                <p class="my-1">Berikut ini informasi yang harus diperhatikan :</p>
                <p class="my-1 mx-2">1. Untuk Contoh Format Dokumen <code>Untuk Siswa</code> anda bisa download di link
                    ini. <a href="{{ asset('asset/import_sample/Data Siswa Sample.xlsx') }}" target="_blank"
                        rel="noopener noreferrer"> Download </a> </p>
                <p class="my-1 mx-2">2. Untuk Contoh Format Dokumen <code>Untuk Guru </code> anda bisa download di link
                    ini. <a href="{{ asset('asset/import_sample/Data Guru.xlsx') }}" target="_blank"
                        rel="noopener noreferrer"> Download </a></p>
                <p class="my-1 mx-2">3. File yang di Import Harus bertype .xlsx atau type file Excel</p>

            </div>
        </div>
    </div>
</div>

@section('javascript')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('fileUploadForm').addEventListener('submit', function(event) {
        event.preventDefault();

        let form = this;
        let formData = new FormData(form);
        let progressBar = document.querySelector('.progress');
        let progress = document.getElementById('uploadProgress');
        let progressText = document.getElementById('progressText');

        progressBar.style.display = 'block'; // Tampilkan progress bar
        progressText.style.display = 'block'; // Tampilkan teks progress

        let xhr = new XMLHttpRequest();
        xhr.open('POST', form.action, true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

        xhr.upload.onprogress = function(event) {
            if (event.lengthComputable) {
                let percentComplete = Math.round((event.loaded / event.total) * 100);
                progress.style.width = percentComplete + '%';
                progress.textContent = percentComplete + '%';
                progressText.textContent = `Uploading... ${percentComplete}%`;
            }
        };

        xhr.onload = function() {
            if (xhr.status == 200) {
                progress.textContent = 'Upload Completed!';
                progressText.textContent = 'Upload Completed!';

                Swal.fire({
                    title: 'Sukses!',
                    text: 'Data berhasil diimport!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload(); // Refresh halaman setelah sukses
                });

            } else {

                progress.style.backgroundColor = 'red'; // Warna merah jika gagal
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat mengupload. Cek data apakah sudah sesuai dengan format atau tidak. atau mungkin ada data nis atau nik yang duplikat',
                    icon: 'error',
                    confirmButtonText: 'Coba Lagi'
                });
            }
        };

        xhr.onerror = function() {
            Swal.fire({
                title: 'Kesalahan!',
                text: 'Tidak dapat terhubung ke server.',
                icon: 'error',
                confirmButtonText: 'Coba Lagi'
            });
        };

        xhr.send(formData);
    });
    </script>


<script>
    function updateTableName(value) {
        document.getElementById("table-name").value = value;
    }
</script>
@endsection
@endsection
