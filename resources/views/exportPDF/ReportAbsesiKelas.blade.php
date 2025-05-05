<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Absensi Kelas -  {{ $kelas->nama_kelas . ' ' . $kelas->jurusanKelas->nama_jurusan . ' ' . $kelas->sub_kelas }} / {{ $mapel->nama }}</title>
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
                margin: 5mm;
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
        
            <h1><b>{{ app('settings')['site_name'] }}</b></h1>
            <h2>{{ app('settings')['address'] }}</h2>
            <p>Telepon: {{ app('settings')['phone'] }} | Email: {{ app('settings')['email'] }}</p>
        </div>
    </div>
    
    
    @php
    $thisMonth = \Carbon\Carbon::now()->format('F'); // Current month name

    @endphp

    <div class="d-flex justify-content-between align-items-center" style="margin-bottom: 10px;">
        <div>
            <strong>LAPORAN ABSENSI KELAS:</strong>
            {{ $kelas->nama_kelas . ' ' . $kelas->jurusanKelas->nama_jurusan . ' ' . $kelas->sub_kelas }}
            <br><strong>Dicetak pada tanggal : </strong> {{ date('d/m/Y') }}

        </div>
        <div>
            <strong>MATA PELAJARAN:</strong>
            {{ $mapel->nama }}
        </div>
    </div>

   
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
            @php
            use Carbon\Carbon;

            $selectedMapel = request('mapel');
            $selectedMonth = request('month');
            $selectedYear  = request('year');

            // Helper function buat hitung jumlah kehadiran berdasarkan status
            $getAttendanceCount = function($absentData, $status) use ($selectedMapel, $selectedMonth, $selectedYear) {
                return $absentData->absentMapel->filter(function($item) use ($status, $selectedMapel, $selectedMonth, $selectedYear) {
                    return Carbon::createFromFormat('d/m/Y', $item->tanggal)
                        ->isSameMonth($selectedYear.'-'.$selectedMonth.'-01')
                        && $item->status == $status
                        && $item->id_mapel == $selectedMapel;
                })->count();
            };
        @endphp

        @foreach ($students as $data => $absentData)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $absentData->nis }}</td>
                <td style="text-align: left;">{{ $absentData->nama }}</td>

                @foreach (range(1, $daysInMonth) as $day2)
                    @php
                        $date   = Carbon::create($selectedYear, $selectedMonth, $day2)->format('d/m/Y');
                        $date2  = Carbon::create($selectedYear, $selectedMonth, $day2)->format('Y-m-d');
                        $isSunday = Carbon::create($selectedYear, $selectedMonth, $day2)->isSunday();
                        $isHoliday = in_array($date2, $hariLibur);
                        $isHolidayEnd = in_array($date2, $hariLiburEnd);

                        // Cek absen untuk tanggal & mapel ini
                        $attendance = $absentData->absentMapel->first(function($item) use ($date, $selectedMapel) {
                            return $item->tanggal == $date && $item->id_mapel == $selectedMapel && $item->id_mapel == request('kelas');
                        });

                        // Style cell berdasarkan status
                        $bgClass = '';
                        if ($attendance) {
                            $bgClass = match($attendance->status) {
                                'H' => 'text-center',
                                'I' => 'text-primary text-center',
                                'S' => 'text-warning text-center',
                                'A' => 'text-danger text-center',
                                default => ''
                            };
                        } elseif ($isSunday) {
                            $bgClass = 'bg-danger text-danger';
                        }
                    @endphp

                    <td class="{{ $bgClass }}">
                        @if ($attendance)
                            @if ($attendance->status == '')
                                -
                            @else
                                <b>
                                    <a id="popoverButton"
                                       data-bs-toggle="popover"
                                       data-bs-trigger="hover"
                                       title="Detail"
                                       data-bs-custom-class="header-info"
                                       data-bs-html="true"
                                       data-bs-content="
                                        Entry : <span class='badge badge-soft-success d-inline-flex align-items-center'>
                                        {{ $attendance->entry }}</span>
                                        Out : <span class='badge badge-soft-success d-inline-flex align-items-center'>
                                        {{ $attendance->out ?? '-' }}</span>">
                                        {{ $attendance->status ?? '-' }}
                                    </a>
                                </b>
                            @endif
                        @else
                            -
                        @endif
                    </td>
                @endforeach

                {{-- Summary kolom --}}
                <td class="text-center">{{ $getAttendanceCount($absentData, 'H') }}</td>
                <td class="text-center">{{ $getAttendanceCount($absentData, 'S') }}</td>
                <td class="text-center">{{ $getAttendanceCount($absentData, 'I') }}</td>
                <td class="text-center">{{ $getAttendanceCount($absentData, 'A') }}</td>
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
