@extends('layout.main')
@section('container')
<style>
    .loader {
        border: 4px solid #f3f3f3;
        border-radius: 50%;
        border-top: 4px solid #3498db;
        width: 25px;
        height: 25px;
        animation: spin 1s linear infinite;
        display: none;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
{{-- Header --}}
<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1">{{ $title }}</h3>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Beranda</a>
                </li>
                <li class="breadcrumb-item">Laporan</li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap"></div>
</div>

<div class="card mb-3">
    <div class="card-header bg-light d-flex justify-content-between flex-wrap">
        <div class="d-flex align-items-center mb-2 mb-md-0">
            <i class="ti ti-eye me-2 text-primary"></i>
            <h6 class="mb-0">Preview</h6>
        </div>
       <div id="loader" class="loader"></div>
        <div class="d-flex align-items-center flex-wrap">
         
            <div class="ms-2">
                <button class="btn btn-outline-primary mb-2 mb-md-0" onclick="printIframe()"><span class="ti ti-printer"></span> Print</button>
            </div>
        </div>     
    </div>
    

    <div class="card-body my-0">
        <iframe id="previewFrame" src="/export/gtks?laporan=1" width="100%" height="600px" frameborder="0"></iframe>
    </div>
</div>

<!-- Import Select2 jika belum ada -->

<script>
    // Inisialisasi Select2
    $(document).ready(function() {
        $('#kelasFilter').select2();
    });

    // Fungsi untuk print konten dari iframe
    function printIframe() {
        const iframe = document.getElementById('previewFrame');
        
        // Pastikan iframe sudah load
        iframe.onload = () => {
            iframe.contentWindow.focus();
            iframe.contentWindow.print();
        };

        if (iframe.contentDocument.readyState === 'complete') {
            iframe.contentWindow.focus();
            iframe.contentWindow.print();
        }
    }
</script>
<script>
    var body = document.body;
    body.classList.add("mini-sidebar");
</script>


@endsection