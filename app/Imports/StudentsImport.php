<?php

namespace App\Imports;

use App\Models\student;
use App\Models\User;
use Session;
use Maatwebsite\Excel\Concerns\ToModel;
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
        if(student::where('nis', '=', $row['nis'])->exists()) {
            Session::flash('gagal',"Data tidak dapat diimpor karena ada NIS yang duplikat");
        }else{
            return new student([
                'nis'=>$row['nis'],
                'nama'=>$row['nama'],
                'gender'=>$row['gender'],
                'tempat_lahir'=>$row['tempat_lahir'],
                'tanggal_lahir'=>$row['tanggal_lahir'],
                'agama'=>$row['agama'],
                'status'=>'1',
            ]);
        }

    }
    public function headingRow(): int
    {
        return 10;
    }
}
