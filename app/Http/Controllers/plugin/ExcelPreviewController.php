<?php

namespace App\Http\Controllers\plugin;

use App\Models\question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ExcelPreviewController extends Controller
{
    public function previewExcel( Request $request)
    {
            // Validasi file
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        // Ambil file yang diupload
        $file = $request->file('excel_file');

        // Baca data dari file Excel
        $data = Excel::toArray([], $file);

        // Ambil hanya sheet pertama
        $sheetData = $data[0];

        // Filter data dari kolom C dan baris 4 ke bawah
        $previewData = [];
        foreach ($sheetData as $rowIndex => $row) {
            if ($rowIndex >= 3) { // Baris ke-4 (index 3 karena array dimulai dari 0)
                $rowData = array_slice($row, 3); // Mulai dari kolom C (index 2)

                // Pastikan ada data yang tidak kosong
                if (array_filter($rowData)) {
                    $previewData[] = $rowData; // Hanya masukkan baris yang tidak kosong
                }
            }
        }

        $id_kelas = $request->id_kelas;
        $task_id = $request->task_id;

        // Kirim data ke tampilan untuk ditampilkan
        return view('classroom.work.quiz.partials.importPreview', ['title' => 'Preview'], compact('previewData', 'id_kelas', 'task_id'));

    }

    public function savePreviewData(Request $request)
    {
        // Decode JSON dari input hidden
        $excelData = json_decode($request->input('excel_data'), true);

        // Loop data untuk menyimpan ke database
        foreach ($excelData as $key => $row) {
            if ($key > 0) { // Abaikan header row
                question::create([
                    'task_id'    => $request->task_id, // Sesuaikan index dengan format Excel
                    'soal'       => $row[0],
                    'pilihan_a'  => $row[1],
                    'pilihan_b'  => $row[2],
                    'pilihan_c'  => $row[3],
                    'pilihan_d'  => $row[4],
                    'pilihan_e'  => $row[5],
                    'jawaban'    => $row[6],
                ]);
            }
        }
        toastr()->success('Data berhasil diimpor ke database!');
        return redirect()->route('classroom.quiz',[$request->id_kelas,$request->task_id]);
    }
}
