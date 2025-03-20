<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $db_host = $_POST['db_host'];
    $db_name = $_POST['db_name'];
    $db_user = $_POST['db_user'];
    $db_pass = $_POST['db_pass'];

    try {
        // Koneksi ke MySQL tanpa memilih database
        $pdo = new PDO("mysql:host=$db_host", $db_user, $db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Cek apakah database sudah ada
        $stmt = $pdo->prepare("SELECT SCHEMA_NAME FROM information_schema.schemata WHERE SCHEMA_NAME = ?");
        $stmt->execute([$db_name]);
        $dbExists = $stmt->fetch();

        if (!$dbExists) {
            // Jika database tidak ada, buat database baru
            $pdo->exec("CREATE DATABASE `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        }

        // Koneksi ke database baru
        $pdo->exec("USE `$db_name`");

        // Buat tabel cache jika belum ada
        $pdo->exec("CREATE TABLE IF NOT EXISTS `cache` (
            `key` VARCHAR(255) NOT NULL PRIMARY KEY,
            `value` MEDIUMTEXT NOT NULL,
            `expiration` VARCHAR(45) NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

        // Buat tabel users jika belum ada
        $pdo->exec("CREATE TABLE IF NOT EXISTS `users` (
            `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `nomor` VARCHAR(255) NOT NULL,
            `nama` VARCHAR(255) NOT NULL,
            `email` VARCHAR(255) NOT NULL UNIQUE,
            `email_verified_at` TIMESTAMP NULL,
            `password` VARCHAR(255) NOT NULL,
            `role` ENUM('admin', 'walikelas', 'guru', 'siswa', 'superadmin') NOT NULL,
            `status` VARCHAR(255) NOT NULL,
            `remember_token` VARCHAR(100) NULL,
            `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

        // Buat tabel sessions jika belum ada
        $pdo->exec("CREATE TABLE IF NOT EXISTS `sessions` (
            `id` VARCHAR(255) NOT NULL PRIMARY KEY,
            `user_id` BIGINT UNSIGNED NULL,
            `ip_address` VARCHAR(45) NULL,
            `user_agent` TEXT NULL,
            `payload` LONGTEXT NOT NULL,
            `last_activity` INT NOT NULL,
            INDEX (`user_id`),
            INDEX (`last_activity`),
            CONSTRAINT `sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

        // Buat tabel password_reset_tokens jika belum ada
        $pdo->exec("CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
            `email` VARCHAR(255) NOT NULL PRIMARY KEY,
            `token` VARCHAR(255) NOT NULL,
            `created_at` TIMESTAMP NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

        // Path ke file .env
        $envPath = __DIR__ . '/../.env';

        // Baca isi file .env
        $envContent = file_get_contents($envPath);

        // Update atau tambahkan nilai
        $envContent = preg_replace("/^DB_HOST=.*/m", "DB_HOST={$db_host}", $envContent);
        $envContent = preg_replace("/^DB_DATABASE=.*/m", "DB_DATABASE={$db_name}", $envContent);
        $envContent = preg_replace("/^DB_USERNAME=.*/m", "DB_USERNAME={$db_user}", $envContent);
        $envContent = preg_replace("/^DB_PASSWORD=.*/m", "DB_PASSWORD={$db_pass}", $envContent);

        // Simpan perubahan
        file_put_contents($envPath, $envContent);


        // Redirect ke halaman utama
        header('Location: /migration');
        exit;
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Database</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
    <style>
        .bg-light-gradient {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef, #dee2e6);
        }
        .spinner {
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top: 3px solid white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        /* HTML: <div class="loader"></div> */
       /* HTML: <div class="loader"></div> */
        /* HTML: <div class="loader"></div> */
/* Container to center the spinner */
.spinner-container {
    display: flex;
    justify-content: center; /* Center horizontally */
    align-items: center;     /* Center vertically */
    height: 100vh;           /* Full viewport height */
}

/* The loader itself */
.loader {
    width: 30px;               /* Size of the spinner */
    aspect-ratio: 1;           /* Make it a perfect circle */
    border-radius: 50%;        /* Circular shape */
    border: 8px solid #fff;    /* White border color */
    animation:
        l20-1 0.8s infinite linear alternate,
        l20-2 1.6s infinite linear;
}

/* Animation for the spinner (shaping the clip-path) */
@keyframes l20-1 {
    0%    {clip-path: polygon(50% 50%,0       0,  50%   0%,  50%    0%, 50%    0%, 50%    0%, 50%    0% )}
    12.5% {clip-path: polygon(50% 50%,0       0,  50%   0%,  100%   0%, 100%   0%, 100%   0%, 100%   0% )}
    25%   {clip-path: polygon(50% 50%,0       0,  50%   0%,  100%   0%, 100% 100%, 100% 100%, 100% 100% )}
    50%   {clip-path: polygon(50% 50%,0       0,  50%   0%,  100%   0%, 100% 100%, 50%  100%, 0%   100% )}
    62.5% {clip-path: polygon(50% 50%,100%    0, 100%   0%,  100%   0%, 100% 100%, 50%  100%, 0%   100% )}
    75%   {clip-path: polygon(50% 50%,100% 100%, 100% 100%,  100% 100%, 100% 100%, 50%  100%, 0%   100% )}
    100%  {clip-path: polygon(50% 50%,50%  100%,  50% 100%,   50% 100%,  50% 100%, 50%  100%, 0%   100% )}
}

/* Animation for rotating and scaling the spinner */
@keyframes l20-2{ 
  0%    {transform:scaleY(1)  rotate(0deg)}
  49.99%{transform:scaleY(1)  rotate(135deg)}
  50%   {transform:scaleY(-1) rotate(0deg)}
  100%  {transform:scaleY(-1) rotate(-135deg)}
}

    </style>
</head>
<body class=" flex items-center justify-center min-h-screen bg-light-gradient" >
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
        <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Pengaturan Database</h2>
        <form action="" method="post" class="space-y-4" id="myForm">
            <div>
                <label class="block text-sm font-medium text-gray-600">Host Database</label>
                <input type="text" name="db_host" placeholder="127.0.0.1"
                    class="w-full mt-1 p-3 border rounded-lg focus:ring focus:ring-blue-300 outline-none" value="127.0.0.1">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600">Nama Database</label>
                <input type="text" name="db_name" placeholder="absensi_sakti"
                    class="w-full mt-1 p-3 border rounded-lg focus:ring focus:ring-blue-300 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600">Username</label>
                <input type="text" name="db_user" placeholder="root"
                    class="w-full mt-1 p-3 border rounded-lg focus:ring focus:ring-blue-300 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600">Password</label>
                <input type="password" name="db_pass" placeholder="********"
                    class="w-full mt-1 p-3 border rounded-lg focus:ring focus:ring-blue-300 outline-none">
            </div>
            <button type="submit" id="submitButton" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                <span id="buttonText"><i class="ti ti-users"></i> Simpan & Mulai Aplikasi</span>
                <center>
                    <div id="loadingSpinner" class="hidden loader"></div>
                </center>
            
            </button>
        </form>
    </div>

  
  
</body>
</html>
