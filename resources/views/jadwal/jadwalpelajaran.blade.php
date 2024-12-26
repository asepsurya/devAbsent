@extends('layout.main')
@section('css')

@endsection
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
<ul class="nav nav-tabs tab-style-1 d-sm-flex d-block" id="myTab" role="tablist">
    @foreach ($hari as $a)
        <li class="nav-item" role="presentation">
            <a class="nav-link "
               id="tab-{{ $a->id }}"
               data-bs-toggle="pill"
               href="#{{ $a->id }}"
               role="tab"
               aria-controls="{{ $a->id }}"
               aria-selected="true">
                <i class="ti ti-calendar"></i> {{-- Calendar Icon --}}
                @switch($a->id_hari)
                    @case(1) Senin @break
                    @case(2) Selasa @break
                    @case(3) Rabu @break
                    @case(4) Kamis @break
                    @case(5) Jum'at @break
                    @case(6) Sabtu @break
                    @case(7) Minggu @break
                    @default Tidak Diketahui
                @endswitch
            </a>
        </li>
    @endforeach
</ul>

<div class="tab-content" id="myTabContent">
    @foreach ($hari as $a)
        <div class="tab-pane fade @if ($loop->first)  @endif" id="{{ $a->id }}" role="tabpanel" aria-labelledby="tab-{{ $a->id }}">
            <div class="d-flex justify-content-between">

                <h4 class="mt-2">Jadwal Hari
                    @switch($a->id_hari)
                        @case(1) Senin @break
                        @case(2) Selasa @break
                        @case(3) Rabu @break
                        @case(4) Kamis @break
                        @case(5) Jum'at @break
                        @case(6) Sabtu @break
                        @case(7) Minggu @break
                        @default Tidak Diketahui
                    @endswitch
                </h4>
                <div class="mb-3">
                    <div class="btn-group">
                        <button class="btn btn-primary "
                            data-id-hari="{{ $a->id_hari }}"
                            data-toggle="modal"
                            data-target="#scheduleModal"> +  Tambah Mata Pelajaran </button>
                        <button class="btn btn btn-outline-light "
                            data-id-hari="{{ $a->id_hari }}"
                            data-toggle="modal"
                            data-target="#scheduleModalref">Referensi</button>
                    </div>
                </div>
            </div>

            <table class="table table-striped ">
                <thead>
                    <tr>
                        <th class="border" width="1%">
                          #
                        </th>
                        <th  class="border-top"  width="2%"></th>
                        <th class="border-top" >Jam</th>
                        <th class="border-top" >Nama Mata Pelajaran</th>
                       
                    </tr>
                </thead>
                <tbody>
                    @if($jadwal->where('day',$a->id_hari)->count())
                        @foreach ($jadwal->where('day',$a->id_hari) as $item )
                        <tr>
                            <td class="border">
                                <a href="{{ route('leassonDelete',$item->id) }}">
                                 <button class="btn btn-outline-light bg-white  "><span class="ti ti-trash-x"></span></button>
                               </a>
                            </td>
                            <td class=" p-2 m-2">
                                <a data-id-hari="{{ $a->id_hari }}" class=""
                                    data-toggle="modal"
                                    data-target="#addManualScheduleModal-{{ $item->id }}">
                                    <img src="{{ asset('asset/img/plus.png') }}" alt="Add Schedule">
                                 </a>
                                 
                            </td>
                            <td class="border">{{ $item->start }} - {{ $item->end }}</td>
                            <td >
                            @if($item->mata_pelajaran)
                                <a data-toggle="modal"
                                data-target="#editScheduleModal-{{ $item->id  }}">{{ $item->mata_pelajaran->nama ?? '' }}
                            </a>
                            @else
                                {{ $item->ref->ref }}
                            @endif

                            </td>    
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4"> Belum Menambahkan Data</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    @endforeach
</div>

