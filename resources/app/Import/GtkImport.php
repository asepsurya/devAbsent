<?php

namespace App\Imports;

use Session;
use App\Models\gtk;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GtkImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
         // Validasi data sebelum menyimpan ke database
    $validator = Validator::make($row, [
        'nik'            => 'required|numeric|unique:gtks,nik',
        'nip'            => 'nullable|numeric',
        'nama'           => 'required|string',
        'gender'         => 'required|in:L,P', // Pastikan gender hanya 'L' (Laki-laki) atau 'P' (Perempuan)
        'tempat_lahir'   => 'required|string',
        'tanggal_lahir'  => 'required|date',
        'agama'          => 'required|string',
        'telp'           => 'nullable|numeric',
    ]);

    // Jika validasi gagal, hentikan proses dan berikan pesan error
    if ($validator->fails()) {
        Session::flash('gagal', "Data tidak dapat diimpor karena ada NIK yang duplikat atau data tidak valid.");
        return null; // Lewati penyimpanan data
    }

    // Simpan data jika validasi berhasil
    return new Gtk([
        'nik'            => $row['nik'],
        'nip'            => $row['nip'] ?? null, // Jika tidak ada, isi dengan null
        'nama'           => $row['nama'],
        'gender'         => $row['gender'],
        'tempat_lahir'   => $row['tempat_lahir'],
        'tanggal_lahir'  => $row['tanggal_lahir'],
        'agama'          => $row['agama'],
        'telp'           => $row['telp'] ?? null, // Jika tidak ada, isi dengan null
        'status'         => '1',
        'id_jenis_gtk'   => '3',
    ]);
    }
    public function headingRow(): int
    {
        return 6;
    }
}
