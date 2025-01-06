@extends('layout.main')
@section('container')
@section('css')
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
   <style>
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            /* background-color: #fff; */

            border-radius: 10px;

            width: 100%; /* Make calendar full-width */
            box-sizing: border-box; /* Include padding and borders in the width */
        }

        .calendar-day {
            text-align: center;
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .calendar-day:hover {
            background-color: #cce7ff;
        }

        .active-day {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            /* border: 2px solid #0056b3; */
        }
        html .darkmode .calendar-day, html[data-theme=dark] .calendar-day {
            background-color: #1b1632;

        }

        html .darkmode .active-day, html[data-theme=dark] .active-day {
            background-color: #007bff;
            color: white;
        }

        /* Responsive design for smaller screens */
        @media (max-width: 768px) {
            .calendar {
                grid-template-columns: repeat(3, 1fr); /* Show 3 days per row on smaller screens */
            }
        }

        @media (max-width: 480px) {
            .calendar {
                grid-template-columns: repeat(2, 1fr); /* Show 2 days per row on very small screens */
            }
        }
        #custom-slider {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;

            border-radius: 10px;
            /* box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); */
        }

        .icon-container .line {
            width: 3px;
            height: 50px;
            background-color: #fff; /* Warna garis putih */
            border-radius: 10px;
        }

        .text-container h4 {
            font-weight: bold;
            margin: 0;
        }

        .text-container p {
            font-size: 14px;
            margin: 0;
        }

        .image-container img {
            max-height: 50px; /* Sesuaikan ukuran logo */
        }

        .slider-container {
            position: relative;
            height: 80px; /* Sesuaikan tinggi kontainer */
            overflow: hidden;
        }



        .slider-item:nth-child(2) {
            animation-delay: 5s; /* Memberi jeda untuk slide kedua */
        }
        .slider-item {
            position: absolute;
            width: 100%;
            left: 0;
            top: 100%; /* Mulai di luar tampilan */
            animation: slideUp 10s infinite;
            cursor: grab; /* Indicate draggable behavior */
            transition: top 0.3s ease; /* Smooth transition when dragging */
            }

            @keyframes slideUp {
            0% {
                top: 100%; /* Mulai di bawah */
            }
            10% {
                top: 0%; /* Naik ke posisi tampilan */
            }
            40% {
                top: 0%; /* Tetap selama beberapa waktu */
            }
            45% {
                top: 0%; /* Tetap selama beberapa waktu */
            }
            48% {
                top: 0%; /* Tetap selama beberapa waktu */
            }
            50% {
                top: -100%; /* Naik keluar tampilan */
            }
            100% {
                top: -100%; /* Tetap di luar tampilan */
            }
            }



   </style>
