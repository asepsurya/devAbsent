<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $settingData = [
            ['key'=>'site_name','value'=>'NAMA SEKOLAH'],
            ['key'=>'slogan','value'=>'Maju Bersama, SMK BISAA!!!'],
            ['key'=>'site_logo','value'=>''],
            ['key'=>'site_fav','value'=>''],
            ['key'=>'address','value'=>'lorem ipsum dolor sit amet'],
            ['key'=>'phone','value'=>'( +255 ) 99283'],
            ['key'=>'email','value'=>'superAdmin.sakti@gmail.com'],
            ['key'=>'fax','value'=>'4511 2233'],
            ['key'=>'headmaster','value'=>'KEPALA SEKOLAH'],
            ['key'=>'headmasterid','value'=>'1234567890'],
            ['key'=>'register','value'=>'true'],
            ['key'=>'start_school','value'=>'07:00'],
            ['key'=>'waktu_mapel','value'=>'45'],

       ];
       Setting::insert($settingData);
    }
}
