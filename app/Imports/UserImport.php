<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Session;
class UserImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(User::where('nomor', '=', $row[0])->exists()) {
            Session::flash('gagal',"Data tidak dapat diimpor karena ada file yang duplikat");
        }else{
            return new User([
                'nomor'=>$row[0],
                'nama'=>$row[2],
                'email'=>$row[8],
                'password'=>Hash::make($row[0]),
                'role'=>$row[10],
                'status'=>'2',
            ]);
            Session::flash('sukses',"Data Berhasil diimport");
        }

    }
}
