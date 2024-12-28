@extends('classroom.layout.classRoom')
@section('css')
<script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@4.6.2/dist/emoji-button.min.js"></script>
<style>
    /* Container for button and input */
    .emoji-container {
        position: relative;
    }

    /* Emoji button styling */
    .emoji-btn {
        font-size: 24px;
        padding: 8px 12px;
        cursor: pointer;
        background: #f0f0f0;
        border: 1px solid #ccc;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
    }



    /* Emoji picker styling */
    .emoji-picker {
        display: none;

        z-index: 1000;
        background-color: white;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        width: auto;
    }

    /* Individual emoji button styling */
    .emoji {
        font-size: 20px;
        margin: 5px;
        cursor: pointer;
        background: none;
        border: none;
        padding: 5px;
    }

    .emoji:hover {
        background-color: #f0f0f0;
        border-radius: 50%;
    }
</style>
<style>
       .close-btn {
            background: transparent;
            border: none;
            font-size: 20px;
            font-weight: bold;
            color: red;
            cursor: pointer;
        }

        .close-btn:hover {
            color: darkred;
        }
        .comment-section {
            max-width: 800px;
            margin: 50px auto;
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .comment-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .comment-box {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 30px;
            padding: 10px;
            background-color: #f9f9f9;
        }

        .comment-box input {
            border: none;
            background: transparent;
            flex: 1;
            margin-left: 10px;
            font-size: 16px;
            outline: none;
            padding: 5px;
        }

        .comment-box button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .comment-box button:hover {
            background-color: #45a049;
        }

        .comment {
            display: flex;
            align-items: center;
            border-bottom: 1px solid #eee;
            padding: 15px 0;
        }

        .comment-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .comment-content {
            flex: 1;
        }

        .comment-user {
            font-weight: bold;
            color: #333;
        }

        .comment-text {
            margin-top: 5px;
            font-size: 14px;
            color: #555;
        }

        .comment-footer {
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
            color: #777;
            font-size: 12px;
        }

        .comment-footer button {
            background: transparent;
            border: none;
            color: #4CAF50;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .comment-footer button:hover {
            color: #45a049;
        }
        .nav-tabs{
            background-color: white;
        }
        html .darkmode .nav-tabs,
        html[data-theme=dark] .nav-tabs {
            background: #0f0c1c;

         }

</style>

@endsection
@section('content')
@foreach ($myclass as $item )
<div class="pt-5">
    <div class="p-3" >
        <div class="d-flex justify-content-between mb-3">
            <div>
                <h4>Detail Tugas</h4>
            </div>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="/dashboard">Beranda</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/dashboard">Forum</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Absensi Kelas</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-9">
                @if($task->count())
                    @foreach ($task as $item)
                        <div class="card board-hover mb-3">
                            <div class="card-body d-md-flex align-items-center justify-content-between pb-1">
                                <div class="d-flex align-items-center mb-3">

                                    <span class="bg-soft-primary text-primary avatar avatar-md me-2 br-5 flex-shrink-0">
                                        <i class="ti ti-notification fs-16"></i>
                                    </span>
                                    <div class="mx-3">
                                        <h6 class="mb-1 fw-semibold">
                                            <div class="d-flex align-items-center">
                                                <a class="avatar avatar-lg flex-shrink-0"><img src="{{ asset('asset/img/user-default.jpg') }}" class="img-fluid rounded-circle" alt="img"></a>
                                                <div class="ms-2">
                                                    <h6 class="text-dark text-truncate mb-0"><a>{{ $item->user->nama }}</a></h6>
                                                    <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                            {{-- <a href="#" data-bs-toggle="modal" data-bs-target="#view_details">Tugas Pertemuan 2</a> --}}
                                        </h6>
                                        <div class="col my-3 ">
                                            <h5>{{ $item->judul }}</h5>
                                            @if ($item->type == 'quiz')
                                            Kunjungi link berikut ini untuk memulai,jangan lupa berdo'a terlebih dahulu sebelum dimulai :) <a href="{{ route('quiz',[$id_kelas,$item->id]) }}">{{ route('quiz',[$id_kelas,$item->id]) }}</a>
                                            @else
                                                <p>{!! $item->description !!}</p>
                                            @endif
                                        </div>
                                        @if ($item->type == 'quiz')
                                            <div class="col">
                                                <div class="owl-item active" style="width: 338.667px; margin-right: 15px;">
                                                    <div class="border rounded-3 bg-white p-3">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center">
                                                                <img src="{{ asset('asset/img/icon/qa.png') }}" alt="YouTube Icon" class="me-2" width="35">
                                                                <h5 class="text-nowrap">
                                                                    <a href="{{ route('quiz', [$id_kelas, $item->id]) }}" target="_blank">Soal Pilihan Ganda</a>
                                                                </h5>
                                                            </div>
                                                            <div class="d-flex align-items-center">

                                                                <div class="dropdown">
                                                                    <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false" class="dropset">
                                                                        <i class="fa fa-ellipsis-v"></i>
                                                                    </a>
                                                                    <ul class="dropdown-menu">
                                                                        <li>
                                                                            <!-- Add a download link -->
                                                                            <a class="dropdown-item">Download File</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-between mt-3">
                                                            <p class="text-primary mb-0 me-2">{{ $item->created_at->diffForHumans() }}</p>
                                                            <div>
                                                                <a href="{{ route('quiz', [$id_kelas, $item->id]) }}" class="btn btn-primary">Ayo Mulai!</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        @else
                                            {{-- media --}}
                                        <div class="row g-2">
                                            @if($item->media)
                                                @foreach ($item->media as $media)

                                                <div class="owl-item active" style="width: 338.667px; margin-right: 15px;">
                                                    <div class="border rounded-3 bg-white p-3">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center">
                                                                @if(isset($media->exstention) && $media->exstention == 'pdf')
                                                                    <img src="{{ asset('asset/img/icon/pdf-02.svg') }}" alt="PDF Icon" class="me-2">
                                                                    <h5 class="text-nowrap"><a href="/storage/{{ $media->file_path }}" target="_blank" >{{ Str::limit($media->name, 20, '...') }}</a></h5>
                                                                @elseif(isset($media->exstention) && in_array($media->exstention, ['doc', 'docx']))
                                                                    <img src="{{ asset('asset/img/icon/doc.png') }}" alt="Document Icon" class="me-2" width="50px">
                                                                    <h5 class="text-nowrap"><a href="/storage/{{$media->file_path }}" download="{{ $media->name }}">{{ Str::limit($media->name, 20, '...') }}</a></h5>
                                                                @else
                                                                    <img src="{{ asset('asset/img/icon/word.png') }}" alt="Default Icon" class="me-2" width="50px">
                                                                    <h5 class="text-nowrap"><a href="/storage/{{$media->file_path }}" download>{{ Str::limit($media->name, 20, '...') }}</a></h5>
                                                                @endif
                                                            </div>
                                                            <div class="d-flex align-items-center">

                                                                <div class="dropdown">
                                                                    <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false" class="dropset">
                                                                        <i class="fa fa-ellipsis-v"></i>
                                                                    </a>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a href="/storage/{{$media->file_path }}" download="{{ $media->name }}" class="dropdown-item">Download File</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-start mt-3">
                                                            <p class="text-primary mb-0 me-2">{{ $media->created_at->diffForHumans() }}</p>
                                                            <span class="d-flex align-items-center fw-semibold me-2"><i class="ti ti-circle-filled fs-5 me-2"></i>
                                                                {{ number_format($media->size / 1048576, 2) }} MB
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @endif
                                            @if($item->links)
                                                @php
                                                // Decode links into an array
                                                $linksArray = json_decode($item->links->youtube_link, true);
                                                @endphp

                                                @foreach($linksArray as $link)
                                                <div class="owl-item active" style="width: 338.667px; margin-right: 15px;">
                                                    <div class="border rounded-3 bg-white p-3">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center">
                                                                <img src="{{ asset('asset/img/icon/youtube.png') }}" alt="YouTube Icon" class="me-2" width="34">
                                                                <h5 class="text-nowrap">
                                                                    <a href="{{ $link }}" target="_Blank">YouTube Video</a>
                                                                </h5>
                                                            </div>
                                                            <div class="d-flex align-items-center">

                                                                <div class="dropdown">
                                                                    <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false" class="dropset">
                                                                        <i class="fa fa-ellipsis-v"></i>
                                                                    </a>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a href="{{ $link }}" target="_blank" class="dropdown-item">Details</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-start mt-3">
                                                            <p class="text-primary mb-0 me-2">{{ $item->created_at->diffForHumans() }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @endif

                                        </div>
                                        @endif

                                    </div>

                                </div>
                                <div class="d-flex align-items-center board-action mb-3">

                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                <div class="card p-5">
                    <div class="d-flex justify-content-center">
                        <p>Belum membuat postingan apapun</p>
                    </div>
                </div>
                @endif

            </div>

            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <strong>Unggah Tugas</strong>
                        <h3 class="text-white"></h3>
                        <div class="d-flex align-items-center">
                            <div class="dropdown">
                                <a href="#" class="btn btn-white btn-icon btn-sm d-flex align-items-center justify-content-center rounded-circle p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical fs-14"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right p-3">
                                    <li>
                                        <a class="dropdown-item rounded-1" href="edit-teacher.html"><i class="ti ti-edit-circle me-2"></i>Edit</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-1" href="#" data-bs-toggle="modal" data-bs-target="#delete-modal"><i class="ti ti-trash-x me-2"></i>Delete</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card position-relative">
                            <!-- Button X in top-right corner -->
                            <button class="btn-close position-absolute top-0 end-0 m-2" aria-label="Close"></button>

                            <div class="card-body d-flex justify-content-center">
                                <img src="{{ asset('asset/img/icon/word.png') }}" width="100">
                            </div>
                            <center class="mb-2"><span class="ti ti-check text-success"></span>File Terkumpulkan</center>
                        </div>
                        <input type="file" class="form-control">
                    </div>

                </div>

            </div>
        </div>
        <div class="container ">
            <h4 class="mb-3"><span class="ti ti-brand-hipchat"></span> Forum Diskusi</h4>
            <div class="card">
                <!-- Daftar komentar -->
                <div class="card-body" id="commentSection" style="max-height: 400px; overflow-y: auto;">
                    <div id="loadingIndicator" class="d-flex justify-content-center" style="display: none;">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    {{-- .... --}}
                </div>
                <div class="card-footer bg-light">
                    <div class="d-flex align-items-center " >
                        <input type="text" name="user_id" id="nameInput" class="form-control me-2" placeholder="Masukkan nama Anda..." value="{{ auth()->user()->nomor }}" hidden>
                        <input type="text" name="username" id="nameInputName" class="form-control me-2" placeholder="Masukkan nama Anda..." value="{{ auth()->user()->nama }}" hidden>
                        <input type="text" name="id_kelas" class="form-control me-2" placeholder="Masukkan nama Anda..." value="{{ $id_kelas }}" hidden>
                        <input type="text" name="task_id" class="form-control me-2" placeholder="Masukkan nama Anda..." value="{{ $task_id }}" hidden>
                    </div>
                    <div class="d-flex align-items-center">
                        @if(auth()->user()->student)
                            <img src="/storage/{{ auth()->user()->student->foto }}" class="rounded-circle me-3" alt="avatar" width="50">
                        @elseif (auth()->user()->gtk)
                            <img src="/storage/{{ auth()->user()->gtk->gambar }}" class="rounded-circle me-3" alt="avatar" width="50">
                        @else
                            <img src="{{ asset('asset/img/user-default.jpg') }}" class="rounded-circle me-3" alt="avatar" width="50">
                        @endif
                        <button id="emojiPickerButton" class="btn ">😊</button>
                        <input type="text" id="commentInput" name="comment" class="form-control me-2  p-2" placeholder="Tulis komentar..." style="border-radius:50px;">

                        <button class="btn btn-primary" onclick="addComment()"  style="border-radius:20px;"> Kirim </button>
                    </div>

                    <div id="emojiPicker" class="mt-2" style="display: none;  z-index: 1000;border-radius:30px; border: 1px solid #ccc; background-color: white; padding: 10px; ">
                       @include('classroom.partial_detail.emote')

                        <!-- Add more emoji buttons here -->
                    </div>
                </div>
            </div>
        </div>

</div>
@endforeach

@section('myjavascript')

<script>
    // Get elements
    const emojiButton = document.getElementById("emojiPickerButton");
    const emojiPicker = document.getElementById("emojiPicker");
    const commentInput = document.getElementById("commentInput");

    // Toggle emoji picker visibility when emoji button is clicked
    emojiButton.addEventListener("click", function() {
        emojiPicker.style.display = emojiPicker.style.display === "none" ? "block" : "none";
        const rect = emojiButton.getBoundingClientRect();
        emojiPicker.style.left = rect.left + "px";  // Position the emoji picker below the button
        emojiPicker.style.top = rect.bottom + "px";
    });

    // Insert emoji into the input field when clicked
    emojiPicker.addEventListener("click", function(e) {
        if (e.target && e.target.classList.contains("emoji")) {
            const emoji = e.target.getAttribute("data-emoji");
            commentInput.value += emoji;  // Append emoji to the input field
        }
    });

    // Close the emoji picker if clicked outside
    window.addEventListener("click", function(e) {
        if (!emojiButton.contains(e.target) && !emojiPicker.contains(e.target)) {
            emojiPicker.style.display = "none";  // Close picker when clicking outside
        }
    });
</script>

<script>
    // Function to add a new comment via AJAX
function addComment() {
    const commentInput = document.getElementById('commentInput');
    const commentText = commentInput.value.trim();

    if (!commentText) {
        alert('Komentar tidak boleh kosong!');
        return;
    }

    // Prepare the data
    const data = {
        comment: commentText,
        user_id: document.querySelector('[name="user_id"]').value,  // Assuming user_id is a hidden input
        username: document.querySelector('[name="username"]').value,  // Assuming username is a hidden input
        id_kelas: document.querySelector('[name="id_kelas"]').value,
        task_id: document.querySelector('[name="task_id"]').value
    };

    // Send the comment to the server via AJAX
    fetch('{{ route('comments.store') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'  // CSRF Token
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Add the new comment to the comment section
            addCommentToSection(data.comment);
            commentInput.value = '';  // Clear the input field
        } else {
            alert('Gagal mengirim komentar!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan, coba lagi nanti.');
    });
}

// Function to add a comment to the comment section
function addCommentToSection(commentData) {
    const commentSection = document.getElementById('commentSection');

    // Create the new comment element
    const newComment = document.createElement('div');
    newComment.classList.add('d-flex', 'align-items-start', 'mb-3');
    let $link;

    if (commentData.gtkFoto && commentData.gtkFoto !== '') {
        $link = '/storage/' + commentData.gtkFoto.gambar;  // Concatenate correctly using + operator
    } else if (commentData.studentFoto && commentData.studentFoto !== '') {
        // If gtkFoto is not available, check studentFoto
        $link = '/storage/' + commentData.studentFoto.foto;  // Concatenate correctly using + operator
    } else {
        // Fallback to a default image if neither is available
        $link = '{{ asset("asset/img/user-default.jpg") }}';  // Laravel Blade helper
    }
    // Create the new comment element

    newComment.classList.add('d-flex', 'align-items-start', 'mb-3');

    newComment.innerHTML = `
        <img src="${$link}" class="rounded-circle me-3" alt="avatar" width="40">
        <div>
            <strong>${commentData.username}</strong> <small>| ${commentData.created_at} </small>
            <div class="p-3 bg-light rounded">${commentData.comment}</div>
        </div>
    `;

    // Append the new comment to the top (or bottom) of the comment section
    commentSection.prepend(newComment);
}

// Function to fetch the latest comments every 5 seconds (polling)
function fetchComments() {
    const taskId = document.querySelector('[name="task_id"]').value;  // Get task_id from the hidden input field

    fetch('{{ route('comments.index') }}' + '?task_id=' + taskId)  // Pass task_id as a query parameter
        .then(response => response.json())
        .then(data => {
            const commentSection = document.getElementById('commentSection');

            // Clear existing comments (optional, if you want to reload all comments)
            commentSection.innerHTML = '';

            if (data.success && data.comments.length > 0) {
                // If there are comments, add them to the section
                data.comments.forEach(comment => {
                    addCommentToSection(comment);  // Add each comment to the section
                });
            } else {
                // If there are no comments, display a message
                const noCommentsMessage = document.createElement('div');
                noCommentsMessage.classList.add('p-3', 'bg-light', 'rounded', 'text-center');
                noCommentsMessage.textContent = 'Belum ada komentar untuk tugas ini.';
                commentSection.appendChild(noCommentsMessage);
            }
        })
        .catch(error => {
            console.error('Error fetching comments:', error);
        });
    }

// Polling every 5 seconds to fetch new comments
setInterval(fetchComments, 5000);

</script>

@endsection
@endsection
