@extends('layout.main')
@section('css')
<link rel="stylesheet" href="{{ asset('asset/css/DataTables.css') }}">
@endsection
@section('container')
{{-- header --}}
<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1"><span class="ti ti-users"></span> {{ $title }}</h3>
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
            <button type="button" class="btn btn-outline-light bg-white btn-icon me-1" data-bs-toggle="tooltip"
                data-bs-placement="top" aria-label="Print" data-bs-original-title="Print">
                <i class="ti ti-printer"></i>
            </button>
        </div>

    </div>
</div>
{{-- End Header --}}
<div class="alert alert-primary overflow-hidden p-0" role="alert">
    <div class="p-3 bg-primary text-white d-flex justify-content-between">
        <h3 class="alert-heading mb-0 text-white"><span class="ti ti-info-circle"></span> Petunjuk Singkat</h3>
    </div>

    <div class="p-3">
        <ol>
            <li><strong>1.Pilih Kelas Asal:</strong> Pilih kelas asal dari data yang tersedia. Terdapat pilihan <strong>"Belum Diatur"</strong> yang akan menampilkan siswa yang belum terdaftar di kelas manapun, atau <strong>"Tampilkan Semua"</strong> untuk menampilkan seluruh siswa yang sudah terdaftar di kelas.</li>
            <li><strong>2.Pilih Tahun Pelajaran:</strong> Tentukan tahun pelajaran yang relevan.</li>
            <li><strong>3.Tampilkan Data Siswa:</strong> Secara otomatis, sistem akan menampilkan data siswa berdasarkan kelas dan tahun pelajaran yang dipilih.</li>
            <li><strong>4.Pilih Kelas Tujuan:</strong> Pilih kelas tujuan serta tahun ajaran yang diinginkan, di mana siswa akan dipindahkan atau ditambahkan ke kelas tersebut.</li>
            <li><strong>5.Pilih Siswa untuk Dipindahkan:</strong> Pilih kolom centang pada bagian "Kelas Asal" dan pilih siswa yang akan dipindahkan.</li>
            <li><strong>6.Klik Tombol Pindahkan:</strong> Klik tombol <strong>"Pindahkan"</strong> yang terletak di kolom "Kelas Asal".</li>
            <li><strong>7.Proses Pemindahan Siswa:</strong> Secara otomatis, data siswa yang telah dipilih akan dipindahkan ke kelas tujuan yang ditentukan.</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h4><span class="ti ti-settings"></span> Kelas Asal</h4>
                <div>
                   {{-- ..... --}}
                </div>
            </div>
            <div class="card-body p-0 mb-0">
                <!-- Filter Form -->
            <div class="alert alert-primary overflow-hidden p-0 mb-0">
                <form action="{{ route('PengaturaRombel') }}" method="get" id="filterForm">
                    <input type="text" value="{{ request('id_tahun_pelajaran') }}" name="id_tahun_pelajaran" hidden>
                    <input type="text" value="{{ request('id_kelas_tujuan') }}" name="id_kelas_tujuan" hidden>

                    <div class="col m-3">
                        <label class="form-label">Kelas Asal <span class="text-danger">*</span></label>
                        <select name="id_kelas_asal" id="kelasAsal" class="form-control kelasAsal" onchange="this.form.submit()">
                            <option value="" selected>-- Pilih Kelas --</option>
                            <option value="belumDiatur" {{ request('id_kelas_asal') == 'belumDiatur' ? 'selected' : '' }}>Belum Diatur</option>
                            <option value="all" {{ request('id_kelas_asal') == 'all' ? 'selected' : '' }}>Tampilkan Semua</option>
                            @foreach ($kelas as $item)
                            <option value="{{ $item->id }}" {{ request('id_kelas_asal') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_kelas }} - {{ $item->jurusanKelas->nama_jurusan }} {{ $item->sub_kelas }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    @if(request('id_kelas_asal') != "belumDiatur" && request('id_kelas_asal') != "all")
                    <div class="col m-3">
                        <label class="form-label">Tahun Pelajaran <span class="text-danger">*</span></label>
                        <select name="tahunAjarAsal" id="tahunAsal" class="form-control tahunAsal" onchange="this.form.submit()">
                            <option value="" selected>-- Tahun Pelajaran --</option>
                            @foreach ($tahunAjar as $item)
                            <option value="{{ $item->id }}" {{ $item->id == request('tahunAjarAsal') ? 'selected' : '' }}>
                                {{ $item->tahun_pelajaran }} - {{ $item->semester }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                </form>
            </div>
                <div class="table-responsive">
                  <form action="{{ route('PengaturaRombelUpdate') }}" method="post">
                     @csrf
                    <table class="table table-nowrap mb-0" id="myTable">
                        <thead>
                            <tr>
                                <th class="bg-light-400" width="3%">
                                    <div class="form-check form-check-md">
                                        <input type="checkbox" class="form-check-input" id="select-all">
                                    </div>
                                </th>
                                <th class="bg-light-400" width="30%">NIS</th>
                                <th class="bg-light-400" width="40%">Nama Lengkap</th>
                              
                            </tr>
                        </thead>
                       
                    </table>
                    <input type="text" name="id_kelas_asal" value="{{ request('id_kelas_asal') }}" hidden>
                    <input type="text" name="tahunAjarAsal" value="{{ request('tahunAjarAsal') }}" hidden>
                    <input type="text" name="id_kelas" class="GetKelas" value="{{ request('id_kelas_tujuan') }}" hidden>
                    <input type="text" name="id_tahun_pelajaran" class="GetTahunPelajaran" value="{{ request('id_tahun_pelajaran') }}" hidden>
                    <input type="text" name="type" value="single" class="type" hidden>
                    <div class="m-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary" id="formSubmit">Pindahkan  <span class="ti ti-arrow-right"></span></button>
                    </div>
                </form>
               
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card mb-0">
            <div class="card-body p-0 ">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4><span class="ti ti-settings"></span> Kelas Tujuan</h4>
                    <div>
                        {{-- ..... --}}
                    </div>
                    </div>
                </div>
                <div class="alert alert-success overflow-hidden p-0 mb-0" role="alert">
                    <hr class="my-0">
                    <div class="p-3">
                        <form action="{{ route('PengaturaRombel') }}" method="get">
                            <p class="mb-0">
                                <input type="text" id="id_kelas_awal" value="{{ request('id_kelas_asal') }}" name="id_kelas_asal" hidden>
                                <input type="text" id="id_ajaran_awal" value="{{ request('tahunAjarAsal') }}" name="tahunAjarAsal" hidden>
                                <div>
                                    <div class="col mb-2">
                                        <label class="form-label">Tahun Pelajaran</label>
                                        <select name="id_tahun_pelajaran" id="tahunAjar" class="form-control tahunAjarTujuan" >
                                            <option value="" selected>-- Pilih Kelas --</option>
                                            @foreach ($tahunAjar as $item)
                                                <option value="{{ $item->id }}" selected>
                                                    {{ $item->tahun_pelajaran }} - {{ $item->semester }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col mb-2">
                                        <label class="form-label">Pilih Kelas Tujuan</label>
                                        <select name="id_kelas_tujuan" id="kelas" class="form-control KelasTujuan"  onchange="this.form.submit()">
                                            <option value="" selected>-- Pilih Kelas --</option>
                                            @foreach ($kelas as $item)
                                                <option value="{{ $item->id }}" {{ $item->id == request('id_kelas_tujuan') ? 'selected' : '' }}>
                                                    {{ $item->nama_kelas }} - {{ $item->jurusanKelas->nama_jurusan }} {{ $item->sub_kelas }}
                                                </option>
                                            @endforeach
                                            <optgroup label=" -- siswa yang sudah lulus --">
                                                <option value="lulusan" {{ 'lulusan' == request('id_kelas_tujuan') ? 'selected' : '' }}>Kelas Lulusan</option>
                                            </optgroup>
                                         
                                        </select>
                                    </div>
                                </div>
                            </p>
                        </form>
                    </div>
                    <input type="text" id="id_kelas_tujuan" value="{{ request('id_kelas_tujuan') }}" hidden>
                    <input type="text" id="tahun_ajaran_tujuan" value="{{ request('id_tahun_pelajaran') }}" hidden>
                </div>
                
            </div>
            <div class="card">
                <div class="table-responsive mt-0">
                    <table class="table table-nowrap mb-0" id="tableTujuan">
                        <thead>
                            <tr>
                                <th class="bg-light-400" width="10%">#</th>
                                <th class="bg-light-400 "width="30%">NIS</th>
                                <th class="bg-light-400">Nama Lengkap</th>
                            </tr>
                        </thead>
                    
                    </table>
                
                </div>
            </div>
        </div>

    </div>
</div>
</div>
</div>
@section('javascript')
<script src="{{ asset('asset/js/DataTables.js') }}"></script>

<script>
    $(document).ready(function() {
        // Inisialisasi DataTable pertama
        var table1 = $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{!! route('PengaturaRombel.dataAwalSiswa') !!}',
                data: function(d) {
                    d.id_kelas_asal = $('#kelasAsal').val();
                    d.tahunAjarAsal = $('#tahunAsal').val();
                    d.id_tahun_pelajaran = $("input[name='id_tahun_pelajaran']").val();
                    d.id_kelas_tujuan = $("input[name='id_kelas_tujuan']").val();
                }
            },
            columns: [
                {
                    data: null,
                    sortable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `<div class="form-check form-check-md">
                                    <input class="form-check-input" type="checkbox" name="nis[]" value="${row.nis}">
                                </div>`;
                    }
                },
                {
                    data: 'nis',
                    name: 'nis'
                },
                {
                    data: 'nama',
                    name: 'nama',
                    render: function(data, type, row) {
                        return (row.rombelStudent && row.rombelStudent.nama) ? row.rombelStudent.nama : data;
                    }
                },
                {
                    data: null,
                    sortable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `<input type="text" name="id_rfid[]" value="${row.id_rfid}" hidden>
                                <input type="text" name="id_kelas_tujuan" value="${data.id_kelas_tujuan}" hidden>
                                <input type="text" name="id_tahun_pelajaran" value="${data.id_tahun_pelajaran}" hidden>`;
                    }
                }
            ],
            order: [[1, 'asc']], 
        });

        // Inisialisasi DataTable kedua
        var table2 = new DataTable('#tableTujuan', {
            processing: true,
            serverSide: true,
            order: [[1, 'desc']],
            ajax: function(data, callback, settings) {
                var tahunAjar = $('#tahunAjar').val();
                var kelasTujuan = $('#kelas').val();
                var searchTerm = data.search.value; // Get search term from the DataTable instance

                // Ensure the search term is properly included in the AJAX request
                $.ajax({
                    url: '{!! route('PengaturaRombel.dataTujuanSiswa') !!}',
                    method: 'GET',
                    data: {
                        id_tahun_pelajaran: tahunAjar,
                        id_kelas_tujuan: kelasTujuan,
                        search: searchTerm // Send search term
                    },
                    success: function(response) {
                        // Use callback to update the table with the fetched data
                        callback({
                            draw: settings.iDraw,
                            recordsTotal: response.recordsTotal,
                            recordsFiltered: response.recordsFiltered,
                            data: response.data
                        });
                    }
                });
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nis',
                    name: 'nis',
                    searchable: true
                },
                {
                    data: 'nama',
                    name: 'nama',
                    searchable: true
                }
            ],
            language: {
                search: "Search",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "No entries available"
            }
        });

        // Reload DataTable kedua saat filter berubah
        $('#tahunAjar, #kelas').on('change', function() {
            table2.ajax.reload();
        });
    });
