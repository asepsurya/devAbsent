@extends('layout.main')

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

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap pb-0">
        <h4 class="mb-3">Daftar Absensi</h4>
        <div class="d-flex align-items-center flex-wrap">
            <div class="input-icon-start mb-3 me-2 position-relative">
                <span class="icon-addon">
                    <i class="ti ti-search"></i>
                </span>
                <input type="text" class="form-control" placeholder="Cari Absensi.." id="myInput" onkeyup="myFunction()">
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-striped mb-0" id="myTable">
                <thead>
                    <tr class="text-center">
                        <th scope="col" width="30">#</th>
                        <th scope="col" width="80">ID</th>
                        <th scope="col" width="170">NAMA</th>
                        @foreach ($allDates as $date)
                            @php
                                $formattedDate = \Carbon\Carbon::createFromFormat('d/m/Y', $date)->format('d');
                            @endphp
                            <th scope="col">{{ $formattedDate }}</th>
                        @endforeach
                        <th scope="col" width="20">H</th>
                        <th scope="col" width="20">S</th>
                        <th scope="col" width="20">I</th>
                        <th scope="col" width="20">A</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($absents as $id_rfid => $absentData)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $id_rfid }}</td>
                            <td>{{ $absentData[0]['nama'] ?? '-' }}</td>
                            @foreach ($allDates as $date)
                                <td class="text-center"
                                    @php
                                        // Mencari absensi berdasarkan tanggal dalam $absentData
                                        $absent = collect($absentData)->firstWhere('tanggal', $date);
                                        // Menentukan warna berdasarkan status
                                        $status = $absent['status'] ?? '-';
                                        $bgColor = '';
                                        if ($status == 'H') {
                                            $bgColor = 'background-color: green; color: white;';
                                        } elseif ($status == 'S') {
                                            $bgColor = 'background-color: blue; color: white;';
                                        } elseif ($status == 'I') {
                                            $bgColor = 'background-color: yellow; color: black;';
                                        } elseif ($status == 'A') {
                                            $bgColor = 'background-color: red; color: white;';
                                        }
                                    @endphp
                                    style="{{ $bgColor }}"
                                >
                                    {{ $status }}
                                </td>
                            @endforeach
                            <td class="text-center">{{ $absentData['counts']['H'] ?? 0 }}</td>
                            <td class="text-center">{{ $absentData['counts']['S'] ?? 0 }}</td>
                            <td class="text-center">{{ $absentData['counts']['I'] ?? 0 }}</td>
                            <td class="text-center">{{ $absentData['counts']['A'] ?? 0 }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('javascript')
<script>
    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
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
