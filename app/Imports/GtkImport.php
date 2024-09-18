<?php

namespace App\Imports;

use App\Models\gtk;
use Maatwebsite\Excel\Concerns\ToModel;
use Session;
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
        if(gtk::where('nik', '=', $row['nik'])->exists()) {
            Session::flash('gagal',"Data tidak dapat diimpor karena ada NIK yang duplikat");
        }else{
        return new gtk([
            'nik'=>$row['nik'],
            'nip'=>$row['nip'],
            'nama'=>$row['nama'],
            'gender'=>$row['gender'],
            'tempat_lahir'=>$row['tempat_lahir'],
            'tanggal_lahir'=>$row['tanggal_lahir'],
            'agama'=>$row['agama'],
            'telp'=>$row['telp'],
            'status'=>'1',
            'id_jenis_gtk'=>'3',
        ]);
        }
    }
    public function headingRow(): int
    {
        return 6;
    }
}
