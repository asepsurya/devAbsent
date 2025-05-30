@extends('layout.main')
@section('container')
@section('css')
<link rel="stylesheet" href="{{ asset('asset/css/DataTables.css') }}">
@endsection
{{-- header --}}
<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1">{{ $title }}</h3>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Beranda</a>
                </li>
                <li class="breadcrumb-item " aria-current="page">Akademik</li>
                <li class="breadcrumb-item " aria-current="page">Pengaturan</li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
        <div class="pe-1 mb-2">
            <a href="#" class="btn btn-outline-light bg-white btn-icon me-1" data-bs-toggle="tooltip"
                data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh">
                <i class="ti ti-refresh"></i>
            </a>
        </div>
        <div class="pe-1 mb-2">
            @if(request('id_kelas'))
            <a href="{{ route('list',request('id_kelas')) }}" type="button" class="btn btn-primary  me-1" data-bs-toggle="tooltip"
                data-bs-placement="top" aria-label="Print" data-bs-original-title="Setel" >
               <span class="ti ti-book"></span> Setel Mata Pelajaran
            </a>
            @else
            <button type="button" class="btn btn-primary  me-1" data-bs-toggle="tooltip"
            data-bs-placement="top" aria-label="Print" data-bs-original-title="Setel" disabled >
           <span class="ti ti-book"></span> Setel Jadwal Pelajaran
            </button>
            @endif
        </div>

    </div>
