<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Pelajar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-container {
            width: 8.56cm;
            height: 5.398cm;
            background: url('background-image.jpg') no-repeat center center;
            background-size: cover;
            border-radius: 10px;
            padding: 10px;

        }
        .header {
            text-align: center;
            font-weight: bold;
            font-size: 10px;
            margin-bottom: 7px;
        }
        .photo {
            background: url('https://cdn0-production-images-kly.akamaized.net/IngvimdI_xv6ePAuBzJ7GjHWUIM=/1200x1200/smart/filters:quality(75):strip_icc():format(webp)/kly-media-production/medias/3914908/original/017294300_1643170592-OPPO_Indonesia__69_.jpg') no-repeat center center;
            background-size: cover;
            width: 60px;
            height: 75px;
            border: 1px solid #000;
            margin-top: -10px;
        }
        .content {
            font-size: 10px;
            line-height: 1.2;
        }
        .footer {
            text-align: right;
            font-size: 10px;
            margin-top: 14px;
            position: relative;

        }
        .signature {
            width: 80px;
            height: 30px;
            display: block;
            margin-left: auto;
            margin-top: -20px;
            margin-bottom: -20px;
        }
        .stamp {
            width: 60px;
            height: 60px;
            position: absolute;
            left: auto;
            right: 40px;
            bottom: -5px;
        }
        .content p {
            margin-top: -12px; /* Mengurangi jarak sebelum teks kepala sekolah */
        }
        .footer p {
            margin-top: -19px; /* Mengurangi jarak sebelum teks kepala sekolah */
        }
    </style>
</head>
<body>
    <div class="card-container border shadow p-2">
        <div class="d-flex">
            <div class="me-3">
                <img src="{{ asset('asset/img/default-logo.png') }}" alt="Stempel" width="50px" style="margin-top: -5px;">
            </div>
            <div class="header">
                <p>PEMERINTAH KOTA TASIKMALAYA<br>
                <strong>SMK NEGERI 4 JEMBER</strong><br>
                Jln. Kartini No. 1 Telp. 0331-487488 Jember</p>
            </div>

        </div>

        <div class="d-flex">
            <div class="photo me-2"></div>
            <div class="content">
                <p><strong>Nama &nbsp;&nbsp;&nbsp;:</strong> CINTYA CHAMERON Z.</p>
                <p><strong>NIS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong> 123456789</p>
                <p><strong>TTL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong> Kota, 29 Februari 2050</p>
                <p><strong>Alamat&nbsp;&nbsp;:</strong> Jl. Dharmawangsa B.60 Jember Jawa Timur</p>
            </div>
        </div>
        <div class="footer">

                <p>Jember, 21 Maret 2050<p>
                <img src="{{ asset('asset/img/card/signature_default.png') }}" alt="Tanda Tangan" class="signature">
                <p> Kepala Sekolah</p>
                <p><b>NIP : 123312312312</b></p>
               <img src="{{ asset('asset/img/card/signature_stamp.png') }}" alt="Stempel" class="stamp">

        </div>
    </div>
</body>
</html>
