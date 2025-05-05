<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class BackupDatabase extends Command
{
    protected $signature = 'backup:database';
    protected $description = 'Backup database ke file SQL';

    public function handle()
    {
        $dbName = env('DB_DATABASE');
        $user = env('DB_USERNAME');
        $pass = env('DB_PASSWORD');
        $host = env('DB_HOST');
        $fileName = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        $path = storage_path('app/backups/' . $fileName);

        if (!is_dir(storage_path('app/backups'))) {
            mkdir(storage_path('app/backups'), 0755, true);
        }

        $command = "mysqldump --user={$user} --password={$pass} --host={$host} {$dbName} > {$path}";
        exec($command, $output, $resultCode);

        if ($resultCode === 0) {
            $this->info("Backup berhasil: {$fileName}");
        } else {
            $this->error('Backup gagal dibuat.');
        }
    }
}
