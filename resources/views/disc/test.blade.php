@extends('layouts.app')

@section('title', 'Tes Kepribadian DISC')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Tes Kepribadian DISC</h4>
                    <p class="text-muted mb-0">Jawablah 15 pertanyaan berikut dengan jujur sesuai dengan kepribadian Anda</p>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('disc.store') }}" method="POST" id="discForm">
                        @csrf

                        <div class="progress mb-4">
                            <div class="progress-bar" role="progressbar" style="width: 0%"
                                 aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="progressBar">
                                0/15 Pertanyaan
                            </div>
                        </div>

                        @foreach($questions as $index => $question)
                            <div class="question-container mb-4 p-4 border rounded" data-question="{{ $index + 1 }}">
                                <div class="row">
                                    <div class="col-md-1">
                                        <span class="badge badge-primary badge-lg">{{ $index + 1 }}</span>
                                    </div>
                                    <div class="col-md-11">
                                        <h6 class="question-category text-muted mb-2">
                                            {{ $question->category_name }}
                                        </h6>

                                        <p class="question-text mb-3">
                                            {{ $question->question }}
                                        </p>

                                        <div class="answer-options">
                                            @foreach($question->options as $optionIndex => $option)
                                                <div class="form-check form-check-inline mb-2">
                                                    <input class="form-check-input answer-radio"
                                                           type="radio"
                                                           name="answers[{{ $question->question_id }}]"
                                                           id="q{{ $question->question_id }}_{{ $optionIndex }}"
                                                           value="{{ $option }}"
                                                           data-question="{{ $index + 1 }}">
                                                    <label class="form-check-label btn btn-outline-secondary btn-sm"
                                                           for="q{{ $question->question_id }}_{{ $optionIndex }}">
                                                        {{ $option }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn" disabled>
                                <i class="fas fa-paper-plane"></i> Selesaikan Tes DISC
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.question-container {
    background-color: #f8f9fa;
    transition: all 0.3s ease;
}

.question-container.answered {
    border-color: #28a745;
    background-color: #d4edda;
}

.badge-lg {
    font-size: 1.1em;
    padding: 8px 12px;
}

.form-check-label {
    cursor: pointer;
    margin-right: 10px;
    margin-bottom: 8px;
    transition: all 0.2s ease;
}

.form-check-input:checked + .form-check-label {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
}

.form-check-label:hover {
    background-color: #e9ecef;
}

.progress-bar {
    transition: width 0.3s ease;
}

#submitBtn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const totalQuestions = {{ count($questions) }};
    let answeredQuestions = 0;

    // Update progress bar
    function updateProgress() {
        const percentage = (answeredQuestions / totalQuestions) * 100;
        const progressBar = document.getElementById('progressBar');
        const submitBtn = document.getElementById('submitBtn');

        progressBar.style.width = percentage + '%';
        progressBar.textContent = answeredQuestions + '/' + totalQuestions + ' Pertanyaan';
        progressBar.setAttribute('aria-valuenow', percentage);

        // Enable submit button only when all questions are answered
        if (answeredQuestions === totalQuestions) {
            submitBtn.disabled = false;
            submitBtn.classList.add('btn-success');
            submitBtn.classList.remove('btn-primary');
        } else {
            submitBtn.disabled = true;
            submitBtn.classList.add('btn-primary');
            submitBtn.classList.remove('btn-success');
        }
    }

    // Track answered questions
    const radioButtons = document.querySelectorAll('.answer-radio');
    const answeredQuestionNumbers = new Set();

    radioButtons.forEach(function(radio) {
        radio.addEventListener('change', function() {
            const questionNumber = this.getAttribute('data-question');
            const questionContainer = document.querySelector(`[data-question="${questionNumber}"]`);

            if (!answeredQuestionNumbers.has(questionNumber)) {
                answeredQuestionNumbers.add(questionNumber);
                answeredQuestions++;
                questionContainer.classList.add('answered');
            }

            updateProgress();
        });
    });

    // Form validation before submit
    document.getElementById('discForm').addEventListener('submit', function(e) {
        if (answeredQuestions < totalQuestions) {
            e.preventDefault();
            alert('Harap jawab semua pertanyaan sebelum mengirim.');
            return false;
        }

        // Show loading state
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
        submitBtn.disabled = true;
    });
});
</script>
@endsection