@endsection
<div class="row">
    <div class="col-md-12">
        <div class="card bg-dark">
            <div class="overlay-img">
                <img src="https://preskool.dreamstechnologies.com/html/template/assets/img/bg/shape-04.png" alt="img"
                    class="img-fluid shape-01">
                <img src="https://preskool.dreamstechnologies.com/html/template/assets/img/bg/shape-01.png" alt="img"
                    class="img-fluid shape-02">
                <img src="https://preskool.dreamstechnologies.com/html/template/assets/img/bg/shape-02.png" alt="img"
                    class="img-fluid shape-03">
                <img src="https://preskool.dreamstechnologies.com/html/template/assets/img/bg/shape-03.png" alt="img"
                    class="img-fluid shape-04">
            </div>
            <div class="card-body">
                <div class="d-flex align-items-xl-center justify-content-xl-between flex-xl-row flex-column">
                    <div class="mb-3 mb-xl-0">
                        <div class="d-flex align-items-center flex-wrap mb-2">
                           @php
                            $hour = date('H');
                            if ($hour < 12) { $ucapan = "Selamat Pagi!" ; } elseif ($hour < 18) { $ucapan = "Selamat Siang!" ; } else { $ucapan= "Selamat Malam!"
                                ; } @endphp
                            <h1 class="text-white me-2">{{ $ucapan }}, {{ auth()->user()->nama }}</h1>
                            <a href="https://preskool.dreamstechnologies.com/html/template/profile.html"
                                class="avatar avatar-sm img-rounded bg-gray-800 dark-hover"><i
                                    class="ti ti-edit text-white"></i></a>
                        </div>
                        <p class="text-white"><i>"Jadilah cahaya yang menerangi jalan, karena setiap usaha yang tulus akan berbuah hasil!"</i></p>
                    </div>
                    <p class="text-white"><i class="ti ti-refresh me-1"></i><i>Updated at {{ date("D d M Y, h:m:s")
                            }}</i>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
        <div class="my-auto mb-2">
            {{-- <h3 class="page-title mb-1">Beranda</h3> --}}
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="index.html">Beranda</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Beranda</li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- Card --}}
    <div class="slider-container rounded mb-3" style="background-color: #0b5d1e; position: relative;">
        <!-- Slider items -->

        <div id="custom-slider" class="d-flex align-items-center slider-item">
            <div class="icon-container me-3">
                <div class="line"></div>
            </div>
            <div>
                <h4 class="text-white mb-1">Selamat Tahun Baru 2025!</h4>
                <p class="text-light mb-0">Selalu bahagia & semua impian tercapai!</p>
            </div>
            <div class="image-container ms-auto">
                <img src="{{ asset('asset/img/logo-white.png') }}" alt="2025 Logo" style="height: 50px;">
            </div>
        </div>
        <div id="custom-slider" class="d-flex align-items-center slider-item">
            <div class="icon-container me-3">
                <div class="line"></div>
            </div>
            <div>
                <h4 class="text-white mb-1">Semoga Tahun Baru membawa kebahagiaan!</h4>
                <p class="text-light mb-0">Ayo wujudkan impianmu tahun ini!</p>
            </div>
            <div class="image-container ms-auto">
                <img src="{{ asset('asset/img/logo-white.png') }}" alt="2025 Logo" style="height: 50px;">
            </div>
        </div>

    </div>

    <div class="col-xxl-4 col-sm-4 d-flex">
        <div class="card flex-fill animate-card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-xl  me-2 p-1">
                        <img src="{{ asset('asset/img/peserta-didik.png') }}" alt="img">
                    </div>
                    <div class="overflow-hidden flex-fill">
                        <div class="d-flex align-items-center justify-content-between">
                            <h2 class="counter">{{ $studentCount }}</h2>
                        </div>
                        <p>Peserta Didik</p>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between border-top mt-3 pt-3">
                    <p class="mb-0">Aktif : <span class="text-dark fw-semibold counter">{{ $studentActive }}</span></p>
                    <span class="text-light">|</span>
                    <p>Tidak Aktif : <span class="text-dark fw-semibold counter">{{ $studentDeactive }}</span></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-4 col-sm-4 d-flex">
        <div class="card flex-fill animate-card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-xl me-2 p-1">
                        <img src="{{ asset('asset/img/gtk.png') }}" alt="img">
                    </div>
                    <div class="overflow-hidden flex-fill">
                        <div class="d-flex align-items-center justify-content-between">
                            <h2 class="counter">{{ $gtkCount }}</h2>
                        </div>
                        <p>GTK</p>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between border-top mt-3 pt-3">
                    <p class="mb-0">Aktif : <span class="text-dark fw-semibold counter">{{ $gtkActive }}</span></p>
                    <span class="text-light">|</span>
                    <p>Tidak Aktif : <span class="text-dark fw-semibold counter">{{ $gtkDeactive }}</span></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-4 col-sm-4 d-flex">
        <div class="card flex-fill animate-card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-xl me-2  p-1">
                        <img src="{{ asset('asset/img/rombongan-belajar.png') }}" alt="img">
                    </div>
                    <div class="overflow-hidden flex-fill">
                        <div class="d-flex align-items-center justify-content-between">
                            <h2 class="counter">{{ $rombelCount }}</h2>
                        </div>
                        <p>Rombongan Belajar</p>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between border-top mt-3 pt-3">
                    <p class="mb-0">Aktif : <span class="text-dark fw-semibold counter">{{ $rombelActive }}</span></p>
                    <span class="text-light">|</span>
                    <p>Tidak Aktif : <span class="text-dark fw-semibold counter">{{ $rombelDeactive }}</span></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-4 col-sm-4 d-flex">
        <div class="card flex-fill animate-card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-xl me-2  p-1">
                        <img src="{{ asset('asset/img/kelas.png') }}" alt="img">
                    </div>
                    <div class="overflow-hidden flex-fill">
                        <div class="d-flex align-items-center justify-content-between">
                            <h2 class="counter">{{ $kelasCount }}</h2>
                            {{-- <span class="badge bg-success">1.2%</span> --}}
                        </div>
                        <p>Kelas</p>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between border-top mt-3 pt-3">
                    <p class="mb-0">Aktif : <span class="text-dark fw-semibold counter">{{ $kelasActive }}</span></p>
                    <span class="text-light">|</span>
                    <p>Tidak Aktif : <span class="text-dark fw-semibold counter">{{ $kelasDeactive }}</span></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-4 col-sm-4 d-flex">
        <div class="card flex-fill animate-card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-xl me-2 p-1">
                        <img src="{{ asset('asset/img/masuk.png') }}" alt="img">
                    </div>
                    <div class="overflow-hidden flex-fill">
                        <div class="d-flex align-items-center justify-content-between">
                            <h2 class="counter">{{ $absenEntryCount }}</h2>
                            {{-- <span class="badge bg-success">1.2%</span> --}}
                        </div>
                        <p>Absen Masuk</p>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between border-top mt-3 pt-3">
                    <p class="mb-0"></p>
                    <span class="text-light"></span>
                    <p class="mb-0">Belum : <span class="text-dark fw-semibold counter">{{ $studentActive + $gtkActive - $absenEntryCount }}</span></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-4 col-sm-4 d-flex">
        <div class="card flex-fill animate-card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-xl me-2 p-1">
                        <img src="{{ asset('asset/img/pulang.png') }}" alt="img">
                    </div>
                    <div class="overflow-hidden flex-fill">
                        <div class="d-flex align-items-center justify-content-between">
                            <h2 class="counter">{{ $absenOutCount }}</h2>
                            {{-- <span class="badge bg-success">1.2%</span> --}}
                        </div>
                        <p>Absen Pulang</p>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between border-top mt-3 pt-3">
                    <p class="mb-0"></p>
                    <span class="text-light"></span>
                    <p class="mb-0">Belum : <span class="text-dark fw-semibold counter">{{ $studentActive + $gtkActive - $absenOutCount }}</span></p>
                </div>
            </div>
        </div>
    </div>
    {{-- End Card --}}
    <div class="col mb-3">
        <div class="d-flex justify-content-between">
            <h4 class="mb-2">Kalender Mingguan</h4>
            <div>
                <strong><p id="clock"> </p></strong>
            </div>
        </div>

        <div id="weekly-calendar" class="calendar"></div>
    </div>

    <div class="row ">
        {{-- Rombongan Belajar --}}
        <div class="col-xxl-6 col-xl-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header  d-flex align-items-center justify-content-between">
                    <h4 class="card-title">Rombongan Belajar</h4>
                </div>
                <div class="card-body">
                    <div class="d-md-flex align-items-center justify-content-between" style="overflow-y: auto; ">
                        <div class="me-md-3 mb-3 mb-md-0 w-100">
                            @if($kelas->count()== 0)
                            <div
                            class="border border-dashed p-3 rounded d-flex align-items-center justify-content-between mb-1">
                            <p class="mb-0 me-2"><i class="ti ti-arrow-badge-down-filled me-2 text-primary"></i>
                                Data Kosong</p>
                        </div>
                        @else
                            @foreach ($kelas as $item)
                            <div
                                class="border border-dashed p-3 rounded d-flex align-items-center justify-content-between mb-1">
                                <p class="mb-0 me-2"><i class="ti ti-arrow-badge-down-filled me-2 text-primary"></i>
                                    {{ $item->nama_kelas }} {{ $item->jurusanKelas->nama_jurusan }} {{ $item->sub_kelas }}</p>
                                <h5>
                                    <span class="badge badge-soft-success d-inline-flex align-items-center">
                                        {{ $item->jmlRombel->count() }} Siswa
                                    </span>
                                </h5>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        {{-- End Rombongan Belajar --}}
        {{-- Riwayat Absen --}}
        <div class="col-xxl-6 col-xl-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header  d-flex align-items-center justify-content-between">
                    <h4 class="card-title">Riwayat Absen RFID</h4>
                    <div>
                        <i class="ti ti-calendar me-2"></i>Hari ini
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush todo-list " id="myData"style="overflow-y: auto; height: 500px;">
                        {{-- data Ajax --}}
                    </ul>
                </div>
            </div>
        </div>


    </div>


