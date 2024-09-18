<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Session;
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
        if(User::where('nomor', '=', $row['nik'])->exists() || User::where('email', '=', $row['email'])->exists()) {
            Session::flash('gagal',"Data tidak dapat diimpor karena ada file yang duplikat");
        }else{
            return new User([
                'nomor'=>$row['nik'],
                'nama'=>$row['nama'],
                'email'=>$row['email'],
                'password'=>Hash::make($row['nik']),
                'role'=>'3',
                'status'=>'2',
            ]);
        }
    }
    public function headingRow(): int
    {
        return 6;
    }
}
