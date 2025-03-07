@extends('layout.main')
@section('container')
@section('css')
<style>
    .save-btn {
        position: fixed;
        bottom: 20px;
        /* Posisi dari bawah */
        right: 20px;
        /* Posisi dari kanan */
        width: 60px;
        /* Lebar tombol */
        height: 60px;
        /* Tinggi tombol */
        padding: 0;
        /* Menghapus padding untuk membuat tombol menjadi bulat sempurna */
        font-size: 24px;
        /* Ukuran font */
        display: flex;
        align-items: center;
        /* Menyelaraskan teks di tengah */
        justify-content: center;
        /* Menyelaraskan teks di tengah */
        border-radius: 50%;
        /* Membuat tombol menjadi bulat */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        /* Efek bayangan */
    }

</style>
@endsection
{{-- header --}}
<div class="d-md-flex d-block align-items-center justify-content-between mb-3 border-bottom">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1">{{ $title }}</h3>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Beranda</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">

    </div>
</div>
<div class="row">
    <div class="col-xxl-2 col-xl-3">
        <div class="pt-3 d-flex flex-column list-group mb-4">
            <a href="{{ route('setelan.app') }}" class="d-block rounded   p-2"><i class="ti ti-school"></i> Pengaturan Sekolah</a>
            <a href="{{ route('setelan.card') }}" class="d-block rounded  p-2"><i class="ti ti-cards"></i> Pengaturan Kartu</a>
            <a href="{{ route('setelan.sistem') }}" class="d-block rounded active p-2"><i class="ti ti-assembly"></i> Pengaturan Sistem</a>
            <a href="{{ route('setelan.customize') }}" class="d-block rounded p-2"><i class="ti ti-device-desktop-analytics"></i> Pengaturan Tampilan</a>
        </div>
    </div>
    <div class="col-xxl-10 col-xl-9">
        <div class="border-start ps-3">
            <form action="{{ route('setelan.appChange') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="d-flex align-items-center justify-content-between flex-wrap border-bottom pt-3 mb-3">
                    <div class="mb-3">
                        <h5 class="mb-1">Pengaturan Sekolah</h5>
                        <p>School Settings Configuration</p>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-light me-2" type="button" onclick="history.back()"><span class="ti ti-arrow-left"></span> Kembali</button>
                        <button class="btn btn-primary" type="submit" >Simpan Perubahan</button>
                    </div>
                </div>
                <input type="text" name="type" value="sistem" hidden>
                <div class="d-md-flex">
                    <div class="row flex-fill">
                        <div class="col-xl-10">
                            <div class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill">
                                    <div class="col-xxl-8 col-lg-6">
                                        <div class="mb-3">
                                            <h6>Alamat Situs ( URL )</h6>
                                            <p>Default alamat Situs ini</p>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">
                                        <div class="mb-3">
                                            <input type="text" class="form-control" placeholder="Enter Phone Number" value="{{ (isset($_SERVER['HTTPS']) ? "https://" : "http://"). $_SERVER['HTTP_HOST'] }}" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill">
                                    <div class="col-xxl-8 col-lg-6">
                                        <div class="mb-3">
                                            <h6>Register Page</h6>
                                            <p>Tampilkan Halaman Register..? Fitur ini untuk membatasi pendaftaran atau Registrasi di halaman <a href="/register" target="_BLANK" class="text-primary">Register</a></p>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">
                                        <div class="mb-3">
                                            @foreach ($settings->where('key','register') as $register )
                                            <select name="register" id="register" class="form-control select">
                                                <option value="true" {{ $register->value == 'true' ? 'selected' : '' }}>YA</option>
                                                <option value="false" {{ $register->value == 'false' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2">
                                <h5>Instagram Feed Configuration</h5>
                            </div>
                            <div class="alert alert-info" role="alert">
                                Bagian ini bertujuan untuk menghubungkan postingan Instagram ke dalam aplikasi. Dengan mengintegrasikan Instagram ke aplikasi, pengguna dapat melihat, berinteraksi, atau berkongsi kandungan dari Instagram secara langsung dalam aplikasi ini.
                              </div>
                            <div class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill"> 
                                    <div class="col-xxl-8 col-lg-6">
                                        <div class="mb-3">
                                            <h6>INSTAGRAM USER ID</h6>
                                            <p>Bagian ini bertujuan untuk menghubungkan aplikasi dengan Instagram User ID. User ID ini digunakan untuk mengenal pasti akaun Instagram pengguna secara unik. Dengan menggunakan User ID, aplikasi dapat mengakses dan memaparkan kandungan dari akaun Instagram tertentu, seperti gambar dan video, serta membolehkan pengguna berinteraksi dengan akaun mereka dalam aplikasi.</p>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">
                                        @foreach ($settings->where('key','instagram_userID') as $userid )
                                            <input type="text" class="form-control"  name="userid" value="{{ $userid->value }}">
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill">
                                    <div class="col-xxl-8 col-lg-6">
                                        <div class="mb-3">
                                            <h6>INSTAGRAM ACCESS TOKEN</h6>
                                            <p>Bagian ini bertujuan untuk menghubungkan aplikasi dengan Instagram menggunakan Instagram Access Token. Access token ini diperlukan untuk memberi aplikasi akses kepada akaun Instagram pengguna. Dengan token ini, aplikasi dapat mengambil data dari Instagram, seperti gambar, video, dan maklumat profil, serta membenarkan pengguna berinteraksi dengan kandungan Instagram mereka secara langsung dalam aplikasi.</p>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6 mb-3">
                                        @foreach ($settings->where('key','instagram_access_token') as $accessToken )
                                            <textarea name="access_token" name="access_token"  cols="30" rows="10" class="form-control">{{ $accessToken->value }}</textarea>   
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <a class="btn btn-outline-light bg-white " href="https://socialfeed.quadlayers.com/" target="_blank"><i class="ti ti-link" ></i> Get Access</a>
                            </div>
                            <button class="btn btn-primary save-btn"><i class="ti ti-device-floppy"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
