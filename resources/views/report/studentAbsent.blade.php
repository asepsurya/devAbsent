@extends('layout.main')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf-8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <style>
        table.dataTable thead th, table.dataTable thead td {
        padding: 10px 18px;
        border-bottom: 1px solid #e9edf4;
        }

        table.dataTable.no-footer {
            border-bottom: 1px solid #e9edf4;
        }
        div.dataTables_wrapper div.dataTables_info {
            padding-top: 20px;
            padding-left: 20px;
        }
        .dataTables_wrapper .dataTables_paginate {
            float: right;
            text-align: right;
            /* padding-top: 0; */
            padding-right: 20px;
            padding-bottom: 20px;
        }
        .dataTables_wrapper .dataTables_length {
            float: left;
            padding-top: 10px;
            padding-left: 20px;
        }

        .dataTables_wrapper .dataTables_filter {
            float: right;
            text-align: right;
            padding-right: 30px;
        }
    </style>
@endsection
@section('container')
<form action="" method="get">
{{-- Header --}}
<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1">{{ $title }}</h3>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Beranda</a>
                </li>
                <li class="breadcrumb-item">Laporan</li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
        <div class="col mx-2">
            <label for="">Tahun Pelajaran </label>
            <select name="month"  class="form-control select" onchange="">

                @foreach ($tahunpelajaran as $item)
                <option value="{{ $item->id }}" > {{ $item->tahun_pelajaran }} - {{ $item->semester }}</option>
                @endforeach
            </select>
        </div>
        <div class="col mx-2">
            <label for="">Bulan </label>
            <select name="month" id="bulan" class="form-control select" onchange="">
                @foreach (range(1, 12) as $monthNumber)
                    <option value="{{ str_pad($monthNumber, 2, '0', STR_PAD_LEFT) }}"
                        {{ (request('month') == str_pad($monthNumber, 2, '0', STR_PAD_LEFT)) || (!request()->has('month') && $monthNumber == now()->month) ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($monthNumber)->format('F') }}
                    </option>
                @endforeach
            </select>

        </div>
        <div class="col mx-2">
            <label for="">Tahun </label>
            <select name="year" class="form-control select" id="yearSelect">
                <!-- Options will be added here by JavaScript -->

                @php
                $currentYear = date('Y'); // Get the current year
                $startYear = 2000; // Define the starting year
                @endphp

                @for ($year = $startYear; $year <= $currentYear; $year++)
                    <option value="{{ $year }}"
                        {{ (request('year') == $year || (!request()->has('year') && $year == $currentYear)) ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                @endfor
            </select>
        </div>


    </div>
</div>

{{-- End Header --}}

<div class="card" role="alert">
    <div class="card-body p-3 bg-primary text-fixed-white rounded">

        <div class=" row g-3  mt-2">
            <div class="d-flex justify-content-end g-3">
                <div class="col-lg-2">
                    <h4 class=" mb-0 text-fixed-white mt-4"><span class="ti ti-filter"></span> Filter Data</h4>
                </div>
                <div class="col mx-2">
                    <label for="">Rombongan Belajar </label>
                    <select name="kelas" class="form-control rombel">
                        <option value="">Pilih Rombongan Belajar</option>
                        <!-- Options will be added here by JavaScript -->
                        @foreach ($kelas as $data )
                        <option value="{{ $data->id }}" {{ $data->id == request('kelas') ? 'selected' : '' }}>{{
                            $data->nama_kelas }} {{ $data->jurusanKelas->nama_jurusan }} {{ $data->sub_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col mx-2">
                    <label for="">Mata Pelajaran </label>
                    <select name="mapel" class="form-control mapel">
                        <option value="" >Pilih Mata Pelajaran</option>
                        @if(request('mapel'))
                        @foreach ($mapel as $mapel)
                        <option value="{{ $mapel->id_mapel }}" {{ $mapel->id_mapel == request('mapel') ? 'Selected' :
                            ''}}>{{ $mapel->mata_pelajaran->nama }} - {{ $mapel->guru->nama ?? 'Belum Diatur' }} </option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="mt-3">
                    <button class="btn btn-light"><span class="ti ti-search"></span> Tampilkan Data</button>
                </div>
            </div>
        </div>

    </div>
</div>
</form>
<div class="card mt-3">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap pb-0">
        <h4 class="mb-3">Laporan Absensi Siswa</h4>
        <div class="d-flex align-items-center flex-wrap">

            <button class="btn btn-outline-light bg-white mb-3 mx-1"><span class="ti ti-printer"></span> Cetak</button>
            <button class="btn btn-outline-light bg-white mb-3">Exsport PDF</button>
        </div>
    </div>
    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table  table-striped mb-0" id="myTable">
                <thead>
                    <tr class="text-center">
                        <td rowspan="2" class="border">#</td>
                        <td rowspan="2" class="text-center border"><p>NIS</p></td>
                        <td rowspan="2" class="text-center border"><p>NAMA</p></td>
                        @php
                            $thisMonth = \Carbon\Carbon::now()->format('F'); // Current month name

                        @endphp
                        <td colspan="32" class="border"><p class="d-flex justify-content-start">Bulan: {{ \Carbon\Carbon::create()->month((int) (request('month') ?: \Carbon\Carbon::now()->month))->format('F') }} {{ request('year') ?: \Carbon\Carbon::now()->format('Y') }}
                        </p></td>
                    </tr>
                    <tr class="text-center">
                        @php
                            // Get current month and year
                            $year = request('year');
                            $month = request('month')  ; // Set to the desired month, e.g., November

                            $holidayRecord = $holiday->firstWhere('type', 'holiday');
                            $hariLibur = $holidayRecord ? $holidayRecord->pluck('start')->toArray() : [];
                            $hariLiburEnd = $holidayRecord ? $holidayRecord->pluck('end')->toArray() : [];

                            // Calculate number of days in the current month
                            $daysInMonth = \Carbon\Carbon::create($year, $month, 1)->daysInMonth;

                            // Generate day headers for each day of the month
                            for ($day = 1; $day <= $daysInMonth; $day++) {
                                // Get the name of the day (e.g., Mon, Tue, etc.)
                                $dayName = \Carbon\Carbon::create($year, $month, $day)->format('D');
                                echo "<th scope='col' class='border'>{$day} <br> {$dayName}</th>";
                            }
                        @endphp
                        <th scope="col" width="20" class="border">H</th>
                        <th scope="col" width="20" class="border">S</th>
                        <th scope="col" width="20" class="border">I</th>
                        <th scope="col" width="20" class="border">A</th>
                    </tr>
                </thead>
                <tbody>
                    @if(request('kelas'))
                        @foreach ($students as $data => $absentData)
                            <tr>
                                <td class="text-center border">{{ $loop->iteration }}</td>
                                <td class="border">{{ $absentData->nis }}</td>
                                <td class="border">{{ $absentData->nama }}</td>

                                @foreach (range(1, $daysInMonth) as $day2)
                                    @php
                                        $isSunday = \Carbon\Carbon::create($year, $month, $day2)->isSunday(); // Check if it's Sunday
                                        $date = \Carbon\Carbon::create($year, $month, $day2)->format('d/m/Y'); // Format the day into a date string
                                        $date2 = \Carbon\Carbon::create($year, $month, $day2)->format('Y-m-d'); // Format the day into a date string
                                        $isHoliday = in_array($date2, $hariLibur); // Check if it's a holiday
                                        $isHolidayEnd = in_array($date2, $hariLiburEnd); // Check if it's a holiday end
                                    @endphp

                                    @php
                                        // Check if there is an attendance record for this date
                                        $attendance = $absentData->absentMapel->filter(function($item) use ($date) {
                                            return $item->tanggal == $date && $item->id_mapel == request('mapel');
                                        })->first();

                                    @endphp

                                    <td  @if ($attendance)
                                            @php
                                                // Apply background color based on the status
                                                $bgClass = match($attendance->status) {
                                                    'H' => 'text-center',   // For 'H' (Hadir), green success color
                                                    'I' => 'text-primary text-center',   // For 'I' (Izin), yellow warning color
                                                    'S' => 'text-warning text-center',   // For 'S' (Sakit), blue primary color
                                                    'A' => 'text-danger text-center',    // For 'A' (Absen), red danger color
                                                    default => ''
                                                };
                                            @endphp
                                            class="{{ $bgClass }} text-center"
                                        @elseif ($isSunday)
                                            class="bg-danger text-danger"
                                        @endif
                                        class="border">
                                        @if ($attendance)
                                            {{-- If attendance exists, display the entry and exit times --}}
                                            @if ($attendance->status == '')
                                                -
                                            @else
                                                <b><a id="popoverButton" data-bs-toggle="popover" data-bs-trigger="hover" title="Detail" data-bs-custom-class="header-info" data-bs-html="true"  data-bs-content="Entry : <span class='badge badge-soft-success d-inline-flex align-items-center'>
                                                    {{ $attendance->entry }} </span>  Out : <span class='badge badge-soft-success d-inline-flex align-items-center'>
                                                    {{ $attendance->out ?? '-' }} </span>">{{ $attendance->status ?? '-' }}</a></b>
                                            @endif
                                        @else
                                            {{-- If no attendance, display '-' --}}
                                            -
                                        @endif
                                    </td>
                                @endforeach

                                {{-- Attendance Summary Columns (H, S, I, A counts) --}}
                                <td class="text-center border">
                                    {{ $absentData->absentMapel->filter(function($item) {
                                        return \Carbon\Carbon::createFromFormat('d/m/Y', $item->tanggal)
                                            ->isSameMonth(request('year').'-'.request('month').'-01') && $item->status == 'H';
                                    })->count() }}
                                </td>

                                <td class="text-center border">
                                    {{ $absentData->absentMapel->filter(function($item) {
                                        return \Carbon\Carbon::createFromFormat('d/m/Y', $item->tanggal)
                                            ->isSameMonth(request('year').'-'.request('month').'-01') && $item->status == 'S';
                                    })->count() }}
                                </td>

                                <td class="text-center border">
                                    {{ $absentData->absentMapel->filter(function($item) {
                                        return \Carbon\Carbon::createFromFormat('d/m/Y', $item->tanggal)
                                            ->isSameMonth(request('year').'-'.request('month').'-01') && $item->status == 'I';
                                    })->count() }}
                                </td>

                                <td class="text-center border">
                                    {{ $absentData->absentMapel->filter(function($item) {
                                        return \Carbon\Carbon::createFromFormat('d/m/Y', $item->tanggal)
                                            ->isSameMonth(request('year').'-'.request('month').'-01') && $item->status == 'A';
                                    })->count() }}
                                </td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="38" >Data Not Set</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="accordions-items-seperate mt-2" id="accordionSpacingExample">
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingSpacingOne">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#SpacingOne" aria-expanded="false" aria-controls="SpacingOne">
                Event dan Hari Libur
            </button>
        </h2>
        <div id="SpacingOne" class="accordion-collapse collapse " aria-labelledby="headingSpacingOne" data-bs-parent="#accordionSpacingExample" style="">
            <div class="accordion-body">
                <ul>
                    @foreach ($holiday->where('type','holiday') as $key)
                        <li>{{ $key->start }} / {{ $key->end }} | <strong>{{ $key->title }}</strong></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@section('javascript')

<script>
    var body = document.body;
    body.classList.add("mini-sidebar");
</script>
<script>
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
<script>
$(document).ready(function() {
    if ($("#yearSelect option").length === 0) {
        // Only populate options if they're not already populated
        let currentYear = new Date().getFullYear();
        let startYear = 2000;
        for (let year = startYear; year <= currentYear; year++) {
            let selected = (year == {{ request('year') }}) ? 'selected' : '';
            $('#yearSelect').append(`<option value="${year}" ${selected}>${year}</option>`);
        }
    }
});

  </script>
<script>
    // Enable popovers for elements with the data-bs-toggle="popover" attribute
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#myTable').DataTable({
            "paging": true,         // Enable pagination
            "searching": true,      // Enable searching
            "ordering": true,       // Enable column ordering
            "lengthChange": true,   // Allow users to change the number of records per page
            "info": true,           // Display table information (e.g., "Showing 1 to 10 of 50 entries")
            "autoWidth": false,     // Disable auto column width calculation
            "responsive": true      // Enable responsive design for mobile view
        });
    });
</script>
<script>
     $(function(){
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });
        $('.mapel').select2({
            placeholder : 'Pilih Mata Pelajaran'
        });
        $('.rombel').select2({
            placeholder : 'Pilih Rombongan Belajar'
        });
        $(function (){
            $('.rombel').on('change',function(){
                let id_kelas = $('.rombel').val();

                $.ajax({
                    type : 'POST',
                    url : "{{route('getmapel')}}",
                    data : {id_kelas:id_kelas},
                    cache : false,

                    success: function(msg){
                        $('.mapel').html(msg);
                    },
                    error: function(data) {
                        console.log('error:',data)
                    },
                })
            })
        });

    });

</script>
@endsection

@endsection
