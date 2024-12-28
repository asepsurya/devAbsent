<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jadwal Pelajaran</title>
<style>
    /* General styles for the page */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

.container {
    margin: 20px auto;
    padding: 20px;
    max-width: 900px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
    <div class="header">
        <h3>
            Jadwal Pelajaran
            {{ $title }}</h3>
        <p>Di Cetak Pada Tanggal : {{ date('d-m-Y') }}</p>
    </div>

    <!-- Table for Jadwal Pelajaran -->
    <div class="container">
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
</body>
</html>
