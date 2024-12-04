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
                <a id="addRowBtn" class="btn btn-success mb-3 btn-sm mx-1">+ Tambah Jadwal</a>
                <a id="addRowRef" class="btn btn-primary mb-3 btn-sm">+ Tambah Referensi</a>
            </div>
            <input class="id_kelas" value="{{ $id }}" name="id_kelas" hidden>
            <table class="table  input-table" id="draggable-table">
                <thead>
                    <tr>
                        <th class="bg-light-400">#</th>
                        <th class="bg-light-400 border">Hari</th>
                        <th class="bg-light-400 border">Mata Pelajaran</th>
                        <th class="bg-light-400 border">Guru Pengajar</th>
                        <th class="bg-light-400 border"><span class="ti ti-clock"></span> Start</th>
                        <th class="bg-light-400 border"><span class="ti ti-clock"></span> End</th>
                        <th class="bg-light-400 border"><span class="ti ti-certificate"></span> SK</th>
                        <th class="bg-light-400 border"><span class="ti ti-calendar-due"></span> Tanggal SK</th>
                        <th class="bg-light-400 border">Action</th> <!-- Column for the Delete Button -->
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
                                <option selected value="{{ $key->id_mapel  }}"">{{ $key->ref->ref ?? '' }}</option>
                                 @foreach($ref2 as $b)
                                    <option value="{{ $b->ref_ID }} ">{{ $b->ref }}</option>
                                @endforeach
                            @endif
                        </select></td>  
                    <td class=" border" style="width: 350px;">
                                    <select name="id_gtk[]" class="form-control guru">
                                        <option>-Pilih Guru Pengajar-</option>
                                        @foreach ($gtk as $item )
                                        <option value="{{ $item->nik }}" {{ $item->nik == $key->id_gtk ? 'selected' :''}}>{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                        </td>
                        <td class="border"><input type="time" name="start[]" class="form-control" value="{{ $key->start }}"></td>
                        <td class="border"><input type="time" name="end[]" class="form-control" value="{{ $key->end }}"></td>
                        <td class="border"><input type="text" name="sk[]" class="form-control" value="{{ $key->sk }}"></td>
                        <td class="border"><input type="date" name="tanggal_sk[]" class="form-control" value="{{ $key->tanggal_sk }}"></td>
                        <td class="border"><a href="{{ route('leassonDelete',$key->id) }}" type="button" class="btn btn-small btn-danger" >X</button></td>
                    </tr>
                    @endif

                    @endforeach
            </table>

            {{-- <div class="table-responsive">
            <table class="table table-nowrap mb-0">
                <thead>
                    <tr>
                        <th class="bg-light-400">#</th>
                        <th class="bg-light-400" width="2%"></th>
                        <th class="bg-light-400 border">Hari</th>
                        <th class="bg-light-400">Mata Pelajaran</th>
                        <th class="bg-light-400">Guru Pengajar</th>
                        <th class="bg-light-400"><span class="ti ti-clock"></span> Start</th>
                        <th class="bg-light-400"><span class="ti ti-clock"></span> End</th>
                        <th class="bg-light-400"><span class="ti ti-calendar-due"></span> Status</th>
                        <th class="bg-light-400"><span class="ti ti-certificate"></span> SK</th>
                        <th class="bg-light-400"><span class="ti ti-calendar-due"></span> Tanggal SK</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $no=1;
                    @endphp

                    @if($jadwal->count())
                    @foreach ($jadwal as $item )
                    <tr>
                        <td><a href="#">{{ $no++ }}</a></td>
            <td>
                <div class="hstack ">
                    <a href="{{ route('leassonDelete',$item->id) }}" class="btn btn-icon btn-sm btn-soft-danger rounded-pill"><span class="ti ti-trash"></span></a>
            </td>
            <td class="border">
                @if($item->day == 1)
                Senin
                @elseif ($item->day == 2)
                Selasa
                @elseif ($item->day == 3)
                Rabu
                @elseif ($item->day == 4)
                Kamis
                @elseif ($item->day == 5)
                Jum'at
                @elseif ($item->day == 6)
                Sabtu
                @elseif ($item->day == 7)
                Minggu
                @endif
            </td>
            <td>
                @if($item->mata_pelajaran)
                <b>{{ $item->mata_pelajaran->nama }}</b>
                @else
                <b>{{ $item->ref->ref }}</b>
                @endif
            </td>
            <td>
                @if($item->id_gtk == '')
                Belum Disetel
                @else
                {{ $item->guru->nama }}
                @endif
            </td>
            <td>
                {{ $item->start }}
            </td>
            <td>
                {{ $item->end }}
            </td>
            <td>
                @if($item->status == 1)
                <span class="badge badge-soft-success d-inline-flex align-items-center">Aktif</span>
                @else
                <span class="badge badge-soft-danger d-inline-flex align-items-center">Tidak AKtif</span>
                @endif
            </td>
            <td>{{ $item->sk == '' ? '-' : $item->sk }}</td>
            <td>{{ $item->tanggal_sk == '' ? '-' : $item->tanggal_sk }}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="10">
                    <center class="m-5"> <span class="ti ti-mood-confuzed"></span> Data masih kosong</center>
                </td>
            </tr>
            @endif
            </tbody>
            </table>
        </div> --}}
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
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
@if (session('refresh'))
    <script>
        window.location.reload();
    </script>
@endif
<script>
   // Function to populate the GTK (id_gtk) dropdown dynamically using $gtk data
function populateGtkDropdown(row) {
    const gtkData = @json($gtk); 
    const gtkDropdown = row.querySelector('.id_gtk'); // Get the select element for id_gtk

    // Clear existing options
    gtkDropdown.innerHTML = '<option value="">Pilih GTK</option>';

    // Loop through the gtkData and add options
    gtkData.forEach(item => {
        const option = document.createElement('option');
        option.value = item.nik;  // Use 'nik' as the value
        option.textContent = `${item.nik} - ${item.nama}`;  // Display 'nik' and 'nama' in the option text
        gtkDropdown.appendChild(option);
    });
}

// Function to add a new row dynamically
function addRow(source) {
    let rowCount = 1;
    // Get the table body
    const tbody = document.querySelector('#draggable-table tbody');
    
    // Create a new row element
    const newRow = document.createElement('tr');
    newRow.setAttribute('draggable', 'true');
    newRow.classList.add('drag-item');

    // Define the data for the row (inputs for each column)
    const rowData = [
        // Automatically add row number
        `<td class=" border"><span class="ti ti-grip-vertical"></span></td>`, // Row number (not an input)
        
        // Dropdown for Hari (Day of the week)
        `<td class=" border" style="width: 150px;"><select name="day[]" class="form-control hari" required>
                <option value="1">Senin</option>
                <option value="2">Selasa</option>
                <option value="3">Rabu</option>
                <option value="4">Kamis</option>
                <option value="5">Jumat</option>
                <option value="6">Sabtu</option>
                <option value="7">Minggu</option>
            </select></td>`,

        // Dropdown for Mata Pelajaran (Mapel)
        `<td class=" border" style="width: 300px;"><select name="id_mapel[]" class="form-control mapel" required>
                <option value="">Pilih Mata Pelajaran</option>
                <!-- Dynamic options for Mata Pelajaran will be inserted here -->
            </select></td>`,

        // GTK Dropdown
        `<td class=" border" style="width: 350px;"><select name="id_gtk[]" class="form-control id_gtk"></select></td>`,
    
        '<td class=" border"><input type="time" name="start[]" class="form-control"></td>',
        '<td class=" border"><input type="time" name="end[]" class="form-control"></td>',
        '<td class=" border"><input type="text" name="sk[]" class="form-control"></td>',
        '<td class=" border"><input type="date" name="tanggal_sk[]" class="form-control"></td>',
        
        // Action Column with Delete Button
        `<td class=" border"><button type="button" class="btn btn-sm btn-danger" onclick="deleteRow(this)">Delete</button></td>`
    ];

    // Insert each <td> into the new row
    rowData.forEach(data => {
        newRow.innerHTML += data;
    });

    // Append the new row to the table body
    tbody.appendChild(newRow);

    // Populate the dropdown based on the selected data source
    if (source === 'mapel') {
        populateMapelDropdown(newRow); // Use $mapel data
    } else if (source === 'ref') {
        populateRefDropdown(newRow); // Use $ref data
    }

    // Populate the GTK dropdown with the data from $gtk
    populateGtkDropdown(newRow); // Populate GTK (id_gtk)

    // Initialize Select2 on the newly added selects
    initializeSelect2();

    // Increment the rowCount for the next row
    rowCount++;

    // Reapply the drag-and-drop functionality (in case the table is updated)
    addDragAndDropFunctionality();
}

// Function to populate the Mata Pelajaran (Mapel) dropdown dynamically using $mapel data
function populateMapelDropdown(row) {
    const mapelData = @json($mapel);
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

// Function to populate the Mata Pelajaran (Mapel) dropdown dynamically using $ref data
function populateRefDropdown(row) {
    const refData = @json($ref2);
    const mapelDropdown = row.querySelector('.mapel'); // Get the select element for mapel

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
    rowCount--; // Decrease the row count after deletion
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
    $(function(){
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                });

        $('#mapel').on('change',function(){
            let mapel = $('.mapel').val();
            let id_kelas = $('.id_kelas').val();
            // var value = e.value;
            $.ajax({

                method:"POST",
                url:"{{ route('getgtk') }}",
                cache:false,
                data : {
                    id_mapel:mapel,
                    id_kelas:id_kelas
                },
                success: function(data){
                    $('.id_gtk').html(data.a);
                    $('.name_gtk').val(data.b);
                }
            });

        })
    })
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
@endsection
@endsection
