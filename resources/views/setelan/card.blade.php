@extends('layout.main')
@section('container')
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
            <a href="{{ route('setelan.app') }}" class="d-block rounded  p-2">> Pengaturan Sekolah</a>
            <a href="{{ route('setelan.card') }}" class="d-block rounded active p-2">> Pengaturan Kartu</a>
            <a href="{{ route('setelan.sistem') }}" class="d-block rounded  p-2">> Pengaturan Sistem</a>
            <a href="{{ route('setelan.customize') }}" class="d-block rounded p-2">> Pengaturan Tampilan</a>
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


                            <div class="p-2">
                                <h5>Tanda Tangan</h5>
                            </div>
                            <div class="alert alert-info" role="alert">
                                Bagian ini bertujuan untuk menghubungkan postingan Instagram ke dalam aplikasi. Dengan mengintegrasikan Instagram ke aplikasi, pengguna dapat melihat, berinteraksi, atau berkongsi kandungan dari Instagram secara langsung dalam aplikasi ini.
                              </div>
                            <div class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill">
                                    <div class="col-xxl-8 col-lg-6">
                                        <div class="mb-3">
                                            <h6>Kota Tanda Tangan</h6>
                                            <p>lorem ipsum</p>
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
                                            <h6>Nama Tanda Tangan</h6>
                                            <p>lorem ipsum</p>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">
                                        @foreach ($settings->where('key','headmaster') as $headmaster )
                                            <input type="text" class="form-control"  value="{{ $headmaster->value }}" disabled>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill">
                                    <div class="col-xxl-8 col-lg-6">
                                        <div class="mb-3">
                                            <h6>NIP Tanda Tangan</h6>
                                            <p>lorem ipsum</p>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">
                                        @foreach ($settings->where('key','headmasterid') as $headmasterid )
                                            <input type="text" class="form-control"  value="{{ $headmasterid->value }}" disabled>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill">
                                    <div class="col-xxl-8 col-lg-6">
                                        <div class="mb-3">
                                            <h6>Jabatan</h6>
                                            <p>lorem ipsum</p>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">
                                        @foreach ($settings->where('key','signature_position') as $signature_position )
                                            <input type="text" class="form-control"  name="signature_position" value="{{ $signature_position->value }}">
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill">
                                    <div class="col-xxl-8 col-lg-6">
                                        <div class="mb-3">
                                            <h6>Tanggal Tanda Tangan</h6>
                                            <p>lorem ipsum</p>
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
                                            <p>lorem ipsum</p>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">

                                        @foreach ($settings->where('key','signature') as $signature )
                                        <div class="mb-3 ">
                                            <div class="d-flex justify-content-bettween">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <input type="text" name="logoOld" value="{{ $signature->value }}" hidden>
                                                        @if ($signature->value == "")
                                                            <img src="{{ asset('asset/img/card/signature_default.png') }}" alt="signature" width="90px">
                                                        @else
                                                            <img src="/storage/{{ $signature->value }}" alt="" width="90px" class="mx-2" alt="logo">
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
                                            <p>lorem ipsum</p>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">
                                        @foreach ($settings->where('key','signature_stamp') as $signature_stamp )
                                        <div class="mb-3 ">
                                            <div class="d-flex justify-content-bettween">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <input type="text" name="logoOld" value="{{ $signature_stamp->value }}" hidden>
                                                        @if ($signature_stamp->value == "")
                                                            <img src="{{ asset('asset/img/card/signature_stamp.png') }}" alt="signature_stamp" width="90px">
                                                        @else
                                                            <img src="/storage/{{ $signature_stamp->value }}" alt="" width="90px" class="mx-2" alt="logo">
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

                            <div class="p-2">
                                <h5>Layout kartu</h5>
                            </div>
                            <div class="alert alert-info" role="alert">
                                Bagian ini bertujuan untuk menghubungkan postingan Instagram ke dalam aplikasi. Dengan mengintegrasikan Instagram ke aplikasi, pengguna dapat melihat, berinteraksi, atau berkongsi kandungan dari Instagram secara langsung dalam aplikasi ini.
                              </div>
                              <div class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill">
                                    <div class="col-xxl-8 col-lg-6">
                                        <div class="mb-3">
                                            <h6>Background Depan</h6>
                                            <p>lorem ipsum</p>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">
                                        <div class="d-flex justify-content-bettween">
                                            <div class="card">
                                                <div class="card-body">
                                                    <input type="text" name="logoOld" value="" hidden="">
                                                    <img src="http://127.0.0.1:8000/asset/img/default-logo.png" alt="logo" width="90px">

                                                </div>
                                            </div>
                                        </div>
                                        @foreach ($settings->where('key','instagram_userID') as $userid )
                                            <input type="file" class="form-control"  name="userid">
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between flex-wrap border mb-3 p-3 pb-0 rounded">
                                <div class="row align-items-center flex-fill">
                                    <div class="col-xxl-8 col-lg-6">
                                        <div class="mb-3">
                                            <h6>Background Belakang</h6>
                                            <p>lorem ipsum</p>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">
                                        <div class="d-flex justify-content-bettween">
                                            <div class="card">
                                                <div class="card-body">
                                                    <input type="text" name="logoOld" value="" hidden="">
                                                    <img src="http://127.0.0.1:8000/asset/img/default-logo.png" alt="logo" width="90px">

                                                </div>
                                            </div>
                                        </div>
                                        @foreach ($settings->where('key','instagram_userID') as $userid )
                                            <input type="file" class="form-control"  name="userid">
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <a class="btn btn-outline-light bg-white " href="https://socialfeed.quadlayers.com/" target="_blank"><i class="ti ti-link" ></i> Get Access</a>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
