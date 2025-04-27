@extends('plugin.classroom.layout.classRoom')
@section('css')
<script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@4.6.2/dist/emoji-button.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/css/lightbox.min.css" rel="stylesheet">
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
         .preview-container {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
        }
        .preview-box {
            position: relative;
            width: 140px;
            margin-right: 10px;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
            box-sizing: border-box;
        }
        .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: red;
            border-radius:30px;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 14px;
            padding: 5px;
        }
        .preview-box img {
            max-width: 100%;
            height: auto;
        }
        .preview-box p {
            font-size: 14px;
            margin-top: 10px;
            word-wrap: break-word;
        }
        .disabled-section {
            opacity: 0.5;
            pointer-events: none;  /* Prevent interactions */
        }
</style>

@endsection
@section('content')
@foreach ($myclass as $item )
<div class="pt-4">
    <div class="p-3" >

        <div class="d-flex justify-content-between mb-3 border-bottom">
            <div>
                <h3 class="mt-3 mb-2">Detail Tugas</h3>
            </div>
            @if(auth()->user()->role != 'siswa')
                <div class="m-2">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                                <span class="ti ti-list-details"></span> Detail
                            </a>
                        </li>

                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                                <span class="ti ti-clipboard-list"></span> Tugas Siswa
                            </a>
                        </li>

                        <li class="nav-item" role="presentation">
                            <a class="btn btn-primary" onclick="window.location.reload(); window.location.href='/classroom/detail/{{ $id_kelas }}';">
                                <span class="ti ti-arrow-left"></span> Kembali
                            </a>
                        </li>
                    </ul>

                </div>
            @else
            <a class="btn btn-primary my-3" href="/classroom/detail/{{ $id_kelas }}">
                <span class="ti ti-arrow-left"></span> Kembali
            </a>
            @endif
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
                                                        <a class="avatar avatar-lg flex-shrink-0">
                                                            @if(optional($item->user->gtk)->gambar)
                                                            <img src="{{ asset('storage/' . $item->user->gtk->gambar) }}" alt="Img" class="img-fluid rounded-circle">
                                                            @else
                                                                <img src="{{ asset('asset/img/user-default.jpg') }}" alt="Img" class="img-fluid rounded-circle">
                                                            @endif
                                                        </a>

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
                                                    Kunjungi link berikut ini untuk memulai,jangan lupa berdo'a terlebih dahulu sebelum dimulai :)
                                                    <p>
                                                        @if($score && $score->where('status', '1')->where('student_id', auth()->user()->nomor)->count() > 0)
                                                            <div class="alert alert-info" role="alert">
                                                                Terimakasih sudah mengikuti quiz atau tugas Ini 😊
                                                            </div>
                                                        @else
                                                            <a href="{{ route('quiz',[$id_kelas,$item->id]) }}">{{ route('quiz',[$id_kelas,$item->id]) }}</a>
                                                        @endif
                                                    </p>
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
                                                                            @if($score && $score->where('status', '1')->where('student_id', auth()->user()->nomor)->count() > 0)
                                                                                Soal Pilihan Ganda
                                                                             @else
                                                                                <a href="{{ route('quiz', [$id_kelas, $item->id]) }}" target="_blank">Soal Pilihan Ganda</a>
                                                                             @endif

                                                                        </h5>
                                                                    </div>

                                                                </div>
                                                                <div class="d-flex align-items-center justify-content-between mt-3">
                                                                    <p class="text-primary mb-0 me-2">{{ $item->created_at->diffForHumans() }}</p>
                                                                    <div>
                                                                        @if($score && $score->where('status', '1')->where('student_id', auth()->user()->nomor)->count() > 0)
                                                                        @else
                                                                            <a href="{{ route('quiz', [$id_kelas, $item->id]) }}" class="btn btn-primary">Ayo Mulai!</a>
                                                                        @endif

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
                                                                            <h5 class="text-nowrap"><a href="{{ asset('storage/' . $media->file_path) }}" target="_blank" >{{ Str::limit($media->name, 20, '...') }}</a></h5>
                                                                        @elseif(isset($media->exstention) && in_array($media->exstention, ['doc', 'docx']))
                                                                            <img src="{{ asset('asset/img/icon/doc.png') }}" alt="Document Icon" class="me-2" width="50px">
                                                                            <h5 class="text-nowrap"><a href="{{ asset('storage/' . $media->file_path) }}" download="{{ $media->name }}">{{ Str::limit($media->name, 20, '...') }}</a></h5>
                                                                        @else
                                                                            <img src="{{ asset('asset/img/icon/word.png') }}" alt="Default Icon" class="me-2" width="50px">
                                                                            <h5 class="text-nowrap"><a href="{{ asset('storage/'  . $media->file_path) }}" download>{{ Str::limit($media->name, 20, '...') }}</a></h5>
                                                                        @endif
                                                                    </div>
                                                                    <div class="d-flex align-items-center">

                                                                        <div class="dropdown">
                                                                            <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false" class="dropset">
                                                                                <i class="fa fa-ellipsis-v"></i>
                                                                            </a>
                                                                            <ul class="dropdown-menu">
                                                                                <li><a href="{{ asset('storage/' . $media->file_path) }}" download="{{ $media->name }}" class="dropdown-item">Download File</a></li>
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
                            <!-- Display Validation Errors -->
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="card-header">
                                <h4>Manangement Upload</h4>
                            </div>
                            <form action="{{ route('filetugas.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="text" name="task_id" value="{{ $task_id }}" hidden>

                                <div class="card-body {{ auth()->user()->role == 'superadmin' ? 'disabled-section' : ''}} n">
                                    @if ($files->isEmpty())
                                        <!-- No files, show the upload form -->
                                        <input type="text" name="student_id" id="student_id" value="{{ auth()->user()->nomor }}" hidden>
                                        <input type="file" class="form-control" name="files[]" id="fileInput" multiple onchange="previewFiles()" >

                                        <!-- Preview container -->
                                        <div class="row">
                                            <div class="preview-container" id="previewContainer">
                                                <!-- Preview will appear here -->
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100"> <span class="ti ti-upload"></span> Upload File</button>
                                    @else
                                        <!-- Files exist, display them -->
                                        <div class="alert alert-info">
                                            <div class="mb-3">
                                                <strong>Tugas telah diserahkan :</strong>
                                            </div>

                                            <ul>
                                                @foreach ($files as $file)
                                                <li class="d-flex justify-content-start align-items-center mb-2">
                                                    <!-- Delete Button (on the left) -->
                                                    @if($file->status != 2)
                                                    <a href="/file-tugas/{{ $file->id }}" class="btn btn-danger btn-sm me-2"
                                                       onclick="return confirm('Are you sure you want to delete this file?')">
                                                       <span class="ti ti-trash-x"></span>
                                                    </a>
                                                    @endif

                                                    <!-- File details (on the right) -->
                                                    <div class="ml-2">
                                                        <a href="{{ Storage::url($file->path) }}" target="_blank">{{ $file->file_name }}</a>
                                                        ({{ number_format($file->size / 1024, 2) }} KB) @if($file->status == 2)<span class="ti ti-checks text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Tugas telah diperiksa"></span>@endif

                                                    </div>
                                                </li>

                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </form>


                        </div>
                    @else
                    @php
                    $totalScore = 0;  // Initialize the variable to store total score
                    $time = 0;
                    $status= ''       // Initialize time variable to store finish time
                @endphp

                @foreach ($score as $item)
                    @php
                        $totalScore = $item->nilai;  // Add the score to total score
                        $time = $item->finish_time;
                        $status = $item->status;  // Keep updating with the last finish time
                    @endphp
                @endforeach

                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 align="center">Your Score</h4>
                            @if($status == '1' ?? '')
                             <span class="badge bg-success d-inline-flex align-items-center ms-2"> Sudah Mengkuti Quiz ini</span>
                            @endif
                        </div>

                    </div>

                    <div class="card-body bg-light">
                        <div align="center">
                            <h1 class="text-success mt-4 fs-1">{{ $totalScore ?? '0' }}</h1><br>  <!-- Display total score or default to 0 -->
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>Finish Time: </strong>
                            </div>
                            <div>
                                <span class="text-success">{{ $time ?? '-' }}</span>  <!-- Display finish time or default to 0 -->
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
                        @php
                            $user = auth()->user();
                            $foto = $user->student ? $user->student->foto : ($user->gtk ? $user->gtk->gambar : null);
                        @endphp

                        <img src="{{ $foto ? asset('storage/' . $foto) : asset('asset/img/user-default.jpg') }}"
                        class="rounded-circle me-3"
                        alt="avatar" width="50">


                        <button id="emojiPickerButton" class="btn ">😊</button>
                        <input type="text" id="commentInput" name="comment" class="form-control me-2  p-2" placeholder="Tulis komentar..." style="border-radius:50px;">

                        <button class="btn btn-primary" onclick="addComment()"  style="border-radius:20px;"> Kirim </button>
                    </div>

                    <div id="emojiPicker" class="mt-2" style="display: none;  z-index: 1000;border-radius:30px; border: 1px solid #ccc; background-color: white; padding: 10px; ">
                       @include('plugin.classroom.partial_detail.emote')

                        <!-- Add more emoji buttons here -->
                    </div>
                </div>
            </div>
        </div>

            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="py-3">
                    <input type="text" class="form-control" placeholder="Search..." id="myInput" onkeyup="myFunction()">
                </div>

                <table class="table table-nowrap mb-0" id="tabeltugas">
                    <thead>
                        <tr>
                            <th width="1%"></th>
                            <th>Nama</th>
                            <th>Tanggal Pengumpulan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    {{-- @if ($peserta->count()) --}}
                        @php
                            // Initialize an array to store the processed student IDs
                            $processedStudentIds = [];
                        @endphp
                        @if($peserta->where('task_id', $task_id)->count())
                            @foreach ($peserta as $key => $item)
                                <tr>
                                    <!-- Iterate through each student -->
                                    @foreach($item->student as  $student)
                                        @if (!in_array($student->id, $processedStudentIds)) <!-- Check if this student has been displayed already -->
                                            @php
                                                // Mark this student as processed by adding their ID to the array
                                                $processedStudentIds[] = $student->id;
                                            @endphp

                                            <td>
                                                @if($item->status == '1')
                                                    <span class="ti ti-check" data-bs-toggle="tooltip" title="Belum Diperiksa"></span>
                                                @else
                                                    <span class="ti ti-checks text-success" data-bs-toggle="tooltip" title="Sudah Diperiksa"></span>
                                                @endif
                                            </td>

                                            <td width="50%">
                                                <div class="d-flex align-items-center">
                                                    <a href="#" class="avatar avatar-md">
                                                        <!-- Check if student photo exists -->
                                                        @if ($student->foto == '')
                                                            <img src="{{ asset('asset/img/user-default.jpg') }}" class="img-fluid rounded-circle" alt="foto">
                                                        @else
                                                            <img src="{{ asset('storage/' .  $student->foto ) }}" class="img-fluid rounded-circle" alt="foto">
                                                        @endif
                                                    </a>
                                                    <div class="ms-2">
                                                        <p class="mb-0">{{ $student->nama }}</p>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y | H:i') }}</td>

                                            <!-- Button to view assignment with a modal trigger -->
                                            <td>
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#fileModal-{{ $item->student_id }}">
                                                    <span class="ti ti-eye"></span> Lihat Tugas
                                                </button>
                                            </td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach

                        @else
                        <tr>
                            <td colspan="4" class="text-center">Belum ada tugas yang dikumpulkan</td>
                        </tr>
                        @endif

                    </tbody>
                </table>
             </div>

        </div>


