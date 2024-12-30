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

        /* Additional custom styles for toggling details */
        .detail-row {
            display: none;
        }
        .clickable {
            cursor: pointer;
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
<div class="pt-4">
    <div class="p-3" >

        <div class="d-flex justify-content-between mb-3 border-bottom">
            <div>
                <h3 class="mt-3">Detail Tugas</h3>
            </div>
            <div class="m-2">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><span class="ti ti-list-details"></span> Detail</a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><span class="ti ti-clipboard-list"></span> Tugas Siswa</a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a class=" btn btn-primary"  href="/classroom/detail/{{ $id_kelas }}" ><span class="ti ti-arrow-left"></span> Kembali</a>
                    </li>
                </ul>
                {{-- <a href="/classroom/detail/{{ $id_kelas }}" class="btn btn-primary"><span class="ti ti-arrow-left"></span>Kembali</a> --}}
            </div>

        </div>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
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
                        @if($item->type == 'task')
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
                    @else
                        <div class="card">
                            <div class="card-header">
                                <h4 align="center">Your Score</h4>
                            </div>
                            <div class="card-body bg-light">
                                <div align="center">
                                    <h1 class="text-success mt-4 fs-1">100</h1><br>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <span class="text-success">Benar </span> :10
                                    </div>
                                    <div>
                                        <span class="text-danger">Salah</span> : 0
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    </div>
                </div>
                  {{-- komentar --}}
        <div class="mt-4">
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
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="py-3">
                    <input type="text" class="form-control" placeholder="Search...">
                </div>

                <table class="table table-nowrap mb-0" id="myTable2">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Tanggal Pengumpulan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($peserta->count())

                            @foreach ($peserta as $item )
                            <tr>
                            <td width="50%">
                                    <div class="d-flex align-items-center">
                                    <a href="#" class="avatar avatar-md">
                                            @if ( $item->peopleStudent->foto =='')
                                                <img src="{{ asset('asset/img/user-default.jpg') }}" class="img-fluid rounded-circle" alt="foto">
                                            @else
                                                <img src="/storage/{{ $item->peopleStudent->foto }}" class="img-fluid rounded-circle" alt="foto">
                                            @endif
                                        </a>
                                        <div class="ms-2">
                                            <p class="mb-0">{{ $item->peopleStudent->nama }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>2 Januari 2025</td>
                                <td><button class="btn btn-primary btn-sm"  data-bs-toggle="modal" data-bs-target="#fileModal"><span class="ti ti-eye"></span> Lihat Tugas</button></td>
                            </tr>

                            @endforeach
                        @else
                            <tr>
                                <td>
                                    <div class="d-flex justify-content-center p-5">
                                        Belum ada peserta yang ditambahkan
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

             </div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <h4>Contact Tab</h4>
                <p>This is the contact tab content.</p>
            </div>
        </div>


</div>
@endforeach
<div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="fileModalLabel">File List</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Table inside modal body -->
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">File Name</th>
                <th scope="col">Size</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- Example Table Rows (Add more as needed) -->
              <tr>
                <th scope="row">1</th>
                <td>example-file1.pdf</td>
                <td>2.4 MB</td>
                <td><a href="#" class="btn btn-success btn-sm">Download</a></td>
              </tr>
              <tr>
                <th scope="row">2</th>
                <td>example-file2.jpg</td>
                <td>1.2 MB</td>
                <td><a href="#" class="btn btn-success btn-sm">Download</a></td>
              </tr>
              <tr>
                <th scope="row">3</th>
                <td>example-file3.zip</td>
                <td>15.6 MB</td>
                <td><a href="#" class="btn btn-success btn-sm">Download</a></td>
              </tr>
              <!-- Add more files here -->
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

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
            <strong>${commentData.username}</strong>
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
setInterval(fetchComments, 2000);

</script>

@endsection
@endsection
