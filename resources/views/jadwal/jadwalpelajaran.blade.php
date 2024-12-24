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

        <div class="pe-1 mb-2">
            <button type="button" class="btn btn-outline-light bg-white btn-icon me-1" onclick="history.back()">
                <i class="ti ti-arrow-left"></i>
            </button>
        </div>
        <div class="pe-1 mb-2">
            <a href="{{ route('leassonView',$id) }}" class=" btn btn-outline-light me-1"><span class="ti ti-eye"></span>
                Tampilkan Jadwal</a>
        </div>
        <div class="pe-1 mb-2">
            <a data-bs-toggle="modal" href="#ref" class=" btn btn-outline-light me-1"><span class="ti ti-settings"></span>
                Referensi</a>
        </div>


    </div>
</div>
{{-- End Header --}}


        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th scope="col" class="border" width="2%">No</th>
                    <th scope="col" class="border" width="2%">Jam</th>
                    @foreach ($hari as $a )
                    <th scope="col" class="border text-center">
                        @switch($a->id_hari)
                        @case(1)
                        Senin
                        @break
                        @case(2)
                        Selasa
                        @break
                        @case(3)
                        Rabu
                        @break
                        @case(4)
                        Kamis
                        @break
                        @case(5)
                        Jum'at
                        @break
                        @case(6)
                        Sabtu
                        @break
                        @case(7)
                        Minggu
                        @break
                        @default
                        Tidak Diketahui
                        @endswitch
                    </th>
                    @endforeach
                <tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
               @foreach ($jam as $b)
                <tr >
                    <td class="border" width="2%">{{ $no++ }}</td>
                    <td class="border" width="2%">{{ $b->jam_mulai }} - {{ $b->jam_berakhir }}</td>
                    @foreach ($hari as $a)
                        <td class="border text-center" width="2%">
                            {{-- Check if there's a schedule for this day and time slot --}}
                            @php
                                $scheduleFound = false;  // Flag to check if any schedule exists for this time slot
                            @endphp

                            {{-- Loop through possible time slots --}}
                            @foreach ($jadwal->where('day', $a->id_hari) as $jadwalItem)
                                @if ($jadwalItem->id_jam == $b->jam_ke)
                                    {{-- If there's a matching schedule, display the subject --}}
                                    <div class="border p-2 rounded">
                                        @if($jadwalItem->mata_pelajaran)
                                           <a data-toggle="modal"
                                            data-target="#editScheduleModal-{{ $jadwalItem->id  }}">{{ $jadwalItem->mata_pelajaran->nama ?? '' }}</a>
                                        @else
                                            {{ $jadwalItem->ref->ref }}
                                        @endif
                                    </div>

                                    @php
                                        $scheduleFound = true;  // Mark that a schedule was found
                                    @endphp
                                @endif
                            @endforeach

                            {{-- If no schedule found for this time slot, display the "add" button --}}
                            @if (!$scheduleFound)
                            <button class="btn btn-sm btn-primary"
                            data-id-jam="{{ $b->jam_ke }}"
                            data-id-hari="{{ $a->id_hari }}"
                            data-toggle="modal"
                            data-target="#scheduleModal">
                                +
                            </button>
                            @endif
                        </td>
                    @endforeach

                </tr>
            @endforeach
                </tbody>

        </table>
<!-- Modal -->
@foreach ($jadwal as $item)

<div class="modal fade editScheduleModal" id="editScheduleModal-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editScheduleModalLabel">Edit Jadwal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editScheduleForm" action="" method="POST">
                    @csrf
                    @method('PUT') <!-- Use PUT method for updating -->
                    <input type="hidden" name="id_jam" value="{{ $item->id_jam }}">
                    <input type="hidden" name="day" value="{{ $item->day }}" >
                    <input type="hidden" name="id_kelas" value="{{ $item->id_rombel }}">

                    <div class="mb-3">
                        <label for="edit_mata_pelajaran" class="form-label">Mata Pelajaran</label>
                        <select name="tahun_ajar" class="form-control">
                            @foreach ($tahun_ajar as $item2)
                            <option value="{{ $item2->id }}" {{ $item->id_tahun_ajar == $item2->id ? 'selected' : '' }}>Tahun Pelajaran : {{ $item2->tahun_pelajaran }} - {{ $item2->semester }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="edit_id_mapel" class="form-label">Pilih Referensi</label>
                        <select class="form-control select2 edit_id_mapel" name="id_mapel"  required>
                            <option value="">Select Subject</option>
                            <optgroup label="Mata Pelajaran">
                                @foreach ($mapel as $mapel2)
                                    <option value="{{ $mapel2->id_mapel }}" {{ $mapel2->id_mapel === $item->id_mapel ? 'selected' : '' }}>{{ $mapel2->mata_pelajaran->nama }}</option>
                                @endforeach
                            </optgroup>

                            <optgroup label="Referensi">
                                @foreach ($ref2 as $ref)
                                    <option value="{{ $ref->ref_ID }}">{{ $ref->ref }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="edit_id_gtk" class="form-label">Teacher</label>
                        <input type="text" class="form-control edit_id_gtk" name="id_gtk" hidden>
                        <input type="text" class="form-control edit_name" name="name_gtk" disabled>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary w-100">Update Schedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endforeach
<div class="modal fade" id="scheduleModal" tabindex="-1" role="dialog" aria-labelledby="scheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scheduleModalLabel">Tambah Jadwal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="scheduleForm" action="{{ route('leassonAdd') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_jam" id="modal-id-jam">
                    <input type="hidden" name="day" id="modal-id-hari">
                    <input type="hidden" name="id_kelas" value="{{ $id }}">
                    <div class="mb-3">
                        <label for="mata_pelajaran" class="form-label">Mata Pelajaran</label>
                        <select name="tahun_ajar" class=" form-control">
                            @foreach ($tahun_ajar as $item )
                            <option value="{{ $item->id }}" {{ request('tahun_ajar') == $item->id ? 'selected' : '' }}>Tahun Pelajaran : {{ $item->tahun_pelajaran }} - {{ $item->semester }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Add other form fields as needed -->
                    <div class="form-group mb-3">
                        <label for="id_mapel " class="form-label">PIlih Referensi</label>
                        <select class="form-control select2" name="id_mapel" id="id_mapel" required>
                            <option value="">Select Subject</option>
                            <optgroup label="Mata Pelajaran">
                                @foreach ($mapel as  $mapel)
                                    <option value="{{ $mapel->id_mapel }}">{{ $mapel->mata_pelajaran->nama }}</option>
                                @endforeach
                            </optgroup>

                            <optgroup label="Referensi">
                                @foreach ($ref2 as $ref)
                                    <option value="{{ $ref->ref_ID }}">{{ $ref->ref }}</option>
                                @endforeach
                            </optgroup>
                            <!-- Add your other options here -->
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="id_gtk" class="form-label">Teacher</label>
                        <input type="text" class="form-control" id="id_gtk" name="id_gtk" hidden >
                        <input type="text" class="form-control" id="name" name="name_gtk" disabled>
                    </div>

                    <!-- Add more fields as needed -->

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary w-100">Save Schedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade " id="ref" aria-labelledby="exampleModalToggleLabel" tabindex="-1" aria-modal="true"
    role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-body m-0 p-0">
                <form action="{{ route('reference') }}" method="post">
                    @csrf
                    <div class="bg-light">
                        <div class="m-3">
                            <label class="form-label">Nama Refrensi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="ref" required placeholder="Example: Ishoma,Upacara Bendera">
                            <button class="btn btn-primary mt-2 w-100"><span class="ti ti-device-floppy"></span> Tambah</button>
                        </div>
                    </div>

                    <div class="accordion accordions-items-seperate m-3" id="accordionSpacingExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne">
                                    Edit Referensi
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample" style="">
                                <div class="accordion-body m-0 p-0">
                                    <div class="table-responsive">
                                        <table class="table table-nowrap mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="bg-light-400" width="10%"></th>
                                                    <th class="bg-light-400">Referensi</th>

                                            </thead>
                                            <tbody>
                                                @foreach ($ref2 as $item )
                                                <tr>
                                                    <td>
                                                        <div class="hstack gap-2 fs-15">
                                                            <a data-bs-toggle="modal" href="#edit-ref-{{ $item->ref_ID }}" class="btn btn-icon btn-sm btn-soft-info rounded-pill" >
                                                                <i class="ti ti-pencil-minus"></i>
                                                            </a>
                                                            <a href="{{ route('referenceDelete',$item->ref_ID) }}" class="btn btn-icon btn-sm btn-soft-danger rounded-pill">
                                                                <i class="ti ti-trash"></i>
                                                            </a>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <div id="ref_item">{{$item->ref}}</div>
                                                    </td>

                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button data-bs-toggle="modal" href="#add_holiday" class="btn btn-outline-light me-1"> <span
                        class="ti ti-arrow-left"></span>Kembali
                </button>
            </div>
        </div>
    </div>
</div>
@foreach ($ref2 as $a )

{{-- Edit referensi --}}
<div class="modal fade " id="edit-ref-{{ $a->ref_ID }}" aria-labelledby="exampleModalToggleLabel" tabindex="-1" aria-modal="true"
    role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-body m-0 p-0">
                <form action="{{ route('referenceEdit') }}" method="post">
                    @csrf
                    <div class="bg-light">
                        <div class="m-3">
                            <label class="form-label">Nama Refrensi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="ref_ID" required placeholder="Ex:Ishoma,Upacara" value="{{ $a->ref_ID }}" hidden>
                            <input type="text" class="form-control" name="ref" required placeholder="Ex:Ishoma,Upacara" value="{{ $a->ref }}">
                            <button class="btn btn-primary mt-2 w-100">Simpan</button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button data-bs-toggle="modal" href="#ref" class="btn btn-outline-light me-1"> <span
                        class="ti ti-arrow-left"></span>Kembali
                </button>
            </div>
        </div>
    </div>
</div>

@endforeach

@section('javascript')
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@if (session('refresh'))
    <script>
        window.location.reload();
    </script>
@endif
<script>

  $(document).ready(function () {
    // Initialize Select2 when the modal is opened
    $('#scheduleModal').on('shown.bs.modal', function () {
        // Initialize Select2 on the select element
        $('.select2').select2({
            dropdownParent: $('#scheduleModal'),
            placeholder: "Reference",
        });
        $('.tahunAjar').select2({
            dropdownParent: $('#scheduleModal'),
            placeholder: "Tahun Pelajaran",
        });


    });

    $('.editScheduleModal').on('shown.bs.modal', function () {
        // Initialize Select2
        var selectElement = $(this).find('.select2'); // This selects the .select2 within the modal

        // Initialize or reinitialize Select2
        selectElement.select2({
            dropdownParent: $(this), // Ensures dropdown is inside the modal
            placeholder: "Reference", // Set a placeholder
        });

    });

    // Reset Select2 when modal is closed to clear previous selections
    $('#scheduleModal').on('hidden.bs.modal', function () {
        $('.select2').val(null).trigger('change');
    });

});

</script>

<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    // Event listener for when the subject (id_mapel) changes
    $('#id_mapel').on('change', function () {
        var id_mapel = $(this).val();  // Get the selected subject ID
        var id_kelas = {{ $id }};
        if (id_mapel) {
            // Make the AJAX request to get teacher data based on the selected subject
            $.ajax({
                url: "{{ route('getgtk.leasson') }}",  // Your route to fetch teacher data
                type: 'GET',
                data: {
                    id_mapel: id_mapel,
                    id_kelas: id_kelas,

                },
                success: function (response) {

                    // Check if the response contains teacher data
                    if (response.options && response.options.length > 0) {
                        // Assuming you want to set the first teacher in the list (response.options[0])
                        var teacher = response.options[0];  // Get the first teacher's data

                        // Set the teacher's ID (NIK) in the 'id_gtk' field
                        $('#id_gtk').val(teacher.nik);

                        // Set the teacher's name in the 'name' field
                        $('#name').val(teacher.nama);
                    } else {
                        // Handle the case where no teacher data is found
                        $('#id_gtk').val('');
                        $('#name').val('');
                        // alert('No teacher found for this subject/class.');
                    }// Set the teacher's name
                },
                error: function (xhr, status, error) {
                    // If no teacher is found, show a message or clear the fields
                    $('#id_gtk').val('');
                    $('#name').val('');
                    // alert('Teacher not found for this subject.');
                }
            });
        } else {
            // If no subject is selected, clear the fields
            $('#id_gtk').val('');
            $('#name').val('');
        }
    });
});
</script>

<script>

    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    // Event listener for when the subject (id_mapel) changes
    $('.edit_id_mapel').on('change', function () {
        var id_mapel = $(this).val();  // Get the selected subject ID
        var id_kelas = {{ $id }};
        if (id_mapel) {
            // Make the AJAX request to get teacher data based on the selected subject
            $.ajax({
                url: "{{ route('getgtk.leasson') }}",  // Your route to fetch teacher data
                type: 'GET',
                data: {
                    id_mapel: id_mapel,
                    id_kelas: id_kelas,

                },
                success: function (response) {

                    // Check if the response contains teacher data
                    if (response.options && response.options.length > 0) {
                        // Assuming you want to set the first teacher in the list (response.options[0])
                        var teacher = response.options[0];  // Get the first teacher's data

                        // Set the teacher's ID (NIK) in the 'id_gtk' field
                        $('.edit_id_gtk').val(teacher.nik);

                        // Set the teacher's name in the 'name' field
                        $('.edit_name').val(teacher.nama);
                    } else {
                        // Handle the case where no teacher data is found
                        $('.edit_id_gtk').val('');
                        $('.edit_name').val('');
                        // alert('No teacher found for this subject/class.');
                    }// Set the teacher's name
                },
                error: function (xhr, status, error) {
                    // If no teacher is found, show a message or clear the fields
                    $('.edit_id_gtk').val('');
                    $('.edit_name').val('');
                    // alert('Teacher not found for this subject.');
                }
            });
        } else {
            // If no subject is selected, clear the fields
            $('.edit_id_gtk').val('');
            $('.edit_name').val('');
        }
    });
});
</script>

@endsection
@endsection
