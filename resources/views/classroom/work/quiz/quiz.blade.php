@extends('layout.main')
@section('css')
<style>
    .page-wrapper .content{
        background-color: #f1f1f1;
    }
    #countdown-timer {
    font-size: 1.5rem;
    font-weight: bold;
    color: red;
    }
    .option-card.active {
    border: 2px solid #007bff;
    box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
}
.question-box {
    width: 50px; /* Lebar kotak */
    height: 50px; /* Tinggi kotak */
    display: flex;
    justify-content: center; /* Posisikan konten di tengah horizontal */
    align-items: center; /* Posisikan konten di tengah vertikal */
    margin: 2px; /* Margin antar kotak */
}

.question-button {
    width: 100%; /* Tombol mengisi lebar penuh kotak */
    height: 100%; /* Tombol mengisi tinggi penuh kotak */
    display: flex; /* Flexbox untuk tombol */
    justify-content: center; /* Tengah horizontal */
    align-items: center; /* Tengah vertikal */
    border-radius: 8px; /* Membuat sudut membulat */
    font-weight: bold; /* Mempertegas teks */
    font-size: 14px; /* Ukuran font */
    padding: 0; /* Hilangkan padding default */
    line-height: 1; /* Atur line-height agar teks tidak melebar */
}


@media (max-width: 768px) {
    .question-box {
        width: 40px; /* Atur ulang lebar kotak untuk layar kecil */
        height: 40px;
    }
}
    html .darkmode .a,
    html[data-theme=dark] .a {
    background: #0f0c1c;
    border-bottom-color: #eeeeee
    }
    .a{
        background-color: #e7e7e7;
        height: 100%;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
@section('container')

    <div class="row">
        <div class="col-md-9">
            <form action="{{ route('quiz.submit') }}" method="post" id="quizForm">
                @csrf
            <div class="card-body p-4 a" >
                <div class="list-group p-3">

                    @forelse ($questions as $index => $question)

                        <div class="list-group-item p-3" >
                            {{-- <h5>Pertanyaan {{ ($questions->currentPage() - 1) * $questions->perPage() + $index + 1 }}:</h5> --}}
                            <h5 class="mb-2"  id="soal{{ $index+1 }}">Pertanyaan {{ $index + 1 }}</h5>

                            <p class="fs-17">{!! $question->soal !!}</p>

                            <!-- Hidden input to store question ID -->
                            <input type="hidden" name="question_id[]" value="{{ $question->id }}">

                            @php
                                $options = [
                                    'A' => $question->pilihan_a,
                                    'B' => $question->pilihan_b,
                                    'C' => $question->pilihan_c,
                                    'D' => $question->pilihan_d,
                                    'E' => $question->pilihan_e,
                                ];
                            @endphp

                            @foreach ($options as $key => $option)

                                @if ($option)
                                    <div class="card my-2 board-hover option-card" >
                                        <div class="card-body p-2 px-3 d-md-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="form-check form-check-md me-3">
                                                    <input class="form-check-input" type="radio" name="answer[{{ $question->id }}]" value="{{ $key }}"
                                                        @if(isset($studentAnswers[$question->id]) && $studentAnswers[$question->id] == $key) checked @endif>
                                                </div>
                                                <span class="bg-soft-primary text-primary avatar avatar-md me-2 br-5 flex-shrink-0">
                                                    {{ $key }}
                                                </span>
                                                <div class="mt-1">
                                                    <p class="mb-0">{!! $option !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @empty
                        <div class="list-group-item text-center">
                            <p>No questions available.</p>
                        </div>
                        <script>

                            Swal.fire({
                                icon: 'info',
                                title: 'No Questions',
                                text: 'There are no questions available at the moment.',
                                confirmButtonText: 'Go Back'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.history.back(); // Redirect back
                                }
                            });
                        </script>
                    @endforelse
                </div>
                <input type="hidden" name="student_id" value="{{ auth()->user()->nomor }}">
                <input type="hidden" name="task_id" value="{{ $task_id }}">
            </div>
            </form>
        </div>
        <div class="col-md-3  bg-white" style="min-height: 100vh;">
            <div style="position: sticky; top: 70px;">
                <div class="d-flex justify-content-center mt-3">
                    <h4>Waktu Tersisa: <span id="countdown-timer">{{ $time }}:00</span></h4>
                </div>
                <div class="card mt-4 pt-2 mx-3 ">
                    <h6 class="mb-2 d-flex justify-content-center">Pertanyaan:</h6>
                    <div class="d-flex flex-wrap justify-content-center"  style="overflow-y: auto; max-height: 400px;">
                        @foreach ($questions as $index => $question)
                            @php
                                // Check if the question has been answered
                                $isAnswered = isset($studentAnswers[$question->id]); // Assuming $studentAnswers contains answers keyed by question_id
                                $btnClass = $isAnswered ? 'btn-success' : 'btn-outline-light bg-white';
                            @endphp

                            <div class="question-box m-1">
                                <a href="{{ url('#soal' . ($index + 1)) }}"
                                   class="btn btn-sm {{ $btnClass }} position-relative question-button "
                                   data-id="{{ $question->id }}">
                                    {{ $index + 1 }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <form action="{{ route('quiz.finish') }}" method="POST" id="finish" >
                    @csrf
                    <div hidden>
                        <input type="text" name="finish_time" id="finish_time">
                        <input type="text" name="status" value="1">
                        <input type="text" name="student_id" value="{{ auth()->user()->nomor }}">
                        <input type="text" name="task_id" value="{{ $task_id }}">
                    </div>
                    <div class="m-3">
                        <button type="submit" class="btn btn-primary w-100" id="submitBtn">Submit</button>
                    </div>
                </form>

                <div class="alert alert-primary overflow-hidden p-0 m-3" role="alert">
                    <div class="p-3 bg-primary text-fixed-white d-flex justify-content-between">
                        <h3 class="alert-heading mb-0 text-fixed-white">Quiz Matematika</h3>
                    </div>
                    <div class="p-3">
                        <p>Disarankan untuk tidak keluar dari halaman ini sebelum di submit, karena waktu akan terus berlanjut sebelum waktu habis.</p>
                    </div>
                </div>
                <div class="bg-light-400 rounded-2 p-3 mb-3 border m-3">
                    <div class="d-flex align-items-center">
                        <a class="avatar avatar-lg flex-shrink-0"><img src="{{ asset('asset/img/user-default.jpg') }}" class="img-fluid rounded-circle" alt="img"></a>
                        <div class="ms-2">
                            <h6 class="text-dark text-truncate mb-0"><a>{{ auth()->user()->nama }}</a></h6>
                            <p>{{ auth()->user()->nomor }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>



<!-- Modal HTML Structure -->
<div class="modal fade" id="startModal" tabindex="-1" aria-labelledby="startModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="startModalLabel">Quiz Starting</h5>
        </div>
        <div class="modal-body ">
            <div class="p-5">
                <center><h3>Are you ready to start the quiz?</h3></center>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary w-100" id="startQuizButton">Start Quiz</button>
        </div>
      </div>
    </div>
</div>



@section('javascript')
<script>
    // Add event listener to the submit button
    document.getElementById('submitBtn').addEventListener('click', function() {
        // Show SweetAlert2 confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to submit your answers?',
            icon: 'warning',
            showCancelButton: true, // Show Cancel button
            confirmButtonText: 'Yes, submit it!',
            cancelButtonText: 'No, go back',
            reverseButtons: true
        }).then((result) => {
            // If the user clicked 'Yes, submit it!'
            if (result.isConfirmed) {
                // You can submit the form here
                document.getElementById('finish').submit(); // Replace 'quizForm' with the actual form id if different
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
    // Listen for changes in answers
    document.querySelectorAll('.form-check-input').forEach(input => {
        input.addEventListener('change', (event) => {
            const questionId = event.target.closest('.list-group-item').querySelector('input[name="question_id[]"]').value;

            // Find the corresponding button
            const button = document.querySelector(`.question-button[data-id="${questionId}"]`);

            if (button) {
                // Update the button class to indicate the question has been answered
                button.classList.remove('btn-outline-light', 'bg-white');
                button.classList.add('btn-success');
            }
        });
    });
});

</script>
{{-- action form --}}
<script>
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            var form = document.getElementById('quizForm');
            var formData = new FormData(form);

            // Start the AJAX request to submit the form
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => response.json())  // Parse the JSON response from the server
            .then(data => {
                // Handle response
                if (data.status === 'success') {
                    // You can handle success here without Toastr
                    console.log(data.message);  // For example, log to console
                } else {
                    console.log(data.message);  // Log error to console if needed
                }
            })
            .catch(error => {
                console.error('Error submitting form:', error);  // Handle any errors
            });
        });
    });
