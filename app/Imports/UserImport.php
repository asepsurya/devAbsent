<?php

namespace App\Imports;

use Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Validasi input sebelum proses penyimpanan
        $validator = Validator::make($row, [
            'nik'   => 'required|numeric|unique:users,nomor',
            'nama'  => 'required|string',
            'email' => 'required|email|unique:users,email',
        ]);

        // Jika validasi gagal, hentikan proses dan tampilkan pesan error
        if ($validator->fails()) {
            Session::flash('gagal', "Data tidak dapat diimpor karena ada duplikasi atau data tidak Sesuai fomat yang diberikan.");
            return null; // Lewati penyimpanan data
        }

        // Jika validasi berhasil, simpan ke database
        return new User([
            'nomor'    => $row['nik'],
            'nama'     => $row['nama'],
            'email'    => $row['email'],
            'password' => Hash::make($row['nik']), // Pastikan password terenkripsi
            'role'     => '3',
            'status'   => '2',
        ]);
    }
    public function headingRow(): int
    {
        return 6;
    }
}
