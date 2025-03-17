<?php

namespace App\Imports;

use App\Models\Mapel;
use Session;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class MapelImport implements ToModel, WithHeadingRow
{

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        return new Mapel([
            'nama'=> $row['nama'],
            'kode_mapel'=> '',
            'jml_jam'=> $row['jumlah_jam'],
            'type'=> $row['type'],
            'status'=> '1'
        ]);
    }
    public function headingRow(): int
    {
        return 10;
    }
}
