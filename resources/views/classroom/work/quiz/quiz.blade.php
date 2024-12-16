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
</style>
@endsection
@section('container')
<form action="{{ route('quiz.submit') }}" method="post" id="quizForm">
    @csrf
    <div class="row">
        <div class="col-md-9">
            <div class="card-body">
                <div class="list-group p-3">
                    @forelse ($questions as $index => $question)
                        <div class="list-group-item p-3">
                            {{-- <h5>Pertanyaan {{ ($questions->currentPage() - 1) * $questions->perPage() + $index + 1 }}:</h5> --}}
                            <h5>Pertanyaan {{ $index + 1 }}</h5>

                            <p class="fw-semibold">{!! $question->soal !!}</p>

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
                                    <div class="card my-2 board-hover option-card">
                                        <div class="card-body p-2 px-3 d-md-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="form-check form-check-md me-3">
                                                    <input class="form-check-input" type="radio" name="answer[{{ $question->id }}]" value="{{ $key }}"
                                                        @if(isset($studentAnswers[$question->id]) && $studentAnswers[$question->id] == $key) checked @endif>
                                                </div>
                                                <span class="bg-soft-primary text-primary avatar avatar-md me-2 br-5 flex-shrink-0">
                                                    {{ $key }}
                                                </span>
                                                <div class="mt-3">
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
                    @endforelse
                </div>
            </div>

        </div>
        <div class="col-md-3 border-start bg-white" style="min-height: 100vh;">
            <div style="position: sticky; top: 70px;">
                <div class="d-flex justify-content-center mt-3">
                    <h4>Waktu Tersisa: <span id="countdown-timer">10:00</span></h4>
                </div>
                <div class="card mt-4 pt-2 mx-3">
                    <h6 class="mb-2 d-flex justify-content-center">Pertanyaan:</h6>
                    <div class="d-flex flex-wrap justify-content-center">

                        @foreach ($questionsCount as $index => $question)
                        @php
                            // Check if the question has been answered
                            $isAnswered = isset($studentAnswers[$question->id]); // Assuming $studentAnswers contains answers keyed by question_id
                            $btnClass = $isAnswered ? 'btn-success' : 'btn-outline-light bg-white';
                        @endphp

                        <div class="me-1 mb-2">
                            <a href="{{ url('#soal' . ($index + 1)) }}"
                               class="btn {{ $btnClass }} btn-icon position-relative question-button"
                               data-id="{{ $question->id }}">
                                {{ $index + 1 }}
                            </a>
                        </div>
                    @endforeach

                    </div>
                </div>
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
                            <h6 class="text-dark text-truncate mb-0"><a>Administrator</a></h6>
                            <p>{{ auth()->user()->nomor }}</p>
                        </div>
                    </div>
                    <input type="hidden" name="student_id" value="{{ auth()->user()->nomor }}">
                    <input type="hidden" name="task_id" value="{{ $task_id }}">
                </div>
                <div class="m-3">
                    <button type="submit" class="btn btn-primary w-100" id="submitBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>

@section('javascript')

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
    document.addEventListener('DOMContentLoaded', function () {
        const countdownElement = document.getElementById('countdown-timer');
        const form = document.querySelector('form');
        const totalTime = 10 * 60; // Total time in seconds (10 minutes)
        const timerKey = 'quizTimer'; // Key to store timer in localStorage

        let timer = localStorage.getItem(timerKey)
            ? parseInt(localStorage.getItem(timerKey), 10)
            : totalTime;

        function updateTimer() {
            const minutes = Math.floor(timer / 60);
            const seconds = timer % 60;
            countdownElement.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            timer--;

            if (timer < 0) {
                clearInterval(timerInterval);
                alert('Waktu habis! Jawaban Anda akan dikirim.');
                localStorage.removeItem(timerKey); // Clear timer from localStorage
                form.submit(); // Automatically submit the form
            } else {
                localStorage.setItem(timerKey, timer); // Save remaining time to localStorage
            }
        }

        const timerInterval = setInterval(updateTimer, 1000);

        // Clear timer on form submission
        form.addEventListener('submit', function () {
            localStorage.removeItem(timerKey);
        });
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
