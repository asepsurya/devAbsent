<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class BackupController extends Controller
{
    public function backupDatabase()
    {
        // Nama file SQL backup
        $backupFile = storage_path('app/backups/database_backup_' . now()->format('Ymd_His') . '.sql');

        // Ambil semua tabel database
        $tables = DB::select('SHOW TABLES');
        $databaseName = env('DB_DATABASE');
        $sqlDump = "-- Database backup for: $databaseName\n\n";

        // Loop untuk setiap tabel dan dump struktur dan data
        foreach ($tables as $table) {
            $tableName = $table->{'Tables_in_' . $databaseName};

            // Dump struktur tabel
            $createTable = DB::select("SHOW CREATE TABLE `$tableName`");
            $sqlDump .= "\n" . $createTable[0]->{'Create Table'} . ";\n";

            // Ambil data tabel
            $rows = DB::table($tableName)->get();
            foreach ($rows as $row) {
                $columns = array_keys((array)$row);
                $values = array_map(fn($value) => "'" . addslashes($value) . "'", (array)$row);
                $sqlDump .= "INSERT INTO `$tableName` (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $values) . ");\n";
            }
        }

        // Simpan ke file .sql
        File::put($backupFile, $sqlDump);

        // Menampilkan pesan sukses
        return response()->json([
            'message' => 'Backup berhasil!',
            'file' => $backupFile,
        ]);
    }

    public function getBackupHistory()
    {
        $backupPath = storage_path('app/backups');

        // Pastikan folder backups ada, kalau tidak buat
        if (!File::exists($backupPath)) {
            File::makeDirectory($backupPath, 0755, true); // true agar membuat folder secara rekursif
        }
    
        // Ambil daftar file backup
        $backupFiles = File::files($backupPath);
    
        return view('backup.history', [
            'backupFiles' => $backupFiles,
            'title' => 'Backup History'
        ]);
    }

    public function downloadBackup($filename)
    {
        // Mengunduh file backup
        return response()->download(storage_path('app/backups/' . $filename));
    }



    public function showPartialRestore()
    {
        // Ambil semua tabel di database aktif
        $tables = DB::select('SHOW TABLES');

        // Ambil nama field tabel dari hasil query
        $dbName = env('DB_DATABASE');
        $key = 'Tables_in_'.$dbName;

        $tableNames = array_map(function($item) use ($key) {
            return $item->$key;
        }, $tables);

        return view('backup.partial-restore',[
            'title'=> 'Restone Database'
        ], compact('tableNames'));
    }

    public function processPartialRestore(Request $request)
    {

      // Upload file & simpan path-nya dulu
        $file = $request->file('sql_file');
        $filePath = $file->storeAs('backups', 'restore_' . time() . '.sql');

        DB::beginTransaction();

        try {
            // Baca isi file SQL
            $sql = File::get(storage_path('app/' . $filePath));

            // Ambil query khusus tabel yang dipilih
            $queries = $this->extractTableQueries($sql, $request->input('table_name'));

            if (empty($queries)) {
                return redirect()->back()->with('error', 'Tidak ada query INSERT untuk tabel yang dipilih.');
            }

            // Ambil data yang sudah ada di tabel untuk cek ID
            $existingData = DB::table($request->input('table_name'))->pluck('id')->toArray();

            foreach ($queries as $query) {
                // Ekstrak kolom yang di-insert dan values-nya
                preg_match("/INSERT INTO `.*?` \((.*?)\) VALUES (.*)/is", $query, $matches);

                if (!isset($matches[1], $matches[2])) {
                    continue; // Skip kalau format tidak sesuai
                }

                $columns = explode(',', str_replace('`', '', $matches[1]));
                $valuesPart = $matches[2];

                // Ambil semua values
                preg_match_all("/\((.*?)\)/", $valuesPart, $valuesMatches);

                foreach ($valuesMatches[1] as $values) {
                    $valuesArray = array_map('trim', explode(',', $values));

                    // Cari posisi kolom id
                    $idIndex = array_search('id', $columns);
                    if ($idIndex === false) {
                        continue; // skip kalau tidak ada kolom id
                    }

                    $recordId = trim($valuesArray[$idIndex], "'");

                    // Cek kalau data ID belum ada
                    if (!in_array($recordId, $existingData)) {
                        // Susun query insert per row
                        $singleInsert = "INSERT INTO `".$request->input('table_name')."` (".implode(',', $columns).") VALUES (".$values.");";
                        DB::unprepared($singleInsert);

                        // Tambahkan ID ke array existing
                        $existingData[] = $recordId;
                    }
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Data berhasil direstore ke tabel ' . $request->input('table_name'));

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Restore error: '.$e->getMessage(), [
                'filePath' => $filePath ?? null,
                'exception' => $e
            ]);
            return redirect()->back()->with('error', 'Gagal merestore data: ' . $e->getMessage());
        }
    }
   // Fungsi untuk mengekstrak query berdasarkan tabel
    private function extractTableQueries($sql, $tableName)
    {
        $queries = [];
        $sqlStatements = explode(';', $sql);

        foreach ($sqlStatements as $statement) {
            // Periksa apakah query mengandung tabel yang diminta
            if (stripos($statement, "INSERT INTO `{$tableName}`") !== false) {
                $queries[] = $statement;
            }
        }

        return $queries;
    }

    public function delete($filename)
    {
        $path = storage_path('app/backups/' . $filename);

        if (File::exists($path)) {
            File::delete($path);
            return redirect()->back()->with('success', 'File backup berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }
    }

}