<div class="modal fade " id="ref" aria-labelledby="exampleModalToggleLabel" tabindex="-1" aria-modal="true"
    role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-body m-0 p-0">
                <form action="{{ route('reference') }}" method="post">
                    @csrf
                    <div class="bg-light">
                        <div class="mb-3 m-3">
                            <label class="form-label">Nama Refrensi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="ref" required placeholder="Example: Ishoma,Upacara Bendera">
                        </div>
                        <div class="m-3">
                            <label class="form-label">Waktu ajar <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-sm-4"><input type="number" class="form-control" name="waktu" required placeholder=""></div>
                                <div class="col-sm-4 mt-2"> Menit</div>
                            </div>

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
                                                    <th class="bg-light-400">Waktu Ajar</th>
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
                                                    <td>{{ $item->waktu }} Menit</td>

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
                <form id="editScheduleForm" action="{{ route('leassonUpdate') }}" method="POST">
                    @csrf
                    
                    <input type="hidden" name="id" value="{{ $item->id }}">
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
                                @if($ref2->count())
                                    @foreach ($ref2 as $ref)
                                        <option value="{{ $ref->ref_ID }}">{{ $ref->ref }}</option>
                                    @endforeach
                                @else
                                    <option value="">---Belum Menemukan Data Referensi----</option>
                                @endif
                            </optgroup>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="edit_id_gtk" class="form-label">Teacher</label>
                        <input type="text" class="form-control edit_id_gtk" name="id_gtk" value="{{ $item->id_gtk }}" hidden>
                        <input type="text" class="form-control edit_name" name="name_gtk" disabled value="{{ $item->guru->nama ?? '' }}" >
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