</script>
{{-- count time --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if quiz status is 1, prevent navigation out
        const quizStatus = {{ $studentScore->status ?? 0 }}; // Default to 0 if null or undefined
        const quizTimer = {{ $task_id }};
        if (quizStatus === 0) {
            window.onbeforeunload = function() {
                alert( "Anda tidak bisa keluar dari halaman ini selama ujian berlangsung.");
            };
        }

        // Modal will show before quiz starts
        $('#startModal').modal('show');
        // Start the quiz and begin timer when "Mulai" button is clicked
        document.getElementById('startQuizButton').addEventListener('click', function() {
            $('#startModal').modal('hide');
            startQuizTimer();  // Start the countdown timer
            // window.onbeforeunload = null;  // Allow page leave after quiz starts
        });

        // Start countdown timer after user clicks "Mulai"
        function startQuizTimer() {
            const countdownElement = document.getElementById('countdown-timer');
            const totalTime = {{ $time }} * 60;  // in seconds

            // Get the remaining time from localStorage if it exists
            let timer = localStorage.getItem(quizTimer) ? parseInt(localStorage.getItem(quizTimer)) : totalTime;
            const finishtime = document.getElementById('finish_time');
            const timerInterval = setInterval(function() {
                const minutes = Math.floor(timer / 60);
                const seconds = timer % 60;
                countdownElement.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                finishtime.value = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                timer--;

                // Save remaining time to localStorage
                localStorage.setItem(quizTimer, timer);

                if (timer < 0) {
                    clearInterval(timerInterval);
                    Swal.fire({
                        title: 'Waktu Habis!',
                        text: 'Jawaban Anda akan dikirim secara otomatis.',
                        icon: 'warning',
                        showConfirmButton: false,
                        timer: 10000 // Show alert for 3 seconds
                    }).then(() => {
                        submitQuiz();
                    });
                }
            }, 10000);
        }

        // If the page is reloaded, use the stored timer value
        if (localStorage.getItem(quizTimer)) {
            startQuizTimer();
        }

        // Function to submit the quiz, clear localStorage, and log out the user
        function submitQuiz() {
            // Show SweetAlert message
            Swal.fire({
                title: 'Terima Kasih!',
                text: 'Telah Mengikuti Ujian/Kuis ini',
                icon: 'success',
                confirmButtonText: 'OK',
                showConfirmButton: true
            }).then(() => {
                // Wait for 3 seconds before submitting the form
                setTimeout(function() {
                    // Submit the form (replace 'finish' with the actual form id if different)
                    document.getElementById('finish').submit();
                    // Clear the timer data from localStorage when submitting the quiz
                    localStorage.removeItem('quizTimer');
                }, 3000); // 3000ms = 3 seconds delay
            });
        }
    });
</script>

<script>
      var elements = document.querySelectorAll('.blank-page');

    // Loop through the elements and remove the class from each
    elements.forEach(function(element) {
    element.classList.remove('blank-page');
    element.classList.remove('content');
    });
</script>
@endsection
@endsection
