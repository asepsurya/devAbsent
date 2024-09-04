<?php

namespace App\Imports;

use App\Models\gtk;
use Maatwebsite\Excel\Concerns\ToModel;
use Session;
class GtkImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(gtk::where('nik', '=', $row[0])->exists()) {
            Session::flash('gagal',"Data tidak dapat diimpor karena ada NIK yang duplikat");
        }else{
        return new gtk([
            'nik'=>$row[0],
            'nip'=>$row[1],
            'nama'=>$row[2],
            'gender'=>$row[3],
            'tempat_lahir'=>$row[4],
            'tanggal_lahir'=>$row[5],
            'agama'=>$row[6],
            'telp'=>$row[7],
            'status'=>$row[9],
            'id_jenis_gtk'=>$row[10],
        ]);
        Session::flash('sukses',"Data Berhasil diimport");
        }

    }
}
