@extends('layout.main')
@section('css')

@endsection
@section('container')

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
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap"></div>
</div>
{{-- End Header --}}
<div class="card" role="alert">
   <div class="card-body p-3 bg-primary text-fixed-white rounded">
    <form action="" method="get">
        <div class="d-flex row g-3 justify-content-center">
                <div class="col-lg-3">
                    <h4 class=" mb-0 text-fixed-white mt-2">Filter Data</h4>
                </div>
                <div class="col-lg-3">
                    <select name="month" id="bulan" class="form-control select" onchange="">
                        <option value="all" selected>Semua Bulan</option>
                        @php
                        for ($month = 1; $month <= 12; $month++) { $monthName=\Carbon\Carbon::create(null, $month, 1, 0, 0,
                            0, 'Asia/Jakarta' )->format('F');
                            printf('<option value="%02d">%s</option>', $month, $monthName);
                            }
                            @endphp
                    </select>
                </div>
                <div class="col-lg-3">
                    <select id="yearSelect" name="year" class="form-control select">
                        <!-- Options will be added here by JavaScript -->
                        <option value="">Pilih Tahun</option>
                    </select>
                </div>
                <div class="col-lg-2">
                    <button class="btn btn-light"><span class="ti ti-search"></span> Tampilkan Data</button>
                </div>

        </div>

    </div>
</form>
</div>
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap pb-0">
        <h4 class="mb-3">Laporan Absensi RFID</h4>
        <div class="d-flex align-items-center flex-wrap">
            <div class="input-icon-start mb-3 me-2 position-relative">
                <span class="icon-addon">
                    <i class="ti ti-search"></i>
                </span>
                <input type="text" class="form-control" placeholder="Cari Siswa.." id="myInput" onkeyup="myFunction()">
            </div>
            <button class="btn btn-outline-light bg-white mb-3 mx-1"><span class="ti ti-printer"></span> Cetak</button>
            <button class="btn btn-outline-light bg-white mb-3">Exsport PDF</button>
        </div>
    </div>
    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table table-bordered table-striped mb-0" id="myTable">
                <thead>
                    <tr class="text-center">
                        <td rowspan="2">#</td>
                        <td rowspan="2" class="text-center"><p>RFID</p></td>
                        <td rowspan="2" class="text-center"><p>NAMA</p></td>
                        @php
                            $thisMonth = \Carbon\Carbon::now()->format('F'); // Current month name
                        @endphp
                        <td colspan="31"><p>Bulan : {{ $thisMonth }}</p></td>
                    </tr>
                    <tr class="text-center">
                        @php
                            // Get current month and year
                            $year = \Carbon\Carbon::now()->year;
                            $month = 11; // Set to the desired month, e.g., November

                            $holidayRecord = $holiday->firstWhere('type', 'holiday');
                            $hariLibur = $holidayRecord ? $holidayRecord->pluck('start')->toArray() : [];
                            $hariLiburEnd = $holidayRecord ? $holidayRecord->pluck('end')->toArray() : [];

                            // Calculate number of days in the current month
                            $daysInMonth = \Carbon\Carbon::create($year, $month, 1)->daysInMonth;

                            // Generate day headers for each day of the month
                            for ($day = 1; $day <= $daysInMonth; $day++) {
                                // Get the name of the day (e.g., Mon, Tue, etc.)
                                $dayName = \Carbon\Carbon::create($year, $month, $day)->format('D');
                                echo "<th scope='col'>{$day} <br> {$dayName}</th>";
                            }
                        @endphp
                        <th scope="col" width="20">H</th>
                        <th scope="col" width="20">S</th>
                        <th scope="col" width="20">I</th>
                        <th scope="col" width="20">A</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $data => $absentData)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $absentData->id_rfid }}</td>
                            <td>{{ $absentData->nama }}</td>

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
                                    $attendance = $absentData->absentRFID->firstWhere('tanggal', $date);
                                @endphp

                                <td @if ($attendance)
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
                                >
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
                            <td class="text-center">
                                {{ $absentData->absentRFID->where('status', 'H')->count() }}
                            </td>
                            <td class="text-center">
                                {{ $absentData->absentRFID->where('status', 'S')->count() }}
                            </td>
                            <td class="text-center">
                                {{ $absentData->absentRFID->where('status', 'I')->count() }}
                            </td>
                            <td class="text-center">
                                {{ $absentData->absentRFID->where('status', 'A')->count() }}
                            </td>
                        </tr>
                    @endforeach
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
    const selectBox = document.getElementById('yearSelect');
    const currentYear = new Date().getFullYear();
    const startYear = 2000; // Start year

    for (let year = startYear; year <= currentYear; year++) {
      const option = document.createElement('option');
      option.value = year;
      option.textContent = year;
      selectBox.appendChild(option);
    }
  </script>
<script>
    // Enable popovers for elements with the data-bs-toggle="popover" attribute
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
</script>
@endsection

@endsection