</div>
@endforeach
@foreach ($peserta as $file)
<div class="modal fade" id="fileModal-{{ $file->student_id }}" tabindex="-1" data-bs-backdrop="static" aria-labelledby="fileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="fileModalLabel">File List</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('filetugas.verifikasi') }}" method="post">
            @csrf
            <div class="modal-body p-0 m-0">
            <!-- Table inside modal body -->
            <table class="table ">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">File Name</th>
                    <th scope="col">Size</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                    @php
                        $no =1;
                    @endphp
                <!-- Example Table Rows (Add more as needed) -->
                @foreach ($peserta->where('student_id',$file->student_id ) as $file)
                <tr>
                    <td>
                        <input type="text" name="id[]" value="{{ $file->id }}" hidden>
                        {{ $no++ }}</td>
                    <td>{{ $file->file_name }}</td>
                    <td>{{ number_format($file->size / 1024, 2) }} KB</td>
                    <td>
                        <a href="{{ Storage::url($file->path) }}" data-lightbox="gallery" class="btn btn-success btn-sm me-2"><span class="ti ti-eye"></span> Periksa Tugas</a>
                        <a href="{{ Storage::url($file->path) }}" target="_blank" class="btn btn-primary btn-sm" download><span class="ti ti-download"></span></a></td>
                </tr>
                @endforeach

                <!-- Add more files here -->
                </tbody>
            </table>
            </div>
            <div class="modal-footer">
                <div class="mb-3">
                    <label for="status" class="form-label">Masukan Score / Nilai </label>
                    <input type="text" class="form-control" name="task_id" value="{{ $task_id }}" hidden>
                    <input type="text" class="form-control" name="student_id" value="{{ $file->student_id }}" hidden>
                    @php
                        $scoreRecord = $score->where('student_id',$file->student_id)->first()->nilai ?? '';  // Get the 'nilai' of the first record
                    @endphp

                    <input type="number" class="form-control" name="score" placeholder="1-100"
                    value="{{ $scoreRecord }}" min="1" max="100">
                </div>
            <button type="submit" class="btn btn-primary w-100" >Selesai</button>
            </div>
        </form>
      </div>
    </div>
  </div>
