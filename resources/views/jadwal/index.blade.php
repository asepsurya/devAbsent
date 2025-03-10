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


<form action="{{ route('leassonAdd') }}" method="POST">
    @csrf
    <div class="card">
        <div class="card-header">
            <form action="{{ route('list',$id) }}" method="get">
                <h4 class="mb-2">Daftar {{ $title }}</h4>
                <select name="tahun_ajar" class="tahun_ajar">
                    @foreach ($tahun_ajar as $item )
                    <option value="{{ $item->id }}" {{ request('tahun_ajar') == $item->id ? 'selected' : '' }}>Tahun Pelajaran : {{ $item->tahun_pelajaran }} - {{ $item->semester }}
                    </option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="card-body p-0 m-0">
            <div class="m-3">
                <a id="addRowBtn" class="btn btn-success mb-3 mx-1">+ Tambah Jadwal</a>
                <a id="addRowRef" class="btn btn-primary mb-3 ">+ Tambah Referensi</a>
            </div>
            <input class="id_kelas" value="{{ $id }}" name="id_kelas" hidden >
            <table class="table  input-table table-nowrap mb-0" id="draggable-table">
                <thead>
                    <tr>
                        <th class="bg-light-400">#</th>
                        <th class="bg-light-400 border"></th> <!-- Column for the Delete Button -->
                        <th class="bg-light-400 border">Hari</th>
                        <th class="bg-light-400 border">Mata Pelajaran</th>
                        <th class="bg-light-400 border">Guru Pengajar</th>
                        <th class="bg-light-400 border"><span class="ti ti-clock"></span> Start</th>
                        <th class="bg-light-400 border"><span class="ti ti-clock"></span> End</th>

                    </tr>
                </thead>
                <tbody>
                    @php
                    $no =1;
                    @endphp
                    @foreach($jadwal as $key)

                    @if($jadwal->count())
                    <tr>
                        <td class="border">{{ $no++ }}</td>
                        <td class="border"><a href="{{ route('leassonDelete',$key->id) }}" type="button" class=" btn btn-outline-light" ><span class="ti ti-trash"></span></button></td>
                        <td class="border" style="width: 200px;"><select name="day[]" class="form-control hari" required>
                                <option value="1" {{ $key->day == '1' ?'selected':'' }}>Senin</option>
                                <option value="2" {{ $key->day == '2' ?'selected':'' }}>Selasa</option>
                                <option value="3" {{ $key->day == '3' ?'selected':'' }}>Rabu</option>
                                <option value="4" {{ $key->day == '4' ?'selected':'' }}>Kamis</option>
                                <option value="5" {{ $key->day == '5' ?'selected':'' }}>Jumat</option>
                                <option value="6" {{ $key->day == '6' ?'selected':'' }}>Sabtu</option>
                                <option value="7" {{ $key->day == '7' ?'selected':'' }}>Minggu</option>
                            </select></td>

                        <td class="border" style="width: 300px;">
                            <select name="id_mapel[]" class="form-control pelajaran" required>
                                <option value="">Pilih Mata Pelajaran</option>
                                @if($key->mata_pelajaran)
                                <option selected value="{{ $key->id_mapel }}">{{ $key->mata_pelajaran->nama }}</option>
                                @foreach($mapel as $a)
                                <option value="{{ $a->id_mapel }}">{{ $a->mata_pelajaran->nama }}</option>
                                @endforeach
                                @else
                                <option selected value="{{ $key->id_mapel  }}">{{ $key->ref->ref ?? '' }}</option>
                                 @foreach($ref2 as $b)
                                    <option value="{{ $b->ref_ID }} ">{{ $b->ref }}</option>
                                @endforeach
                            @endif
                        </select></td>
                    <td class=" border" style="width: 350px;">
                                    <select name="id_gtk[]" class="form-control guru id_gtk" >
                                        <option>-Pilih Guru Pengajar-</option>
                                        @foreach ($gtk as $item )
                                        <option value="{{ $item->nik }}" {{ $item->nik == $key->id_gtk ? 'selected' :''}}>{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                        </td>
                        <td class="border"><input type="time" name="start[]" class="form-control" value="{{ $key->start }}"></td>
                        <td class="border"><input type="time" name="end[]" class="form-control" value="{{ $key->end }}"></td>


                    </tr>


                    @endif

                    @endforeach
            </table>
    </div>

    <div class="d-flex justify-content-end m-4">
        <button class="btn btn-primary" type="submit">Simpan Data </button>
    </div>


</form>



{{-- referensi --}}
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
                                                @foreach ($ref as $item )
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
                                        {{ $ref->links() }}
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
@foreach ($ref as $a )

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
>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
@if (session('refresh'))
    <script>
        window.location.reload();
    </script>
@endif

<script>
    // Function to populate the GTK (id_gtk) dropdown dynamically using $gtk data
    function populateGtkDropdown(row, selectedMataPelajaran, source) {
        const gtkData = @json($gtk); // Assuming $gtk contains GTK data
        const gtkDropdown = row.querySelector('.id_gtk'); // Get the select element for id_gtk

        // Clear existing options
        gtkDropdown.innerHTML = '<option value="">Pilih GTK</option>';

        // Loop through the gtkData and add options
        gtkData.forEach(item => {
            const option = document.createElement('option');
            option.value = item.nik;  // Use 'nik' as the value
            option.textContent = `${item.nama}`;  // Display 'nik' and 'nama' in the option text

            // If the GTK belongs to the selected Mata Pelajaran and source is not 'ref', pre-select it
            if (source !== 'ref' && item.mata_pelajaran && item.mata_pelajaran.nama === selectedMataPelajaran) {
                option.selected = true;
            }

            gtkDropdown.appendChild(option);
        });
    }

    // Function to add a new row dynamically at the top of the table
    function addRow(source) {
        let rowCount = 1;
        const tbody = document.querySelector('#draggable-table tbody');

        // Create a new row element
        const newRow = document.createElement('tr');
        newRow.setAttribute('draggable', 'true');
        newRow.classList.add('drag-item');

        // Define the data for the row (inputs for each column)
        const rowData = [
            `<td class="border"><span class="ti ti-grip-vertical"></span></td>`, // Row number (not an input)
            `<td class="border"><button type="button" class="btn btn-sm btn-danger" onclick="deleteRow(this)">Delete</button></td>`,
            `<td class="border" style="width: 150px;">
                <select name="day[]" class="form-control hari" required>
                    <option value="1">Senin</option>
                    <option value="2">Selasa</option>
                    <option value="3">Rabu</option>
                    <option value="4">Kamis</option>
                    <option value="5">Jumat</option>
                    <option value="6">Sabtu</option>
                    <option value="7">Minggu</option>
                </select>
            </td>`,
            `<td class="border" style="width: 300px;">
                <select name="id_mapel[]" class="form-control mapel" required>
                    <option value="">Pilih Mata Pelajaran</option>
                </select>
            </td>`,
            `<td class="border" style="width: 350px;">
                <select name="id_gtk[]" class="form-control id_gtk"></select>
            </td>`,
            '<td class="border"><input type="time" name="start[]" class="form-control"></td>',
            '<td class="border"><input type="time" name="end[]" class="form-control"></td>',
            '<td class="border" hidden><input type="text" name="sk[]" class="form-control"></td>',
            '<td class="border" hidden><input type="date" name="tanggal_sk[]" class="form-control"></td>',

        ];

        // Insert each <td> into the new row
        rowData.forEach(data => {
            newRow.innerHTML += data;
        });

        // Prepend the new row to the table body (adds the row to the top)
        tbody.insertBefore(newRow, tbody.firstChild);

        // Get the selected Mata Pelajaran for the new row
        let selectedMataPelajaran = '';
        if (source === 'mapel') {
            populateMapelDropdown(newRow); // Populate Mata Pelajaran dropdown
        } else if (source === 'ref') {
            populateRefDropdown(newRow); // Populate Ref dropdown
        }

        // Populate GTK dropdown based on selected Mata Pelajaran and source
        populateGtkDropdown(newRow, selectedMataPelajaran, source);

        // Initialize Select2 on the newly added selects
        initializeSelect2();

        // Increment the rowCount for the next row
        rowCount++;

        // Reapply the drag-and-drop functionality (in case the table is updated)
        addDragAndDropFunctionality();
    }

    // Function to populate the Mata Pelajaran (Mapel) dropdown dynamically using $mapel data
    function populateMapelDropdown(row) {
        const mapelData = @json($mapel); // Assuming $mapel contains Mata Pelajaran data
        const mapelDropdown = row.querySelector('.mapel'); // Get the select element for mapel

        // Clear existing options
        mapelDropdown.innerHTML = '<option value="">Pilih Mata Pelajaran</option>';

        // Loop through the mapelData and add options
        mapelData.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id_mapel;
            option.textContent = item.mata_pelajaran.nama;
            mapelDropdown.appendChild(option);
        });
    }

    // Function to populate the Ref dropdown dynamically using $ref data
    function populateRefDropdown(row) {
        const refData = @json($ref2); // Assuming $ref2 contains Ref data
        const mapelDropdown = row.querySelector('.mapel'); // Get the select element for ref

        // Clear existing options
        mapelDropdown.innerHTML = '<option value="">Pilih Referensi</option>';

        // Loop through the refData and add options
        refData.forEach(item => {
            const option = document.createElement('option');
            option.value = item.ref_ID;
            option.textContent = item.ref;
            mapelDropdown.appendChild(option);
        });
    }

    // Function to initialize Select2 on dynamically added select elements
    function initializeSelect2() {
        $('#draggable-table select').select2({
            width: '100%' // Ensures Select2 width adapts to the table cell
        });
    }

    // Function to delete a row
    function deleteRow(button) {
        const row = button.closest('tr');
        row.remove();
    }

    // Function to add drag-and-drop functionality to rows
    function addDragAndDropFunctionality() {
        const rows = document.querySelectorAll('.drag-item');
        let draggedRow = null;

        rows.forEach(row => {
            row.addEventListener('dragstart', (e) => {
                draggedRow = row;
                setTimeout(() => {
                    row.classList.add('dragging');
                }, 0);
            });

            row.addEventListener('dragend', () => {
                setTimeout(() => {
                    draggedRow.classList.remove('dragging');
                    draggedRow = null;
                }, 0);
            });

            row.addEventListener('dragover', (e) => {
                e.preventDefault();
                const draggedOverRow = e.target.closest('tr');
                if (draggedOverRow && draggedOverRow !== draggedRow) {
                    draggedOverRow.classList.add('drag-placeholder');
                }
            });

            row.addEventListener('dragleave', () => {
                const draggedOverRow = row.closest('tr');
                if (draggedOverRow) {
                    draggedOverRow.classList.remove('drag-placeholder');
                }
            });

            row.addEventListener('drop', (e) => {
                e.preventDefault();
                const draggedOverRow = e.target.closest('tr');
                if (draggedOverRow && draggedOverRow !== draggedRow) {
                    document.querySelector('tbody').insertBefore(draggedRow, draggedOverRow);
                }
                const allRows = document.querySelectorAll('.drag-item');
                allRows.forEach(row => {
                    row.classList.remove('drag-placeholder');
                });
            });
        });
    }

    // Add event listener to the "Add Row" button for $mapel
    document.getElementById('addRowBtn').addEventListener('click', function() {
        addRow('mapel'); // Trigger the addRow function with $mapel data
    });

    // Add event listener to the "Add Row" button for $ref
    document.getElementById('addRowRef').addEventListener('click', function() {
        addRow('ref'); // Trigger the addRow function with $ref data
    });

    $(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#draggable-table').on('change', '.mapel', function() {
            const mapel = $(this).val(); // Get the selected mapel ID
            const row = $(this).closest('tr'); // Get the current row
            const id_kelas = {{ $id }}; // Assuming $id is passed from the controller

            // Capture the current selected GTK (teacher) nik
            const currentSelectedNik = row.find('.id_gtk').val(); // Get the selected teacher's nik

            $.ajax({
                method: "GET",
                url: "{{ route('getgtk.leasson') }}",
                data: {
                    id_mapel: mapel,
                    id_kelas: id_kelas,
                    existing_nik: currentSelectedNik // Send current value of the GTK as existing_nik
                },
                success: function(data) {
                    row.find('.id_gtk option:selected').remove(); // Remove selected option to avoid duplication
                    // Add the new options based on the response data

                    row.find('.id_gtk').append(data.a);

                    // Optionally, select the previously selected GTK based on the response
                    if (currentSelectedNik && currentSelectedNik === data.selectedNik) {
                        row.find('.id_gtk').val(currentSelectedNik).trigger('change');; // Keep the same value selected
                    } else if (data.selectedNik) {
                        // Optionally, select the new selected GTK
                        row.find('.id_gtk').val(data.selectedNik).trigger('change');
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Error fetching GTK data: " + error);
                }
            });
        });
    });
</script>







@if (!empty(Session::get('ref')) && Session::get('ref') == 5)
<script type="text/javascript">
    $(function() {
        $('#ref').modal('show');
    });
</script>
@endif
<script>
     $(".tahun_ajar").select2({
        placeholder: "Pilih Mata Pelajaran",
    });
    $(".day").select2({
        dropdownParent: "#add_holiday",
    });
    $(".guru").select2({
         placeholder: "Pilih Referensi",
    });
    $(".hari").select2({
         placeholder: "Pilih Referensi",
    });
    $(".pelajaran").select2({
         placeholder: "Pilih Referensi",
    });



</script>


<script>

    var body = document.body;
    body.classList.add("mini-sidebar");
</script>
<script>

    $("#tab1").click(function(){
        $("#type").val('ref');
    });
    $("#tab2").click(function(){
        $("#type").val('mapel');
    });
</script>


<script>

</script>
@endsection
@endsection
