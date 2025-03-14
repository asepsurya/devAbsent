@extends('layout.main')

@section('css')
<style>
    .import-container {
        border: 2px dashed #ccc;
        padding: 20px;
        text-align: center;
        border-radius: 5px;
        background: #f9f9f9;
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

    <form action="{{ route('pluginImport') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="import-container">
            <p>Choose the file to be imported</p>
            <p><small>[only .zip formats are supported]</small></p>
            <input type="file" name="plugin_zip" id="plugin_zip" accept=".zip" required>
            <label for="plugin_zip" class="btn btn-primary">Upload File</label>
            <p><a href="#">Download sample template for Import</a></p>
        </div>

        <!-- File Preview -->
        <div class="file-preview alert alert-info" id="file-preview">
            <strong>Selected File:</strong> <span id="file-name"></span>
        </div>

        <button type="submit" class="btn btn-success btn-upload">Import Plugin</button>
        <a href="#" class="btn btn-secondary">Cancel</a>
    </form>

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
