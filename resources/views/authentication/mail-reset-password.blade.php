<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="image/x-icon" href="{{ app('settings')['site_logo'] == '' ? asset('asset/img/default-logo.png') : asset('storage/' . app('settings')['site_logo'])}}">
    <title>Reset Password</title>
    <style>
        .email-container {
            max-width: 480px;
            margin: 0 auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            text-align: center;
            font-family: Arial, sans-serif;
        }
        .logo {
            width: 100px;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 24px;
            background-color: #4CAF50;
            color: #fff !important;
            text-decoration: none;
            border-radius: 6px;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body style="background-color: #f5f5f5; padding: 20px;">

    <div class="email-container">
        <img src="https://dev.scrollwebid.com/asset/img/logo.png" alt="Logo" class="logo">

        <h2>Reset Password</h2>
        <p>Halo, kami menerima permintaan untuk mereset password akun kamu.</p>

        <a href="{{ url('/reset-password/' . $token) }}" class="btn">Reset Password Sekarang</a>

        <p style="margin-top: 20px; color: #555;">
            Jika kamu tidak merasa melakukan permintaan ini, abaikan saja email ini.
        </p>

        <div class="footer">
            &copy; {{ date('Y') }} Absensi Sakti. All rights reserved.
        </div>
    </div>

</body>
</html>
