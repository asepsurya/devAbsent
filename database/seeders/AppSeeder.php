<?php

namespace Database\Seeders;

use App\Models\gtk;
use App\Models\rfid;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\rombel;
use App\Models\Jurusan;
use App\Models\student;
use App\Models\JenisGTK;
use App\Models\grupMapel;
use App\Models\walikelas;
use Illuminate\Support\Str;
use App\Models\TahunPelajaran;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\IndoRegionSeeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    //-----------------------------------------------------------------
    // *********************** SEEDER START ***********************
    // ----------------------------------------------------------------
    public function run(): void
    {
        //-----------------------------------------------------------------
        // SEEDER UNTUK MATA PELAJARAN
        // ----------------------------------------------------------------

        Mapel::create([
            'nama' =>'Matematika',
            'jml_jam' =>'2',
            'type'=>'Umum',
            'status'=>'1',
        ]);
        Mapel::create([
            'nama' =>'Bahasa Inggris',
            'jml_jam' =>'2',
            'type'=>'Umum',
            'status'=>'1',
        ]);
        Mapel::create([
            'nama' =>'Bahasa Indonesia',
            'jml_jam' =>'2',
            'jml_jam' =>'2',
            'type'=>'Umum',
            'status'=>'1',
        ]);

        //-----------------------------------------------------------------
        // SEEDER UNTUK TAHUN PELAJARAN PELAJARAN
        // ----------------------------------------------------------------

        TahunPelajaran::create([
            'tahun_pelajaran'=>'2024/2025',
            'semester'=>'Ganjil',
            'status'=>'1'
        ]);
        TahunPelajaran::create([
            'tahun_pelajaran'=>'2024/2025',
            'semester'=>'Genap',
            'status'=>'2'
        ]);

        //-----------------------------------------------------------------
        // SEEDER UNTUK JURUSAN
        // ----------------------------------------------------------------

        Jurusan::create([
            'nama_jurusan'=>'REKAYASA PERANGKAT LUNAK',
            'status'=>'1'
        ]);
        Jurusan::create([
            'nama_jurusan'=>'SENI PERTUNJUKAN',
            'status'=>'1'
        ]);
        Jurusan::create([
            'nama_jurusan'=>'FARMASI KLINIS & KOMUNITAS',
            'status'=>'1'
        ]);

        //-----------------------------------------------------------------
        // SEEDER UNTUK JURUSAN
        // ----------------------------------------------------------------

        Kelas::create([
            'nama_kelas'=>'X',
            'id_jurusan'=>'1',
            'sub_kelas'=>'',
            'kapasitas'=>'30',
            'status'=>'1'
        ]);
        Kelas::create([
            'nama_kelas'=>'XI',
            'id_jurusan'=>'1',
            'sub_kelas'=>'',
            'kapasitas'=>'30',
            'status'=>'1'
        ]);
        Kelas::create([
            'nama_kelas'=>'XI',
            'id_jurusan'=>'1',
            'sub_kelas'=>'',
            'kapasitas'=>'30',
            'status'=>'1'
        ]);
        Kelas::create([
            'nama_kelas'=>'XII',
            'id_jurusan'=>'1',
            'sub_kelas'=>'',
            'kapasitas'=>'30',
            'status'=>'1'
        ]);

        //-----------------------------------------------------------------
        // SEEDER UNTUK RFID
        // ----------------------------------------------------------------

        rfid::create([
            'id_rfid'=>'RFID001',
            'status'=>'2'
        ]);
        rfid::create([
            'id_rfid'=>'RFID002',
            'status'=>'2'
        ]);
        rfid::create([
            'id_rfid'=>'RFID003',
            'status'=>'2'
        ]);
        rfid::create([
            'id_rfid'=>'RFID004',
            'status'=>'2'
        ]);
        rfid::create([
            'id_rfid'=>'RFID005',
            'status'=>'2'
        ]);

        //-----------------------------------------------------------------
        // SEEDER UNTUK ROLE AND PERMISSION
        // ----------------------------------------------------------------

        // CREATE PERMISSION MENU
        Permission::create(['name' => 'absent']);
        Permission::create(['name' => 'akademik']);
        Permission::create(['name' => 'gtk']);
        Permission::create(['name' => 'lisensi']);
        Permission::create(['name' => 'rfid']);
        Permission::create(['name' => 'verifikasi_pengguna']);
        Permission::create(['name' => 'pelajaran']);
        Permission::create(['name' => 'hari_libur']);
        Permission::create(['name' => 'laporan']);
        Permission::create(['name' => 'pengguna']);
        Permission::create(['name' => 'setelan']);
        // PERMISSION CRUD
        Permission::create(['name' => 'create']);
        Permission::create(['name' => 'delete']);
        Permission::create(['name' => 'update']);
        Permission::create(['name' => 'read']);
       // create roles and assign existing permissions

        //FOR ROLE WALI KELAS
       $role1 = Role::create(['name' => 'walikelas']);
        //give Permission
       $role1->givePermissionTo('update');
       $role1->givePermissionTo('delete');
       $role1->givePermissionTo('read');

        // FOR GURU
       $role2 = Role::create(['name' => 'guru']);
        // give Permisson
       $role2->givePermissionTo('create');
       $role2->givePermissionTo('read');
       $role2->givePermissionTo('delete');
       $role2->givePermissionTo('update');

        // FOR SISWA
       $role3 = Role::create(['name' => 'siswa']);
        // give Permission
       $role3->givePermissionTo('read');

        // FOR ADMIN
       $role4 = Role::create(['name' => 'admin']);
        // give Permisson
        $role4->givePermissionTo('create');
        $role4->givePermissionTo('read');
        $role4->givePermissionTo('delete');
        $role4->givePermissionTo('update');

        $role5 = Role::create(['name' => 'superadmin']);

        //-----------------------------------------------------------------
        // SEEDER UNTUK PESERTA DIDIK
        // ----------------------------------------------------------------
        student::create([
            'nis'=>'24257001',
            'nama'=> 'Sample Student',
            'gender'=>'L',
            'tempat_lahir'=>'Tasikmalaya',
            'tanggal_lahir'=>'07-05-2003',
            'agama'=>'Islam',
            'alamat'=> 'Jl. CIROYOM',
            'id_provinsi' =>'32',
            'id_kota' =>'3278',
            'id_kecamatan' =>'3278070',
            'id_desa' => '3278070012',
            'status' => '1',
            'tanggal_masuk' => '07-05-2013',
            'id_rfid' => 'RFID001',
            'id_kelas' => '1',
            'id_tahun_ajar' => '1',
        ]);

        student::create([
            'nis'=>'24257002',
            'nama'=> 'Sample Student 1',
            'gender'=>'P',
            'tempat_lahir'=>'Tasikmalaya',
            'tanggal_lahir'=>'07-05-2003',
            'agama'=>'Islam',
            'alamat'=> 'Jl. CIMUNCANG',
            'id_provinsi' =>'32',
            'id_kota' =>'3278',
            'id_kecamatan' =>'3278070',
            'id_desa' => '3278070012',
            'status' => '1',
            'tanggal_masuk' => '07-05-2013',
            'id_rfid' => 'RFID002',
            'id_kelas' => '1',
            'id_tahun_ajar' => '1',
        ]);

        //-----------------------------------------------------------------
        // SEEDER UNTUK USER PESERTA DIDIK
        // ----------------------------------------------------------------

        $user = User::create([
            'nomor'=>'24257001',
            'nama'=>'Sample Student',
            'email'=>'siswa.sakti@gmail.com',
            'role'=>'4',
            'status'=>'2',
            'email_verified_at' => now(),
            'password' =>'tasik2024',
            'remember_token' => 'KmQZvcFoiceUiz2mAm7owajYSkkeCMUOpPeknIEuroZOiZJmgFBa3l0p5YGz',
        ]);

        $user->assignRole($role3);

        $user = User::create([
            'nomor'=>'24257002',
            'nama'=>'Sample Student 1',
            'email'=>'siswa1.sakti@gmail.com',
            'role'=>'4',
            'status'=>'2',
            'email_verified_at' => now(),
            'password' =>'tasik2024',
            'remember_token' => 'KmQZvcFoiceUiz2mAm7owajYSkkeCMUOpPeknIEuroZOiZJmgFBa3l0p5YGz',
        ]);
        $user->assignRole($role3);

        //-----------------------------------------------------------------
        // SEEDER UNTUK GURU TENAGA KEPENPENDIDIKAN
        // ----------------------------------------------------------------

        gtk::create([
            'nik'=>'8992453671234567',
            'nip'=>'100129379',
            'nama'=>'CUCU SUTIRAH S.Pd',
            'gender'=>'P',
            'tempat_lahir'=>'TASIKMALAYA',
            'tanggal_lahir'=>'20-04-1950',
            'agama'=>'Islam',
            'alamat'=>'PERUM BUMI ASRI',
            'telp'=>'+6285331002523',
            'id_provinsi' => '32',
            'id_kota' => '3278',
            'id_kecamatan' => '3278070',
            'id_desa' => '3278070012',
            'id_jenis_gtk' => '3',
            'status' => '1',
            'tanggal_masuk' =>'08-09-2005',
            'id_rfid' =>'RFID003',

        ]);

        gtk::create([
            'nik'=>'8992453671234891',
            'nip'=>'100129380',
            'nama'=>'ABDUL MUJAHIDIN S.Kom',
            'gender'=>'L',
            'tempat_lahir'=>'TASIKMALAYA',
            'tanggal_lahir'=>'20-04-1950',
            'agama'=>'Islam',
            'alamat'=>'JL.BURUJUL No.40',
            'telp'=>'+6285331002524',
            'id_provinsi' => '32',
            'id_kota' => '3278',
            'id_kecamatan' => '3278070',
            'id_desa' => '3278070012',
            'id_jenis_gtk' => '1',
            'status' => '1',
            'tanggal_masuk' =>'08-09-2005',
            'id_rfid' =>'RFID004',

        ]);

        gtk::create([
            'nik'=>'8992453671234892',
            'nip'=>'100129381',
            'nama'=>'ADE FAUIZI S.Kom M.Kom',
            'gender'=>'L',
            'tempat_lahir'=>'TASIKMALAYA',
            'tanggal_lahir'=>'20-04-1950',
            'agama'=>'Islam',
            'alamat'=>'JL. CIBAREGBEG',
            'telp'=>'+6285331002525',
            'id_provinsi' => '32',
            'id_kota' => '3278',
            'id_kecamatan' => '3278070',
            'id_desa' => '3278070012',
            'id_jenis_gtk' => '1',
            'status' => '1',
            'tanggal_masuk' =>'08-09-2005',
            'id_rfid' =>'RFID005',

        ]);

        //-----------------------------------------------------------------
        // SEEDER UNTUK USER GURU TENAGA KEPENPENDIDIKAN
        // ----------------------------------------------------------------

        $user = User::create([
            'nomor'=>'8992453671234567',
            'nama'=>'CUCU SUTIRAH S.Pd',
            'email'=>'walikelas.sakti@gmail.com',
            'role'=>'2',
            'status'=>'2',
            'email_verified_at' => now(),
            'password' =>'tasik2024',
            'remember_token' => 'KmQZvcFoiceUiz2mAm7owajYSkkeCMUOpPeknIEuroZOiZJmgFBa3l0p5YGz',
        ]);

        $user->assignRole($role1);

        $user = User::create([
            'nomor'=>'8992453671234891',
            'nama'=>'ABDUL MUJAHIDIN S.Kom',
            'email'=>'guru.sakti@gmail.com',
            'role'=>'3',
            'status'=>'2',
            'email_verified_at' => now(),
            'password' =>'tasik2024',
            'remember_token' => 'KmQZvcFoiceUiz2mAm7owajYSkkeCMUOpPeknIEuroZOiZJmgFBa3l0p5YGz',
        ]);

        $user->assignRole($role2);

        $user = User::create([
            'nomor'=>'8992453671234892',
            'nama'=>'ADE FAUIZI S.Kom M.Kom',
            'email'=>'admin@gmail.com',
            'role'=>'1',
            'status'=>'2',
            'email_verified_at' => now(),
            'password' =>'tasik2024',
            'remember_token' => 'KmQZvcFoiceUiz2mAm7owajYSkkeCMUOpPeknIEuroZOiZJmgFBa3l0p5YGz',
        ]);
        $user->assignRole($role4);

        $user = User::create([
            'nomor'=>'99876776229',
            'nama'=>'Administrator',
            'email'=>'superAdmin.sakti@gmail.com',
            'role'=>'5',
            'status'=>'2',
            'email_verified_at' => now(),
            'password' =>'tasik2024',
            'remember_token' => 'KmQZvcFoiceUiz2mAm7owajYSkkeCMUOpPeknIEuroZOiZJmgFBa3l0p5YGz',
        ]);

        $user->assignRole($role5);

        //-----------------------------------------------------------------
        // SEEDER UNTUK JENIS GTK
        // ----------------------------------------------------------------

        JenisGTK::create([
            'nama'=>'GURU PENGAJAR'
        ]);
        JenisGTK::create([
            'nama'=>'KEPALA SEKOLAH'
        ]);
        JenisGTK::create([
            'nama'=>'WALI KELAS'
        ]);
        JenisGTK::create([
            'nama'=>'GURU BIMBINGAN KONSELING'
        ]);
        JenisGTK::create([
            'nama'=>'STAF TU'
        ]);

        //-----------------------------------------------------------------
        // SEEDER UNTUK REGION PROVINCE,REGENCY,DRITRICT,VILLAGE
        // ----------------------------------------------------------------
        $this->call([IndoRegionSeeder::class]);
        //-----------------------------------------------------------------
        // SEEDER UNTUK ROMBONGAN BELAJAR
        // ----------------------------------------------------------------
        rombel::create([
            'nis'=>'24257001',
            'id_kelas'=>'1',
            'id_tahun_pelajaran'=>'1',
            'status'=>'1',
            'id_rfid'=>'RFID001',
        ]);
        rombel::create([
            'nis'=>'24257002',
            'id_kelas'=>'1',
            'id_tahun_pelajaran'=>'1',
            'status'=>'1',
            'id_rfid'=>'RFID002',
        ]);

        //-----------------------------------------------------------------
        // SEEDER UNTUK GURU MATA PELAJARAN
        // ----------------------------------------------------------------
        grupMapel::create([
            'id_tahun_pelajaran'=>'1',
            'id_kelas'=>'1',
            'id_mapel'=>'1',
            'semester'=>'Ganjil',
            'id_gtk'=>'8992453671234567',
            'status'=>'2',
        ]);
        grupMapel::create([
            'id_tahun_pelajaran'=>'1',
            'id_kelas'=>'1',
            'id_mapel'=>'2',
            'semester'=>'Ganjil',
            'id_gtk'=>'8992453671234891',
            'status'=>'2',
        ]);
        grupMapel::create([
            'id_tahun_pelajaran'=>'1',
            'id_kelas'=>'1',
            'id_mapel'=>'3',
            'semester'=>'Ganjil',
            'id_gtk'=>'8992453671234892',
            'status'=>'2',
        ]);

        //-----------------------------------------------------------------
        // SEEDER UNTUK WALI KELAS
        // ----------------------------------------------------------------
        walikelas::create([
            'id_tahun_pelajaran'=>'1',
            'id_kelas'=>'1',
            'id_gtk'=>'8992453671234567',
        ]);
    }
        //-----------------------------------------------------------------
        // *********************** END SEEDER ***********************
        // ----------------------------------------------------------------
}
