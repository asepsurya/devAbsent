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

<link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/css/lightbox.min.css" rel="stylesheet">
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
            <a href="{{ route('setelan.app') }}" class="d-block rounded p-2"><i class="ti ti-school"></i> Pengaturan Sekolah</a>
            <a href="{{ route('setelan.card') }}" class="d-block rounded active p-2"><i class="ti ti-cards"></i> Pengaturan Kartu</a>
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
                <input type="text" name="type" value="kartu" hidden>
                <div class="d-md-flex">
                    <div class="row flex-fill">
                        <div class="col-xl-10">


                            <div class="p-2">
                                <h5>Tanda Tangan</h5>
                            </div>
                            <div class="alert alert-info" role="alert">
                                Bagian ini digunakan untuk menentukan tanda tangan dan stample sekolah pada kartu.
                              </div>
                            <div class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill">
                                    <div class="col-xxl-8 col-lg-6">
                                        <div class="mb-3">
                                            <h6>Kota Tanda Tangan</h6>
                                            <p>Nama Kota yang digunakan untuk menandatangani dokumen</p>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">
                                        @foreach ($settings->where('key','signature_city') as $signature_city )
                                            <input type="text" class="form-control"  name="signature_city" value="{{ $signature_city->value }}">
                                        @endforeach
                                    </div>
                                </div>
                            </div>


                            <div class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill">
                                    <div class="col-xxl-8 col-lg-6">
                                        <div class="mb-3">
                                            <h6>Tanggal Tanda Tangan</h6>
                                            <p>Tanggal yang digunakan untuk menandatangani dokumen</p>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">
                                        @foreach ($settings->where('key','signature_date') as $signature_date )
                                            <input type="text" class="form-control datetimepickerCustom"  name="signature_date" value="{{ $signature_date->value }}">
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill">
                                    <div class="col-xxl-8 col-lg-6">
                                        <div class="mb-3">
                                            <h6> Tanda Tangan</h6>
                                            <p>Tanda tangan yang digunakan untuk menandatangani dokumen</p>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">

                                        @foreach ($settings->where('key','signature') as $signature )
                                        <div class="mb-3 ">
                                            <div class="d-flex justify-content-bettween">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <input type="text" name="oldimage" value="{{ $signature->value }}" hidden>
                                                        @if ($signature->value == "")
                                                            <img src="{{ asset('asset/img/card/signature_default.png') }}" alt="signature" width="90px">
                                                        @else
                                                            <img src="{{ asset('storage/' . $signature->value) }}" alt="" width="90px" class="mx-2" alt="logo">
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                            <input type="file" name="signature" class="form-control" placeholder="signature">
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill">
                                    <div class="col-xxl-8 col-lg-6">
                                        <div class="mb-3">
                                            <h6>Cap Tanda Tangan</h6>
                                            <p>Cap yang digunakan untuk men-stempel dokumen</p>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">
                                        @foreach ($settings->where('key','signature_stamp') as $signature_stamp )
                                        <div class="mb-3 ">
                                            <div class="d-flex justify-content-bettween">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <input type="text" name="oldimage" value="{{ $signature_stamp->value }}" hidden>
                                                        @if ($signature_stamp->value == "")
                                                            <img src="{{ asset('asset/img/card/signature_stamp.png') }}" alt="signature_stamp" width="90px">
                                                        @else
                                                            <img src="{{ asset('storage/' .  $signature_stamp->value) }}" alt="" width="90px" class="mx-2" alt="logo">
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                            <input type="file" name="signature_stamp" class="form-control" placeholder="signature_stamp">
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="p-2">
                                <h5>Layout kartu</h5>
                            </div>
                            <div class="alert alert-info" role="alert">
                                Bagian ini digunakan untuk menentukan desain kartu siswa maupun guru, yang dapat disesuaikan sepenuhnya sesuai kebutuhan dan preferensi pengguna.
                              </div>

                              <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab">Desain Kartu untuk Siswa</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab">Desain Kartu untuk Guru</button>
                                </li>
                            </ul>
                            <!-- Tab Content -->
                            <div class="tab-content mt-3" id="myTabContent">
                                <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                        <div class="row align-items-center flex-fill">
                                            <div class="col-xxl-8 col-lg-6">
                                                <div class="mb-3">
                                                    <h6>Background Depan (Lanscape)</h6>
                                                    <p>Background Depan yang digunakan untuk menampilkan background kartu.Rekomendasi Size <code> width: 8.56 cm; height: 5.398 cm;</code></p>
                                                </div>
                                            </div>
                                            <div class="col-xxl-4 col-lg-6 mb-2">
                                                <div class="d-flex justify-content-bettween">
                                                    <div class="card">
                                                        <div class="card-body">
                                                        @foreach ($settings->where('key','studentBG_front_default') as $fav)
                                                            <input type="text" name="bg_old" value="{{ $fav->value }}" hidden>
                                                            @if ($fav->value == "")
                                                                <a href="{{ asset('asset/img/card/bg-front-default.jpg') }}" data-lightbox="image1" data-title="Front Background">
                                                                    <img src="{{ asset('asset/img/card/bg-front-default.jpg') }}" alt="logo" width="90px">
                                                                </a>

                                                            @else
                                                            <a href="{{ asset('storage/' .  $fav->value) }}" data-lightbox="image1" data-title="Front Background">
                                                                <img src="{{ asset('storage/' . $fav->value) }}"  alt="" width="90px" class="mx-2" alt="Fav_logo">
                                                            </a>
                                                            @endif
                                                        @endforeach
                                                        <p><center><a href="/bg-back/reset?section=front" id="reset">Reset Default</a></center></p>
                                                        </div>

                                                    </div>
                                                </div>
                                                    <input type="file" class="form-control"  name="studentBG_front_default">
                                                </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                        <div class="row align-items-center flex-fill">
                                            <div class="col-xxl-8 col-lg-6">
                                                <div class="mb-3">
                                                    <h6>Background Belakang (Portait)</h6>
                                                    <p>Background Belakang yang digunakan untuk menampilkan background kartu. Rekomendasi Size <code> height: 8.56cm;
                                                        width: 5.398cm;</code></p>
                                                </div>
                                            </div>
                                            <div class="col-xxl-4 col-lg-6 mb-3">
                                                <div class="d-flex justify-content-bettween">
                                                    <div class="card">
                                                        <div class="card-body">
                                                        @foreach ($settings->where('key','studentBG_back_default') as $fav)
                                                            <input type="text" name="bg_old" value="{{ $fav->value }}" hidden>
                                                            @if ($fav->value == "")
                                                                <a href="{{ asset('asset/img/card/Back-bg-default.png') }}" data-lightbox="image2" data-title="Back Background">
                                                                    <img src="{{ asset("asset/img/card/Back-bg-default.png") }}" alt="logo" width="90px">
                                                                </a>
                                                            @else
                                                            <a href="{{ asset('storage/' . $fav->value) }}" data-lightbox="image2" data-title="Back Background">
                                                                <img src="{{ asset('storage/'. $fav->value ) }}"  alt="" width="90px" class="mx-2" alt="Fav_logo">
                                                            </a>
                                                            @endif
                                                        @endforeach
                                                        <p><a href="/bg-back/reset?section=back" id="reset">Reset Default</a></p>
                                                        </div>
                                                    </div>

                                                </div>
                                                <input type="file" class="form-control"  name="studentBG_back_default">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab2" role="tabpanel">
                                    <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                            <div class="row align-items-center flex-fill">
                                                <div class="col-xxl-8 col-lg-6">
                                                    <div class="mb-3">
                                                        <h6>Background Depan (Portait)</h6>
                                                        <p>Background Depan yang digunakan untuk menampilkan background kartu.Rekomendasi Size <code> width: 5.398 cm; height:  8.56 cm;</code></p>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-lg-6 mb-2">
                                                    <div class="d-flex justify-content-bettween">
                                                        <div class="card">
                                                            <div class="card-body">
                                                            @foreach ($settings->where('key','gtkBG_front_default') as $fav)
                                                                <input type="text" name="bg_old" value="{{ $fav->value }}" hidden>
                                                                @if ($fav->value == "")
                                                                    <a href="{{ asset('asset/img/card/Back-front-gtk-default.png') }}" data-lightbox="image1" data-title="Front Background">
                                                                        <img src="{{ asset('asset/img/card/Back-front-gtk-default.png') }}" alt="front" width="90px">
                                                                    </a>

                                                                @else
                                                                <a href="{{ asset('storage/' .  $fav->value) }}" data-lightbox="image1" data-title="Front Background">
                                                                    <img src="{{ asset('storage/' . $fav->value) }}"  alt="" width="90px" class="mx-2" alt="Fav_logo">
                                                                </a>
                                                                @endif
                                                            @endforeach
                                                            <p><center><a href="/bg-back/reset?section=front&auth=gtk" id="reset">Reset Default</a></center></p>
                                                            </div>

                                                        </div>
                                                    </div>
                                                        <input type="file" class="form-control"  name="gtkBG_front_default">
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                            <div class="row align-items-center flex-fill">
                                                <div class="col-xxl-8 col-lg-6">
                                                    <div class="mb-3">
                                                        <h6>Background Belakang (Portait)</h6>
                                                        <p>Background Belakang yang digunakan untuk menampilkan background kartu. Rekomendasi Size <code> width: 5.398 cm; height:  8.56 cm;</code></p>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-4 col-lg-6 mb-3">
                                                    <div class="d-flex justify-content-bettween">
                                                        <div class="card">
                                                            <div class="card-body">
                                                            @foreach ($settings->where('key','gtkBG_back_default') as $fav)
                                                                <input type="text" name="bg_old" value="{{ $fav->value }}" hidden>
                                                                @if ($fav->value == "")
                                                                    <a href="{{ asset('asset/img/card/Back-back-gtk-default.png') }}" data-lightbox="image2" data-title="Back Background">
                                                                        <img src="{{ asset("asset/img/card/Back-back-gtk-default.png") }}" alt="logo" width="90px">
                                                                    </a>
                                                                @else
                                                                <a href="{{ asset('storage/' . $fav->value) }}" data-lightbox="image2" data-title="Back Background">
                                                                    <img src="{{ asset('storage/' . $fav->value ) }}"  alt="" width="90px" class="mx-2" alt="Fav_logo">
                                                                </a>
                                                                @endif
                                                            @endforeach
                                                            <p><a href="/bg-back/reset?section=back&auth=gtk" id="reset">Reset Default</a></p>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <input type="file" class="form-control"  name="gtkBG_back_default">

                                                </div>
                                            </div>
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
@section('javascript')
<script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/js/lightbox.min.js"></script>
@endsection

@endsection
