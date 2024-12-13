@extends('layout.main')
@section('container')
@section('css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

   <style>
    .fc .fc-multimonth{
        border: none;
    }

    .fc-event-main {
    color: #ffffff;
    }

    /* Make sure the loading spinner is centered */
    #loading {
        display: none; /* Initially hidden */
        position: fixed; /* Fixed to the page */
        top: 0;
        left: 0;
        width: 100vw; /* Take up the entire viewport width */
        height: 100vh; /* Take up the entire viewport height */
        justify-content: center; /* Center content horizontally */
        align-items: center; /* Center content vertically */
        background-color: rgba(0, 0, 0, 0.7); /* Optional background overlay */
        z-index: 9999; /* Ensure it appears above other content */
    }

    .spinner {
        border: 8px solid #f3f3f3; /* Light grey border */
        border-top: 8px solid #3d5ee1; /* Blue color for the top part of the spinner */
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite; /* Make it spin forever */
    }

    /* Keyframes for spinning animation */
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }


   </style>
    <!-- Include SweetAlert CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.2/dist/sweetalert2.min.css" rel="stylesheet">
<!-- Include SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.2/dist/sweetalert2.min.js"></script>
@endsection
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
        <div><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_event"> + Tambah Event / Kegiatan</button></div>
    </div>
</div>
{{-- End Header --}}

<div id='calendar'></div>
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
                    <input class="form-control" type="text" name="type"  value="event" hidden>
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

                    <div class="mb-3">
                        <label class="form-label">Warna<span class="text-danger">*</span></label>
                        <input type="color" id="colorPicker" name="warna" class="form-control"  value="{{ old('color', '#ff0000') }}">
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
<div id="loading" style="display: none;">
    <div class="spinner"></div>
</div>

<div id="no-events-message" style="display: none; text-align: center; margin-top: 20px;">
    <p>No events to display.</p>
</div>
@section('javascript')

<!-- FullCalendar 5.x JS -->
<script>
   document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var loadingEl = document.getElementById('loading');
    var noEventsEl = document.getElementById('no-events-message');  // A new div to show when there are no events

    // Show the loading indicator while fetching data
    loadingEl.style.display = 'flex';

    // Get the current year
    const currentYear = new Date().getFullYear();

    // Fetch holidays from the public API using the current year
    fetch(`https://api-harilibur.netlify.app/api?year=${currentYear}`)
        .then(response => response.json())
        .then(holidays => {
            // Filter holidays where is_national_holiday is true
            const nationalHolidays = holidays.filter(holiday => holiday.is_national_holiday === true);

            // Format the national holidays into FullCalendar events
            const holidayEvents = nationalHolidays.map(holiday => ({
                title: holiday.holiday_name,  // Holiday name
                start: holiday.holiday_date,  // Holiday date
                color: 'red',  // Default holiday color
                textColor: 'white'  // Text color for the holiday event

            }));

            // Fetch events from your Laravel backend
            fetch('/events')
                .then(response => response.json())
                .then(events => {
                    // Combine the national holiday events with backend events
                    const allEvents = [
                        ...holidayEvents,  // Add holiday events
                        ...events.map(event => ({
                            id: event.id,
                            title: event.title,  // Event title
                            start: event.start,  // Event start date
                            end: event.end,  // Event end date (optional)
                            color: event.warna || '#3d5ee1',  // Set event color from 'warna' field or use default
                            textColor: 'white',  // Text color for event
                             // Ensure each event has a unique 'id' field from the backend
                        }))
                    ];

                    // Check if there are any events; if none, show a custom "No Events" message
                    if (allEvents.length === 0) {
                        noEventsEl.style.display = 'block';
                    } else {
                        noEventsEl.style.display = 'none';
                    }

                    // Initialize FullCalendar
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'multiMonthYear',  // Set initial view to multiMonthYear
                        events: allEvents,  // Combine holiday events and backend events

                        eventDisplay: 'auto',
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'multiMonthYear,dayGridWeek,dayGridDay,dayGridMonth'
                        },
                        // Make the calendar read-only
                        editable: false,  // Disable dragging and resizing
                        droppable: false,  // Disable dragging events onto the calendar

                        eventClick: function(info) {
                            // Format the event dates in a readable way
                            const startDate = new Intl.DateTimeFormat('id-ID', {
                                day: '2-digit',
                                month: 'long',
                                year: 'numeric'
                            }).format(info.event.start);

                            const endDate = info.event.end ? new Intl.DateTimeFormat('id-ID', {
                                day: '2-digit',
                                month: 'long',
                                year: 'numeric'
                            }).format(info.event.end) : '';

                            // SweetAlert for event details with delete option
                            Swal.fire({
                                title: info.event.title,
                                text: 'Start: ' + startDate +
                                    (endDate ? '\nEnd: ' + endDate : ''),
                                icon: 'info',
                                showCancelButton: true,
                                confirmButtonText: 'Delete Event.?',
                                cancelButtonText: 'Close',
                                preConfirm: () => {
                                    // If delete is confirmed, call the delete function
                                    deleteEvent(info.event, calendar);
                                }
                            });
                        }
                    });

                    // Render the calendar
                    calendar.render();

                    // Hide the loading indicator after the calendar is rendered
                    loadingEl.style.display = 'none';
                })
                .catch(error => {
                    console.error('Error fetching backend events:', error);
                    loadingEl.style.display = 'none';  // Hide loading indicator in case of error
                });
        })
        .catch(error => {
            console.error('Error fetching holidays:', error);
            loadingEl.style.display = 'none';  // Hide loading indicator in case of error
        });
        function getCSRFToken() {
            return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        }
    // Function to handle event deletion
    function deleteEvent(event, calendar) {
        const csrfToken = getCSRFToken();
        // Send DELETE request to the backend to delete the event
        fetch(`/events/${event.id}`, {
            method: 'get',
            headers: {
                'Content-Type': 'application/json',
                'X-XSRF-TOKEN': csrfToken // Send CSRF token with the request
                // Add any necessary authentication headers
            }
        })
        .then(response => {
            console.log(response);  // Log the response to check if it's HTML or JSON
            if (!response.ok) {
                throw new Error('Server returned an error: ' + response.status);
            }
            return response.json();  // Parse JSON response
        })
        .then(data => {
            if (data.success) {
                const calendarEvent = calendar.getEventById(event.id);
                if (calendarEvent) {
                    calendarEvent.remove();
                }
                Swal.fire({
                    title: 'Event Deleted',
                    text: 'The event has been successfully deleted.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'There was an error deleting the event. ' + data.message,
                    icon: 'error',
                    confirmButtonText: 'Close'
                });
            }
        })
        .catch(error => {
            console.error('Error deleting event:', error);
            Swal.fire({
                title: 'Error',
                text: 'Failed to delete event. ' + error.message,
                icon: 'error',
                confirmButtonText: 'Close'
            });
        });
    }
});

</script>

<script>
    var body = document.body;
    body.classList.add("mini-sidebar");

</script>

</body>
</html>


@endsection
@endsection
