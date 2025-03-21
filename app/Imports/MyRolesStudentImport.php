<?php

namespace App\Imports;

use App\Models\User;
use App\Models\model_has_roles;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class MyRolesStudentImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $cek = User::where('nomor',$row['nis'])->get();
        foreach($cek as $i){
            return new model_has_roles([
                'role_id'=> '3',
                'model_type'=>'App\Models\User',
                'model_id'=>$i->id
            ]);
        }
    }
    public function headingRow(): int
    {
        return 10;
    }
}