</div>
</div>
@section('javascript')
<script src="{{ asset('asset/Plugins/countup/jquery.counterup.min.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
<script src="{{ asset('asset/Plugins/countup/jquery.waypoints.min.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
{{-- <script src="{{ asset('asset/Plugins/apexchart/apexcharts.min.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script>
<script src="{{ asset('asset/Plugins/apexchart/chart-data.js') }}" type="d8aa163ebe66f835399f615d-text/javascript"></script> --}}
<script>

</script>
<script>
            // Function to format the time
        function formatTime(hours, minutes, seconds) {
            return (hours < 10 ? '0' : '') + hours + ':' +
                   (minutes < 10 ? '0' : '') + minutes + ':' +
                   (seconds < 10 ? '0' : '') + seconds;
        }

        // Function to update the clock
        function updateClock() {
            var now = new Date();  // Get the current date and time
            var hours = now.getHours();
            var minutes = now.getMinutes();
            var seconds = now.getSeconds();

            // Format the time
            var timeString = formatTime(hours, minutes, seconds);

            // Set the time in the HTML element with ID 'clock'
            document.getElementById('clock').innerText = timeString;
        }

        // Update the clock every 1000 milliseconds (1 second)
        setInterval(updateClock, 1000);

        // Initial call to display the time as soon as the page loads
        updateClock();

    function generateWeekCalendar() {
        const today = new Date();
        const currentDay = today.getDate(); // Get the current day of the month
        const startOfWeek = today.getDate() - today.getDay(); // Sunday is the first day of the week
        const weekDays = [];

        for (let i = 0; i < 7; i++) {
            const day = new Date(today.getFullYear(), today.getMonth(), startOfWeek + i);
            weekDays.push(day);
        }

        const calendarContainer = document.getElementById('weekly-calendar');
        calendarContainer.innerHTML = ''; // Clear previous calendar if any

        weekDays.forEach(day => {
            const dayElement = document.createElement('div');
            dayElement.classList.add('calendar-day'); // Add a class for each day

            // Mark today as active
            if (
                day.getFullYear() === today.getFullYear() &&
                day.getMonth() === today.getMonth() &&
                day.getDate() === today.getDate()
            ) {
                dayElement.classList.add('active-day'); // Add active class for today
            }

            const dayName = day.toLocaleString('id-ID', { weekday: 'long' }); // Get the day name in Indonesian
            const dayDate = day.getDate();

            dayElement.innerHTML = `
                <div class="day-name">${dayName}</div>
                <div class="day-date">${dayDate}</div>
            `;

            calendarContainer.appendChild(dayElement);
        });
    }

    generateWeekCalendar();

