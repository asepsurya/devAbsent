<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Session;
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
        if(User::where('nomor', '=', $row['nis'])->exists()) {
            Session::flash('gagal',"Data tidak dapat diimpor karena ada file yang duplikat");
        }else{
            return new User([
                'nomor'=>$row['nis'],
                'nama'=>$row['nama'],
                'email'=>$row['nis'],
                'password'=>Hash::make($row['nis']),
                'role'=>'4',
                'status'=>'2',
            ]);
        }
    }
    public function headingRow(): int
    {
        return 10;
    }
}
