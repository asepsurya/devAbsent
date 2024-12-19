@extends('layout.main')
@section('css')
<!-- TinyMCE CDN -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.6.0/tinymce.min.js" integrity="sha512-/4EpSbZW47rO/cUIb0AMRs/xWwE8pyOLf8eiDWQ6sQash5RP1Cl8Zi2aqa4QEufjeqnzTK8CLZWX7J5ZjLcc1Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
<style>
    .preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }
    .preview-box {
        position: relative;
        width: 220px;
        height: 100px;
        border: 1px solid #ddd;
        border-radius: 5px;
        overflow: hidden;

        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 5px;
    }
    .preview-box img {
        max-width: 80px;
        max-height: 80px;
    }
    .preview-box p {
        font-size: 12px;
        word-break: break-word;
        margin-top: 5px;
    }
    .remove-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(255, 0, 0, 0.7);
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        font-size: 12px;
        line-height: 1;
        cursor: pointer;
    }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
</style>
@endsection
@section('container')
<form action="{{ route('classroom.tambahTugas') }}" method="POST" enctype="multipart/form-data">
    @csrf
<div class="row">
    <!-- Main Content -->
    <div class="col-md-9">
        <div class="p-3">
            {{-- header --}}
            <div class="d-md-flex d-block align-items-center justify-content-between mb-3 ">

                <div class="my-auto mb-2">

                    <h3 class="page-title mb-1">{{ $title }}</h3>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Beranda</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Ruangan Kelas</a>
                            </li>

                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
                    <a onclick="window.history.back();" class="btn btn-outline-light bg-white  position-relative me-1">
                        <i class="ti ti-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            {{-- End Header --}}
            <div class="card flex-fill bg-info " style="background-image: url('http://127.0.0.1:8000/asset/img/shape-05.png'); background-size: cover; background-position: center;">
                <div class="card-body pt-5">
                    <h1 class="text-white mb-1 "><span class="ti ti-clipboard-list"></span>Tambah Tugas</h1>
                </div>
            </div>
            @if ($errors->any())
            <div class="alert alert-danger">
                <strong>There are some errors with your submission:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

            <div class="card">
                <div class="card-body">
                    <input type="text" name="type" value="task" hidden>
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" placeholder="Nama Judul Tugas" name="judul">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Petunjuk tugas</label>
                        <textarea name="description"  class="editor" cols="30" rows="10" placeholder="Petunjuk Tugas(optional)"></textarea>
                    </div>
                    <label for="" class="form-label">Lampirkan File</label>
                    <div class="mb-3">
                        <input type="file" id="fileInput" name="dok[]" class="form-control" multiple accept="image/*, .pdf, .docx, .txt">

                    </div>
                    <div class="mb-3">
                        <div class="d-flex mb-3">
                            <input type="text" id="youtubeLinkInput" class="form-control me-2" placeholder="Paste YouTube link here">
                            <a class="btn btn-primary" onclick="addYouTubeLink()">+</a>
                        </div>
                    </div>
                    <input  name="link[]" id="youtubeLinks" hidden>
                     <!-- Preview Section -->
                     <div class="preview-container" id="previewContainer"></div>
                </div>

            </div>

        </div>
    </div>

    <!-- Right Sidebar -->
    <div class="col-md-3 border-start bg-muted" style="min-height: 100vh; ">
        <div class="position:sticky; top: 80px;">
            <div class="mb-3 border-bottom p-3 ">

                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="ti ti-send"></span> Publikasikan
                    </button>
                    <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton" style="z-index:9999;">
                        <li><button type="submit" class="dropdown-item border-bottom"><span class="ti ti-send"></span> Publikasikan</button></li>
                        <li><a href="http://127.0.0.1:8000/classroom/addwork" class="dropdown-item"><span class="ti ti-notes"></span> Simpan sebagai draft</a></li>
                    </ul>

                </div>

            </div>
            <div class="py-2 p-3">
                {{-- <div class="mb-3">
                    <label for="" class="form-label">Untuk</label>
                    <select  class="form-control select" >
                        <option value="">Pemograman</option>
                    </select>
                </div> --}}
                <input type="text" value="{{ $id }}" name="id_kelas" hidden>
                <div class="mb-3">
                    Created by :
                    <div class="bg-light-400 rounded-2 p-3 mb-3 border">
                        <div class="d-flex align-items-center">
                            <a class="avatar avatar-lg flex-shrink-0"><img src="http://127.0.0.1:8000/asset/img/user-default.jpg" class="img-fluid rounded-circle" alt="img"></a>
                            <div class="ms-2">
                                <h6 class="text-dark text-truncate mb-0"><a>{{ auth()->user()->nama }}</a></h6>
                                <small>{{ auth()->user()->email }}</small>
                            </div>
                        </div>
                    </div>
                    <input type="text" name="auth" value="{{ auth()->user()->nomor }}" hidden>
                </div>

                <div class="mb-3" hidden>
                    <label for="" class="form-label">Poin</label>
                    <input type="text" class="form-control" name="poin" placeholder="/100">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Tenggat Waktu</label>
                    <input type="text" class="form-control datetimepicker" name="due_date" placeholder="Tenggat Waktu Pengerjaan">

                </div>
            </div>
        </div>
    </div>
