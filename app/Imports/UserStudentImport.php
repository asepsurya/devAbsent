<?php

namespace App\Imports;

use Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserStudentImport implements ToModel, WithHeadingRow
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
            'nis' => 'required|numeric|unique:users,nomor',
            'nama' => 'required|string',
        ]);

        // Jika validasi gagal, hentikan dan tampilkan pesan error
        if ($validator->fails()) {
            Session::flash('gagal', "Data tidak dapat diimpor karena ada file yang duplikat atau data tidak sesuai format yang diberikan ");
            return null; // Lewati penyimpanan data
        }

        // Pastikan NIS tidak kosong sebelum menyimpan
        if (empty($row['nis'])) {
            Session::flash('gagal', "Data tidak dapat diimpor karena NIS kosong.");
            return null;
        }

        // Jika validasi berhasil, simpan ke database
        return new User([
            'nomor' => $row['nis'],
            'nama' => $row['nama'],
            'email' => $row['nis'] . '@example.com', // Tambahkan format email agar valid
            'password' => Hash::make($row['nis']),
            'role' => '4',
            'status' => '2',
        ]);
    }
    public function headingRow(): int
    {
        return 10;
    }
}
