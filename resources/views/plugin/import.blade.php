@extends('layout.main')

@section('css')
<style>
    .import-container {
        border: 2px dashed #ccc;
        padding: 20px;
        text-align: center;
        border-radius: 5px;

    }

    .import-container input {
        display: none;
    }

    .import-container label {
        cursor: pointer;
        display: block;
        color: #007bff;
        margin-top: 10px;
    }

    .btn-upload {
        margin-top: 10px;
    }

    .file-preview {
        margin-top: 10px;
        display: none;
    }

    .hidden { display: none; }
</style>
@endsection

@section('container')
<h3 class="mb-3">Import Plugin</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif
{{-- Jika Terjadi Kesalahan --}}
@if($errors->any())
<div class="alert alert-warning overflow-hidden p-0" role="alert">
    <div class="p-3 bg-warning text-fixed-white d-flex justify-content-between">
        <h6 class="aletr-heading mb-0 text-fixed-white"><span class="ti ti-alert-triangle"></span> Laporan Kesalahan
        </h6>
        <button type="button" class="btn-close p-0 text-fixed-white" data-bs-dismiss="alert" aria-label="Close"><i
                class="fas fa-xmark"></i></button>
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
    <div class="p-3 bg-danger text-fixed-white d-flex justify-content-between">
        <h6 class="aletr-heading mb-0 text-fixed-white"><span class="ti ti-alert-triangle"></span> Laporan Kesalahan
        </h6>
        <button type="button" class="btn-close p-0 text-fixed-white" data-bs-dismiss="alert" aria-label="Close"><i
                class="fas fa-xmark"></i></button>
    </div>
    <hr class="my-0">
    <div class="p-3">
        <div>{{ $gagal }}</div>

    </div>
</div>
@endif
<form action="{{ route('pluginImport') }}" method="POST" enctype="multipart/form-data" id="install-form">
    @csrf
    <div class="import-container p-6  py-5 my-4">
        <p>Choose the file to be imported</p>
        <p><small>[only .zip formats are supported]</small></p>
        <input type="file" name="plugin_zip" id="plugin_zip" accept=".zip" required>
        <label for="plugin_zip" class="btn btn-primary">Upload File</label>


        <!-- File Preview -->
        <div class="file-preview alert alert-info" id="file-preview">
            <strong>Selected File:</strong> <span id="file-name"></span>
        </div>
    </div>


    <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-success btn-upload">Install Plugin</button>
        <a href="{{ route('plugin.index') }}" type="button" class="btn btn-primary btn-upload">Batal</a>
    </div>
</form>
<div class="mt-4 " id="progress-steps" style="display: none;">
    <p><strong>Proses Instalasi:</strong></p>
    <div class="progress mb-3">
        <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated bg-success"
            role="progressbar" style="width: 0%">0%</div>
    </div>
    <ul class="list-group">
        <li class="list-group-item" id="step-download">🔄 Mengunduh...</li>
        <li class="list-group-item" id="step-extract">⏳ Mengekstrak...</li>
        <li class="list-group-item" id="step-install">⚙️ Menginstal...</li>
    </ul>
</div>
@section('javascript')
<script>
    $(document).ready(function () {
        $("#install-form").submit(function (e) {
            e.preventDefault(); // Mencegah form dikirim langsung

            let formData = new FormData(this);

            $(".btn-upload").prop("disabled", true); // Disable tombol install
            $("#progress-steps").show(); // Tampilkan progress
            let progressBar = $("#progress-bar");

            function updateStep(stepId, message, percentage) {
                $(stepId).text(message).addClass("list-group-item-success");
                progressBar.css("width", percentage + "%").text(percentage + "%");
            }

            // Kirim data ke backend
            $.ajax({
                url: $(this).attr("action"),
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    updateStep("#step-download", "✅ Mengunduh selesai!", 33);
                    setTimeout(() => {
                        updateStep("#step-extract", "✅ Ekstraksi selesai!", 66);
                        setTimeout(() => {
                            updateStep("#step-install", "✅ Instalasi selesai!", 100);
                            $(".btn-upload").prop("disabled", false); // Aktifkan tombol kembali

                            // Redirect ke route setelah selesai
                            window.location.href = "{{ route('plugin.index') }}";

                        }, 1500);
                    }, 1500);
                },
                error: function () {
                    alert("Terjadi kesalahan saat mengunggah file.");
                    $(".btn-upload").prop("disabled", false);
                }
            });
        });
    });
</script>
<script>
    document.getElementById('plugin_zip').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                document.getElementById('file-name').innerText = file.name;
                document.getElementById('file-preview').style.display = 'block';
            } else {
                document.getElementById('file-preview').style.display = 'none';
            }
        });
</script>
@endsection

@endsection
