<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AbsensiSAKTI | Export Peserta Didik</title>
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
<body class="p-2">

    <!-- Header -->
    <div class="kop-surat">
        <div class="logo">
            <img src="{{ app('settings')['site_logo'] === '' ? asset('asset/img/default-logo.png') : app('settings')['site_logo']  }}" alt="Logo">
        </div>
        <div class="text">
            <h2>LAPORAN DATA PESERTA DIDIK TAHUN AJARAN {{ strtoupper($tahunAjaran) }}
            </h2>
            <h1><b>{{ app('settings')['site_name'] }}</b></h1>
            <h2>{{ app('settings')['address'] }}</h2>
            <p>Telepon: {{ app('settings')['phone'] }} | Email: {{ app('settings')['email'] }}</p>
        </div>
    </div>

    <div class=" ">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">NIS</th>
                        <th scope="col">Nama Peserta Didik</th>
                        <th scope="col">JK</th>
                        <th scope="col">Tempat Lahir</th>
                        <th scope="col" width="12%">Tanggal Lahir</th>
                        <th scope="col">Rombongan Belajar</th>
                        <th scope="col">Status</th>
                        <th scope="col">Tanggal Masuk</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $item)
                    <tr>
                        <td class="status-cell">{{ $loop->iteration }}</td> <!-- Rata tengah untuk nomor urut -->
                        <td>{{ $item->nis }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>
                            {{ $item->gender }}
                            {{-- {{ $item->gender == 'L' ? 'Laki - Laki' : 'Perempuan' }} --}}
                        </td>
                        <td>{{ $item->tempat_lahir }}</td>
                        <td class="status-cell">
                            {{ Carbon\Carbon::parse($item->tanggal_lahir)->format('d M Y') }}
                        </td>
                        <td>
                            @if ($item->rombelstudent)
                                {{ $item->rombelstudent->getkelas->nama_kelas }} - {{ $item->rombelstudent->getkelas->jurusanKelas->nama_jurusan }} {{ $item->rombelstudent->getkelas->sub_kelas }}
                            @else
                                -
                            @endif

                        </td>
                        <td class="status-cell">
                            {{ $item->status == 1 ? 'Aktif' : 'Tidak Aktif' }}
                        </td>
                        <td class="status-cell">
                            {{ $item->tanggal_masuk }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @if(!request('kelas'))
        <script>
            window.onload = function () {
                // Tunggu sampai iframe benar-benar siap
                const printContent = document.body;
    
                if (printContent) {
                    // Tambahkan delay kecil untuk memastikan konten sudah ter-load
                    setTimeout(function () {
                        window.print();
                    }, 500); // Delay 0.5 detik
                }
    
                // Tutup tab setelah beberapa detik (agar pengguna bisa melihat preview sebentar)
                setTimeout(function () {
                    window.close();
                }, 2000); // 2 detik (atur sesuai kebutuhan)
            };
        </script>
    @endif
   
</body>
</html>
