@extends('layout.main')
@section('css')
<!-- TinyMCE CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.6.0/tinymce.min.js" integrity="sha512-/4EpSbZW47rO/cUIb0AMRs/xWwE8pyOLf8eiDWQ6sQash5RP1Cl8Zi2aqa4QEufjeqnzTK8CLZWX7J5ZjLcc1Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
@section('container')


    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
        <div class="my-auto mb-2">
            <h3 class="page-title mb-1">{{ $title }}</h3>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="index.html">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">Announcement</li>
                    <li class="breadcrumb-item active" aria-current="page">Notice
                        Board</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">

            <div class="mb-2">
                <a href="#" data-bs-toggle="modal" data-bs-target="#add_message" class="btn btn-primary d-flex align-items-center"><i class="ti ti-square-rounded-plus me-2"></i>Add Message</a>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    @if ($notice->count()!= 0)
    @foreach ($notice as $item)
    <!-- Notice Board List -->
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
    @else
    <div class="card board-hover mb-3">
        <div class="card-body align-items-center ">
            <div class="d-flex justify-content-center">
               Belum Membuat Pengumuman apapun
            </div>
        </div>
    </div>
    @endif
  <!-- Notice Board List -->
  <div id="loading-spinner" style="display:none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
    <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
    <div class="text-center" id="load-more-container">
        @if ($notice->hasMorePages())

            <a href="javascript:void(0);" id="load-more-btn" class="btn btn-primary">
                <i class="ti ti-loader-3 me-2"></i>Load More
            </a>
        @endif
    </div>

    {{-- add modal --}}
    <div class="modal fade" id="add_message" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Message</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="{{ route('announcements.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" name="title">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Author</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->nama }}" readonly name="author">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Notice Date</label>
                                    <div class="date-pic">
                                        <input type="text" class="form-control datetimepicker" name="date">
                                        <span class="cal-icon"><i class="ti ti-calendar"></i></span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Message</label>
                                    <textarea class="form-control editor" rows="4" name="content"></textarea>
                                </div>
                                <div class="mb-0">
                                    <label class="form-label">Message To</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="checkboxs mb-1">
                                                <input type="checkbox" value="admin" name="recived[]">
                                                <span class="checkmarks"></span>
                                                admin
                                            </label>
                                            <label class="checkboxs mb-1">
                                                <input type="checkbox" value="walikelas" name="recived[]">
                                                <span class="checkmarks"></span>
                                                walikelas
                                            </label>
                                            <label class="checkboxs mb-1">
                                                <input type="checkbox" value="guru" name="recived[]">
                                                <span class="checkmarks"></span>
                                                guru
                                            </label>
                                            <label class="checkboxs mb-1">
                                                <input type="checkbox" value="siswa" name="recived[]">
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
    {{-- detail Notice --}}
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
                    <b>Isi Pengumuman :</b>
                    <p>
                        <div class="bg-light p-3 pb-2 rounded">
                            {!! $item->content !!}
                        </div>
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


    {{-- <div class="modal fade" id="edit_message" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Message</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="notice-board.html">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" placeholder="Enter Title" value="Fees Reminder">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Notice Date</label>
                                    <div class="date-pic">
                                        <input type="text" class="form-control datetimepicker" placeholder="15 May 2024">
                                        <span class="cal-icon"><i class="ti ti-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Publish On</label>
                                    <div class="date-pic">
                                        <input type="text" class="form-control datetimepicker" placeholder="15 May 2024">
                                        <span class="cal-icon"><i class="ti ti-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="bg-light p-3 pb-2 rounded">
                                        <div class="mb-3">
                                            <label class="form-label">Attachment</label>
                                            <p>Upload size of 4MB, Accepted Format PDF</p>
                                        </div>
                                        <div class="d-flex align-items-center flex-wrap">
                                            <div class="btn btn-primary drag-upload-btn mb-2 me-2">
                                                <i class="ti ti-file-upload me-1"></i>Upload
                                                <input type="file" class="form-control image_sign" multiple="">
                                            </div>
                                            <p class="mb-2">Fees_Structure.pdf</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Message</label>
                                    <textarea class="form-control" rows="4" placeholder="Add Comment">Please clear the outstanding dues for the school fees on the urgent basis.</textarea>
                                </div>
                                <div class="mb-0">
                                    <label class="form-label">Message To</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check form-check-md mb-1">
                                                <input class="form-check-input" type="checkbox">
                                                <span>Student</span>
                                            </div>
                                            <div class="form-check form-check-md mb-1">
                                                <input class="form-check-input" type="checkbox">
                                                <span>Parent</span>
                                            </div>
                                            <div class="form-check form-check-md mb-1">
                                                <input class="form-check-input" type="checkbox">
                                                <span>Admin</span>
                                            </div>
                                            <div class="form-check form-check-md">
                                                <input class="form-check-input" type="checkbox">
                                                <span>Teacher</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check form-check-md mb-1">
                                                <input class="form-check-input" type="checkbox">
                                                <span>Accountant</span>
                                            </div>
                                            <div class="form-check form-check-md mb-1">
                                                <input class="form-check-input" type="checkbox">
                                                <span>Librarian</span>
                                            </div>
                                            <div class="form-check form-check-md mb-1">
                                                <input class="form-check-input" type="checkbox">
                                                <span>Receptionist</span>
                                            </div>
                                            <div class="form-check form-check-md">
                                                <input class="form-check-input" type="checkbox">
                                                <span>Super Admin</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade " id="view_details" style="display: block;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Fees Reminder</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <div class="modal-body pb-0">
                    <div class="mb-3">
                        <p class="mb-1">Dear parents,</p>
                        <p>Please clear the outstanding dues for the school fees on the urgent
                            basis.</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Notice Date</label>
                                <p class="d-flex align-items-center"><i class="ti ti-calendar me-1"></i>15 May 2024
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Publish On</label>
                                <p class="d-flex align-items-center"><i class="ti ti-calendar me-1"></i>21 May 2024
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="bg-light p-3 pb-2 rounded">
                            <div class="mb-0">
                                <label class="form-label">Attachment</label>
                                <p class="text-primary">Fees_Structure.pdf</p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label d-block">Message To</label>
                        <span class="badge badge-soft-primary me-2">Student</span>
                        <span class="badge badge-soft-primary">Parent</span>
                    </div>
                    <div class="border-top pt-3">
                        <div class="d-flex align-items-center flex-wrap">
                            <div class="d-flex align-items-center me-4 mb-3">
                                <span class="avatar avatar-sm bg-light me-1"><i class="ti ti-calendar text-default fs-14"></i></span>Added on: 28 Apr 2024
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <span class="avatar avatar-sm bg-light me-1"><i class="ti ti-user-edit text-default fs-14"></i></span>Added By
                                : Daniel
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /View Details -->

    </div>
    <div class="modal fade" id="delete-modal" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="notice-board.html">
                    <div class="modal-body text-center">
                        <span class="delete-icon">
                            <i class="ti ti-trash-x"></i>
                        </span>
                        <h4>Confirm Deletion</h4>
                        <p>You want to delete all the marked items, this cant be undone once you
                            delete.</p>
                        <div class="d-flex justify-content-center">
                            <a href="javascript:void(0);" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</a>
                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}

@section('javascript')

<script>
    $(document).ready(function() {
        let page = 1; // Initial page number

        // Load more button click
        $('#load-more-btn').on('click', function() {
            page++; // Increment page number

            // Show the loading spinner
            $('#loading-spinner').show();

            // Send AJAX request to fetch more items
            $.ajax({
                url: "{{ route('announcements.index') }}?page=" + page,  // Ensure the route is correct and the `page` parameter is included
                type: "GET",
                dataType: "html",
                success: function(response) {
                    // Append the new notices to the list
                    $('#load-more-container').before(response);

                    // Re-initialize Bootstrap modals for the newly added items
                    initializeModals();

                    // Re-initialize TinyMCE on the newly added editor
                    initializeTinyMCE();

                    // Hide the Load More button if there are no more pages
                    if (!response.trim()) {
                        $('#load-more-btn').hide();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + error);
                },
                complete: function() {
                    // Hide the loading spinner after the AJAX call completes (success or error)
                    $('#loading-spinner').hide();
                }
            });
        });

        // Function to initialize modals
        function initializeModals() {
            // Initialize all modals that are currently in the DOM
            $('.modal').each(function() {
                // Check if the modal has already been initialized, if not initialize it
                if (!$(this).data('bs.modal')) {
                    new bootstrap.Modal(this); // Initialize Bootstrap modal for each modal element
                }
            });
        }

        // Function to initialize TinyMCE on the editor
        function initializeTinyMCE() {
            // Initialize TinyMCE on the textarea with the class 'editor'
            if (typeof tinymce !== 'undefined') {
                tinymce.init({
                    selector: '.editor', // Initialize TinyMCE on any element with class 'editor'
                    menubar: false,
                    statusbar: false,
                    toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | bullist numlist',
                });
            }
        }

        // Ensure modals and TinyMCE are initialized on page load
        initializeModals();
        initializeTinyMCE(); // Initialize TinyMCE for the initial page
    });
</script>


@endsection
@endsection
