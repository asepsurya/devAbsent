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
                            <h1 class="text-white me-2">Selamat Datang, {{ auth()->user()->nama }}</h1>
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
            <h3 class="page-title mb-1">Beranda</h3>
            {{-- <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="index.html">Beranda</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Beranda</li>
                </ol>
            </nav> --}}
        </div>
    </div>
    {{-- Card --}}
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
                    <p class="mb-0">Aktif : <span class="text-dark fw-semibold">{{ $studentActive }}</span></p>
                    <span class="text-light">|</span>
                    <p>Tidak Aktif : <span class="text-dark fw-semibold">{{ $studentDeactive }}</span></p>
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
                    <p class="mb-0">Aktif : <span class="text-dark fw-semibold">{{ $studentActive }}</span></p>
                    <span class="text-light">|</span>
                    <p>Tidak Aktif : <span class="text-dark fw-semibold">{{ $gtkDeactive }}</span></p>
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
                    <p class="mb-0">Aktif : <span class="text-dark fw-semibold">{{ $rombelActive }}</span></p>
                    <span class="text-light">|</span>
                    <p>Tidak Aktif : <span class="text-dark fw-semibold">{{ $rombelDeactive }}</span></p>
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
                    <p class="mb-0">Aktif : <span class="text-dark fw-semibold">{{ $kelasActive }}</span></p>
                    <span class="text-light">|</span>
                    <p>Tidak Aktif : <span class="text-dark fw-semibold">{{ $kelasDeactive }}</span></p>
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
                            <h2 class="counter">82</h2>
                            {{-- <span class="badge bg-success">1.2%</span> --}}
                        </div>
                        <p>Absen Masuk</p>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between border-top mt-3 pt-3">
                    <p class="mb-0">Sudah : <span class="text-dark fw-semibold">81</span></p>
                    <span class="text-light">|</span>
                    <p>Belum : <span class="text-dark fw-semibold">01</span></p>
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
                            <h2 class="counter">82</h2>
                            {{-- <span class="badge bg-success">1.2%</span> --}}
                        </div>
                        <p>Absen Pulang</p>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between border-top mt-3 pt-3">
                    <p class="mb-0">Sudah : <span class="text-dark fw-semibold">81</span></p>
                    <span class="text-light">|</span>
                    <p>Belum : <span class="text-dark fw-semibold">01</span></p>
                </div>
            </div>
        </div>
    </div>
    {{-- End Card --}}

    <div class="row ">
        {{-- Rombongan Belajar --}}
        <div class="col-xxl-4 col-xl-6 d-flex">
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
                                <h5>{{ $item->jmlRombel->count() }}</h5>
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
        <div class="col-xxl-4 col-xl-6 d-flex">
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
        <div class="col-xxl-4 col-xxl-4 ">
            <div class="card flex-fill">
                <div class="card-header  d-flex align-items-center justify-content-between">
                    <h4 class="card-title">Papan Pengumuman</h4>
                    <a href="https://preskool.dreamstechnologies.com/html/template/notice-board.html" class="fw-medium">View All</a>
                </div>
                <div class="card-body">
                    <div class="notice-widget">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center overflow-hidden me-2 mb-2 mb-sm-0">
                                <span class="bg-primary-transparent avatar avatar-md me-2 rounded-circle flex-shrink-0">
                                    <i class="ti ti-books fs-16"></i>
                                </span>
                                <div class="overflow-hidden">
                                    <h6 class="text-truncate mb-1">New Syllabus Instructions</h6>
                                    <p><i class="ti ti-calendar me-2"></i>Added on : 11 Mar 2024</p>
                                </div>
                            </div>
                            <span class="badge bg-light text-dark"><i class="ti ti-clck me-1"></i>20
                                Days</span>
                        </div>
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center overflow-hidden me-2 mb-2 mb-sm-0">
                                <span class="bg-success-transparent avatar avatar-md me-2 rounded-circle flex-shrink-0">
                                    <i class="ti ti-note fs-16"></i>
                                </span>
                                <div class="overflow-hidden">
                                    <h6 class="text-truncate mb-1">World Environment Day Program.....!!!
                                    </h6>
                                    <p><i class="ti ti-calendar me-2"></i>Added on : 21 Apr 2024</p>
                                </div>
                            </div>
                            <span class="badge bg-light text-dark"><i class="ti ti-clck me-1"></i>15
                                Days</span>
                        </div>
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center overflow-hidden me-2 mb-2 mb-sm-0">
                                <span class="bg-danger-transparent avatar avatar-md me-2 rounded-circle flex-shrink-0">
                                    <i class="ti ti-bell-check fs-16"></i>
                                </span>
                                <div class="overflow-hidden">
                                    <h6 class="text-truncate mb-1">Exam Preparation Notification!</h6>
                                    <p><i class="ti ti-calendar me-2"></i>Added on : 13 Mar 2024</p>
                                </div>
                            </div>
                            <span class="badge bg-light text-dark"><i class="ti ti-clck me-1"></i>12
                                Days</span>
                        </div>
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center overflow-hidden me-2 mb-2 mb-sm-0">
                                <span class="bg-skyblue-transparent avatar avatar-md me-2 rounded-circle flex-shrink-0">
                                    <i class="ti ti-notes fs-16"></i>
                                </span>
                                <div class="overflow-hidden">
                                    <h6 class="text-truncate mb-1">Online Classes Preparation</h6>
                                    <p><i class="ti ti-calendar me-2"></i>Added on : 24 May 2024</p>
                                </div>
                            </div>
                            <span class="badge bg-light text-dark"><i class="ti ti-clck me-1"></i>02
                                Days</span>
                        </div>
                        <div class="d-sm-flex align-items-center justify-content-between mb-0">
                            <div class="d-flex align-items-center overflow-hidden me-2 mb-2 mb-sm-0">
                                <span class="bg-warning-transparent avatar avatar-md me-2 rounded-circle flex-shrink-0">
                                    <i class="ti ti-package fs-16"></i>
                                </span>
                                <div class="overflow-hidden">
                                    <h6 class="text-truncate mb-1">Exam Time Table Release</h6>
                                    <p><i class="ti ti-calendar me-2"></i>Added on : 24 May 2024</p>
                                </div>
                            </div>
                            <span class="badge bg-light text-dark"><i class="ti ti-clck me-1"></i>06
                                Days</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- End Riwayat Absen --}}
    </div>
    <div class="col ">
    {{-- Agenda Sekolah --}}
    <div class="card flex-fill ">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h4 class="card-title">Agenda Sekolah</h4>
            <div><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_event"> + Tambah Event / Kegiatan</button></div>
        </div>
        <div class="card-body">
            <div id='calendar'></div>
        </div>
    </div>
    {{-- End Agenda Sekolah --}}
    <div class="modal fade" id="add_event" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Event</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="/addEventModal" method="POST">
                    @csrf
                    <div class="modal-body pb-0">
                        <div class="mb-3">
                            <label class="form-label">Event Title <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Start<span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input class="form-control " type="date" name="start" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">End<span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input class="form-control" type="date" name="end" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-primary">Add Event</button>
                    </div>
                </form>
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
