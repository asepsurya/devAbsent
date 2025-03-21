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
            <a href="{{ route('setelan.app') }}" class="d-block rounded active  p-2"><i class="ti ti-school"></i> Pengaturan Sekolah</a>
            <a href="{{ route('setelan.card') }}" class="d-block rounded  p-2"><i class="ti ti-cards"></i> Pengaturan Kartu</a>
            <a href="{{ route('setelan.sistem') }}" class="d-block rounded  p-2"><i class="ti ti-assembly"></i> Pengaturan Sistem</a>
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

                <div class="d-md-flex">
                    <div class="row flex-fill">
                        <div class="col-xl-10">
                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill">
                                    <div class="col-xxl-8 col-lg-6">
                                        <div class="mb-3">
                                            <h6>Nama Sekolah</h6>
                                            <p>Nama Sekolah atau Instansi. Data ini akan muncul sebagai <code>default</code> nama Instansi atau Sekolah.</p>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">
                                        @foreach ($settings->where('key','site_name') as $item )
                                        <div class="mb-3">
                                            <input type="text" name="site_name" value="{{ $item->value }}" class="form-control" placeholder="Enter School Name">
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill">
                                    <div class="col-xxl-8 col-lg-6">
                                        <div class="mb-3">
                                            <h6>Nama Yayasan</h6>
                                            <p>Yayasan adalah organisasi non-profit yang didirikan untuk tujuan sosial, pendidikan, kemanusiaan, keagamaan, atau kegiatan lain yang bermanfaat bagi masyarakat. </p>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">
                                        <div class="mb-3">
                                            @foreach ($settings->where('key','nama_yayasan') as $nama_yayasan)
                                                 <input type="text" class="form-control"  name="nama_yayasan" value="{{ $nama_yayasan->value }}">
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill">
                                    <div class="col-xxl-8 col-lg-6">
                                        <div class="mb-3">
                                            <h6>Nomor Telepon</h6>
                                            <p>Nomor Telpon Sekolah atau Instansi</p>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">
                                        <div class="mb-3">
                                            @foreach ($settings->where('key','phone') as $phone )
                                                <input type="text" class="form-control" placeholder="Enter Phone Number" name="phone" value="{{ $phone->value }}">
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill">
                                    <div class="col-xxl-8 col-lg-6">
                                        <div class="mb-3">
                                            <h6>Email</h6>
                                            <p>Email Instansi atau Sekolah</p>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">
                                        <div class="mb-3">
                                            @foreach ($settings->where('key','email') as $email)
                                                <input type="email" class="form-control" placeholder="Enter Email" name="email" value="{{ $email->value }}">
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill">
                                    <div class="col-xxl-8 col-lg-6">
                                        <div class="mb-3">
                                            <h6>Fax</h6>
                                            <p>Nomor Fax</p>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">
                                        <div class="mb-3">
                                            @foreach ($settings->where('key','fax') as $fax )
                                            <input type="text" class="form-control" placeholder="Enter Fax" name="fax" value="{{ $fax->value }}">
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill">
                                    <div class="col-xxl-8 col-lg-6">
                                        <div class="mb-3">
                                            <h6>Alamat Sekolah</h6>
                                            <p>Alamat Sekolah atau Instansi</p>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">
                                        <div class="mb-3">
                                            @foreach ($settings->where('key','address') as $address )
                                            <textarea rows="4" class="form-control" name="address"
                                            placeholder="Add Comment">{{ $address->value }}</textarea>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill">
                                    <div class="col-xxl-8 col-lg-6">
                                        <div class="mb-3">
                                            <h6>Nama Kepala Sekolah</h6>
                                            <p>Nama lengkap berikut gelar Kepala Sekolah atau Instansi</p>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">
                                        <div class="mb-3">
                                            @foreach ($settings->where('key','headmaster') as $headmaster )
                                            <input type="text" class="form-control" placeholder="Kepala Sekolah" name="headmaster" value="{{ $headmaster->value }}">
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill">
                                    <div class="col-xxl-8 col-lg-6">
                                        <div class="mb-3">
                                            <h6>NRKS</h6>
                                            <p>Diisi dengan Nomor Registrasi Kepala Sekolah</p>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">
                                        <div class="mb-3">
                                            @foreach ($settings->where('key','headmasterid') as $headmasterid )
                                            <input type="text" class="form-control" placeholder="Nomor Registrasi Kepala Sekolah" name="headmasterid" value="{{ $headmasterid->value ?? ''}}">
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill">
                                    <div class="col-xxl-8 col-lg-6">
                                        <div class="mb-3">
                                            <h6>Jabatan</h6>
                                            <p>Jabatan yang bertanggung jawab</p>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">
                                        @foreach ($settings->where('key','signature_position') as $signature_position )
                                            <input type="text" class="form-control"  name="signature_position" value="{{ $signature_position->value }}">
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill">
                                    <div class="col-xxl-8 col-lg-6">
                                        <div class="mb-3">
                                            <h6>Toleransi Waktu</h6>
                                            <p>Diisi dengan toleransi waktu keterlambatan absensi (menit)</p>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">
                                        <div class="mb-3">
                                            @foreach ($settings->where('key','estimasi_waktu_masuk') as $estimasi_waktu_masuk )
                                            <input type="number" class="form-control" placeholder="Toleransi waktu absensi" name="estimasi_waktu_masuk" value="{{ $estimasi_waktu_masuk->value }}">
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill">
                                    <div class="col-xxl-8 col-lg-6">
                                        <div class="mb-3">
                                            <h6>Slogan</h6>
                                            <p>Jelaskan secara singkat tentang <code>Moto</code> Sekolah atau Instansi.</p>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">
                                        <div class="mb-3">
                                            @foreach ($settings->where('key','slogan') as $slogan)
                                            <input type="text" class="form-control" placeholder="Enter School Name" name="slogan" value="{{ $slogan->value }}">

                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill">
                                    <div class="col-xxl-6 col-lg-6">
                                        <div class="mb-3">
                                            <h6>Logo Sekolah</h6>
                                            <p class="description">
                                                Logo Sekolah atau Instansi. <code>512 × 512</code> piksel.	</p>
                                                <img src="{{ asset('asset/img/pic logo.png') }}" alt="" >
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 col-lg-6">
                                        @foreach ($settings->where('key','site_logo') as $logo )
                                        <div class="mb-3 ">
                                            <div class="d-flex justify-content-bettween">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <input type="text" name="logoOld" value="{{ $logo->value }}" hidden>
                                                        @if ($logo->value == "")
                                                            <img src="{{ asset('asset/img/default-logo.png') }}" alt="logo" width="90px">
                                                        @else
                                                            <img src="{{ asset('storage/' . $logo->value) }}" alt="" width="90px" class="mx-2" alt="logo">
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                            <input type="file" name="site_logo" class="form-control" placeholder="Enter School Name">
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill">
                                    <div class="col-xxl-8 col-lg-6">
                                        <div class="mb-3">
                                            <h6>Ikon Situs</h6>
                                            <p class="description">
                                                Ikon Situs adalah yang Anda lihat di tab browser, bar bookmark, dan dalam aplikasi Absensi Sakti. Harus berbentuk persegi dan setidaknya <code>512 × 512</code> piksel.	</p>
                                            <img src="{{ asset('asset/img/browser.png') }}" alt="">

                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-bettween">
                                            <div class="card">
                                                <div class="card-body">
                                                    @foreach ($settings->where('key','site_fav') as $fav)
                                                        <input type="text" name="favOld" value="{{ $fav->value }}" hidden>
                                                        @if ($fav->value == "")
                                                            <img src="{{ asset('asset/img/default-logo.png') }}" alt="logo" width="90px">
                                                        @else
                                                            <img src="{{ asset('storage/' . $fav->value ) }}"  alt="" width="90px" class="mx-2" alt="Fav_logo">
                                                        @endif

                                                    @endforeach
                                                </div>
                                            </div>
                                            </div>
                                            <input type="file" class="form-control" name="site_fav" placeholder="Enter School Name" value="">
                                        </div>
                                    </div>
                                </div>
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
