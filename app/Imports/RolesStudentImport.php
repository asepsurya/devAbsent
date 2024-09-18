<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;

class RolesStudentImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $cekid = User::where('nis', '=', $row[0]);
        foreach($cekid as $key){
            $a = DB::table('model_has_roles')->insert([
                'role_id' => '3',
                'model_type'=>'App\Models\User',
                'model_id'=>$key->id
            ]);
        }

        return new $a;
    }
}