@endforeach

@section('myjavascript')
<script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/js/lightbox.min.js"></script>
<script>
    function myFunction() {
      // Declare variables
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("tabeltugas");
      tr = table.getElementsByTagName("tr");

      // Loop through all table rows, and hide those who don't match the search query
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
    </script>
<script>
    // Menyimpan tab aktif ke localStorage saat tab berubah
    const tabs = document.querySelectorAll('.nav-link');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            localStorage.setItem('activeTab', tab.id);
        });
    });

    // Memuat tab yang aktif setelah halaman di-load
    document.addEventListener('DOMContentLoaded', () => {
        const activeTabId = localStorage.getItem('activeTab');
        if (activeTabId) {
            const activeTab = document.getElementById(activeTabId);
            if (activeTab) {
                const tab = new bootstrap.Tab(activeTab);
                tab.show();
            }
        }
    });
</script>

<script>
    function previewFiles() {
        const fileInput = document.getElementById('fileInput');
        const previewContainer = document.getElementById('previewContainer');

        // Clear previous previews
        previewContainer.innerHTML = '';

        const files = fileInput.files;
        if (files.length > 0) {
            Array.from(files).forEach(file => {
                const previewBox = document.createElement('div');
                previewBox.classList.add('preview-box');

                // Remove button
                const removeBtn = document.createElement('button');
                removeBtn.classList.add('remove-btn');
                removeBtn.textContent = 'x';
                removeBtn.onclick = function() {
                    previewBox.remove(); // Remove the preview box
                };
                previewBox.appendChild(removeBtn);

                // Icon and file name
                const icon = document.createElement('img');
                const fileType = file.type.split('/')[0]; // Determine if file is image or not

                // Default icon for non-image files
                if (fileType !== 'image') {
                    icon.src = '{{ asset("asset/img/icon/word.png") }}'; // You can replace this with any appropriate icon
                } else {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        icon.src = e.target.result; // For images, use the image preview
                    };
                    reader.readAsDataURL(file);
                }
                previewBox.appendChild(icon);

                // File name
                const fileName = document.createElement('p');
                fileName.textContent = file.name;
                previewBox.appendChild(fileName);

                previewContainer.appendChild(previewBox);
            });
        }
    }
</script>
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
    let assetPath = "{{ asset('') }}"; // Base asset UR

    // Memeriksa gtkFoto
    if (commentData.gtkFoto && commentData.gtkFoto.gambar) {
        if (commentData.gtkFoto.gambar == null || commentData.gtkFoto.gambar === '') {
            // Jika gambar kosong atau null, gunakan gambar default
            $link = assetPath + 'asset/img/user-default.jpg';
        } else {
            // Jika ada gambar, gunakan storage path
            $link = assetPath + 'storage/' + commentData.gtkFoto.gambar;
        }
    } else if (commentData.studentFoto && commentData.studentFoto.foto) {
        // Jika gtkFoto tidak ada, periksa studentFoto
        if (commentData.studentFoto.foto == null || commentData.studentFoto.foto === '') {
            $link = assetPath + 'asset/img/user-default.jpg';
        } else {
            $link = assetPath + 'storage/' + commentData.studentFoto.foto;
        }
    } else {
        // Jika keduanya tidak ada, gunakan gambar default
        $link = assetPath + 'asset/img/user-default.jpg';
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
