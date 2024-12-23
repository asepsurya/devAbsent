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
            'nama' =>'Pendidikan Agama Islam dan Budi Pekerti',
            'jml_jam' =>'2',
            'type'=>'Umum',
            'status'=>'1',
        ]);
        Mapel::create([
            'nama' =>'Pendidikan Pancasila dan Kewarganegaraan',
            'jml_jam' =>'2',
            'type'=>'Umum',
            'status'=>'1',
        ]);
        Mapel::create([
            'nama' =>'Pendidikan Jasmani, Olahraga, dan Kesehatan',
            'jml_jam' =>'2',
            'type'=>'Umum',
            'status'=>'1',
        ]);
        Mapel::create([
            'nama' =>'Bahasa Sunda',
            'jml_jam' =>'2',
            'type'=>'Umum',
            'status'=>'1',
        ]);
        Mapel::create([
            'nama' =>'Sejarah',
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
            'nama' =>'Matematika',
            'jml_jam' =>'2',
            'type'=>'Umum',
            'status'=>'1',
        ]);
        Mapel::create([
            'nama' =>'Informatika',
            'jml_jam' =>'2',
            'type'=>'Umum',
            'status'=>'1',
        ]);
        Mapel::create([
            'nama' =>'Project IPAS',
            'jml_jam' =>'2',
            'type'=>'Kejuruan',
            'status'=>'1',
        ]);
        Mapel::create([
            'nama' =>'Dasar-Dasar Layanan Kesehatan',
            'jml_jam' =>'2',
            'type'=>'Kejuruan',
            'status'=>'1',
        ]);

        //-----------------------------------------------------------------
        // SEEDER UNTUK TAHUN PELAJARAN
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
            'nama_jurusan'=>'Farmasi Klinis dan Komunitas',
            'kurikulum'=>'K13',
            'status'=>'1'
        ]);
        Jurusan::create([
            'nama_jurusan'=>'Asisten Keperawatan',
            'kurikulum'=>'K13',
            'status'=>'1'
        ]);
        Jurusan::create([
            'nama_jurusan'=>'Teknologi Farmasi',
            'kurikulum'=>'Kurikulum Merdeka',
            'status'=>'1'
        ]);
        Jurusan::create([
            'nama_jurusan'=>'Layanan Kesehatan',
            'kurikulum'=>'Kurikulum Merdeka',
            'status'=>'1'
        ]);

        //-----------------------------------------------------------------
        // SEEDER UNTUK JURUSAN
        // ----------------------------------------------------------------

        Kelas::create([
            'nama_kelas'=>'X',
            'id_jurusan'=>'3',
            'sub_kelas'=>'',
            'kapasitas'=>'30',
            'status'=>'1'
        ]);
        Kelas::create([
            'nama_kelas'=>'X',
            'id_jurusan'=>'4',
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
            'id_jurusan'=>'2',
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
        Kelas::create([
            'nama_kelas'=>'XII',
            'id_jurusan'=>'2',
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
        Permission::create(['name' => 'Absensi RFID']);
        Permission::create(['name' => 'Absensi Kelas']);
        Permission::create(['name' => 'Management Absensi']);
        Permission::create(['name' => 'akademik']);
        Permission::create(['name' => 'gtk']);
        Permission::create(['name' => 'lisensi']);
        Permission::create(['name' => 'rfid']);
        Permission::create(['name' => 'verifikasi_pengguna']);
        Permission::create(['name' => 'Ruangan Kelas']);
        Permission::create(['name' => 'Setelan Masuk Keluar']);
        Permission::create(['name' => 'Papan Pengumuman']);
        Permission::create(['name' => 'Jadwal Pelajaran']);
        Permission::create(['name' => 'Kalender Akademik']);
        Permission::create(['name' => 'Setelan Hari Libur']);
        Permission::create(['name' => 'laporan']);
        Permission::create(['name' => 'Setelan Aplikasi']);
        Permission::create(['name' => 'action']);

       // create roles and assign existing permissions

        //FOR ROLE WALI KELAS
       $role1 = Role::create(['name' => 'walikelas']);
        //give Permission
       $role1->givePermissionTo('Absensi Kelas');
       $role1->givePermissionTo('akademik');
       $role1->givePermissionTo('gtk');
       $role1->givePermissionTo('verifikasi_pengguna');
       $role1->givePermissionTo('Ruangan Kelas');
       $role1->givePermissionTo('Setelan Masuk Keluar');
       $role1->givePermissionTo('Papan Pengumuman');
       $role1->givePermissionTo('Jadwal Pelajaran');
       $role1->givePermissionTo('Kalender Akademik');
       $role1->givePermissionTo('Setelan Hari Libur');
       $role1->givePermissionTo('laporan');
       $role1->givePermissionTo('action');

        // FOR GURU
       $role2 = Role::create(['name' => 'guru']);
        // give Permisson
        $role2->givePermissionTo('Absensi Kelas');
        $role2->givePermissionTo('akademik');
        $role2->givePermissionTo('gtk');
        $role2->givePermissionTo('verifikasi_pengguna');
        $role2->givePermissionTo('Ruangan Kelas');
        $role2->givePermissionTo('Papan Pengumuman');
        $role2->givePermissionTo('Jadwal Pelajaran');
        $role2->givePermissionTo('Kalender Akademik');
        $role2->givePermissionTo('action');

        // FOR SISWA
        $role3 = Role::create(['name' => 'siswa']);
        // give Permission
        $role3->givePermissionTo('Ruangan Kelas');

        // FOR ADMIN
        $role4 = Role::create(['name' => 'admin']);

        $role4->givePermissionTo('Absensi RFID');
        $role4->givePermissionTo('Management Absensi');
        $role4->givePermissionTo('akademik');
        $role4->givePermissionTo('gtk');
        $role4->givePermissionTo('lisensi');
        $role4->givePermissionTo('verifikasi_pengguna');
        $role4->givePermissionTo('Ruangan Kelas');
        $role4->givePermissionTo('Setelan Masuk Keluar');
        $role4->givePermissionTo('Papan Pengumuman');
        $role4->givePermissionTo('Jadwal Pelajaran');
        $role4->givePermissionTo('Kalender Akademik');
        $role4->givePermissionTo('Setelan Hari Libur');
        $role4->givePermissionTo('laporan');
        $role4->givePermissionTo('Setelan Aplikasi');
        $role4->givePermissionTo('action');


        $role5 = Role::create(['name' => 'superadmin']);

        //-----------------------------------------------------------------
        // SEEDER UNTUK PESERTA DIDIK
        // ----------------------------------------------------------------
        student::create([
            'nis'=>'24257001',
            'nama'=> 'Sample Student 1',
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
            'nama'=> 'Sample Student 2',
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
            'id_kelas' => '2',
            'id_tahun_ajar' => '1',
        ]);

        //-----------------------------------------------------------------
        // SEEDER UNTUK USER PESERTA DIDIK
        // ----------------------------------------------------------------

        $user = User::create([
            'nomor'=>'24257001',
            'nama'=>'Sample Student 1',
            'email'=>'24257001@saktiproject.my.id',
            'role'=>'4',
            'status'=>'2',
            'email_verified_at' => now(),
            'password' =>'tasik2024',
            'remember_token' => 'KmQZvcFoiceUiz2mAm7owajYSkkeCMUOpPeknIEuroZOiZJmgFBa3l0p5YGz',
        ]);
        $user->assignRole($role3);

        $user = User::create([
            'nomor'=>'24257002',
            'nama'=>'Sample Student 2',
            'email'=>'24257002@saktiproject.my.id',
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
            'nik'=>'6376372635140006',
            'nip'=>'1',
            'nama'=>'SAMPLE WALIKELAS',
            'gender'=>'L',
            'tempat_lahir'=>'TASIKMALAYA',
            'tanggal_lahir'=>'09-09-2009',
            'agama'=>'Islam',
            'alamat'=>'CIBEUREUM',
            'telp'=>'+6285123432546',
            'id_provinsi' => '32',
            'id_kota' => '3278',
            'id_kecamatan' => '3278020',
            'id_desa' => '3278020008',
            'id_jenis_gtk' => '1',
            'status' => '1',
            'tanggal_masuk' =>'11-11-2019',
            'id_rfid' =>'RFID003',
        ]);

        gtk::create([
            'nik'=>'6376372635140008',
            'nip'=>'2',
            'nama'=>'SAMPLE GURU',
            'gender'=>'L',
            'tempat_lahir'=>'TASIKMALAYA',
            'tanggal_lahir'=>'09-09-2009',
            'agama'=>'Islam',
            'alamat'=>'Jl. Mugarsari',
            'telp'=>'+6285123432456',
            'id_provinsi' => '32',
            'id_kota' => '3278',
            'id_kecamatan' => '3278020',
            'id_desa' => '3278020008',
            'id_jenis_gtk' => '1',
            'status' => '1',
            'tanggal_masuk' =>'11-11-2019',
            'id_rfid' =>'RFID004',
        ]);

        gtk::create([
            'nik'=>'6376372635140009',
            'nip'=>'3',
            'nama'=>'SAMPLE TENDIK',
            'gender'=>'L',
            'tempat_lahir'=>'TASIKMALAYA',
            'tanggal_lahir'=>'09-09-2009',
            'agama'=>'Islam',
            'alamat'=>'Jl. Depok I',
            'telp'=>'+6285123432654',
            'id_provinsi' => '32',
            'id_kota' => '3278',
            'id_kecamatan' => '3278020',
            'id_desa' => '3278020008',
            'id_jenis_gtk' => '2',
            'status' => '1',
            'tanggal_masuk' =>'11-11-2019',
            'id_rfid' =>'RFID005',
        ]);

        //-----------------------------------------------------------------
        // SEEDER UNTUK USER GURU TENAGA KEPENPENDIDIKAN
        // ----------------------------------------------------------------

        $user = User::create([
            'nomor'=>'6376372635140006',
            'nama'=>'SAMPLE WALIKELAS',
            'email'=>'walikelas@saktiproject.my.id',
            'role'=>'2',
            'status'=>'2',
            'email_verified_at' => now(),
            'password' =>'tasik2024',
            'remember_token' => 'KmQZvcFoiceUiz2mAm7owajYSkkeCMUOpPeknIEuroZOiZJmgFBa3l0p5YGz',
        ]);
        $user->assignRole($role1);

        $user = User::create([
            'nomor'=>'6376372635140008',
            'nama'=>'SAMPLE GURU',
            'email'=>'guru@saktiproject.my.id',
            'role'=>'3',
            'status'=>'2',
            'email_verified_at' => now(),
            'password' =>'tasik2024',
            'remember_token' => 'KmQZvcFoiceUiz2mAm7owajYSkkeCMUOpPeknIEuroZOiZJmgFBa3l0p5YGz',
        ]);
        $user->assignRole($role2);

        $user = User::create([
            'nomor'=>'20271907',
            'nama'=>'Admin',
            'email'=>'admin@saktiproject.my.id',
            'role'=>'1',
            'status'=>'2',
            'email_verified_at' => now(),
            'password' =>'tasik2024',
            'remember_token' => 'KmQZvcFoiceUiz2mAm7owajYSkkeCMUOpPeknIEuroZOiZJmgFBa3l0p5YGz',
        ]);
        $user->assignRole($role4);

        $user = User::create([
            'nomor'=>'20271907',
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
            'nama'=>'Guru'
        ]);
        JenisGTK::create([
            'nama'=>'Tenaga Kependidikan'
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
            'id_gtk'=>'6376372635140008',
            'status'=>'2',
        ]);

        //-----------------------------------------------------------------
        // SEEDER UNTUK WALI KELAS
        // ----------------------------------------------------------------
        walikelas::create([
            'id_tahun_pelajaran'=>'1',
            'id_kelas'=>'1',
            'id_gtk'=>'6376372635140006',
        ]);
        //-----------------------------------------------------------------
        // SEEDER SETELAN DEFAULT
        // ----------------------------------------------------------------
        $this->call([SettingSeeder::class]);
    }
        //-----------------------------------------------------------------
        // *********************** END SEEDER ***********************
        // ----------------------------------------------------------------

}
