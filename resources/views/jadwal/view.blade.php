@extends('layout.main')
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
                <li class="breadcrumb-item active" aria-current="page">Jadwal Pelajaran</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">

        <div class="pe-1 mb-2">
            <button type="button" class="btn btn-outline-light bg-white  me-1" onclick="history.back()">
                <i class="ti ti-arrow-left"></i> Kembali
            </button>
        </div>

    </div>
</div>
{{-- End Header --}}

<div class="row">
    <div class="col-xxl-3 col-xl-6 col-md-7 d-flex">
        <div class="card flex-fill">
            <div class="card-header d-flex align-items-center justify-content-between">
              <h3>Senin</h3>
            </div>
            <div class="card-body p-0 m-0">
                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <tbody>
                            @foreach ($senin as $item)
                            <tr>
                                <td class="border"><span class="ti ti-clock-hour-1"></span> {{  $item->start }} -  {{ $item->end }}</td>
                                <td><b>{{ $item->mata_pelajaran->nama }}</b></td>
                                <td>
                                    @if($item->id_gtk == '')
                                    Belum Disetel
                                    @else
                                    {{ $item->guru->nama }}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-xl-6 col-md-7 d-flex">
        <div class="card flex-fill">
            <div class="card-header d-flex align-items-center justify-content-between">
              <h3>Selasa</h3>
            </div>
            <div class="card-body p-0 m-0">
                <table class="table table-nowrap mb-0">
                    <tbody>
                        @foreach ($selasa as $item)
                        <tr>
                            <td class="border"><span class="ti ti-clock-hour-1"></span> {{  $item->start }} -  {{ $item->end }}</td>
                            <td><b>{{ $item->mata_pelajaran->nama }}</b></td>
                            <td>
                                @if($item->id_gtk == '')
                                Belum Disetel
                                @else
                                {{ $item->guru->nama }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-xl-6 col-md-7 d-flex">
        <div class="card flex-fill">
            <div class="card-header d-flex align-items-center justify-content-between">
              <h3>Rabu</h3>
            </div>
            <table class="table table-nowrap mb-0">
                <tbody>
                    @foreach ($rabu as $item)
                    <tr>
                        <td class="border"><span class="ti ti-clock-hour-1"></span> {{  $item->start }} -  {{ $item->end }}</td>
                        <td><b>{{ $item->mata_pelajaran->nama }}</b></td>
                        <td>
                            @if($item->id_gtk == '')
                            Belum Disetel
                            @else
                            {{ $item->guru->nama }}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-xxl-3 col-xl-6 col-md-7 d-flex">
        <div class="card flex-fill">
            <div class="card-header d-flex align-items-center justify-content-between">
              <h3>Kamis</h3>
            </div>
            <div class="card-body p-0 m-0">
                <table class="table table-nowrap mb-0">
                    <tbody>
                        @foreach ($kamis as $item)
                        <tr>
                            <td class="border"><span class="ti ti-clock-hour-1"></span> {{  $item->start }} -  {{ $item->end }}</td>
                            <td><b>{{ $item->mata_pelajaran->nama }}</b></td>
                            <td>
                                @if($item->id_gtk == '')
                                Belum Disetel
                                @else
                                {{ $item->guru->nama }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-xl-6 col-md-7 d-flex">
        <div class="card flex-fill">
            <div class="card-header d-flex align-items-center justify-content-between">
              <h3>Jum'at</h3>
            </div>
            <div class="card-body p-0 m-0">
                <table class="table table-nowrap mb-0">
                    <tbody>
                        @foreach ($jumat as $item)
                        <tr>
                            <td class="border"><span class="ti ti-clock-hour-1"></span> {{  $item->start }} -  {{ $item->end }}</td>
                            <td><b>{{ $item->mata_pelajaran->nama }}</b></td>
                            <td>
                                @if($item->id_gtk == '')
                                Belum Disetel
                                @else
                                {{ $item->guru->nama }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-xl-6 col-md-7 d-flex">
        <div class="card flex-fill">
            <div class="card-header d-flex align-items-center justify-content-between">
              <h3>Sabtu</h3>
            </div>
            <div class="card-body p-0 m-0">
                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <tbody>
                            @foreach ($sabtu as $item)
                            <tr>
                                <td class="border"><span class="ti ti-clock-hour-1"></span> {{  $item->start }} -  {{ $item->end }}</td>
                                <td><b>{{ $item->mata_pelajaran->nama }}</b></td>
                                <td>
                                    @if($item->id_gtk == '')
                                    Belum Disetel
                                    @else
                                    {{ $item->guru->nama }}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div>
@section('javascript')
<script>
    var body = document.body;
    body.classList.add("mini-sidebar");
</script>
@endsection

@endsection
