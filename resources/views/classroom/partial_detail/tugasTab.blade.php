<div class="tab-pane" id="bottom-tab2" role="tabpanel">

    <div class="bg-white p-3 border rounded-1 d-flex align-items-center justify-content-between flex-wrap mb-4 pb-0">
        <h4 class="mb-3">Daftar Tugas</h4>
        <div class="d-flex align-items-center flex-wrap">
            <div class="d-flex align-items-center flex-wrap">
                @if(auth()->user()->role !=="siswa")
                <div class="dropdown mb-3">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="ti ti-circle-plus"></span> Buat
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a href="{{ route('classroom.tugas',$id) }}" class="dropdown-item" href="#"><span class="ti ti-clipboard-list"></span> Tugas / Pengumuman</a></li>
                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#addMateri"><span class="ti ti-clipboard-text"></span> Tugas Kuis Kelas</a></li>
                      
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="">
        <h5 class="mb-3 border-bottom pb-2"><span class="ti ti-clipboard-list"></span>List Tugas</h5>
        @if($task->count())
            @foreach ($task as $item)
                @if($item->type == "quiz")
                    <div class="card board-hover mb-3">
                        <div class="card-body d-md-flex align-items-center justify-content-between pb-1">
                            <div class="d-flex align-items-center mb-3">
                            
                                <span class="bg-soft-primary text-primary avatar avatar-md me-2 br-5 flex-shrink-0">
                                    <i class="ti ti-question-mark fs-16"></i>
                                </span>
                                <div>
                                    <h6 class="mb-1 fw-semibold">
                                        <a href="{{ route('classroom.quiz',[$id,$item->id]) }}" >{{ $item->judul }}</a>
                                    </h6>
                                    <p><i class="ti ti-calendar me-1"></i>Added {{ $item->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center board-action mb-3">
                                <a href="{{ route('classroom.quiz',[$id,$item->id]) }}" class="text-primary border rounded p-2 badge me-1 primary-btn-hover">
                                Lihat Pertanyaan
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#editMateri-{{ $item->id }}" class="text-danger border rounded p-1  me-1 badge danger-btn-hover">
                                    <i class="ti ti-pencil fs-16"></i>
                                </a>
                                <a href="javascript:void(0);"  class="text-danger border rounded p-1 badge danger-btn-hover">
                                    <i class="ti ti-trash-x fs-16"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card board-hover mb-3">
                        <div class="card-body pb-1">
                            <div class="d-md-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center mb-3">
                                
                                    <span class="bg-soft-success text-success avatar avatar-md me-2 br-5 flex-shrink-0">
                                        <i class="ti ti-notification fs-16"></i>
                                    </span>
                                    <div>
                                        <!-- Trigger for Collapsible Content -->
                                        <h6 class="mb-1 fw-semibold">
                                            <a href="#details-{{ $item->id }}" class="text-decoration-none" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="details-{{ $item->id }}">
                                                {{ $item->judul }}
                                            </a>
                                        </h6>
                                        <p>
                                            <i class="ti ti-calendar me-1"></i>
                                            Added {{ $item->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center board-action mb-3">
                                    <a href="{{ route('classroom.editTugas', $item->id) }}" class="text-primary border rounded p-1 badge me-1 primary-btn-hover">
                                        <i class="ti ti-edit-circle fs-16"></i>
                                    </a>
                                    <a href="{{ route('classroom.deleteTaskAction',$item->id) }}"class="text-danger border rounded p-1 badge danger-btn-hover">
                                        <i class="ti ti-trash-x fs-16"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Collapsible Content -->
                        <div id="details-{{ $item->id }}" class="collapse">
                            <div class="card-body border-top p-5">
                                <div class="d-flex align-items-center">
                                    <a class="avatar avatar-lg flex-shrink-0"><img src="http://127.0.0.1:8000/asset/img/user-default.jpg" class="img-fluid rounded-circle" alt="img"></a>
                                    <div class="ms-2">
                                        <h6 class="text-dark text-truncate mb-0"><a>Administrator</a></h6>
                                        <small class="text-muted">23 Des 2024</small>
                                    </div>
                                </div>

                                <p>{!! $item->description !!}</p>
                                <div class="row g-2">
                                    @if($item->media)
                                    @foreach ($item->media as $media)
                                    <div class="owl-item active" style="width: 338.667px; margin-right: 15px;">
                                        <div class="border rounded-3 bg-white p-3">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    @if(isset($media->exstention) && $media->exstention == 'pdf')
                                                    <img src="{{ asset('asset/img/icon/pdf-02.svg') }}" alt="PDF Icon" class="me-2">
                                                    <h5 class="text-nowrap"><a href="{{ route('download',$media->file_path)}}" download>{{ Str::limit($media->name, 20, '...') }}</a></h5>
                                                    @elseif(isset($media->exstention) && in_array($media->exstention, ['doc', 'docx']))
                                                    <img src="{{ asset('asset/img/icon/doc.png') }}" alt="Document Icon" class="me-2" width="50px">
                                                    <h5 class="text-nowrap"><a href="javascript:void(0);">{{ Str::limit($media->name, 20, '...') }}</a></h5>
                                                    @else
                                                    <img src="{{ asset('asset/img/icon/word.png') }}" alt="Default Icon" class="me-2" width="50px">
                                                    <h5 class="text-nowrap"><a href="javascript:void(0);">{{ Str::limit($media->name, 20, '...') }}</a></h5>
                                                    @endif
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <a href="javascript:void(0);"><i class="fa fa-star me-2"></i></a>
                                                    <div class="dropdown">
                                                        <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false" class="dropset">
                                                            <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li><a href="javascript:void(0);" class="dropdown-item">Details</a></li>
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
                                                        <a href="javascript:void(0);" class="lightbox-video" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-url="{{ $link }}">YouTube Video</a>
                                                    </h5>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <a href="javascript:void(0);"><i class="fa fa-star me-2"></i></a>
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

                                <!-- Modal for Video Embedding -->
                                <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="videoModalLabel">YouTube Video</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="embed-responsive embed-responsive-16by9">
                                                    <iframe id="videoIframe" class="embed-responsive-item" src="" allowfullscreen width="100%" height="500px"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Add more details as needed -->
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @else
        <div class="card p-5">
            <div class="d-flex justify-content-center">
                <p>Belum membuat tugas apapun</p>
            </div>
        </div> 
        @endif
    </div>
</div>
