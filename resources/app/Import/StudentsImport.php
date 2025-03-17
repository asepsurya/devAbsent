<?php

namespace App\Imports;

use Session;
use App\Models\User;
use App\Models\student;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
       // Validasi data sebelum diproses
        $validator = Validator::make($row, [
            'nis' => 'required|numeric|unique:students,nis',
            'nama' => 'required|string',
            'gender' => 'required|in:L,P',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required',
            'agama' => 'required|string',
        ]);

        // Jika validasi gagal, hentikan dan kirim pesan error
        if ($validator->fails()) {
            Session::flash('gagal', "Data tidak dapat diimpor karena ada NIS yang duplikat atau tidak valid.");
            return null; // Lewati proses penyimpanan data
        }

        // Jika validasi lolos, simpan data ke database
        return new Student([
            'nis' => $row['nis'],
            'nama' => $row['nama'],
            'gender' => $row['gender'],
            'tempat_lahir' => $row['tempat_lahir'],
            'tanggal_lahir' => $row['tanggal_lahir'],
            'agama' => $row['agama'],
            'status' => '1',
        ]);

    }
    public function headingRow(): int
    {
        return 10;
    }
}
