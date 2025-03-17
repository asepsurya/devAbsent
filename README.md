
<p align="center"><a href="https://absent.saktiproject.my.id" target="_blank"><img src="https://drive.usercontent.google.com/download?id=1CC7oxC75oAwwW9hUiqjKEGAraOZ5u9B-&export=view&authuser=0" width="100%" alt="Absensi SAKTI Logo"></a></p>


## Tentang Absensi Sakti

Absensi Sakti adalah website berbasis Internet Of Things (IoT) untuk management data absensi disebuah instansi yang di buat dan kembangkan oleh Sakti Project Community.

Aplikasi dan website ini dibangun untuk mengatasi permasalahan pencatatan absensi guru dan siswa di instansi yang selama ini masih dilakukan menggunakan mesin fingerprint yang reportnya secara manual/lokal yang kurang efisien.

Mesin yang digunakan untuk aplikasi ini terdapat dua jenis, menggunakan idcard dan menggunakan fingerprint. Dengan adanya sistem ini, diharapkan bisa membantu mengatasi permasalahan-permasalahan yang telah disebutkan.

## Fitur Absensi Sakti

- Dashboard Admin, Walikelas, Guru dan Siswa
- Fitur absensi RFID/Fingerprint untuk guru maupun siswa
- Fitur absensi manual(hadir, sakit, izin dan alpa) oleh admin/walikelas
- Fitur absensi kelas(hadir, sakit, izin dan alpa) oleh guru
- Management data akademik, siswa dan guru oleh admin
- Management pengguna dan setelan aplikasi
- Fitur classroom (tugas dan quiz) untuk siswa oleh guru
- Fitur kalendar akademik yang dapat disesuaikan dengan kebutuhan(libur, tambah acara, dll)
- Bisa menggunakan banyak perangkat AbsensiIoT
- Import data dari excel
- Ekport data ke excel maupun pdf

## Cara Install

***Setup Database***

Buat database baru dengan nama `saktiabsensi`

***Setup Aplikasi***

1. Clone repository
   ```bash
   git clone https://github.com/asepsurya/Aplikasi-Absensi-SAKTI.git saktiabsensi
   ```
2. Buat file .env
   ```bash
   cp .env.example .env
   ```
3. Konfigurasi database
   ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=saktiabsensi
    DB_USERNAME=root
    DB_PASSWORD=
   ```
4. Install depedencies
   ```bash
   composer install
   ```
5. Buat APP_KEY
   ```bash
   php artisan key:generate
   ```
6. Membuat tabel baru ke database dan input data awal
   ```bash
   php artisan migrate:fresh --seed
   ```
7. Membuat link storage agar diakses public
   Local
   ```bash
   php artisan storage:link
   ```
   Hosting Multi Domain
   ```bash
   ln -s /home/username/domains/domain.my.id/public_html/app/saktiabsensi/storage/app/public /home/username/domains/domain.my.id/public_html/app/saktiabsensi/storage 
   ```
9. Jalankan website
   Local
   ```bash
   php artisan serve
   ```
11. Buka di browser
   Local
   ```bash
   http://127.0.0.1:8000
   ```
   Hosting
   ```bash
   https://domain.my.id
   ```

***Login User***

1. Administrator
   user : `superAdmin.sakti@gmail.com`
   pass : `tasik2024`
2. Walikelas
   user : `walikelas@saktiproject.my.id`
   pass : `tasik2024`
3. Guru
   user : `guru@saktiproject.my.id`
   pass : `tasik2024`
4. Siswa
   user : `24257001@saktiproject.my.id`
   pass : `tasik2024`

Playlist Video Tutorial [SAKTI PROJECT](https://www.youtube.com/@saktiproject)

## Lisensi

Lisensi diberikan oleh Sakti Project Community, satu lisensi hanya untuk satu instansi dan tidak boleh diperjual belikan kembali.
Apabila melanggar lisensi akan di blokir permanen.
