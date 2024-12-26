@extends('layout.main')
@section('css')
<style>
    .table-warning {
    background-color: #ffcc00; /* Custom yellow color */
    color: rgb(0, 0, 0); /* Optional: change text color to white for contrast */
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
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">

        <div class="pe-1 mb-2">
            <button type="button" class="btn btn-outline-light bg-white  me-1" onclick="history.back()">
                <i class="ti ti-arrow-left"></i> Kembali
            </button>
            <a href="{{ route('export.jadwal' ,$id) }}">
            <button type="button" class="btn btn-primary  me-1" onclick="history.back()">
                <i class="ti ti-download"></i> Download PDF
            </button></a>
        </div>

    </div>
</div>
{{-- End Header --}}
<table class="table  table-striped">
    <thead>
        <tr>
            <th class="border">HARI</th>
            <th class="border"> WAKTU</th>
            <th class="border">MATA PELAJARAN</th>
            <th class="border">GURU PENGAJAR</th>
         
        </tr>
      
    </thead>
    <tbody>

        @foreach([1, 2, 3, 4, 5, 6, 7] as $day)  <!-- Loop through days (1 = Monday, 7 = Sunday) -->
        @php
            $dayName = ['1' => 'SENIN', '2' => 'SELASA', '3' => 'RABU', '4' => 'KAMIS', '5' => 'JUMAT', '6' => 'SABTU', '7' => 'MINGGU'][$day];
            $jadwalForDay = $jadwal->where('day', $day); 
        @endphp
        
        @if($jadwalForDay->isNotEmpty())  <!-- Check if there are any schedules for the current day -->
            <tr>
                <td rowspan="{{ $jadwalForDay->count() + 1 }}" class="border">{{ $dayName }}</td>  <!-- Display the day name -->
            </tr>
    
            @foreach ($jadwalForDay as $jadwalItem)  <!-- Loop through the schedule for that day -->
                <tr>
                    <td class="border">{{ $jadwalItem->start }} - {{ $jadwalItem->end }}</td>
                    <td class="border" @if($jadwalItem->ref) colspan="2"  @endif>
                        @if($jadwalItem->mata_pelajaran)
                            {{ $jadwalItem->mata_pelajaran->nama ?? '' }}
                        @else
                            {{ $jadwalItem->ref->ref ?? ''}}
                        @endif
                    </td>
                    @if($jadwalItem->mata_pelajaran)
                    <td class="border">
                        {{ $jadwalItem->guru->nama ?? '' }}
                    </td>
                    @endif
                </tr>
            @endforeach
        @endif
    @endforeach
         
    </tbody>
</table>
<br>



{{-- <div class="row">
    
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
                                <td>
                                    @if($item->mata_pelajaran)
                                    <b>{{ $item->mata_pelajaran->nama }}</b>
                                    @else
                                    <b>{{ $item->ref->ref }}</b>
                                    @endif
                                </td>
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


</div> --}}
@section('javascript')
<script>
    // Initialize Bootstrap popovers
    document.addEventListener('DOMContentLoaded', function () {
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });
    });
</script>
<script>
    var body = document.body;
    body.classList.add("mini-sidebar");
</script>
@endsection

@endsection
