
@foreach ($notice as $item)
    <!-- Render each announcement card -->
    <div class="card board-hover mb-3">
        <div class="card-body d-md-flex align-items-center justify-content-between pb-1">
            <div class="d-flex align-items-center mb-3">
                <div class="form-check form-check-md me-2">
                    <input class="form-check-input" type="checkbox">
                </div>
                <span class="bg-soft-primary text-primary avatar avatar-md me-2 br-5 flex-shrink-0">
                    <i class="ti ti-notification fs-16"></i>
                </span>
                <div>
                    <h6 class="mb-1 fw-semibold">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#view_details-{{ $item->id }}">{{ $item->title }}</a>
                    </h6>
                    <p><i class="ti ti-calendar me-1"></i>Added on : {{ \Carbon\Carbon::parse($item->date)->format('d M y') }}
                    </p>
                </div>
            </div>
            <div class="d-flex align-items-center board-action mb-3">
                <a href="javascript:void(0);" data-bs-toggle="modal"  data-bs-target="#edit-{{ $item->id }}" class="text-primary border rounded p-1 badge me-1 primary-btn-hover">
                    <i class="ti ti-edit-circle fs-16"></i>
                </a>
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete-modal" class="text-danger border rounded p-1 badge danger-btn-hover">
                    <i class="ti ti-trash-x fs-16"></i>
                </a>
            </div>
        </div>
    </div>
@endforeach
@foreach ($notice as $item)
<div class=" modal fade " id="view_details-{{ $item->id }}" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $item->title }}</h4>
                <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </button>
            </div>
            <div class="modal-body pb-0">
                <p>
                   {!! $item->content !!}
                </p>
                <div class="mb-3">
                    <label class="form-label d-block">Message To</label>
                    @foreach (json_decode($item->recived) as $a)
                        <span class="badge badge-soft-primary me-2">{{ ucfirst($a) }}</span>
                     @endforeach

                </div>
                <div class="border-top pt-3">
                    <div class="d-flex align-items-center flex-wrap">
                        <div class="d-flex align-items-center me-4 mb-3">
                            <span class="avatar avatar-sm bg-light me-1"><i class="ti ti-calendar text-default fs-14"></i></span>Added on: {{ \Carbon\Carbon::parse($item->date)->format('d M y') }}

                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <span class="avatar avatar-sm bg-light me-1"><i class="ti ti-user text-default fs-14"></i></span>Added By
                            : {{ $item->author }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /View Details -->

</div>
@endforeach

@foreach ( $notice as $item )
<div class="modal fade" id="edit-{{ $item->id }}" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">New Message</h4>
                <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </button>
            </div>
            <form action="{{ route('announcements.update') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" name="id" value="{{ $item->id }}" hidden>
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" value="{{ $item->title }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Author</label>
                                <input type="text" class="form-control" value="{{ $item->author }}" readonly name="author">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Notice Date</label>
                                <div class="date-pic">
                                    <input type="text" class="form-control datetimepicker" name="date" value="{{ $item->date }}">
                                    <span class="cal-icon"><i class="ti ti-calendar"></i></span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Message</label>
                                <textarea  class="form-control editor" rows="4" name="content">{{ $item->content }}</textarea>
                            </div>
                            <div class="mb-0">
                                <label class="form-label">Message To</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="checkboxs mb-1">
                                            <input type="checkbox" value="admin" name="recived[]"
                                                   {{ in_array('admin', json_decode($item->recived, true) ?? []) ? 'checked' : '' }}>
                                            <span class="checkmarks"></span>
                                            admin
                                        </label>

                                        <label class="checkboxs mb-1">
                                            <input type="checkbox" value="walikelas" name="recived[]"
                                                   {{ in_array('walikelas', json_decode($item->recived, true) ?? []) ? 'checked' : '' }}>
                                            <span class="checkmarks"></span>
                                            walikelas
                                        </label>

                                        <label class="checkboxs mb-1">
                                            <input type="checkbox" value="guru" name="recived[]"
                                                   {{ in_array('guru', json_decode($item->recived, true) ?? []) ? 'checked' : '' }}>
                                            <span class="checkmarks"></span>
                                            guru
                                        </label>

                                        <label class="checkboxs mb-1">
                                            <input type="checkbox" value="siswa" name="recived[]"
                                                   {{ in_array('siswa', json_decode($item->recived, true) ?? []) ? 'checked' : '' }}>
                                            <span class="checkmarks"></span>
                                            siswa
                                        </label>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</a>
                    <button type="submit" class="btn btn-primary">Add New Mesaage</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