</script>


<script>
$('.tahunAjarTujuan').select2({
    placeholder: "Pilih Tahun Pelajaran Tujuan",
});
$('.KelasTujuan').select2({
    placeholder: "Pilih Tahun Kelas Tujuan",
});
$('.kelasAsal').select2({
    placeholder: "Pilih Tahun Kelas",
});
$('.tahunAsal').select2({
    placeholder: "Pilih Tahun Pelajaran",
});
</script>
<script>
    function TahunAjarValue() {
        var e = document.getElementById("tahunAjar");
        var val = e.options[e.selectedIndex].value;
        document.getElementById("tahun_ajaran_tujuan").value = val;
        $(".GetTahunPelajaran").val(val);

     }
    function KelasValue() {
        var e = document.getElementById("kelas");
        var val = e.options[e.selectedIndex].value;
        document.getElementById("id_kelas_tujuan").value = val;
        $(".GetKelas").val(val);

    }
    // $(".GetKelas").val(document.getElementById("id_kelas_tujuan").value) ;
    // $(".GetTahunPelajaran").val(document.getElementById("tahun_ajaran_tujuan").value);

</script>
<script>
    function myFunction1() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("myInput1");
      filter = input.value.toUpperCase();
      table = document.getElementById("table");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[2];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
    function myFunction() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[2];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
</script>
@endsection
@endsection
