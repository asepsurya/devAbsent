<?php

use Illuminate\Http\Request;
// Fungsi untuk membaca variabel dari .env
function getEnvValue($key, $default = null)
{   
     // Tentukan path file .env
     $envPath = __DIR__ . '/../.env';
    
     // Cek apakah file .env ada
     if (!file_exists($envPath)) {
         // Jika .env tidak ada, coba menyalin .env.example ke .env
         $fileSumber = __DIR__ . '/../.env.example';
         if (file_exists($fileSumber)) {
             if (copy($fileSumber, $envPath)) {
                 echo ".env file berhasil disalin dari .env.example\n";
             } else {
                 echo "Gagal menyalin .env dari .env.example\n";
             }
         } else {
             echo "File .env.example tidak ditemukan!\n";
         }
         // Setelah menyalin, coba lagi untuk membaca .env
         if (!file_exists($envPath)) {
             return $default; // Return default jika masih tidak ditemukan
         }
     }
 
     // Baca isi file .env jika ada
     $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
     foreach ($lines as $line) {
         if (strpos($line, $key . '=') === 0) {
             return trim(str_replace('"', '', substr($line, strlen($key) + 1)));
         }
     }
     return $default; // Return default jika key tidak ditemukan
}

// Cek apakah database di MySQL sesuai dengan ENV
function checkDatabase()
{
    try {
        $host = getEnvValue('DB_HOST', '127.0.0.1');
        $database = getEnvValue('DB_DATABASE', '');
        $username = getEnvValue('DB_USERNAME', 'root');
        $password = getEnvValue('DB_PASSWORD', '');

        // Cek apakah DB_DATABASE sudah diatur di .env
        if (empty($database)) {
            return false;
        }

        // Gunakan PDO untuk cek apakah database tersedia
        $pdo = new PDO("mysql:host=$host", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT SCHEMA_NAME FROM information_schema.schemata WHERE SCHEMA_NAME = ?");
        $stmt->execute([$database]);
        $dbExists = $stmt->fetch();

        return !empty($dbExists);
    } catch (PDOException $e) {
        return false;
    }
}

// Jika database tidak ada atau tidak sesuai dengan `.env`, redirect ke setup
if (!checkDatabase()) {
    header('Location: /setup-database.php');
    exit;
}

// Start Laravel jika database tersedia
define('LARAVEL_START', microtime(true));

// Include composer autoloader
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap the app
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Jalankan Laravel
$app->handleRequest(Request::capture());
