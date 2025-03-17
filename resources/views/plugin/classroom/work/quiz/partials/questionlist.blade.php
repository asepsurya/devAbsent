<form action="{{ route('quiz.submit') }}" method="post" id="quizForm">
    @csrf
    <div class="row">
        <div class="col-md-9">
            <div class="card-body">
                <div class="list-group p-3">
                    @forelse ($questions as $index => $question)
                        <div class="list-group-item p-3">
                            <h5>Pertanyaan {{ ($questions->currentPage() - 1) * $questions->perPage() + $index + 1 }}:</h5>

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
            <div class="d-flex justify-content-end mx-3">
                @if ($questions->hasMorePages())
                <button id="load-more" data-next-page="{{ $questions->currentPage() + 1 }}" class="btn btn-primary">
                    Load More
                </button>
                 @endif
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
