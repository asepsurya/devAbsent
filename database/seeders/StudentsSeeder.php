<?php

namespace Database\Seeders;
use App\Models\student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::beginTransaction();
        // try {
           
        //     DB::commit();
        // } catch (\Throwable $th) {
        //     DB::rollback();
        // }
        student::create([
            'nis'=>'24257003',
            'nama'=> 'Sample Student',
            'gender'=>'1',
            'tempat_lahir'=>'Tasikmalaya',
            'tanggal_lahir'=>'07-05-2003',
            'agama'=>'Islam',
            'alamat'=> 'Jl. Ciroyom',
            'id_provinsi' =>'32',
            'id_kota' =>'3278',
            'id_kecamatan' =>'3278070',
            'id_desa' => '3278070012',
            'status' => '1',
            'status' => '1',
            'tanggal_masuk' => '07-05-2013',
            'id_rfid' => '',
            'id_rfid' => '',
            'id_kelas' => '',
            'id_user' => '',
            'id_rombel' => '',
        ]);
        student::create([
            'nis'=>'24257001',
            'nama'=> 'Sample Student 1',
            'gender'=>'1',
            'tempat_lahir'=>'Tasikmalaya',
            'tanggal_lahir'=>'07-05-2003',
            'agama'=>'Islam',
            'alamat'=> 'Jl. Mangkoko',
            'id_provinsi' =>'32',
            'id_kota' =>'3278',
            'id_kecamatan' =>'3278070',
            'id_desa' => '3278070012',
            'status' => '1',
            'status' => '1',
            'tanggal_masuk' => '07-05-2013',
            'id_rfid' => '',
            'id_rfid' => '',
            'id_kelas' => '',
            'id_user' => '',
            'id_rombel' => '',
        ]);
        student::create([
            'nis'=>'24257002',
            'nama'=> 'Sample Student 3',
            'gender'=>'1',
            'tempat_lahir'=>'Tasikmalaya',
            'tanggal_lahir'=>'07-05-2003',
            'agama'=>'Islam',
            'alamat'=> 'Jl. Cipapagan',
            'id_provinsi' =>'32',
            'id_kota' =>'3278',
            'id_kecamatan' =>'3278070',
            'id_desa' => '3278070012',
            'status' => '1',
            'status' => '1',
            'tanggal_masuk' => '07-05-2013',
            'id_rfid' => '',
            'id_rfid' => '',
            'id_kelas' => '',
            'id_user' => '',
            'id_rombel' => '',
        ]);
    }
}
