<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jadwal Pelajaran</title>
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


        /* Table styles */
        .custom-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .custom-table th,
        .custom-table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .custom-table th {
            background-color: #f8f8f8;
            font-weight: bold;
        }

        .custom-table td {
            background-color: #fff;
        }

        /* Row for the day name */
        .day-row td {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        /* Row styles for time and subject */
        .schedule-row td {
            vertical-align: middle;
        }

        /* Styling for the "Hari" column */
        .day-cell {
            text-align: center;
            background-color: #e9ecef;
            font-weight: bold;
        }

        /* Time column styles */
        .time-cell {
            background-color: #e9ecef;
            text-align: center;
        }

        /* Subject cell styles */
        .subject-cell {
            background-color: #fafafa;
        }

        /* Teacher column styles */
        .teacher-cell {
            background-color: #fafafa;
            font-style: italic;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        .header{
            text-align: center;
        }

</style>
</head>
<body>
    <!-- Header (Kop Surat) -->
    <div class="kop-surat">
        <div class="logo">
            <img src="{{ app('settings')['site_logo'] === '' ? asset('asset/img/default-logo.png') : app('settings')['site_logo']  }}" alt="Logo">
        </div>
        <div class="text">
            <h2 style="text-transform: uppercase;"><b>Jadwal Pelajaran {{$title}}</b></h2>
            <h1><b>{{ app('settings')['site_name'] }}</b></h1>
            <h2>{{ app('settings')['address'] }}</h2>
            <p>Telepon: {{ app('settings')['phone'] }} | Email: {{ app('settings')['email'] }}</p>
        </div>
    </div>
    <center class="pb-2">Dicetak Pada Tanggal : {{ date('d/m/Y') }}</center>
    <!-- Table for Jadwal Pelajaran -->
    <div class="">
       
        <table class="custom-table">
            <thead>
                <tr>
                    <th class="header-cell">HARI</th>
                    <th class="header-cell">WAKTU</th>
                    <th class="header-cell">MATA PELAJARAN</th>
                    <th class="header-cell">GURU PENGAJAR</th>
                </tr>
            </thead>
            <tbody>
              @php
    $previousDay = null; // Variabel untuk menyimpan nama hari sebelumnya
@endphp

@foreach([1, 2, 3, 4, 5, 6, 7] as $day)  <!-- Loop through days (1 = Monday, 7 = Sunday) -->
    @php
        $dayName = ['1' => 'SENIN', '2' => 'SELASA', '3' => 'RABU', '4' => 'KAMIS', '5' => 'JUMAT', '6' => 'SABTU', '7' => 'MINGGU'][$day];
        $jadwalForDay = $jadwal->where('day', $day);
    @endphp

    @if($jadwalForDay->isNotEmpty())  <!-- Check if there are any schedules for the current day -->
        @foreach ($jadwalForDay as $jadwalItem)
            <tr class="schedule-row">
                <td class="day-cell">
                    @if($previousDay !== $dayName)
                        {{ $dayName }}
                    @else
                        &nbsp;
                    @endif
                </td>
                <td class="time-cell">{{ $jadwalItem->start }} - {{ $jadwalItem->end }}</td>
                <td class="subject-cell" @if($jadwalItem->ref) colspan="2" @endif>
                    @if($jadwalItem->mata_pelajaran)
                        {{ $jadwalItem->mata_pelajaran->nama ?? '' }}
                    @else
                        {{ $jadwalItem->ref->ref ?? '' }}
                    @endif
                </td>
                @if($jadwalItem->mata_pelajaran)
                <td class="teacher-cell">
                    {{ $jadwalItem->guru->nama ?? '' }}
                </td>
                @endif
            </tr>
            @php
                $previousDay = $dayName; // Update nama hari sebelumnya
            @endphp
        @endforeach
    @endif
@endforeach
            </tbody>
        </table>
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