</script>
<script>
    function refreshdata2(){

    var content="";
    $.ajax({
        url:"{{ route('listabsents') }}",
        method:"GET",
        dataType:"json",
        success: function(response){
            if(response.length === 0){
                content+='<li class="list-group-item py-3 px-0 pt-0">'+
                            '<div class="d-sm-flex align-items-center justify-content-between border rounded p-3">'+
                                '<div class="d-flex align-items-center overflow-hidden me-2 ">'+
                                    '<div class=" d-flex overflow-hidden justify-content-beetwen">'+
                                       'Belum ada yang absent hari ini'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</li>'
            }else{

                for(i=0;i<response.length;i++){
                    if(response[i].status == 'ENTRY'){
                      content+= '<li class="list-group-item py-3 px-3 pt-0">'+
                            '<div class="d-sm-flex align-items-center justify-content-between border rounded p-3">'+
                                '<div class="d-flex align-items-center overflow-hidden me-2 ">'+
                                    '<div class=" d-flex overflow-hidden justify-content-beetwen">'+
                                        '<span class="avatar avatar-lg flex-shrink-0 rounded me-2">'+
                                            '<img src="{{ asset('asset/img/masuk.png') }}" alt="student">'+
                                        '</span>'+
                                        '<div class="mt-1">'
                                                if(response[i].student){
                                                    content +='<b>'+response[i].student.nama+'</b>'
                                                }else{
                                                  content += '<b>'+response[i].gtk.nama+'</b>'
                                                }
                                            content +='<p>'+response[i].time+'</p>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                                '<span class="badge badge-soft-success mt-2 mt-sm-0">Masuk</span>'+
                            '</div>'+
                        '</li>'
                    }else{
                    content+= '<li class="list-group-item py-3 px-3 pt-0">'+
                            '<div class="d-sm-flex align-items-center justify-content-between border rounded p-3">'+
                                '<div class="d-flex align-items-center overflow-hidden me-2 ">'+
                                    '<div class=" d-flex overflow-hidden justify-content-beetwen">'+
                                        '<span class="avatar avatar-lg flex-shrink-0 rounded me-2">'+
                                            '<img src="{{ asset("asset/img/pulang.png") }}" alt="student">'+
                                        '</span>'+
                                        '<div class="mt-1">'
                                            if(response[i].student){
                                                    content +='<b>'+response[i].student.nama+'</b>'
                                                }else{
                                                  content += '<b>'+response[i].gtk.nama+'</b>'
                                                }
                                            content += '<p>'+response[i].time+'</p>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                                '<span class="badge badge-soft-danger mt-2 mt-sm-0">Pulang</span>'+
                            '</div>'+
                        '</li>'
                    }
                }
            }

            $('#myData').html(content);
        }
    });
}
    setInterval(refreshdata2,2000);

