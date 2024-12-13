@extends('layout.main')
@section('container')
<div class="d-md-flex d-block align-items-center justify-content-between mb-3">
    <div class="my-auto mb-2">
        <h3 class="page-title mb-1">Dashboard</h3>
    </div>
</div>

<div class="row flex-fill">
    <div class="col-xl-6 d-flex">
        <div class="flex-fill">
            <div class="card bg-dark position-relative">
                <div class="card-body">
                    <div class="d-flex align-items-center row-gap-3 mb-3">
                        <div class="avatar avatar-xxl rounded flex-shrink-0 me-3">
                           {{-- user siswa --}}
                        @if(auth()->user()->role == "siswa")
                        @if(Auth::user()->student == NULL)
                           <img src='{{ asset('asset/img/user-default.jpg')  }}' alt='Img' class='img-fluid'>
                        @else
                           @if(Auth::user()->student->foto == "" )
                               <img src='{{ asset('asset/img/user-default.jpg')  }}' alt='Img' class='img-fluid'>
                           @else
                               <img src="/storage/{{ Auth::user()->student->foto }}" alt='Img' class='img-fluid'>
                           @endif
                        @endif
                       @endif

                      @if(auth()->user()->role == "guru")
                        @if(Auth::user()->gtk == NULL)
                           <img src='{{ asset('asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                        @else
                           @if(Auth::user()->gtk->gambar == "" )
                               <img src='{{ asset('asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                           @else
                               <img src="/storage/{{ Auth::user()->gtk->gambar }}" alt='Img' class='img-fluid'>
                           @endif
                        @endif
                       @endif

                       @if( auth()->user()->role == "walikelas")
                           @if(Auth::user()->gtk == NULL)
                               <img src='{{ asset('asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                           @else
                           @if(Auth::user()->gtk->gambar == "" )
                               <img src='{{ asset('asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                           @else
                               <img src="/storage/{{ Auth::user()->gtk->gambar }}" alt='Img' class='img-fluid'>
                           @endif
                           @endif
                       @endif

                       @if(auth()->user()->role == "admin" || auth()->user()->role == "superadmin" )
                           <img src='{{ asset('asset/img/user-default.jpg') }}' alt='Img' class='img-fluid'>
                       @endif


                        </div>
                        <div class="d-block">
                            <span class="badge bg-transparent-primary text-primary mb-1">NIS : {{ auth()->user()->nomor }}</span>
                            <h3 class="text-truncate text-white mb-1">{{ auth()->user()->nama }}</h3>
                            <div class="d-flex align-items-center flex-wrap row-gap-2 text-gray-2">
                                <span class="  pe-2">
                                   Kelas :
                                </span>
                                @if(Auth::user()->rombelstudent)
                                <span>{{ Auth::user()->rombelstudent->getkelas->nama_kelas }} {{ Auth::user()->rombelstudent->getkelas->jurusanKelas->nama_jurusan }} {{ Auth::user()->rombelstudent->getkelas->sub_kelas }}</span>
                                @else
                                <span>Belum disetel</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div
                        class="d-flex align-items-center justify-content-between profile-footer flex-wrap row-gap-3 pt-4">
                        <div class="d-flex align-items-center">
                            <h6 class="text-white">Status</h6>
                            <span class="badge bg-success d-inline-flex align-items-center ms-2">{{ auth()->user()->status == '2' ?' Aktif' : 'Tidak Aktif'  }}</span>
                        </div>
                        <a href="edit-student.html" class="btn btn-primary">Edit Profile</a>
                    </div>
                    <div class="student-card-bg">
                        <img src="https://preskool.dreamstechnologies.com/html/template/assets/img/bg/circle-shape.png" alt="Bg">
                        <img src="https://preskool.dreamstechnologies.com/html/template/assets/img/bg/shape-02.png" alt="Bg">
                        <img src="https://preskool.dreamstechnologies.com/html/template/assets/img/bg/shape-04.png" alt="Bg">
                        <img src="https://preskool.dreamstechnologies.com/html/template/assets/img/bg/blue-polygon.png" alt="Bg">
                    </div>
                </div>
            </div>
            <div class="card flex-fill">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="card-title">Today’s Class</h4>
                    {{-- <div class="d-inline-flex align-items-center class-datepick">
                        <span class="icon"><i class="ti ti-chevron-left me-2"></i></span>
                        <input type="text" class="form-control datetimepicker border-0" placeholder="16 May 2024">
                        <span class="icon"><i class="ti ti-chevron-right"></i></span>
                    </div> --}}
                </div>
                <div class="card-body">
                    @foreach ($jadwal as $item )
                    @php
                        $day_number = date('N'); // 'N' returns 1 for Monday, 7 for Sunday
                        $current_time = \Carbon\Carbon::now()->format('H:i'); // Get current time in 'H:i' format
                    @endphp
                       @foreach ($item->jadwalStudent->where('day', $day_number)->sortBy('start') as $i)
                        <div class="card mb-3">
                            <div class="d-flex align-items-center justify-content-between flex-wrap p-3 pb-1">
                                <div class="d-flex align-items-center flex-wrap mb-2">
                                    <span class="avatar avatar-lg flex-shrink-0 rounded me-2">
                                     @if(!empty($i->guru->gambar))
                                        <img src="/storage/{{ $i->guru->gambar }}" alt="Profile">
                                    @else
                                        <img src="{{ asset('asset/img/user-default.jpg') }}" alt="Default Profile">
                                    @endif
                                    
                                    </span>
                                    <div>
                                        <h6 class="mb-1 {{ $current_time > $i->end ? 'text-decoration-line-through' : ''}}">{{ $i->mata_pelajaran->nama }}</h6>
                                        <span><i class="ti ti-clock me-2"></i>{{ $i->start }} - {{ $i->end }}</span>
                                    </div>
                                </div>
                            
                            @if($current_time < $i->end)
                                <span class="badge badge-soft-danger shadow-none mb-2">
                                    <i class="ti ti-circle-filled fs-8 me-1"></i>On going
                                </span>
                            @else
                                <span class="badge badge-soft-success shadow-none mb-2">
                                    <i class="ti ti-circle-filled fs-8 me-1"></i>Completed
                                </span>
                            @endif
                            </div>
                        </div>
                        @endforeach
                    @endforeach
                   
                    
                </div>
            </div>
        </div>
    </div>


    <div class="col-xl-6 d-flex">
        <div class="card flex-fill">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h4 class="card-title">Attendance</h4>
                <div class="card-dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle p-2" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <span><i class="ti ti-calendar-due"></i></span>
                        This Week
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" style="">
                        <ul>
                            <li>
                                <a href="javascript:void(0);">This Week</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">Last Week</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">Last Month</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="attendance-chart">
                    <p class="mb-3"><i class="ti ti-calendar-heart text-primary me-2"></i>No of total working days <span
                            class="fw-medium text-dark"> 28 Days</span></p>
                    <div class="border rounded p-3">
                        <div class="row">
                            <div class="col text-center border-end">
                                <p class="mb-1">Present</p>
                                <h5>25</h5>
                            </div>
                            <div class="col text-center border-end">
                                <p class="mb-1">Absent</p>
                                <h5>2</h5>
                            </div>
                            <div class="col text-center">
                                <p class="mb-1">Halfday</p>
                                <h5>0</h5>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div id="attendance_chart" style="min-height: 222.7px;">
                            <div id="apexchartskv4j0h7c" class="apexcharts-canvas apexchartskv4j0h7c apexcharts-theme-"
                                style="width: 434px; height: 222.7px;"><svg id="SvgjsSvg1293" width="434"
                                    height="222.70000000000002" xmlns="http://www.w3.org/2000/svg" version="1.1"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev"
                                    class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)">
                                    <foreignObject x="0" y="0" width="434" height="222.70000000000002">
                                        <div class="apexcharts-legend apexcharts-align-center apx-legend-position-bottom"
                                            xmlns="http://www.w3.org/1999/xhtml"
                                            style="inset: auto 0px 1px; position: absolute; max-height: 127.5px;">
                                            <div class="apexcharts-legend-series" rel="1" seriesname="Present"
                                                data:collapsed="false" style="margin: 4px 5px;"><span
                                                    class="apexcharts-legend-marker" rel="1" data:collapsed="false"
                                                    style="height: 12px; width: 12px; left: 0px; top: 0px; border-radius: 100%; color: rgb(26, 190, 23); background: rgb(26, 190, 23) !important;"></span><span
                                                    class="apexcharts-legend-text" rel="1" i="0"
                                                    data:default-text="Present" data:collapsed="false"
                                                    style="color: rgb(55, 61, 63); font-size: 12px; font-weight: 400; font-family: Helvetica, Arial, sans-serif;">Present</span>
                                            </div>
                                            <div class="apexcharts-legend-series" rel="2" seriesname="Late"
                                                data:collapsed="false" style="margin: 4px 5px;"><span
                                                    class="apexcharts-legend-marker" rel="2" data:collapsed="false"
                                                    style="height: 12px; width: 12px; left: 0px; top: 0px; border-radius: 100%; color: rgb(17, 112, 228); background: rgb(17, 112, 228) !important;"></span><span
                                                    class="apexcharts-legend-text" rel="2" i="1"
                                                    data:default-text="Late" data:collapsed="false"
                                                    style="color: rgb(55, 61, 63); font-size: 12px; font-weight: 400; font-family: Helvetica, Arial, sans-serif;">Late</span>
                                            </div>
                                            <div class="apexcharts-legend-series" rel="3" seriesname="HalfxDay"
                                                data:collapsed="false" style="margin: 4px 5px;"><span
                                                    class="apexcharts-legend-marker" rel="3" data:collapsed="false"
                                                    style="height: 12px; width: 12px; left: 0px; top: 0px; border-radius: 100%; color: rgb(233, 237, 244); background: rgb(233, 237, 244) !important;"></span><span
                                                    class="apexcharts-legend-text" rel="3" i="2"
                                                    data:default-text="Half%20Day" data:collapsed="false"
                                                    style="color: rgb(55, 61, 63); font-size: 12px; font-weight: 400; font-family: Helvetica, Arial, sans-serif;">Half
                                                    Day</span></div>
                                            <div class="apexcharts-legend-series" rel="4" seriesname="Absent"
                                                data:collapsed="false" style="margin: 4px 5px;"><span
                                                    class="apexcharts-legend-marker" rel="4" data:collapsed="false"
                                                    style="height: 12px; width: 12px; left: 0px; top: 0px; border-radius: 100%; color: rgb(232, 38, 70); background: rgb(232, 38, 70) !important;"></span><span
                                                    class="apexcharts-legend-text" rel="4" i="3"
                                                    data:default-text="Absent" data:collapsed="false"
                                                    style="color: rgb(55, 61, 63); font-size: 12px; font-weight: 400; font-family: Helvetica, Arial, sans-serif;">Absent</span>
                                            </div>
                                        </div>
                                        <style type="text/css">
                                            .apexcharts-legend {
                                                display: flex;
                                                overflow: auto;
                                                padding: 0 10px;
                                            }

                                            .apexcharts-legend.apx-legend-position-bottom,
                                            .apexcharts-legend.apx-legend-position-top {
                                                flex-wrap: wrap
                                            }

                                            .apexcharts-legend.apx-legend-position-right,
                                            .apexcharts-legend.apx-legend-position-left {
                                                flex-direction: column;
                                                bottom: 0;
                                            }

                                            .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-left,
                                            .apexcharts-legend.apx-legend-position-top.apexcharts-align-left,
                                            .apexcharts-legend.apx-legend-position-right,
                                            .apexcharts-legend.apx-legend-position-left {
                                                justify-content: flex-start;
                                            }

                                            .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-center,
                                            .apexcharts-legend.apx-legend-position-top.apexcharts-align-center {
                                                justify-content: center;
                                            }

                                            .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-right,
                                            .apexcharts-legend.apx-legend-position-top.apexcharts-align-right {
                                                justify-content: flex-end;
                                            }

                                            .apexcharts-legend-series {
                                                cursor: pointer;
                                                line-height: normal;
                                                display: flex;
                                            }

                                            .apexcharts-legend.apx-legend-position-bottom .apexcharts-legend-series,
                                            .apexcharts-legend.apx-legend-position-top .apexcharts-legend-series {
                                                align-items: center;
                                            }

                                            .apexcharts-legend-text {
                                                position: relative;
                                                font-size: 14px;
                                            }

                                            .apexcharts-legend-text *,
                                            .apexcharts-legend-marker * {
                                                pointer-events: none;
                                            }

                                            .apexcharts-legend-marker {
                                                position: relative;
                                                display: flex;
                                                align-items: center;
                                                justify-content: center;
                                                cursor: pointer;
                                                margin-right: 3px;
                                            }

                                            .apexcharts-legend-series.apexcharts-no-click {
                                                cursor: auto;
                                            }

                                            .apexcharts-legend .apexcharts-hidden-zero-series,
                                            .apexcharts-legend .apexcharts-hidden-null-series {
                                                display: none !important;
                                            }

                                            .apexcharts-inactive-legend {
                                                opacity: 0.45;
                                            }
                                        </style>
                                    </foreignObject>
                                    <g id="SvgjsG1295" class="apexcharts-inner apexcharts-graphical"
                                        transform="translate(12, 0)">
                                        <defs id="SvgjsDefs1294">
                                            <clipPath id="gridRectMaskkv4j0h7c">
                                                <rect id="SvgjsRect1296" width="418" height="194" x="-3" y="-3" rx="0"
                                                    ry="0" opacity="1" stroke-width="0" stroke="none"
                                                    stroke-dasharray="0" fill="#fff"></rect>
                                            </clipPath>
                                            <clipPath id="forecastMaskkv4j0h7c"></clipPath>
                                            <clipPath id="nonForecastMaskkv4j0h7c"></clipPath>
                                            <clipPath id="gridRectMarkerMaskkv4j0h7c">
                                                <rect id="SvgjsRect1297" width="416" height="192" x="-2" y="-2" rx="0"
                                                    ry="0" opacity="1" stroke-width="0" stroke="none"
                                                    stroke-dasharray="0" fill="#fff"></rect>
                                            </clipPath>
                                        </defs>
                                        <g id="SvgjsG1300" class="apexcharts-pie">
                                            <g id="SvgjsG1301" transform="translate(0, 0) scale(1)">
                                                <circle id="SvgjsCircle1302" r="55.709756097560984" cx="206" cy="94"
                                                    fill="transparent"></circle>
                                                <g id="SvgjsG1303" class="apexcharts-slices">
                                                    <g id="SvgjsG1304" class="apexcharts-series apexcharts-pie-series"
                                                        seriesName="Present" rel="1" data:realIndex="0">
                                                        <path id="SvgjsPath1305"
                                                            d="M 206 8.292682926829258 A 85.70731707317074 85.70731707317074 0 1 1 155.62250301083535 163.33867605447722 L 173.25462695704297 139.0701394354102 A 55.709756097560984 55.709756097560984 0 1 0 206 38.290243902439016 L 206 8.292682926829258 z "
                                                            fill="rgba(26,190,23,1)" fill-opacity="1" stroke-opacity="1"
                                                            stroke-linecap="butt" stroke-width="2" stroke-dasharray="0"
                                                            class="apexcharts-pie-area apexcharts-donut-slice-0"
                                                            index="0" j="0" data:angle="216" data:startAngle="0"
                                                            data:strokeWidth="2" data:value="60"
                                                            data:pathOrig="M 206 8.292682926829258 A 85.70731707317074 85.70731707317074 0 1 1 155.62250301083535 163.33867605447722 L 173.25462695704297 139.0701394354102 A 55.709756097560984 55.709756097560984 0 1 0 206 38.290243902439016 L 206 8.292682926829258 z "
                                                            stroke="#ffffff"></path>
                                                    </g>
                                                    <g id="SvgjsG1306" class="apexcharts-series apexcharts-pie-series"
                                                        seriesName="Late" rel="2" data:realIndex="1">
                                                        <path id="SvgjsPath1307"
                                                            d="M 155.62250301083535 163.33867605447722 A 85.70731707317074 85.70731707317074 0 0 1 136.66132394552278 144.37749698916465 L 160.92986056458983 126.74537304295703 A 55.709756097560984 55.709756097560984 0 0 0 173.25462695704297 139.0701394354102 L 155.62250301083535 163.33867605447722 z "
                                                            fill="rgba(17,112,228,1)" fill-opacity="1"
                                                            stroke-opacity="1" stroke-linecap="butt" stroke-width="2"
                                                            stroke-dasharray="0"
                                                            class="apexcharts-pie-area apexcharts-donut-slice-1"
                                                            index="0" j="1" data:angle="18" data:startAngle="216"
                                                            data:strokeWidth="2" data:value="5"
                                                            data:pathOrig="M 155.62250301083535 163.33867605447722 A 85.70731707317074 85.70731707317074 0 0 1 136.66132394552278 144.37749698916465 L 160.92986056458983 126.74537304295703 A 55.709756097560984 55.709756097560984 0 0 0 173.25462695704297 139.0701394354102 L 155.62250301083535 163.33867605447722 z "
                                                            stroke="#ffffff"></path>
                                                    </g>
                                                    <g id="SvgjsG1308" class="apexcharts-series apexcharts-pie-series"
                                                        seriesName="HalfxDay" rel="3" data:realIndex="2">
                                                        <path id="SvgjsPath1309"
                                                            d="M 136.66132394552278 144.37749698916465 A 85.70731707317074 85.70731707317074 0 0 1 124.4874976033861 67.51498248210814 L 153.01687344220096 76.78473861337028 A 55.709756097560984 55.709756097560984 0 0 0 160.92986056458983 126.74537304295703 L 136.66132394552278 144.37749698916465 z "
                                                            fill="rgba(233,237,244,1)" fill-opacity="1"
                                                            stroke-opacity="1" stroke-linecap="butt" stroke-width="2"
                                                            stroke-dasharray="0"
                                                            class="apexcharts-pie-area apexcharts-donut-slice-2"
                                                            index="0" j="2" data:angle="54" data:startAngle="234"
                                                            data:strokeWidth="2" data:value="15"
                                                            data:pathOrig="M 136.66132394552278 144.37749698916465 A 85.70731707317074 85.70731707317074 0 0 1 124.4874976033861 67.51498248210814 L 153.01687344220096 76.78473861337028 A 55.709756097560984 55.709756097560984 0 0 0 160.92986056458983 126.74537304295703 L 136.66132394552278 144.37749698916465 z "
                                                            stroke="#ffffff"></path>
                                                    </g>
                                                    <g id="SvgjsG1310" class="apexcharts-series apexcharts-pie-series"
                                                        seriesName="Absent" rel="4" data:realIndex="3">
                                                        <path id="SvgjsPath1311"
                                                            d="M 124.4874976033861 67.51498248210814 A 85.70731707317074 85.70731707317074 0 0 1 205.98504125131615 8.292684232226335 L 205.9902768133555 38.29024475094712 A 55.709756097560984 55.709756097560984 0 0 0 153.01687344220096 76.78473861337028 L 124.4874976033861 67.51498248210814 z "
                                                            fill="rgba(232,38,70,1)" fill-opacity="1" stroke-opacity="1"
                                                            stroke-linecap="butt" stroke-width="2" stroke-dasharray="0"
                                                            class="apexcharts-pie-area apexcharts-donut-slice-3"
                                                            index="0" j="3" data:angle="72" data:startAngle="288"
                                                            data:strokeWidth="2" data:value="20"
                                                            data:pathOrig="M 124.4874976033861 67.51498248210814 A 85.70731707317074 85.70731707317074 0 0 1 205.98504125131615 8.292684232226335 L 205.9902768133555 38.29024475094712 A 55.709756097560984 55.709756097560984 0 0 0 153.01687344220096 76.78473861337028 L 124.4874976033861 67.51498248210814 z "
                                                            stroke="#ffffff"></path>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                        <line id="SvgjsLine1312" x1="0" y1="0" x2="412" y2="0" stroke="#b6b6b6"
                                            stroke-dasharray="0" stroke-width="1" stroke-linecap="butt"
                                            class="apexcharts-ycrosshairs"></line>
                                        <line id="SvgjsLine1313" x1="0" y1="0" x2="412" y2="0" stroke-dasharray="0"
                                            stroke-width="0" stroke-linecap="butt"
                                            class="apexcharts-ycrosshairs-hidden"></line>
                                    </g>
                                    <g id="SvgjsG1298" class="apexcharts-datalabels-group"
                                        transform="translate(0, 0) scale(1)"></g>
                                    <g id="SvgjsG1299" class="apexcharts-datalabels-group"
                                        transform="translate(0, 0) scale(1)"></g>
                                </svg>
                                <div class="apexcharts-tooltip apexcharts-theme-dark">
                                    <div class="apexcharts-tooltip-series-group" style="order: 1;"><span
                                            class="apexcharts-tooltip-marker"
                                            style="background-color: rgb(26, 190, 23);"></span>
                                        <div class="apexcharts-tooltip-text"
                                            style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                            <div class="apexcharts-tooltip-y-group"><span
                                                    class="apexcharts-tooltip-text-y-label"></span><span
                                                    class="apexcharts-tooltip-text-y-value"></span></div>
                                            <div class="apexcharts-tooltip-goals-group"><span
                                                    class="apexcharts-tooltip-text-goals-label"></span><span
                                                    class="apexcharts-tooltip-text-goals-value"></span></div>
                                            <div class="apexcharts-tooltip-z-group"><span
                                                    class="apexcharts-tooltip-text-z-label"></span><span
                                                    class="apexcharts-tooltip-text-z-value"></span></div>
                                        </div>
                                    </div>
                                    <div class="apexcharts-tooltip-series-group" style="order: 2;"><span
                                            class="apexcharts-tooltip-marker"
                                            style="background-color: rgb(17, 112, 228);"></span>
                                        <div class="apexcharts-tooltip-text"
                                            style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                            <div class="apexcharts-tooltip-y-group"><span
                                                    class="apexcharts-tooltip-text-y-label"></span><span
                                                    class="apexcharts-tooltip-text-y-value"></span></div>
                                            <div class="apexcharts-tooltip-goals-group"><span
                                                    class="apexcharts-tooltip-text-goals-label"></span><span
                                                    class="apexcharts-tooltip-text-goals-value"></span></div>
                                            <div class="apexcharts-tooltip-z-group"><span
                                                    class="apexcharts-tooltip-text-z-label"></span><span
                                                    class="apexcharts-tooltip-text-z-value"></span></div>
                                        </div>
                                    </div>
                                    <div class="apexcharts-tooltip-series-group" style="order: 3;"><span
                                            class="apexcharts-tooltip-marker"
                                            style="background-color: rgb(233, 237, 244);"></span>
                                        <div class="apexcharts-tooltip-text"
                                            style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                            <div class="apexcharts-tooltip-y-group"><span
                                                    class="apexcharts-tooltip-text-y-label"></span><span
                                                    class="apexcharts-tooltip-text-y-value"></span></div>
                                            <div class="apexcharts-tooltip-goals-group"><span
                                                    class="apexcharts-tooltip-text-goals-label"></span><span
                                                    class="apexcharts-tooltip-text-goals-value"></span></div>
                                            <div class="apexcharts-tooltip-z-group"><span
                                                    class="apexcharts-tooltip-text-z-label"></span><span
                                                    class="apexcharts-tooltip-text-z-value"></span></div>
                                        </div>
                                    </div>
                                    <div class="apexcharts-tooltip-series-group" style="order: 4;"><span
                                            class="apexcharts-tooltip-marker"
                                            style="background-color: rgb(232, 38, 70);"></span>
                                        <div class="apexcharts-tooltip-text"
                                            style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                            <div class="apexcharts-tooltip-y-group"><span
                                                    class="apexcharts-tooltip-text-y-label"></span><span
                                                    class="apexcharts-tooltip-text-y-value"></span></div>
                                            <div class="apexcharts-tooltip-goals-group"><span
                                                    class="apexcharts-tooltip-text-goals-label"></span><span
                                                    class="apexcharts-tooltip-text-goals-value"></span></div>
                                            <div class="apexcharts-tooltip-z-group"><span
                                                    class="apexcharts-tooltip-text-z-label"></span><span
                                                    class="apexcharts-tooltip-text-z-value"></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-light-300 rounded border p-3 mb-0">
                        <div class="d-flex align-items-center justify-content-between flex-wrap mb-1">
                            <h6 class="mb-2">Last 7 Days </h6>
                            <p class="fs-12 mb-2">14 May 2024 - 21 May 2024</p>
                        </div>
                        <div class="d-flex align-items-center rounded gap-1 flex-wrap">
                            <a href="javascript:void(0);" class="badge badge-lg bg-success text-white">M</a>
                            <a href="javascript:void(0);" class="badge badge-lg bg-success text-white">T</a>
                            <a href="javascript:void(0);" class="badge badge-lg bg-success text-white">W</a>
                            <a href="javascript:void(0);" class="badge badge-lg bg-success text-white">T</a>
                            <a href="javascript:void(0);" class="badge badge-lg bg-danger text-white">F</a>
                            <a href="javascript:void(0);" class="badge badge-lg bg-white border text-default">S</a>
                            <a href="javascript:void(0);" class="badge badge-lg  bg-white border text-gray-1">S</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-xl-12 d-flex">
        <div class="row flex-fill">
            <div class="col-sm-6 col-xl-3 d-flex">
                <a href="student-fees.html"
                    class="card border-0 border-bottom border-primary flex-fill animate-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-md rounded bg-primary me-2"><i
                                    class="ti ti-report-money fs-16"></i></span>
                            <h6>Pay Fees</h6>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-xl-3 d-flex">
                <a href="student-result.html" class="card border-0 border-bottom border-success flex-fill animate-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-md rounded bg-success me-2"><i
                                    class="ti ti-hexagonal-prism-plus fs-16"></i></span>
                            <h6>Exam Result</h6>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-xl-3 d-flex">
                <a href="student-time-table.html"
                    class="card border-0 border-bottom border-warning flex-fill animate-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-md rounded bg-warning me-2"><i
                                    class="ti ti-calendar fs-16"></i></span>
                            <h6>Calendar</h6>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-xl-3 d-flex">
                <a href="student-leaves.html"
                    class="card border-0 border-bottom border-dark flex-fill animate-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-md rounded bg-dark me-2"><i
                                    class="ti ti-calendar-share fs-16"></i></span>
                            <h6>Attendance</h6>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
