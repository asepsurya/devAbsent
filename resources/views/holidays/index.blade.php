@extends('layout.main')
@section('container')
{{-- header --}}
<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1">{{ $title }}</h3>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Beranda</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">

       <div class="mb-2">
            <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-effect="effect-scale" data-bs-toggle="modal" data-bs-target="#add_holiday"><i class="ti ti-square-rounded-plus me-2"></i>Hari Libur</a>
            </div>
    </div>
</div>
{{-- End Header --}}
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <div><h4 class="mt-2">Daftar {{ $title }}</h4></div>
            <div><a href="/kalender" class="btn btn-outline-light bg-white  position-relative "><span class="ti ti-calendar-week"></span> Lihat di Kalender Akademik</a></div>
        </div>

    </div>
    <div class="card-body p-0 ">
        <div class="table-responsive">
            <table class="table table-nowrap mb-0">
                <thead>
                    <tr >
                        <th class="bg-light-400">#</th>
                        <th class="bg-light-400">Keterangan</th>
                        <th class="bg-light-400">Start</th>
                        <th class="bg-light-400">End</th>

                        <th class="bg-light-400">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no=1 @endphp
                    @foreach ($holidays as $key )

                    <tr>
                        <td><a href="#" class="link-primary">{{ $no++ }}</a></td>
                        <td>
                           {{ $key->title }}
                        </td>
                        <td>{{ $key->start }}</td>
                        <td>{{ $key->end }}</td>

                        <td>
                            <div class="hstack gap-2 fs-15">
                                <a  data-bs-effect="effect-scale" data-bs-toggle="modal" data-bs-target="#edit_holiday-{{ $key->id }}" class="btn btn-icon btn-sm btn-soft-info rounded-pill"><i class="ti ti-pencil-minus"></i></a>
                                <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-soft-danger rounded-pill btn-delete" data-url="/hapusEventModal/{{ $key->id }}">
                                    <i class="ti ti-trash"></i>
                                </a>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- modal tambah Hari Libur --}}
<div class="modal fade" id="add_holiday" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Hari Libur</h4>
                <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </button>
            </div>
            <form action="/addEventModal" method="POST">
                @csrf
                <div class="modal-body pb-0">
                    <div class="mb-3">
                        <label class="form-label">Event Title <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Start<span class="text-danger">*</span></label>
                        <div class="cal-icon">
                            <input class="form-control " type="date" name="start" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">End<span class="text-danger">*</span></label>
                        <div class="cal-icon">
                            <input class="form-control" type="date" name="end" required>
                        </div>
                    </div>
                    <input type="text" name="type" value="holiday" hidden>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</a>
                    <button type="submit" class="btn btn-primary">Add Event</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach ($holidays as $key )
<div class="modal fade" id="edit_holiday-{{ $key->id }}" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Hari Libur</h4>
                <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </button>
            </div>
            <form action="/editEventModal" method="POST">
                @csrf
                <div class="modal-body pb-0">
                    <input type="text" name="id" id="id" value="{{ $key->id }}" hidden>
                    <div class="mb-3">
                        <label class="form-label">Event Title <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="title" required value="{{ $key->title }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Start<span class="text-danger">*</span></label>
                        <div class="cal-icon">
                            <input class="form-control " type="date" name="start" required value="{{ $key->start }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">End<span class="text-danger">*</span></label>
                        <div class="cal-icon">
                            <input class="form-control" type="date" name="end" required value="{{ $key->end }}">
                        </div>
                    </div>
                    <input type="text" name="type" value="holiday" hidden>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</a>
                    <button type="submit" class="btn btn-primary">Add Event</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@section('javascript')
<script>
    $(document).on('click', '.btn-delete', function(e) {
    e.preventDefault();
    var url = $(this).data('url');

    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data yang dihapus tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e3342f',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect ke URL hapus atau bisa juga pakai AJAX kalau mau
            window.location.href = url;
        }
    });
});
</script>

<script>
    $(document).ready(function() {
    $.ajax({
        url: '/check-event-controller',
        method: 'GET',
        success: function(response) {
            if (!response.exists) {
                Swal.fire({
                    title: 'Fitur Tidak Tersedia!',
                    text: 'Anda harus install Kalender Akademik terlebih dahulu sebelum menggunakan fitur ini.',
                    icon: 'error',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showCancelButton: false,
                    confirmButtonText: 'Kembali'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.history.back();  // balik ke halaman sebelumnya
                        // atau bisa pakai window.location.href = '/dashboard'; untuk redirect ke halaman tertentu
                    }
                });
            }
        }
    });
});

</script>
@endsection
@endsection