</script>

<script type="text/javascript">

    $(document).ready(function () {

        /*------------------------------------------
        --------------------------------------------
        Get Site URL
        --------------------------------------------
        --------------------------------------------*/
        var SITEURL = "{{ url('/') }}";

        /*------------------------------------------
        --------------------------------------------
        CSRF Token Setup
        --------------------------------------------
        --------------------------------------------*/
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /*------------------------------------------
        --------------------------------------------
        FullCalender JS Code
        --------------------------------------------
        --------------------------------------------*/
        var calendar = $('#calendar').fullCalendar({
                        header: {
                            left: 'prev, next today',
                            center: 'title',
                            right: 'month, agendaWeek, agendaDay',
                        },

                        editable: true,
                        events: SITEURL + "/fullcalender",
                        displayEventTime: false,
                        editable: true,
                        eventRender: function (event, element, view) {
                            if (event.allDay === 'true') {
                                    event.allDay = true;
                            } else {
                                    event.allDay = false;
                            }
                        },
                        selectable: true,
                        selectHelper: true,
                        select: function (start, end, allDay) {
                            var title = prompt('Event Title:');
                            if (title) {
                                var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
                                var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
                                $.ajax({
                                    url: SITEURL + "/fullcalenderAjax",
                                    data: {
                                        title: title,
                                        start: start,
                                        end: end,
                                        type: 'add'
                                    },
                                    type: "POST",
                                    success: function (data) {
                                        displayMessage("Event Created Successfully");

                                        calendar.fullCalendar('renderEvent',
                                            {
                                                id: data.id,
                                                title: title,
                                                start: start,
                                                end: end,
                                                allDay: allDay
                                            },true);

                                        calendar.fullCalendar('unselect');
                                    }
                                });
                            }
                        },
                        eventDrop: function (event, delta) {
                            var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                            var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");

                            $.ajax({
                                url: SITEURL + '/fullcalenderAjax',
                                data: {
                                    title: event.title,
                                    start: start,
                                    end: end,
                                    id: event.id,
                                    type: 'update'
                                },
                                type: "POST",
                                success: function (response) {
                                    displayMessage("Event Updated Successfully");
                                }
                            });
                        },
                        eventClick: function (event) {
                            var deleteMsg = confirm("Do you really want to delete?");
                            if (deleteMsg) {
                                $.ajax({
                                    type: "POST",
                                    url: SITEURL + '/fullcalenderAjax',
                                    data: {
                                            id: event.id,
                                            type: 'delete'
                                    },
                                    success: function (response) {
                                        calendar.fullCalendar('removeEvents', event.id);
                                        displayMessage("Event Deleted Successfully");
                                    }
                                });
                            }
                        }

                    });

        });

        /*------------------------------------------
        --------------------------------------------
        Toastr Success Code
        --------------------------------------------
        --------------------------------------------*/
        function displayMessage(message) {
            toastr.success(message, 'Event');
        }

    </script>

@endsection
@endsection
