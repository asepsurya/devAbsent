<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kartu Nama {{ $nama }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
     
        .card-container {
            height: 8.56cm;
            width: 5.398cm;
            background: url('{{ app("settings")["gtkBG_back_default"] == "" ? asset("asset/img/card/Back-back-gtk-default.png") : "/storage/" .app("settings")["gtkBG_back_default"] }}') no-repeat center center;
            background-size: cover;
            border-radius: 10px;
            padding: 10px;

        }

        .card-container-back {
            height: 8.56cm;
            width: 5.398cm;
            background: url('{{ app("settings")["gtkBG_front_default"] == "" ? asset("asset/img/card/Back-front-gtk-default.png") : "/storage/" .app("settings")["gtkBG_front_default"] }}') no-repeat center center;
            background-size: cover;
            border-radius: 10px;
            padding: 10px;

        }

        .header {
            text-align: left;
            font-size: 7px;
            margin-top: 3px;
            line-height: 1.2;
            margin-bottom: 10px;
        }

        .photo {
            width: 161px;
            height: 181px;
            margin-top: -15px;

            margin-left: -10px;
        }

        .content {
            width: 80%;
            font-size: 7.7px;
            line-height: 1.2;
            color:white;
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
            margin-top: -14px;
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
            margin-top: -4px;
            /* Mengurangi jarak sebelum teks kepala sekolah */
        }

        .alamat {
            line-height: 1.2;
        }

        .alamat p {
            margin-top: -16px;
            /* Mengurangi jarak sebelum teks kepala sekolah */

        }

    </style>
</head>
<body>
    <div class="d-flex">
        <div class="card-container-back border shadow p-2 me-2">
            <div class="d-flex justify-content-between">
                <div class="me-2">
                    <img src="{{ app('settings')['site_logo'] == '' ? asset('asset/img/default-logo.png') : '/storage/'.app('settings')['site_logo']  }}" alt="logo" width="44px" style="margin-top: -3px;">
                </div>
                <div class="header">
                    <p>{{ app('settings')['nama_yayasan'] }}<br>
                        <strong style="font-size: 9.5px">{{ app('settings')['site_name'] }}</strong><br>
                        <div class="alamat">
                            <p style="font-size: 5px;">{{ app('settings')['address'] }}</p>
                            <p style="font-size: 5px;">Email : <span class="text-primary">{{ app('settings')['email'] }}</span> Telp : {{ app('settings')['phone'] }}</p>
                        </div>

                </div>

            </div>
            @foreach ($data as $item)
            <div class="photo me-2" style="background: url('{{ $item->gambar ? asset('storage/'.$item->gambar) : asset('asset/img/user-default.jpg') }}') no-repeat center center; background-size: cover;"></div>
            <div class="content mt-4 mx-1">


                <p style="font-size:6px;color:#ffa406;">Nama Lengkap :</p>
                <p style="font-size:11px;"><b>{{ $item->nama }}</b></p>
                <p style="font-size:10px;">{{ $item->JenisGTK->nama }}</p>
                <p style="font-size:6px;color:white;margin-top:-10px !important;">{{ (isset($_SERVER['HTTPS']) ? "" : ""). $_SERVER['HTTP_HOST'] }}</p>


            </div>
            @endforeach
        </div>
        <div class="card-container border shadow p-2 me-2">
            <div class=" mx-5" style="margin-top:100px">
                <img src="{{ app('settings')['site_logo'] == '' ? asset('asset/img/default-logo.png') : '/storage/'.app('settings')['site_logo']  }}" alt="logo" width="100px">
            </div>
            <p style="font-size:7px;color:white;margin-top:60px !important;margin-right:-10px;float:right;transform: rotate(90deg);">{{ (isset($_SERVER['HTTPS']) ? "" : ""). $_SERVER['HTTP_HOST'] }}</p>
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
