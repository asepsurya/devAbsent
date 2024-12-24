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
<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col" class="border  bg-primary text-white" width="1%">No</th>
                <th scope="col" class="border  bg-primary text-white" width="">Jam</th>
                @foreach ($hari as $a )
             
                <th colspan="2" class="border text-center">
                    @switch($a->id_hari)
                    @case(1)
                    Senin
                    @break
                    @case(2)
                    Selasa
                    @break
                    @case(3)
                    Rabu
                    @break
                    @case(4)
                    Kamis
                    @break
                    @case(5)
                    Jum'at
                    @break
                    @case(6)
                    Sabtu
                    @break
                    @case(7)
                    Minggu
                    @break
                    @default
                    Tidak Diketahui
                    @endswitch
                </th>
                
                @endforeach
            <tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
        @foreach ($jam as $b)
            <tr >
                <td class="border bg-primary text-white" width="2%">{{ $no++ }}</td>
                <td class="border bg-primary text-white" width="2%">{{ $b->jam_mulai }} - {{ $b->jam_berakhir }}</td>
                @foreach ($hari as $a)
                   
                    <td class="border" >
                        {{-- Check if there's a schedule for this day and time slot --}}
                        @php
                            $scheduleFound = false;  // Flag to check if any schedule exists for this time slot
                        @endphp

                        {{-- Loop through possible time slots --}}
                        @foreach ($jadwal->where('day', $a->id_hari) as $jadwalItem)
                            @if ($jadwalItem->id_jam == $b->jam_ke)
                                {{-- If there's a matching schedule, display the subject --}}
                            
                                    @if($jadwalItem->mata_pelajaran)
                                    {{ \Str::limit($jadwalItem->mata_pelajaran->nama ?? '',255) }}
                                    @else
                                        {{ $jadwalItem->ref->ref }}
                                    @endif
                                

                                @php
                                    $scheduleFound = true;  // Mark that a schedule was found
                                @endphp
                            @endif
                        @endforeach

                        {{-- If no schedule found for this time slot, display the "add" button --}}
                        @if (!$scheduleFound)
                                -
                        @endif
                    </td>
                    <td>
                            @php
                            $scheduleFound = false;  // Flag to check if any schedule exists for this time slot
                        @endphp

                        {{-- Loop through possible time slots --}}
                        @foreach ($jadwal->where('day', $a->id_hari) as $jadwalItem)
                        @if ($jadwalItem->id_jam == $b->jam_ke)
                            {{-- If there's a matching schedule, display the subject --}}
                            
                            @if ($jadwalItem->guru)
                                @php
                                    // Get the full name from the object
                                    $name = $jadwalItem->guru->nama;
                    
                                    // Split the name into parts
                                    $parts = explode(' ', $name);
                    
                                    // Initialize an empty string for the abbreviated name
                                    $abbreviatedName = '';
                    
                                    // Loop through the parts and take the first letter of each word
                                    foreach ($parts as $part) {
                                        $abbreviatedName .= strtoupper(substr($part, 0, 1));
                                    }
                                @endphp
                
                                <!-- Output the abbreviated name inside a badge -->
                                <a id="popoverButton" class="badge badge-soft-success d-inline-flex align-items-center" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-custom-class="header-info" data-bs-html="true" data-bs-content="{{ $name }}" data-bs-original-title="Nama Guru Pengajar : ">{{ $abbreviatedName }}</a>

                                
                            @endif
                    
                            @php
                                $scheduleFound = true;  // Mark that a schedule was found
                            @endphp
                        @endif
                    @endforeach
                    

                        {{-- If no schedule found for this time slot, display the "add" button --}}
                        @if (!$scheduleFound)
                                -
                        @endif
                    </td>
                @endforeach

            </tr>
        @endforeach
            </tbody>

    </table>
 
</div>


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
