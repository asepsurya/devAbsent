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
            ['key'=>'site_name','value'=>'SEKOLAH SAKTI'],
            ['key'=>'nama_yayasan','value'=>'YAYASAN BAKTI TAMAN ARAFAH'],
            ['key'=>'slogan','value'=>'Maju Bersama, SMK BISAA!!!'],
            ['key'=>'site_logo','value'=>''],
            ['key'=>'site_fav','value'=>''],
            ['key'=>'address','value'=>'Jl. Sakti No.1'],
            ['key'=>'phone','value'=>'(+255) 99283'],
            ['key'=>'email','value'=>'superAdmin.sakti@gmail.com'],
            ['key'=>'fax','value'=>'4511 2233'],
            ['key'=>'headmaster','value'=>'KEPALA SEKOLAH'],
            ['key'=>'headmasterid','value'=>'1234567890'],
            ['key'=>'register','value'=>'true'],
            ['key'=>'start_school','value'=>'07:00'],
            ['key'=>'waktu_mapel','value'=>'45'],
            ['key'=>'estimasi_waktu_masuk','value'=>'45'],
            ['key'=>'instagram_userID','value'=>'9478774795468483'],
            ['key'=>'instagram_access_token','value'=>'IGAAHKoYxeZA3JBZAFBTdTBEWXpkeVhEQS1mV096WUNxSXhWWHhqVklsUmcwSEdzQXRmZAV80UjcyZAC1xRTVGV2h2RHpNSE9iTVJRVDg1aFc3YV82SkVSVEFLYU5CaUVGWVdrWnVvb2pSMHFBcF9GZAWZAxSFhB'],
            ['key'=>'signature_city','value'=>'Tasikmalaya'],
            ['key'=>'signature_position','value'=>'Kepala Sekolah'],
            ['key'=>'signature_date','value'=>'03/06/2025'],
            ['key'=>'signature','value'=>''],
            ['key'=>'signature_stamp','value'=>''],
            ['key'=>'studentBG_front_default','value'=>''],
            ['key'=>'studentBG_back_default','value'=>''],
            ['key'=>'gtkBG_front_default','value'=>''],
            ['key'=>'gtkBG_back_default','value'=>''],





       ];
       Setting::insert($settingData);
    }
}
