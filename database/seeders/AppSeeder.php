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

        $mapelData = [
            ['nama' => 'Pendidikan Agama Islam dan Budi Pekerti', 'jml_jam' => '2', 'type' => 'Umum', 'status' => '1'],
            ['nama' => 'Pendidikan Pancasila dan Kewarganegaraan', 'jml_jam' => '2', 'type' => 'Umum', 'status' => '1'],
            ['nama' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan', 'jml_jam' => '2', 'type' => 'Umum', 'status' => '1'],
            ['nama' => 'Bahasa Sunda', 'jml_jam' => '2', 'type' => 'Umum', 'status' => '1'],
            ['nama' => 'Sejarah', 'jml_jam' => '2', 'type' => 'Umum', 'status' => '1'],
            ['nama' => 'Bahasa Inggris', 'jml_jam' => '2', 'type' => 'Umum', 'status' => '1'],
            ['nama' => 'Matematika', 'jml_jam' => '2', 'type' => 'Umum', 'status' => '1'],
            ['nama' => 'Informatika', 'jml_jam' => '2', 'type' => 'Umum', 'status' => '1'],
            ['nama' => 'Project IPAS', 'jml_jam' => '2', 'type' => 'Kejuruan', 'status' => '1'],
            ['nama' => 'Dasar-Dasar Layanan Kesehatan', 'jml_jam' => '2', 'type' => 'Kejuruan', 'status' => '1'],
        ];
        
        foreach ($mapelData as $data) {
            Mapel::updateOrCreate(
                ['nama' => $data['nama']], // Kunci unik (berdasarkan nama mapel)
                $data // Data yang akan diperbarui atau dibuat
            );
        }
        

        //-----------------------------------------------------------------
        // SEEDER UNTUK TAHUN PELAJARAN
        // ----------------------------------------------------------------

        $tahunPelajaranData = [
            ['tahun_pelajaran' => '2024/2025', 'semester' => 'Ganjil', 'status' => '1'],
            ['tahun_pelajaran' => '2024/2025', 'semester' => 'Genap', 'status' => '2'],
        ];
        
        foreach ($tahunPelajaranData as $data) {
            TahunPelajaran::updateOrCreate(
                [
                    'tahun_pelajaran' => $data['tahun_pelajaran'],
                    'semester' => $data['semester']
                ], // Kunci unik
                $data // Data yang akan diperbarui atau dibuat
            );
        }

        //-----------------------------------------------------------------
        // SEEDER UNTUK JURUSAN
        // ----------------------------------------------------------------

        $jurusanData = [
            ['nama_jurusan' => 'Farmasi Klinis dan Komunitas', 'kurikulum' => 'K13', 'status' => '1'],
            ['nama_jurusan' => 'Asisten Keperawatan', 'kurikulum' => 'K13', 'status' => '1'],
            ['nama_jurusan' => 'Teknologi Farmasi', 'kurikulum' => 'Kurikulum Merdeka', 'status' => '1'],
            ['nama_jurusan' => 'Layanan Kesehatan', 'kurikulum' => 'Kurikulum Merdeka', 'status' => '1'],
        ];
        
        foreach ($jurusanData as $data) {
            Jurusan::updateOrCreate(
                ['nama_jurusan' => $data['nama_jurusan']], // Kunci unik
                $data // Data yang akan diperbarui atau dibuat
            );
        }
        

        //-----------------------------------------------------------------
        // SEEDER UNTUK JURUSAN
        // ----------------------------------------------------------------

        $kelasData = [
            ['nama_kelas' => 'X', 'id_jurusan' => '3', 'sub_kelas' => '', 'kapasitas' => '30', 'status' => '1'],
            ['nama_kelas' => 'X', 'id_jurusan' => '4', 'sub_kelas' => '', 'kapasitas' => '30', 'status' => '1'],
            ['nama_kelas' => 'XI', 'id_jurusan' => '1', 'sub_kelas' => '', 'kapasitas' => '30', 'status' => '1'],
            ['nama_kelas' => 'XI', 'id_jurusan' => '2', 'sub_kelas' => '', 'kapasitas' => '30', 'status' => '1'],
            ['nama_kelas' => 'XII', 'id_jurusan' => '1', 'sub_kelas' => '', 'kapasitas' => '30', 'status' => '1'],
            ['nama_kelas' => 'XII', 'id_jurusan' => '2', 'sub_kelas' => '', 'kapasitas' => '30', 'status' => '1'],
        ];
        
        foreach ($kelasData as $data) {
            Kelas::updateOrCreate(
                [
                    'nama_kelas' => $data['nama_kelas'],
                    'id_jurusan' => $data['id_jurusan']
                ], // Kunci unik
                $data // Data untuk diperbarui atau dibuat
            );
        }
        
        //-----------------------------------------------------------------
        // SEEDER UNTUK RFID
        // ----------------------------------------------------------------


        rfid::updateOrCreate(
            ['id_rfid' => 'RFID001'], // Kunci unik untuk pencarian
            ['status' => '2'] // Data yang akan diperbarui atau dibuat
        );
        rfid::updateOrCreate(
            ['id_rfid' => 'RFID002'], // Kunci unik untuk pencarian
            ['status' => '2'] // Data yang akan diperbarui atau dibuat
        );
        rfid::updateOrCreate(
            ['id_rfid' => 'RFID003'], // Kunci unik untuk pencarian
            ['status' => '2'] // Data yang akan diperbarui atau dibuat
        );
        rfid::updateOrCreate(
            ['id_rfid' => 'RFID004'], // Kunci unik untuk pencarian
            ['status' => '2'] // Data yang akan diperbarui atau dibuat
        );
        rfid::updateOrCreate(
            ['id_rfid' => 'RFID005'], // Kunci unik untuk pencarian
            ['status' => '2'] // Data yang akan diperbarui atau dibuat
        );
        

        //-----------------------------------------------------------------
        // SEEDER UNTUK ROLE AND PERMISSION
        // ----------------------------------------------------------------

        // CREATE PERMISSION MENU
        $permissions = [
            'Absensi RFID',
            'Absensi Kelas',
            'Management Absensi',
            'akademik',
            'gtk',
            'lisensi',
            'rfid',
            'verifikasi_pengguna',
            'Ruangan Kelas',
            'Setelan Masuk Keluar',
            'Papan Pengumuman',
            'Jadwal Pelajaran',
            'Kalender Akademik',
            'Setelan Hari Libur',
            'laporan',
            'Setelan Aplikasi',
            'action',
        ];

        // Hapus hanya permission yang ada di dalam daftar seed
        Permission::whereIn('name', $permissions)->delete();

        // Tambahkan ulang permission baru
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

       // create roles and assign existing permissions


        //FOR ROLE WALI KELAS
       $role1 = Role::firstOrCreate(['name' => 'walikelas']);
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
       $role2 = Role::firstOrCreate(['name' => 'guru']);
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
        $role3 = Role::firstOrCreate(['name' => 'siswa']);
        // give Permission
        $role3->givePermissionTo('Ruangan Kelas');

        // FOR ADMIN
        $role4 = Role::firstOrCreate(['name' => 'admin']);

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


        $role5 = Role::firstOrCreate(['name' => 'superadmin']);

        //-----------------------------------------------------------------
        // SEEDER UNTUK PESERTA DIDIK
        // ----------------------------------------------------------------
        Student::updateOrCreate(
            ['nis' => '24257001'], // Kriteria unik
            [
                'nama' => 'Sample Student 1',
                'gender' => 'L',
                'tempat_lahir' => 'Tasikmalaya',
                'tanggal_lahir' => '2003-05-07',
                'agama' => 'Islam',
                'alamat' => 'Jl. CIROYOM',
                'id_provinsi' => '32',
                'id_kota' => '3278',
                'id_kecamatan' => '3278070',
                'id_desa' => '3278070012',
                'status' => '1',
                'tanggal_masuk' => '2013-05-07',
                'id_rfid' => 'RFID001',
                'id_kelas' => '1',
                'id_tahun_ajar' => '1',
            ]
        );

        Student::updateOrCreate(
            ['nis' => '24257002'], // Kunci unik
            [
                'nama' => 'Sample Student 2',
                'gender' => 'P',
                'tempat_lahir' => 'Tasikmalaya',
                'tanggal_lahir' => '2003-05-07',
                'agama' => 'Islam',
                'alamat' => 'Jl. CIMUNCANG',
                'id_provinsi' => '32',
                'id_kota' => '3278',
                'id_kecamatan' => '3278070',
                'id_desa' => '3278070012',
                'status' => '1',
                'tanggal_masuk' => '2013-05-07',
                'id_rfid' => 'RFID002',
                'id_kelas' => '2',
                'id_tahun_ajar' => '1',
            ]
        );

        //-----------------------------------------------------------------
        // SEEDER UNTUK USER PESERTA DIDIK
        // ----------------------------------------------------------------

        $user = User::updateOrCreate(
            ['nomor' => '24257001'], // Kunci unik untuk mencegah duplikasi
            [
                'nama' => 'Sample Student 1',
                'email' => '24257001@saktiproject.my.id',
                'role' => '4',
                'status' => '2',
                'email_verified_at' => now(),
                'password' => bcrypt('tasik2025'), // Pastikan password di-hash
                'remember_token' => 'KmQZvcFoiceUiz2mAm7owajYSkkeCMUOpPeknIEuroZOiZJmgFBa3l0p5YGz',
            ]
        );
        $user->assignRole($role3);

        $user = User::updateOrCreate(
            ['nomor' => '24257002'], // Kunci unik untuk mencegah duplikasi
            [
                'nama' => 'Sample Student 2',
                'email' => '24257002@saktiproject.my.id',
                'role' => '4',
                'status' => '2',
                'email_verified_at' => now(),
                'password' => bcrypt('tasik2024'), // Password harus di-hash
                'remember_token' => Str::random(60), // Generate token random
            ]
        );
        
        $user->assignRole($role3);

        //-----------------------------------------------------------------
        // SEEDER UNTUK GURU TENAGA KEPENPENDIDIKAN
        // ----------------------------------------------------------------

        gtk::updateOrCreate(
            ['nik' => '6376372635140006'], // Kunci unik untuk mencegah duplikasi
            [
                'nip' => '1',
                'nama' => 'SAMPLE WALIKELAS',
                'gender' => 'L',
                'tempat_lahir' => 'TASIKMALAYA',
                'tanggal_lahir' => '2009-09-09', // Format tanggal lebih aman dalam YYYY-MM-DD
                'agama' => 'Islam',
                'alamat' => 'CIBEUREUM',
                'telp' => '+6285123432546',
                'id_provinsi' => '32',
                'id_kota' => '3278',
                'id_kecamatan' => '3278020',
                'id_desa' => '3278020008',
                'id_jenis_gtk' => '1',
                'status' => '1',
                'tanggal_masuk' => '2019-11-11', // Format tanggal diperbaiki
                'id_rfid' => 'RFID003',
            ]
        );
        

        gtk::updateOrCreate(
            ['nik' => '6376372635140008'], // Kunci unik
            [
                'nip' => '2',
                'nama' => 'SAMPLE GURU',
                'gender' => 'L',
                'tempat_lahir' => 'TASIKMALAYA',
                'tanggal_lahir' => '2009-09-09', // Format tanggal diperbaiki
                'agama' => 'Islam',
                'alamat' => 'Jl. Mugarsari',
                'telp' => '+6285123432456',
                'id_provinsi' => '32',
                'id_kota' => '3278',
                'id_kecamatan' => '3278020',
                'id_desa' => '3278020008',
                'id_jenis_gtk' => '1',
                'status' => '1',
                'tanggal_masuk' => '2019-11-11', // Format tanggal diperbaiki
                'id_rfid' => 'RFID004',
            ]
        );
        

        gtk::updateOrCreate(
            ['nik' => '6376372635140009'], // Kunci unik untuk identifikasi data
            [
                'nip' => '3',
                'nama' => 'SAMPLE TENDIK',
                'gender' => 'L',
                'tempat_lahir' => 'TASIKMALAYA',
                'tanggal_lahir' => '2009-09-09', // Pastikan format tanggal benar (YYYY-MM-DD)
                'agama' => 'Islam',
                'alamat' => 'Jl. Depok I',
                'telp' => '+6285123432654',
                'id_provinsi' => '32',
                'id_kota' => '3278',
                'id_kecamatan' => '3278020',
                'id_desa' => '3278020008',
                'id_jenis_gtk' => '2',
                'status' => '1',
                'tanggal_masuk' => '2019-11-11', // Format tanggal diperbaiki
                'id_rfid' => 'RFID005',
            ]
        );
        

        //-----------------------------------------------------------------
        // SEEDER UNTUK USER GURU TENAGA KEPENPENDIDIKAN
        // ----------------------------------------------------------------

        User::updateOrCreate(
            ['nomor' => '6376372635140006'], // Kunci unik
            [
                'nama' => 'SAMPLE WALIKELAS',
                'email' => 'walikelas@saktiproject.my.id',
                'role' => '2',
                'status' => '2',
                'email_verified_at' => now(),
                'password' => Hash::make('tasik2025'), // Pastikan password di-hash!
                'remember_token' => Str::random(60), // Gunakan random token
            ]
        );
        
        $user->assignRole($role1);

        User::updateOrCreate(
            ['nomor' => '6376372635140008'], // Kunci unik
            [
                'nama' => 'SAMPLE GURU',
                'email' => 'guru@saktiproject.my.id',
                'role' => '3',
                'status' => '2',
                'email_verified_at' => now(),
                'password' => Hash::make('tasik2025'), // Hash password!
                'remember_token' => Str::random(60), // Gunakan token random
            ]
        );
        $user->assignRole($role2);

        User::updateOrCreate(
            ['email' => 'admin@saktiproject.my.id'], // Cek berdasarkan email
            [
                'nomor' => '20271907', 
                'nama' => 'Admin',
                'role' => '1',
                'status' => '2',
                'email_verified_at' => now(),
                'password' => Hash::make('tasik2025'), // Hash password!
                'remember_token' => Str::random(60),
            ]
        );
        
        $user->assignRole($role4);

        User::updateOrCreate(
            ['email' => 'superAdmin.sakti@gmail.com'], // Cek berdasarkan email
            [
                'nomor' => '9987762233',
                'nama' => 'Administrator',
                'role' => '5',
                'status' => '2',
                'email_verified_at' => now(),
                'password' => Hash::make('tasik2025'), // Hash password
                'remember_token' => Str::random(60),
            ]
        );
        
        $user->assignRole($role5);

        //-----------------------------------------------------------------
        // SEEDER UNTUK JENIS GTK
        // ----------------------------------------------------------------

        JenisGTK::updateOrCreate(
            ['nama' => 'Guru'], // Kunci unik berdasarkan nama
            ['nama' => 'Guru']  // Jika sudah ada, tidak akan menambahkan duplikasi
        );
        JenisGTK::updateOrCreate(
            ['nama' => 'Tenaga Kependidikan'], // Cek apakah sudah ada
            ['nama' => 'Tenaga Kependidikan']  // Jika belum, buat baru
        );

        //-----------------------------------------------------------------
        // SEEDER UNTUK REGION PROVINCE,REGENCY,DRITRICT,VILLAGE
        // ----------------------------------------------------------------
        $this->call([IndoRegionSeeder::class]);
        //-----------------------------------------------------------------
        // SEEDER UNTUK ROMBONGAN BELAJAR
        // ----------------------------------------------------------------
        rombel::updateOrCreate(
            ['nis' => '24257001'], // Cek apakah NIS sudah ada
            [
                'id_kelas' => '1',
                'id_tahun_pelajaran' => '1',
                'status' => '1',
                'id_rfid' => 'RFID001',
            ]
        );
        rombel::updateOrCreate(
            ['nis' => '24257002'], // Cek apakah sudah ada
            [
                'id_kelas' => '1',
                'id_tahun_pelajaran' => '1',
                'status' => '1',
                'id_rfid' => 'RFID002',
            ]
        );

        //-----------------------------------------------------------------
        // SEEDER UNTUK GURU MATA PELAJARAN
        // ----------------------------------------------------------------
        grupMapel::updateOrCreate(
            [
                'id_tahun_pelajaran' => '1',
                'id_kelas' => '1',
                'id_mapel' => '1',
                'semester' => 'Ganjil',
            ], // Cek apakah sudah ada
            [
                'id_gtk' => '6376372635140008',
                'status' => '2',
            ]
        );

        //-----------------------------------------------------------------
        // SEEDER UNTUK WALI KELAS
        // ----------------------------------------------------------------
        walikelas::updateOrCreate(
            [
                'id_tahun_pelajaran' => '1',
                'id_kelas' => '1',
            ], // Cek apakah sudah ada
            [
                'id_gtk' => '6376372635140006',
            ]
        );
        //-----------------------------------------------------------------
        // SEEDER SETELAN DEFAULT
        // ----------------------------------------------------------------
        $this->call([SettingSeeder::class]);
    }
        //-----------------------------------------------------------------
        // *********************** END SEEDER ***********************
        // ----------------------------------------------------------------

}
