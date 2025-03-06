<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Pelajar {{ $nama }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-container {
            width: 8.56cm;
            height: 5.398cm;
            background: url('{{ asset("asset/img/card/bg-front-default.jpg") }}') no-repeat center center;
            background-size: cover;
            border-radius: 10px;
            padding: 10px;

        }

        .card-container-back {
            height: 8.56cm;
            width: 5.398cm;
            background: url('{{ app("settings")["studentBG_back_default"] == "" ? asset("asset/img/card/Back-bg-default.png") : "/storage/" .app("settings")["studentBG_back_default"] }}') no-repeat center center;
            background-size: cover;
            border-radius: 10px;
            padding: 10px;

        }

        .header {
            text-align: center;
            font-size: 8px;
            margin-bottom: 10px;
        }

        .photo {  
            width: 60px;
            height: 70px;
            margin-top: -15px;
        }

        .content {
            width: 80%;
            font-size: 7.7px;
            line-height: 1.2;

        }

        .content2 {
            width: 30%;
            font-size: 7.5px;
            line-height: 1.2;

        }

        .footer {
            text-align: right;
            font-size: 8px;

            margin-right: 10px;
            position: relative;

        }

        .berlaku {
            width: 100px;
            height: 30px;
            display: block;
            margin-left: -10;
            font-size: 7px;
            color: white;
            margin-top: -30px;
            margin-bottom: -20px;
        }

        .signature {
            width: 80px;
            height: 30px;
            display: block;
            margin-left: auto;
            margin-top: -20px;
            margin-bottom: 15px;
        }

        .stamp {
            width: 60px;
            height: 60px;
            position: absolute;
            left: auto;
            right: 40px;
            bottom: -8px;
        }

        .content p {
            margin-top: -12px;
            /* Mengurangi jarak sebelum teks kepala sekolah */
        }

        .content2 p {
            margin-top: -12px;
            /* Mengurangi jarak sebelum teks kepala sekolah */
        }

        .footer p {
            margin-top: -19px;
            /* Mengurangi jarak sebelum teks kepala sekolah */
        }

        .header p {
            margin-top: -5px;
            /* Mengurangi jarak sebelum teks kepala sekolah */
        }

        .alamat {
            line-height: 1.2;
        }

        .alamat p {
            margin-top: -16px;
            /* Mengurangi jarak sebelum teks kepala sekolah */

        }
        @media print {
            @page {
                size: 18cm 10cm; /* Set custom size in inches */
                margin: 10px; /* Set margins */
            }
        }
    </style>
</head>
<body>
    <div class="d-flex">
        {{-- front --}}
        <div class="card-container border shadow p-2 me-2">
            <div class="d-flex justify-content-between">
                <div class="me-2">
                    <img src="{{ app('settings')['site_logo'] == '' ? asset('asset/img/default-logo.png') : '/storage/'.app('settings')['site_logo']  }}" alt="logo" width="40px" style="margin-top: -5px;">
                </div>
                <div class="header">
                    <p>{{ app('settings')['nama_yayasan'] }}<br>
                        <strong style="font-size: 9px">{{ app('settings')['site_name'] }}</strong><br>
                        <div class="alamat">
                            <p style="font-size: 7px;">{{ app('settings')['address'] }}</p>
                            <p style="font-size: 7px;">Email : <span class="text-primary">{{ app('settings')['email'] }}</span> Telp : {{ app('settings')['phone'] }}</p>
                        </div>

                </div>
                <div class="ms-2">
                    <img src="{{ asset('asset/img/card/Logo_OSIS.svg.png') }}" alt="Stempel" width="35px" style="margin-top: -5px;">
                </div>
            </div>

            <div class="d-flex">
                @foreach ($data as $item )
                <div class="d-flex justify-content-bettween px-2">
                    
                    <div class="content me-3">
                        <p><strong>Nama Siswa &nbsp;&nbsp;&nbsp;:</strong> {{ strtoupper($item->nama) }}</p>
                        <p><strong>Nomor Induk&nbsp;:</strong> {{ $item->nis }}</p>
                        <p><strong>TTL <span class="ms-3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</span></strong> {{ $item->tempat_lahir }},{{ \Carbon\Carbon::parse($item->tanggal_lahir)->locale('id')->format('d F Y') }}</p>                        
                        <p><strong>Agama <span class="ms-3">&nbsp;&nbsp;&nbsp;:</span></strong> {{ $item->agama }}</p>
                        <p><strong>Alamat<span class="ms-3">&nbsp;&nbsp;&nbsp;&nbsp;:</span></strong> {{ ucwords(strtolower($item->alamat)) }} <p> Kec. {{ ucwords(strtolower($item->kecamatan->name)) }}, Kel. {{ ucwords(strtolower($item->desa->name)) }} {{ ucwords(strtolower($item->kota->name)) }}</p></p>
                    </div>
                    <div class="content2">
                        <p><strong>JK &nbsp;&nbsp;&nbsp;&nbsp;:</strong> {{ $item->gender }}</p>
                        <p><strong>Gol Darah &nbsp;&nbsp;:</strong> - </p>
                    </div>                 
                </div>
                <div class="photo me-2" style="background: url('{{ $item->foto ? asset('storage/'.$item->foto) : asset('asset/img/user-default.jpg') }}') no-repeat center center; background-size: cover;"></div>
                @endforeach
            </div>
            <div class="footer">

                <p>{{ app('settings')['signature_city'] == '' ? 'Tasikmalaya' : app('settings')['signature_city'] }}  , {{ app('settings')['signature_date'] == '' ? date("D/MM/YYYY") : app('settings')['signature_date'] }}<p>
                        <p> {{ app('settings')['signature_position'] }}</p>
                        <img src="{{ app('settings')['signature'] == '' ? asset('asset/img/card/signature_default.png') : '/storage/'.app('settings')['signature']  }}" alt="Tanda Tangan" class="signature">
                        <p><b>{{ app('settings')['headmaster'] == '' ? 'JHON DOE' : app('settings')['headmaster'] }}</b></p>
                       
                        @if(app('settings')['headmasterid'] !== '')
                            <p><b>NIP : {{ app('settings')['headmasterid'] }}</b></p>
                        @endif
                        <img src="{{ app('settings')['signature_stamp'] == '' ? asset('asset/img/card/signature_stamp.png') : '/storage/'.app('settings')['signature_stamp']  }}" alt="Stempel" class="stamp">

            </div>
            <div class="berlaku"><i> *) Berlaku selama menjadi siswa</i></div>
        </div>
        {{-- back --}}
        <div class="card-container-back border shadow p-2">
            <div class="card-body d-flex justify-content-center align-items-center pt-5" style="margin-top: -10px;">
                <img src="{{ app('settings')['site_logo'] == '' ? asset('asset/img/default-logo.png') : '/storage/'.app('settings')['site_logo']  }}" alt="Stempel" width="60px" style="margin-top: -5px;"><br>
                
            </div>
            <center>
                <b style="font-size: 15px; ">
                    {{ app('settings')['site_name'] }}
                </b>
                
                <div class="photo me-2 mt-1" style="background: url('{{ $item->foto ? asset('storage/'.$item->foto) : asset('asset/img/user-default.jpg') }}') no-repeat center center; background-size: cover; width:80px;height:100px;border-radius:10px;"></div>
                <div style="width:120px;line-height: 1.0; margin-top:3px;"  >
                    <p class="border-bottom border-dark p-1" style="font-size:12px; margin-bottom:-1px; text-transform: uppercase;">
                        {{ strtoupper($nama) }}
                    </p>
                    <p class="pt-1" style="font-size:12px; margin-bottom:-1px;">
                        {{ $nis }}
                    </p>
                </div>
                
            </center>
          
        </div>
    </div>
    <script>
        window.onload = function() {
            // Simulate saving some data (could be to localStorage, server, etc.)
            const dataToSave = "This is some important data!";
            localStorage.setItem("mySavedData", dataToSave);

            // Open the print dialog as soon as the page loads
            window.print();

            // Set a delay to allow the print dialog to open
            setTimeout(function() {
                // Attempt to close the tab after a brief delay
                window.close(); // Close the tab
            }, 3000); // Adjust the delay (in ms) if needed for your use case
        };
    </script>
</body>
</html>