</div>

</form>
@section('javascript')
<script>
    const youtubeLinks = []; // Array to store the links

    function addYouTubeLink() {
        const inputField = document.getElementById('youtubeLinkInput');
        const link = inputField.value.trim();
        const previewContainer = document.getElementById('previewContainer');
        const youtubeLinksInput = document.getElementById('youtubeLinks');

        if (link) {
            const videoId = extractYouTubeVideoId(link);

            if (videoId) {
                if (!youtubeLinks.includes(link)) {
                    youtubeLinks.push(link); // Add link to the array
                    youtubeLinksInput.value = JSON.stringify(youtubeLinks); // Update hidden input

                    // Create a container for the preview
                    const previewBox = document.createElement('div');
                    previewBox.classList.add('preview-box', 'position-relative', 'mb-3');
                    previewBox.style.width = '200px';

                    previewBox.innerHTML = `
                        <button class="btn btn-danger btn-sm position-absolute top-0 end-0"
                                onclick="removeYouTubeLink('${link}', this)">
                            x
                        </button>
                        <iframe
                            src="https://www.youtube.com/embed/${videoId}"
                            class="w-100"
                            height="150"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    `;

                    previewContainer.appendChild(previewBox);
                    inputField.value = ''; // Clear input field
                } else {
                    alert('This link is already added!');
                }
            } else {
                alert('Invalid YouTube link! Please provide a correct link.');
            }
        } else {
            alert('Please paste a YouTube link.');
        }
    }

    function removeYouTubeLink(link, button) {
        const index = youtubeLinks.indexOf(link);
        if (index > -1) {
            youtubeLinks.splice(index, 1); // Remove the link from the array
            document.getElementById('youtubeLinks').value = JSON.stringify(youtubeLinks); // Update hidden input
            button.parentElement.remove(); // Remove the preview box
        }
    }

    function extractYouTubeVideoId(url) {
        const regex = /(?:https?:\/\/)?(?:www\.)?youtu(?:\.be\/|be\.com\/(?:watch\?v=|embed\/|v\/|.+\?v=))([^&\s]+)/;
        const match = url.match(regex);
        return match ? match[1] : null; // Return video ID or null if not found
    }
</script>

<script>
    document.getElementById('fileInput').addEventListener('change', function (event) {
        const files = event.target.files;
        const previewContainer = document.getElementById('previewContainer');
        const iconPaths = {
            'pdf': "{{ asset('asset/img/icon/pdf-02.svg') }}",
            'xls': "{{ asset('asset/img/icon/xls.svg') }}",
            'xlsx': "{{ asset('asset/img/icon/xls.svg') }}",
            'doc': "{{ asset('asset/img/icon/doc.png') }}",
            'docx': "{{ asset('asset/img/icon/doc.png') }}",
            'default': "{{ asset('asset/img/icon/word.svg') }}"
        };

        // Clear previous previews
        previewContainer.innerHTML = '';

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const fileType = file.name.split('.').pop().toLowerCase();
            const previewBox = document.createElement('div');
            previewBox.classList.add('preview-box');

            // Icon for specific file types
            let previewContent = '';
            if (['jpg', 'jpeg', 'png'].includes(fileType)) {
                // Image Preview
                const imgSrc = URL.createObjectURL(file);
                previewContent = `<img src="${imgSrc}" alt="Preview">`;
            } else if (iconPaths[fileType]) {
                // File Type Icons
                previewContent = `<img src="${iconPaths[fileType]}" alt="${fileType} Icon">`;
            } else {
                // Default Icon
                previewContent = `<img src="${iconPaths['default']}" alt="File Icon">`;
            }

            previewBox.innerHTML = `
                <button class="remove-btn" onclick="this.parentElement.remove()">x</button>
                ${previewContent}
                <p>${file.name}</p>
            `;
            previewContainer.appendChild(previewBox);
        }
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.5.0/tinymce.min.js" integrity="sha512-KmEMNDKX2KDYPrBMr2MJj/JLgYK271k+P2341E5wvBMgepz1HS3wpc7r65hDXcp4Ul89omtSKIHxdk8VYHd9ug==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
     var body = document.body;
     body.classList.add("mini-sidebar");
</script>

<script type="text/javascript">
    tinymce.init({
        selector: '.editor',
        height: 400,
        menubar: false,
        statusbar: false,
        toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | bullist numlist ',

    });
</script>
<script>
    var elements = document.querySelectorAll('.blank-page');
    // Loop through the elements and remove the class from each
    elements.forEach(function(element) {
    element.classList.remove('blank-page');
    element.classList.remove('content');
    });
</script>
@endsection
@endsection

