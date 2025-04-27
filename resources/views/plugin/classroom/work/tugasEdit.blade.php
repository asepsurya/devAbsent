@extends('layout.main')
@section('css')
<!-- TinyMCE CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.6.0/tinymce.min.js" integrity="sha512-/4EpSbZW47rO/cUIb0AMRs/xWwE8pyOLf8eiDWQ6sQash5RP1Cl8Zi2aqa4QEufjeqnzTK8CLZWX7J5ZjLcc1Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
<form action="{{ route('classroom.editTugasAction') }}" method="POST" enctype="multipart/form-data">
    @csrf
    {{-- @method('PUT') --}}
 
    <!-- Form Fields for Editing Task -->
    <div class="row">
        <!-- Main Content -->
        <div class="col-md-9">
       
            <div class="p-3">
                <!-- Header -->
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
                </div>

                @if ($errors->any())
                <div class="alert alert-danger">
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
                        <input type="text" name="task_id" value="{{ $task_id }}" hidden>
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" class="form-control" placeholder="Nama Judul Tugas" name="judul" value="{{ old('judul', $task->judul) }}">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Petunjuk tugas</label>
                            <textarea name="description" class="editor" cols="30" rows="10" placeholder="Petunjuk Tugas(optional)">{{ old('description', $task->description) }}</textarea>
                        </div>
                        <label for="" class="form-label">Lampirkan File</label>
                        <div class="mb-3">
                            <input type="file" id="fileInput" name="dok[]" class="form-control" multiple accept="image/*, .pdf, .docx, .txt">
                        </div>
                        
                     

                        <!-- YouTube Links -->
                        <div class="d-flex mb-3">
                            <input type="text" id="youtubeLinkInput" class="form-control me-2" placeholder="Paste YouTube link here">
                            <a class="btn btn-primary" onclick="addYouTubeLink()">+</a>
                        </div>

                        <input name="link" id="youtubeLinks" value="{{ implode(',', $urls) }}" class="form-control" hidden>

                           <!-- Display Existing Files -->
                           <div class="preview-container" id="previewContainer">
                            @foreach($taskFiles as $file)
                                <div class="preview-box">
                                    <a class="remove-btn" href="{{ route('classroom.filedelete', $file->id) }}" >x</a>
                                    @if(in_array(pathinfo($file->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                        <img src="{{ asset('storage/'.$file->file_path) }}" alt="Preview">
                                    @else
                                        <img src="{{ asset('asset/img/icon/pdf-02.svg') }}" alt="File Icon">
                                    @endif
                                    <p>{{ $file->file_name }}</p>
                                </div>
                            @endforeach

                            @foreach($taskLinks as $taskLink)
                                @php
                                    // Decode the youtube_link if it's stored as a JSON string
                                    $youtubeLinks = json_decode($taskLink->youtube_link, true);
                                @endphp
                        
                        @if(is_array($youtubeLinks))
                        @foreach($youtubeLinks as $youtubeLink)
                                <div class="preview-box position-relative" data-link="{{ $youtubeLink }}">
                                    <!-- Remove Button with YouTube Link passed to JavaScript -->
                                    <a href="javascript:void(0)" class="remove-btn" data-link="{{ $youtubeLink }}">x</a>
                                    <div class="iframe-container">
                                        @php
                                            // Improved regular expression to extract video ID from YouTube URLs
                                            preg_match('/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+|(?:v|e(?:mbed)?)\/|.*[?&]v=)([a-zA-Z0-9_-]{11}))|(?:youtu\.be\/([a-zA-Z0-9_-]{11}))/i', $youtubeLink, $matches);
                                            $videoId = $matches[1] ?? $matches[2] ?? null;
                                        @endphp
                                        
                                        @if($videoId)
                                            <iframe width="420" height="315"
                                                    src="https://www.youtube.com/embed/{{ $videoId }}"
                                                    frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                    allowfullscreen>
                                            </iframe>
                                        @else
                                            <p>Invalid YouTube link</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    
                        @endforeach
                        
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="col-md-3 border-start bg-muted" style="min-height: 100vh;">
            <div class="mb-3 border-bottom p-3">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="ti ti-send"></span> Publikasikan
                    </button>
                    <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                        <li><button type="submit" class="dropdown-item border-bottom"><span class="ti ti-send"></span> Update Tugas</button></li>
                    </ul>
                </div>
            </div>

            <!-- Task Details -->
            <div class="py-2 me-2">
                <div class="mb-3">
                    <label for="" class="form-label">Untuk</label>
                    <select class="form-control select">
                        <option value="{{ $task->judul }}" selected>{{ $task->judul }}</option>
                    </select>
                    <input type="text" value="{{ $task->id_kelas }}" name="id_kelas" hidden>
                </div>
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
                </div>

                <div class="mb-3" hidden>
                    <label for="" class="form-label">Poin</label>
                    <input type="text" class="form-control" name="poin" placeholder="/100" value="{{ old('poin', $task->poin) }}">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Tenggat Waktu</label>
                    <input type="text" class="form-control datetimepicker" name="due_date" placeholder="Tenggat Waktu Pengerjaan" value="{{ old('due_date', $task->due_date) }}">
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('javascript')

<script>
    // Add an event listener for the remove button clicks
    document.querySelectorAll('.remove-btn').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default link behavior
            
            const linkToDelete = button.getAttribute('data-link'); // Get the link to delete
            const index = button.getAttribute('data-index'); // Get the index of the link to delete
            
            // Optionally, remove the preview box from the page
            const previewBox = document.getElementById('preview-box-' + index);
            if (previewBox) {
                previewBox.remove();
            }
            
            // Send the DELETE request using AJAX
            fetch("{{ route('classroom.linkdelete') }}", {
                method: 'POST', // Using POST to handle delete in Laravel
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token for Laravel
                },
                body: JSON.stringify({
                    task_id: {{ $task_id }},
                    link: linkToDelete // Pass the YouTube link to the backend
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.closest('.preview-box').remove();
                    // alert('Link deleted successfully');
                } else {
                    alert('Failed to delete link');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting the link');
            });
        });
    });
</script>

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

<script>
     var body = document.body;
     body.classList.add("mini-sidebar");

    tinymce.init({
    selector: '.editor', // Initialize TinyMCE on any element with class 'editor'
    menubar: false,
    statusbar: false,
    height:200,
    toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | bullist numlist',

    })
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