</div>
{{-- End Header --}}
<div class="alert alert-primary overflow-hidden p-0" role="alert">
    <div class="p-3 bg-primary text-fixed-white d-flex justify-content-between">
        <h3 class="aletr-heading mb-0 text-fixed-white"><span class="ti ti-info-circle"></span> Petunjuk Singkat</h3>

    </div>

    <div class="p-3">
        <p>Menu ini digunakan untuk mengatur daftar Mata Pelajaran pada tiap semester. Pastikan sebelum proses
            pembelajaran dimulai sudah mengatur daftar Mata Pelajaran yang akan diajarkan dengan cara sebagai berikut :
        </p>
        <li>Pilih Mata Pelajaran dengan cara mengklik tombol panah hijau, dan akan otomatis menambah data ke sebelah
            kanan tabel</li>

        <li>Kemudian Pilih <b>Tahun Pelajaran, Semester</b>, dan <b>Kelas</b> pada tabel di sebelah kanan sebagai target
            penyimpanan Mata Pelajaran yang terpilih.</li>
        <li>Klik tombol <b>"Apply dan Simpan"</b> untuk menyimpan ke daftar Mata pelajaran</b>.</li><br>
        <p> <b>Perlu diperhatikan</b> pada tabel <u>pengaturan mata pelajaran</u> pada tabel di bawah terdapat tanda
            warna merah samping tabel yang mengartikan bahwa data belum sepenuhnya tersimpan.</p>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body p-0 ">
                <div class=" overflow-hidden p-0 mb-0" role="alert">
                    <div class="p-3 bg-success text-fixed-white d-flex justify-content-between">
                        <h4 class="alert-heading mb-0 text-fixed-white"> <span class="ti ti-filter"></span>Pengaturan
                            Mata Pelajaran</h3>
                            <div>
                            </div>
                    </div>
                    <hr class="my-0">
                    <div class="p-3">
                        <p class="mb-0">
                        <form action="{{ route('pengaturanMapel') }}" method="get">

                            <input type="text" name="id_tahun_pelajaran" id="GetTahunPelajaran" hidden>
                            <input type="text" name="id_semester" id="GetSemester" hidden>
                            <input type="text" name="id_kelas" id="GetKelas" hidden>

                            <div>
                                <div class="row mb-2">
                                    <label class="col-lg-3 form-label ">Tahun Pelajaran</label>
                                    <div class="col-lg-9">
                                        <select name="tahunAjar" id="tahunAjar" class="form-control tahunAjar"
                                            onchange="copyTextValue()" form="myform">
                                            <option value="" selected>-- Tahun Pelajaran --</option>
                                            @foreach ($tahunAjar as $item )
                                            <option value="{{ $item->id }}" {{ $item->id ==
                                                request('id_tahun_pelajaran') ?
                                                'selected' :
                                                '' }}>{{ $item->tahun_pelajaran }} - {{ $item->semester }}
                                            </option>
                                            @php $a = request('id_tahun_pelajaran'); @endphp
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- <div class="row mt-0 mb-2">
                                    <label class="col-lg-3 form-label mt-2">Semester</label>
                                    <div class="col-lg-9">
                                        <select name="semester" id="semester" class="form-control select2"
                                            onchange="semesterValue()" form="myform">
                                            <option value="" selected>-- Pilih Semester --</option>
                                            <option value="Ganjil" {{ request('id_semester')=="Ganjil" ? 'selected' :''
                                                }}>
                                                Ganjil</option>
                                            <option value="Genap" {{ request('id_semester')=="Genap" ? 'selected' :''
                                                }}>
                                                Genap
                                            </option>
                                        </select>
                                    </div>
                                </div> --}}

                                <div class="row mb-2">
                                    <label class="col-lg-3 form-label mt-2">Kelas</label>
                                    <div class="col-lg-9">
                                        <select name="kelas" id="kelas" class="form-control kelas"
                                            onchange="kelasValue()" form="myform">
                                            <option value="" selected>-- Pilih Kelas --</option>
                                            @foreach ($kelas as $item )
                                            <option value="{{ $item->id }}" {{ $item->id == request('id_kelas') ?
                                                'selected' :
                                                '' }} >{{ $item->nama_kelas }} - {{
                                                $item->jurusanKelas->nama_jurusan }} {{ $item->sub_kelas }}</option>
                                            {{-- get Default Value --}}
                                            @php $c = request('id_kelas') @endphp
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                </p>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 g-1">
                                    <button class="btn btn-soft-success w-100"><span class="ti ti-search"></span> 1.
                                        Pilih Kelas </button>
                        </form>
                    </div>
                    <div class="col-lg-6 g-1">
                        <form action="{{ route('pengaturanMapelUpdate') }}" method="post">
                            @csrf
                            <button class="btn btn-soft-primary w-100"><span class="ti ti-upload"></span> 2. Apply
                                dan Simpan</button>
                            {{-- Input Box untuk mengambil Data Default --}}
                            <input type="text" name="tahun" id="id_tahun_pelajaranVal" value="{{ $a }}" hidden>
                            <input type="text" name="semester" id="semesterVal" value="Ganjil" hidden>
                            <input type="text" name="kelas" id="kelasVal" value="{{ $c }}" hidden>
                        </form>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-nowrap mb-0">
                    <thead>
                        <tr>
                            <th class="bg-light-400" width="10%">#</th>
                            <th class="bg-light-400" width="10%"></th>

                            <th class="bg-light-400">Mata Pelajaran</th>
                            <th class="bg-light-400">Guru Pengajar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no=1;
                        @endphp
                        @foreach ($mapelnotAllow as $item1)
                        <thead @if($item1->status == '1') class="bg-danger" @endif>
                            <tr >
                                <td >{{ $no++ }}</td>
                                <td>
                                    <a href="{{ route('pengaturanMapelDelete',$item1->id) }}"
                                        class="btn btn-icon btn-sm btn-soft-danger rounded-pill"><i
                                            class="ti ti-trash"></i></a>
                                </td>
                                <td>{{ $item1->mata_pelajaran->nama }}</td>
                                <td>
                                    @if ($item1->guru)
                                    {{ $item1->guru->nama }}
                                    @else
                                    Belum disetel
                                    @endif
                                </td>
                            </tr>
                        </thead>
                        @endforeach
                        @foreach ($grupMapel as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>
                                <a href="{{ route('pengaturanMapelDelete',$item->id) }}"
                                    class="btn btn-icon btn-sm btn-soft-danger rounded-pill"><i
                                        class="ti ti-trash"></i></a>
                            </td>
                            <td>{{ $item->mata_pelajaran->nama }}</td>
                            <td>
                                @if ($item->guru)
                                {{ $item->guru->nama }}
                                @else
                                Belum disetel
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end m-3">
                {{ $grupMapel->links() }}
            </div>
        </div>
        </div>
    </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                
                <div> <button type="button" id="save-selected" class="btn btn-primary"><span class="ti ti-arrow-left"></span> Tambahkan </button></div>
                <h3><span class="ti ti-settings"></span> Pilih Mata Pelajaran</h3>
            </div>
            <div class="card-body p-0 ">
                <div class="table-responsive">
                    <table class="table table-nowrap mb-0" id="myTable" >
                        <thead>
                            <tr>
                                <th width="1%"><div class="form-check form-check-md"><input type="checkbox" class=" form-check-input" id="select-all"></div></th>
                                <th class="bg-light-400">Mata Pelajaran</th>

                            </tr>
                        </thead>
                    </table>     
                </div>      
            </div>
        </div>

    </div>
</div>

{{-- modal tambah Hari Libur --}}
<div class="modal fade" id="add_holiday" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span class="ti ti-pencil-plus"></span> Ubah Kata Sandi</h4>
                <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </button>
            </div>
            <form action="holidays.html">
                <div class="modal-body">
                    <div class="row">
                        <form action="" method="post">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Kata Sandi</label>
                                    <div class="pass-group mb-3">
                                        <input type="password" class="pass-input form-control"
                                            placeholder="Masukan Kata Sandi">
                                        <span class="ti toggle-password ti-eye-off"></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ulangi Kata Sandi</label>
                                    <div class="pass-group mb-3">
                                        <input type="password" class="pass-input form-control"
                                            placeholder="Masukan Kata Sandi">
                                        <span class="ti toggle-password ti-eye-off"></span>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100"><span class="ti ti-pencil-plus"></span>
                        Ubah</button>
            </form>
        </div>

    </div>
</div>
</div>
@section('javascript')
<script src="{{ asset('asset/js/DataTables.js') }}"></script>
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(function() {
        var table = new DataTable('#myTable', {
            layout: {
                topEnd: {
                    search: {
                        placeholder: 'Search',
                        text: '<span class="ti ti-search"></span> _INPUT_'
                    }
                }
            },
            processing: true,
            order: [[1, 'desc']],
            serverSide: true,
            ajax: '{!! route('pengaturanMapel') !!}', // Route that returns JSON data
            columns: [
                { // Checkbox column to select rows
                    data: 'DT_RowIndex',
                    sortable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return '<div class="form-check form-check-md"><input type="checkbox" name="id_mapel[]" class="select-row form-check-input" value="'+ row.id +'"></div>';
                    },
                    targets: 0
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
            ]
        });

        // Add a 'Select All' checkbox to the table header
        $('#select-all').on('click', function() {
            var isChecked = this.checked;
            $('.select-row').each(function() {
                this.checked = isChecked;
            });
        });

        $('#save-selected').on('click', function() {
            var selectedIds = [];
            
            // Collect selected row ids
            $('.select-row:checked').each(function() {
                selectedIds.push($(this).val());  // Collect checked IDs
            });

            // Check if id_kelas exists in the request (you can add this validation based on your condition)
            var idKelas = '{{ request('id_kelas') }}';  // Assuming you're getting the id_kelas from the request
            
            // Validate if id_kelas is missing
            if (!idKelas) {
                // Show SweetAlert warning for missing id_kelas
                Swal.fire({
                    title: 'Warning!',
                    text: 'Please select a class first.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return;  // Stop the function execution if id_kelas is missing
            }

            // Check if any rows are selected
            if (selectedIds.length > 0) {
                // Send selectedIds via AJAX
                $.ajax({
                    url: '{{ route('pengaturanMapelAdd') }}',  // Define the route to handle selected data
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',  // CSRF token for security
                        selectedIds: selectedIds,  // Send the array of selected IDs
                        id_kelas: idKelas  // Include id_kelas in the request if needed
                    },
                    success: function(response) {
                        if (response.message) {
                            // Show success message using SweetAlert
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                table.ajax.reload();  // Reload the table data
                                location.reload();  // Optionally reload the page
                            });
                        } else {
                            // Show error message if no message is received
                            Swal.fire({
                                title: 'Error!',
                                text: 'No message received from the server.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function() {
                        // Show error message if AJAX request fails
                        Swal.fire({
                            title: 'Error!',
                            text: 'Error saving selected data.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            } else {
                // Show warning if no row is selected
                Swal.fire({
                    title: 'Warning!',
                    text: 'Please select at least one row.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
</script>




<script>
$('.tahunAjar').select2({
    placeholder: "Pilih Tahun Pelajaran",
});
$('.kelas').select2({
    placeholder: "Pilih Kelas",
});
</script>
<script>
    // set Defalult select ke dala input Box
    function copyTextValue() {
        var e = document.getElementById("tahunAjar");
        var val = e.options[e.selectedIndex].value;
        document.getElementById("id_tahun_pelajaranVal").value = val;
        document.getElementById("GetTahunPelajaran").value = val;
    }
    function semesterValue() {
        var e = document.getElementById("semester");
        var val = e.options[e.selectedIndex].value;
        document.getElementById("semesterVal").value = val;
        document.getElementById("GetSemester").value = val;
    }
    function kelasValue() {
        var e = document.getElementById("kelas");
        var val = e.options[e.selectedIndex].value;
        document.getElementById("kelasVal").value = val;
        document.getElementById("GetKelas").value = val;
    }
    // tangkap Data Data Input Box
    document.getElementById("GetTahunPelajaran").value = document.getElementById("id_tahun_pelajaranVal").value;
    document.getElementById("GetSemester").value = document.getElementById("semesterVal").value;
    document.getElementById("GetKelas").value = document.getElementById("kelasVal").value;
    // get id
    $("#submit").click(function(){
        document.getElementById("GetMapel").value = document.getElementById("MapelVal").value;
    });
</script>

@endsection
@endsection
