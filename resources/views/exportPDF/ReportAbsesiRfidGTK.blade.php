<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Absensi RFID Guru Tenaga Kependidikan</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Styling for the letterhead */
        .kop-surat {
            font-family: Arial, sans-serif;
            width: 100%;
            border-bottom: 3px solid black;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .kop-surat img {
            width: 70px;
            height: auto;
            float: left;
        }

        .kop-surat .text {
            text-align: center;
        }

        .kop-surat .text h1 {
            font-size: 20px;
            margin: 0;
            text-transform: uppercase;
        }

        .kop-surat .text h2 {
            font-size: 16px;
            margin: 5px 0;
        }

        .kop-surat .text p {
            margin: 0;
            font-size: 12px;
        }
        .signature-section {
            margin-top: 50px;
            text-align: center;
        }

        .signature {
            margin-top: 10px;
            font-size: 14px;
            text-align: center;
        }

        .signature .line {
            margin-top: 40px;
            border-top: 1px solid black;
            width: 250px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            margin: 20px 0;
            font-size: 12px;
        }

        td, th {
            padding: 5px;
            text-align: center;
            border: 1px solid #ddd;
            white-space: nowrap;  /* Hindari pemotongan konten pada kolom yang lebih lebar */
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        /* Print-specific styles */
        @media print {
            .signature-section {
            margin-top: 50px;
            text-align: center;
        }

        .signature {
            margin-top: 80px;
            font-size: 14px;
            text-align: center;
        }

        .signature .line {
            margin-top: 40px;
            border-top: 1px solid black;
            width: 250px;
            margin-left: auto;
            margin-right: auto;
        }
            body {
            font-size: 10px;  /* Ukuran font lebih kecil untuk print */
            font-family: Arial, sans-serif;
            }

            table {
                page-break-inside: avoid;
                border-collapse: collapse;
                border: 1px solid black;
            }

            td, th {
                padding: 5px;
                text-align: center;
                border: 1px solid #ddd;
                white-space: nowrap;  /* Hindari pemotongan konten pada kolom yang lebih lebar */
            }

            /* Force landscape mode */
            @page {
                size: A4 landscape;
                margin: 10mm;
            }

            .kop-surat {
                page-break-after: avoid;
            }

            tr {
                page-break-inside: avoid; /* Prevent rows from splitting */
            }

            .no-print {
                display: none;
            }
        }
        @media print {
            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            thead {
                display: table-header-group; /* agar header tetap di atas saat pindah halaman */
            }

            tfoot {
                display: table-footer-group;
            }

            a {
                text-decoration: none;
                color: black !important;
            }

            body {
                margin: 0;
            }
        }
    </style>
</head>
<body>

    <div class="kop-surat">
        <div class="logo">
            <img src="{{ app('settings')['site_logo'] === '' ? asset('asset/img/default-logo.png') : app('settings')['site_logo']  }}" alt="Logo">
        </div>
        <div class="text">
            <h2>Laporan Absensi RFID Guru Tenaga Kependidikan</h2>
            <h1><b>{{ app('settings')['site_name'] }}</b></h1>
            <h2>{{ app('settings')['address'] }}</h2>
            <p>Telepon: {{ app('settings')['phone'] }} | Email: {{ app('settings')['email'] }}</p>
        </div>
    </div>
    @php
    $thisMonth = \Carbon\Carbon::now()->format('F'); // Current month name

    @endphp

    <table class="table table-bordered table-striped mb-0" id="myTable">
        <thead>
            <tr class="text-center">
                <td rowspan="2">#</td>
                <td rowspan="2" class="text-center"><p>Nomor Induk</p></td>
                <td rowspan="2" class="text-center"><p>NAMA</p></td>

                <td colspan="35"><center>Bulan: {{ \Carbon\Carbon::create()->month((int) (request('month') ?: \Carbon\Carbon::now()->month))->format('F') }} {{ request('year') ?: \Carbon\Carbon::now()->format('Y') }}
                </center></td>
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
                        echo "<th scope='col'>{$day} </th>";
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
                    <td>{{ $absentData->nik }}</td>
                    <td style="text-align: left;">{{ $absentData->nama }}</td>

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
                        {{ $absentData->absentRFID->filter(function($item) {
                            return \Carbon\Carbon::createFromFormat('d/m/Y', $item->tanggal)
                                ->isSameMonth(request('year').'-'.request('month').'-01') && $item->status == 'H';
                        })->count() }}
                    </td>

                    <td class="text-center">
                        {{ $absentData->absentRFID->filter(function($item) {
                            return \Carbon\Carbon::createFromFormat('d/m/Y', $item->tanggal)
                                ->isSameMonth(request('year').'-'.request('month').'-01') && $item->status == 'S';
                        })->count() }}
                    </td>

                    <td class="text-center">
                        {{ $absentData->absentRFID->filter(function($item) {
                            return \Carbon\Carbon::createFromFormat('d/m/Y', $item->tanggal)
                                ->isSameMonth(request('year').'-'.request('month').'-01') && $item->status == 'I';
                        })->count() }}
                    </td>

                    <td class="text-center">
                        {{ $absentData->absentRFID->filter(function($item) {
                            return \Carbon\Carbon::createFromFormat('d/m/Y', $item->tanggal)
                                ->isSameMonth(request('year').'-'.request('month').'-01') && $item->status == 'A';
                        })->count() }}
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Area tanda tangan -->
    <div class="signature-section">
        {{-- <p>Malang, {{ date(now()) }} </p> <!-- Anda bisa mengganti secara dinamis --> --}}
        <div class="signature">
            <p>Kepala Sekolah</p>
            <br> <!-- Menambahkan jarak setelah teks Kepala Sekolah -->
            <div class="line"></div> <!-- Garis dengan jarak 0 -->
            <p style="margin: 0; padding: 0;"><strong>{{ app('settings')['headmaster'] }}</strong></p> <!-- Nama Kepala Sekolah dengan jarak 0 -->
            <p style="margin: 0; padding: 0;"><strong>NRKS. {{ app('settings')['headmasterid'] }}</strong></p> <!-- NRKS dengan jarak 0 -->
        </div>
    </div>

    <script>
        window.onload = function () {
            window.print();
    
            // Tunggu beberapa detik lalu tutup tab
            setTimeout(function () {
                window.close();
            }, 1000); // 1 detik (atur sesuai kebutuhan)
        };
    </script>
</body>
</html>
