@extends('layout.main')
@section('css')
<style>
    .container {
        margin: 0px;
    }
    #loadingScreen{
        z-index: 99999;
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
                            <input type="radio" name="data_location" value="student" checked onclick="updateTableName(this.value)"> Siswa
                            <input type="radio" name="data_location" value="gtk" class="ms-3" onclick="updateTableName(this.value)"> Guru
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">File</label>
                        <input type="file" name="file" id="fileInput" class="form-control" required accept=".xlsx, .csv">
                        <small>(Supported file Format: .xlsx or Excel file)</small>
                    </div>

                    <!-- Progress Bar -->
                    <div class="progress mt-2" style="display: none;">
                        <div class="progress-bar" role="progressbar" style="width: 0%;" id="uploadProgress">0%</div>
                    </div>
                    <p id="progressText" style="display: none; text-align: center; font-weight: bold;">Uploading... 0%</p>

                    <!-- Preview Data -->
                    <div id="dataPreview" style="display: none;">
                        <h5>Preview Data</h5>
                        <div style="max-height: 300px; overflow-y: scroll;">
                            <table class="table" id="previewTable"></table>
                        </div>
                        <div class="my-3">
                            <button type="button" class="btn btn-primary" onclick="submitForm()"><span class="ti ti-upload"></span> Import Data</button>
                        </div>

                    </div>

                    <!-- Loading Screen -->
                    <div id="loadingScreen" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); display: flex; justify-content: center; align-items: center;">
                        <div style="color: white; font-size: 20px;">Proses Upload...</div>
                    </div>

                    <!-- Elemen untuk menampilkan status upload -->
                    <ul id="uploadedFiles" style="display:none; list-style-type: none; padding: 0;"></ul>
                </div>
            </div>




            <div class="alert alert-secondary" role="alert">
                Mohon diperhatikan format data terlebih dahulu, sebelum melakukan import data. contoh data sudah
                tersedia disamping kanan
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('loadingScreen').style.display = 'none';
document.getElementById('fileInput').addEventListener('change', function(event) {
    let file = event.target.files[0];

    // Cek file yang dipilih
    if (file) {
        // Menampilkan preview data
        displayFilePreview(file);
    }
});

function displayFilePreview(file) {
    let reader = new FileReader();

    reader.onload = function(e) {
        let fileContent = e.target.result;

        // Jika file CSV
        if (file.name.endsWith('.csv')) {
            let rows = fileContent.split("\n").map(row => row.split(","));
            renderPreviewTable(rows);
        }
        // Jika file XLSX
        else if (file.name.endsWith('.xlsx')) {
            let workbook = XLSX.read(fileContent, { type: 'binary' });
            let sheet = workbook.Sheets[workbook.SheetNames[0]];
            let rows = XLSX.utils.sheet_to_json(sheet, { header: 1 });
            renderPreviewTable(rows);
        }
    };

    // Jika file CSV atau XLSX, baca file sebagai teks
    if (file.name.endsWith('.csv')) {
        reader.readAsText(file);
    } else if (file.name.endsWith('.xlsx')) {
        reader.readAsBinaryString(file);
    }
}

function renderPreviewTable(rows) {
    let table = document.getElementById('previewTable');
    table.innerHTML = '';
    let nisSet = new Set();
    let duplicateNisRows = [];

    // Buat header
    let headerRow = document.createElement('tr');
    rows[0].forEach(cell => {
        let th = document.createElement('th');
        th.textContent = cell;
        headerRow.appendChild(th);
    });
    table.appendChild(headerRow);

    // Buat baris data dan cek NIS duplikat
    rows.slice(1).forEach((row, index) => {
        let rowElement = document.createElement('tr');
        let isDuplicate = false;

        row.forEach((cell, cellIndex) => {
            let td = document.createElement('td');
            td.textContent = cell;

            // Cek NIS duplikat (misalkan NIS ada di kolom pertama)
            if (cellIndex === 0) {
                if (nisSet.has(cell)) {
                    td.style.backgroundColor = 'red'; // Tandai duplikat dengan warna merah
                    isDuplicate = true;
                    duplicateNisRows.push({ row: row, index: index });
                } else {
                    nisSet.add(cell);
                }
            }
            rowElement.appendChild(td);
        });
        table.appendChild(rowElement);
    });

    // Jika ada NIS duplikat, tampilkan tombol untuk mengubah atau menghapus NIS
    if (duplicateNisRows.length > 0) {
        duplicateNisRows.forEach(dupRow => {
            let row = dupRow.row;
            let index = dupRow.index;

            // Tambahkan tombol untuk mengubah atau menghapus NIS
            let td = document.createElement('td');
            td.innerHTML = `<button onclick="editNis(${index})">Ubah NIS</button><button onclick="removeRow(${index})">Hapus</button>`;
            table.appendChild(td);
        });
    }

    // Tampilkan tombol upload
    document.getElementById('dataPreview').style.display = 'block';
}

function editNis(index) {
    // Logika untuk mengubah NIS, bisa menggunakan prompt untuk edit data
    let newNis = prompt("Masukkan NIS baru:");
    if (newNis) {
        let table = document.getElementById('previewTable');
        let row = table.rows[index + 1]; // Skip header
        row.cells[0].textContent = newNis; // Ubah NIS pada kolom pertama
    }
}

function removeRow(index) {
    // Logika untuk menghapus baris
    let table = document.getElementById('previewTable');
    table.deleteRow(index + 1); // Skip header
}

function submitForm() {
    let form = document.getElementById('fileUploadForm');
    let formData = new FormData(form);

    // Tampilkan loading screen
    document.getElementById('loadingScreen').style.display = 'flex';

    let xhr = new XMLHttpRequest();
    xhr.open('POST', form.action, true);
    xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

    // Update progress bar
    xhr.upload.onprogress = function(event) {
        if (event.lengthComputable) {
            let percentComplete = Math.round((event.loaded / event.total) * 100);
            document.getElementById('uploadProgress').style.width = percentComplete + '%';
            document.getElementById('uploadProgress').textContent = percentComplete + '%';
            document.getElementById('progressText').textContent = `Uploading... ${percentComplete}%`;
        }
    };

    // Handle completion
    xhr.onload = function() {
        document.getElementById('loadingScreen').style.display = 'none';
        if (xhr.status == 200) {
            Swal.fire({
                title: 'Sukses!',
                text: 'Data berhasil diimport!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                title: 'Gagal!',
                text: 'Terjadi kesalahan saat mengupload.',
                icon: 'error',
                confirmButtonText: 'Coba Lagi'
            });
        }
    };

    xhr.onerror = function() {
        document.getElementById('loadingScreen').style.display = 'none';
        Swal.fire({
            title: 'Kesalahan!',
            text: 'Tidak dapat terhubung ke server.',
            icon: 'error',
            confirmButtonText: 'Coba Lagi'
        });
    };

    // Send form data with file
    xhr.send(formData);
}

</script>

<script>
    function updateTableName(value) {
        document.getElementById("table-name").value = value;
    }
</script>
@endsection
@endsection
