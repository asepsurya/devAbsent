@extends('classroom.layout.classRoom')
@section('css')
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
</style>
@endsection
@section('content')
{{-- <div class="pt-5">
    asdddddddddddddddddddd
</div> --}}
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
        <div class="card">
            <div class="card-header ">
                {{-- komentar --}}
                <div class="comment-box">
                    <img src="https://via.placeholder.com/40" class="comment-avatar" alt="avatar">
                    <input type="text" id="commentInput" placeholder="Tulis komentar..." />
                    <button class="btn btn-primary" onclick="addComment()">Kirim</button>
                </div>

            </div>
            <div class="card-body">
              <p>Tidak Ada tugas yang perlu diselesaikan</p>
            </div>
        </div>
    </div>


</div>
@endforeach
@endsection
