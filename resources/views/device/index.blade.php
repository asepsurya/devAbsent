@extends('layout.main')
@section('css')
<style>
    .device-card {
        border: 2px solid transparent;
        cursor: pointer;
    }

    .device-card.active {
        border: 2px solid #007bff;
        box-shadow: 0 0 10px rgba(28, 134, 248, 0.5);
    }
    .hover-effect:hover {
        transform: scale(1.02);
        transition: 0.3s ease-in-out;
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }
</style>
@endsection
@section('container')
{{-- header --}}
<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1">{{ $title }}</h3>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Beranda</a>
                </li>
                <li class="breadcrumb-item " aria-current="page">Device</li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
    </div>
</div>
{{-- End Header --}}

<form action="{{ route('deviceInput') }}" method="post">
    @csrf
    <div class="row">
        <div class="d-flex justify-content-center mb-3">
            <h4>Select Device :</h4>
        </div>
        <div class="col-lg-6">
            <label class="card device-card hover-effect">
                <input type="radio" name="device" value="device1" class="device-radio" hidden>
                <div class="card-body my-2">
                    <div class="d-flex justify-content-between mb-3">
                        <h5>Windows USB RFID READER 13.56MHZ </h5>
                        @if(app('settings')['device'] == 'device1')
                            <div class="badge badge-soft-success">Default</div>
                        @endif
                    </div>
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset('asset/img/device.png') }}" alt="" width="310">
                    </div>
                </div>
            </label>
        </div>
        <div class="col-lg-6 hover-effect">
            <label class="card device-card">
                <input type="radio" name="device" value="device2" class="device-radio" hidden>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h5>RFID USB READER Model: 100000</h5>
                        @if(app('settings')['device'] == 'device2')
                            <div class="badge badge-soft-success">Default</div>
                        @endif
                    </div>
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset('asset/img/device2.png') }}" alt="" width="200">
                    </div>
                </div>
            </label>
        </div>
        <center>
            <button class="btn btn-primary">
                Simpan sebagai default
            </button>
        </center>
    </div>
</form>
@section('javascript')
<script>
     document.querySelectorAll('.device-card').forEach(card => {
        card.addEventListener('click', function () {
            document.querySelectorAll('.device-card').forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            this.querySelector('.device-radio').checked = true;
        });
    });
</script>
@endsection
@endsection
