<?php

namespace App\Imports;

use App\Models\student;
use App\Models\User;
use Session;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(student::where('nis', '=', $row[0])->exists()) {
            Session::flash('gagal',"Data tidak dapat diimpor karena ada NIS yang duplikat");
        }else{
            return new student([
                'nis'=>$row[0],
                'nama'=>$row[1],
                'gender'=>$row[2],
                'tempat_lahir'=>$row[3],
                'tanggal_lahir'=>$row[4],
                'agama'=>$row[5],
                'status'=>$row[6],
            ]);
        }

    }
}
