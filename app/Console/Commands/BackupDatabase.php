<?php
namespace App\Console\Commands;

use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class BackupDatabase extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup'; // Nama command yang benar

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Melakukan backup database otomatis sesuai jadwal.'; // Deskripsi command

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Cek jadwal backup
        $schedule = DB::table('backup_schedules')->first();
        if (!$schedule) {
            $this->info('Tidak ada jadwal backup yang diatur.');
            return;
        }

        $shouldBackup = false;
        $now = now();
        $last = $schedule->last_backup_at ? Carbon::parse($schedule->last_backup_at) : null;

        if ($schedule->frequency === 'daily' && (!$last || $now->diffInDays($last) >= 1)) {
            $shouldBackup = true;
        } elseif ($schedule->frequency === 'weekly' && (!$last || $now->diffInWeeks($last) >= 1)) {
            $shouldBackup = true;
        } elseif ($schedule->frequency === 'monthly' && (!$last || $now->diffInMonths($last) >= 1)) {
            $shouldBackup = true;
        }

        if (!$shouldBackup) {
            $this->info('Belum waktunya backup.');
            return;
        }

        $this->info('Melakukan backup database...');

        // Proses backup database
        $backupFile = storage_path('app/backups/database_backup_' . $now->format('Ymd_His') . '.sql');

        $tables = DB::select('SHOW TABLES');
        $databaseName = env('DB_DATABASE');
        $sqlDump = "-- Database backup for: $databaseName\n\n";

        foreach ($tables as $table) {
            $tableName = $table->{'Tables_in_' . $databaseName};

            $createTable = DB::select("SHOW CREATE TABLE `$tableName`");
            $sqlDump .= "\n" . $createTable[0]->{'Create Table'} . ";\n";

            $rows = DB::table($tableName)->get();

            foreach ($rows as $row) {
                $columns = array_keys((array)$row);
                $values = array_map(function ($value) {
                    return is_null($value) ? 'NULL' : "'" . addslashes($value) . "'";
                }, (array)$row);

                $sqlDump .= "INSERT INTO `$tableName` (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $values) . ");\n";
            }
        }

        File::put($backupFile, $sqlDump);

        // Update waktu backup terakhir
        DB::table('backup_schedules')->update(['last_backup_at' => $now]);

        $this->info('Backup selesai. File: ' . $backupFile);
    }
}