{{-- add Modal Manual --}}
@foreach ($jadwal as $item)
<div class="modal fade addManualScheduleModal" id="addManualScheduleModal-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editScheduleModalLabel">Tambah Jadwal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editScheduleForm" action="{{ route('leassonAddManual') }}" method="POST">
                    @csrf
                    <div hidden>
                        <input name="id" value="{{ $item->id }}">
                        <input name="day" value="{{ $item->day }}" >
                        <input name="id_kelas" value="{{ $item->id_rombel }}">
                        <input name="id_jam" id="modal-id-jam-manual" class="modal-id-jam-manual" >
                    </div>
                   
                    <div class="mb-3">
                        <label for="edit_mata_pelajaran" class="form-label">Mata Pelajaran</label>
                        <select name="tahun_ajar" class="form-control ">
                            @foreach ($tahun_ajar as $item2)
                            <option value="{{ $item2->id }}" {{ $item->id_tahun_ajar == $item2->id ? 'selected' : '' }} >Tahun Pelajaran : {{ $item2->tahun_pelajaran }} - {{ $item2->semester }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="jam" class="form-label">Start</label>
                                <input type="text" name="start"  value="{{ $item->end }}" class="form-control start" readonly>
                            </div>
                            <div class="col-sm-6">
                                <label for="jam" class="form-label">End</label>
                                <input type="time"  name="end" class="form-control myTime" >
                            </div>
                        </div>
                       
                    </div>
                    <div class="form-group mb-3">
                        <label for="edit_id_mapel" class="form-label">Pilih Referensi</label>
                        <select class="form-control add_id_mapel_manual select2 " name="id_mapel"  id="add_id_mapel_manual" required>
                            <option value="">Select Subject</option>
                            <optgroup label="Mata Pelajaran">
                                @foreach ($mapel as $mapel2)
                                    <option value="{{ $mapel2->id_mapel }}" data-waktu="{{ app('settings')['waktu_mapel'] }}" >{{ $mapel2->mata_pelajaran->nama }}</option>
                                @endforeach
                            </optgroup>

                            <optgroup label="Referensi">
                                @if($ref2->count())
                                    @foreach ($ref2 as $ref)
                                        <option value="{{ $ref->ref_ID }}" data-waktu="{{ $ref->waktu }}">{{ $ref->ref }}</option>
                                    @endforeach
                                @else
                                    <option value="">---Belum Menemukan Data Referensi----</option>
                                @endif
                            </optgroup>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="edit_id_gtk" class="form-label">Teacher</label>
                        <input type="text" class="form-control " id="id_gtk_manual" name="id_gtk" value="{{ $item->id_gtk }}" hidden>
                        <input type="text" class="form-control " id="name_gtk_manual" name="name_gtk" disabled value="{{ $item->guru->nama ?? '' }}" >
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
                    <div hidden>
                        <input type="text" name="start_school" value="{{ app('settings')['start_school'] }}">
                        <input  name="id_jam" id="modal-id-jam" value="{{ app('settings')['waktu_mapel'] }}" >
                        <input  name="day" id="modal-id-hari">
                        <input  name="id_kelas" value="{{ $id }}">
                    </div>

                    <div class="mb-3" hidden>
                        <label for="mata_pelajaran" class="form-label">Tahun Ajaran</label>
                        <select name="tahun_ajar" class=" form-control " readonly>
                            @foreach ($tahun_ajar as $item )
                            <option value="{{ $item->id }}" {{ request('tahun_ajar') == $item->id ? 'selected' : '' }}>Tahun Pelajaran : {{ $item->tahun_pelajaran }} - {{ $item->semester }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Add other form fields as needed -->
                    <div class="form-group mb-3">
                        <label for="id_mapel " class="form-label">Mata Pelajaran</label>
                        <select class="form-control select2 id_mapel " name="id_mapel"required>
                            <option value="">Select Subject</option>
                            <optgroup label="Mata Pelajaran">
                                @foreach ($mapel as  $mapel)
                                    <option value="{{ $mapel->id_mapel }}">{{ $mapel->mata_pelajaran->nama }}</option>
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

<div class="modal fade" id="scheduleModalref" tabindex="-1" role="dialog" aria-labelledby="scheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scheduleModalLabel">Tambah Referensi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="scheduleForm" action="{{ route('leassonAdd') }}" method="POST">
                    @csrf
                    <div hidden>
                        <input type="text" name="start_school" value="{{ app('settings')['start_school'] }}">
                        <input name="id_jam" id="modal-id-jam-ref" >
                        <input name="day" id="modal-id-hari-ref">
                        <input name="id_kelas" value="{{ $id }}">
                    </div>

                    <div class="mb-3" hidden>
                        <label for="mata_pelajaran" class="form-label">Tahun Pelajaran</label>
                        <select name="tahun_ajar" class=" form-control " readonly>
                            @foreach ($tahun_ajar as $item )
                            <option value="{{ $item->id }}" {{ request('tahun_ajar') == $item->id ? 'selected' : '' }}>Tahun Pelajaran : {{ $item->tahun_pelajaran }} - {{ $item->semester }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Add other form fields as needed -->
                    <div class="form-group mb-3">
                        <label for="id_mapel " class="form-label">Pilih Referensi</label>
                        <select class="form-control select2" name="id_mapel" id="ref-data"  required>
                            <option value="">Select Subject</option>
                            <optgroup label="Refensi">
                                @foreach ($ref2 as  $ref)
                                    <option value="{{ $ref->ref_ID }}" data-waktu="{{ $ref->waktu }}" >{{ $ref->ref }}</option>
                                @endforeach
                            </optgroup>
                            <!-- Add your other options here -->
                        </select>
                    </div>

                    <!-- Add more fields as needed -->

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary w-100">Tambah</button>
                    </div>
                </form>
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
        // When a new option is selected in the 'id_mapel' select box
        $('#ref-data').change(function() {
            // Get the selected option
            var selectedOption = $(this).find('option:selected');
            // Get the 'waktu' from the 'data-waktu' attribute
            var waktu = selectedOption.data('waktu');
            // Set the 'waktu' value to the hidden input field
            $('#modal-id-jam-ref').val(waktu);
            
        });

        $('.add_id_mapel_manual').change(function() {
            // Get the selected option
            var selectedOption = $(this).find('option:selected');
            
            // Get the 'waktu' (time) from the 'data-waktu' attribute
            var waktu = selectedOption.data('waktu');
            
            // Set the 'waktu' value to the hidden input field (modal-id-jam-manual)
            $('.modal-id-jam-manual').val(waktu);
            
            
            
        });

       

    
    });
</script>

<script>
    // Ensure the active tab is stored in sessionStorage or localStorage
    document.addEventListener("DOMContentLoaded", function() {
        // When a tab is clicked, store its ID
        document.querySelectorAll('.nav-link').forEach(function(tab) {
            tab.addEventListener('click', function() {
                const activeTabId = tab.getAttribute('href').substring(1); // Get the ID of the tab content
                sessionStorage.setItem('activeTab', activeTabId); // Store the active tab ID in sessionStorage
            });
        });

        // When the page loads, check if there's a stored active tab
        const storedActiveTab = sessionStorage.getItem('activeTab');
        if (storedActiveTab) {
            // Show the tab corresponding to the stored active tab ID
            const tabToActivate = document.getElementById(storedActiveTab);
            const tabLink = document.querySelector(`[href="#${storedActiveTab}"]`);

            // Add classes to activate the right tab and content
            if (tabLink) {
                tabLink.classList.add('active');
                tabToActivate.classList.add('show', 'active');
            }
        }
    });
</script>

<script>

  $(document).ready(function () {
    // Initialize Select2 when the modal is opened
        $('#scheduleModal').on('shown.bs.modal', function (e) {
        // Get the element that triggered the modal (the button or link)
            var button = $(e.relatedTarget);

            // Extract values from the data attributes of the button
            // var jamKe = button.data('id-jam');
            var hariId = button.data('id-hari');

            // Set the values to the modal input fields
            // $('#modal-id-jam').val(jamKe);
            $('#modal-id-hari').val(hariId);

            // Initialize Select2 (if you still want to apply Select2 inside the modal)
            $('.select2').select2({
                dropdownParent: $('#scheduleModal'),
                placeholder: "Reference",
            });

        });

   

    $('#scheduleModalref').on('shown.bs.modal', function (e) {
        var button = $(e.relatedTarget);

        // Extract values from the data attributes of the button
        // var jamKe = button.data('id-jam');
        var hariId = button.data('id-hari');

        $('#modal-id-hari-ref').val(hariId);

        $('.select2').select2({
            dropdownParent: $('#scheduleModalref'),
            placeholder: "Reference",
         });

        $('.tahunAjar').select2({
            dropdownParent: $('#scheduleModal'),
            placeholder: "Tahun Pelajaran",
         });  

    });


    $('.addManualScheduleModal').on('shown.bs.modal', function () {
        // Initialize Select2
        var selectElement = $(this).find('.select2'); // This selects the .select2 within the modal

        // Initialize or reinitialize Select2
        selectElement.select2({
            dropdownParent: $(this), // Ensures dropdown is inside the modal
            placeholder: "Reference", // Set a placeholder
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
    $('.id_mapel').on('change', function () {
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


<script>

    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    // Event listener for when the subject (id_mapel) changes
    $('.add_id_mapel_manual').on('change', function () {
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
                        $('#id_gtk_manual').val(teacher.nik);

                        // Set the teacher's name in the 'name' field
                        $('#name_gtk_manual').val(teacher.nama);
                    } else {
                        // Handle the case where no teacher data is found
                        $('#id_gtk_manual').val('');
                        $('#name_gtk_manual').val('');
                        // alert('No teacher found for this subject/class.');
                    }// Set the teacher's name
                },
                error: function (xhr, status, error) {
                    // If no teacher is found, show a message or clear the fields
                    $('#id_gtk_manual').val('');
                    $('#name_gtk_manual').val('');
                    // alert('Teacher not found for this subject.');
                }
            });
        } else {
            // If no subject is selected, clear the fields
            $('#id_gtk_manual').val('');
            $('#name_gtk_manual').val('');
        }
    });
});
</script>

@endsection
@endsection
