@extends('layouts.app')

@section('title', 'Tes MBTI - Personality Assessment')

@section('content')
    <meta http-equiv="Cache-Control" content="no-store" />



        <div class="container mx-auto px-4 py-8">
            <div class="max-w-4xl mx-auto">
                <!-- Header -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Tes Kepribadian MBTI</h1>
                    <p class="text-gray-600 mb-4">
                        Jawab semua pertanyaan dengan jujur sesuai dengan kondisi dan preferensi Anda.
                        Tidak ada jawaban yang benar atau salah.
                    </p>
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    <strong>Petunjuk:</strong> Pilih jawaban dari 1 (Sangat Tidak Setuju) hingga 5 (Sangat
                                    Setuju) yang paling menggambarkan diri Anda.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('mbti.store') }}" method="POST" id="mbtiForm">
                    @csrf

                    <!-- Progress Bar -->
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>Progress</span>
                            <span><span id="answered">0</span>/{{ App\Http\Controllers\MbtiTestController::TOTAL_QUESTIONS }}
                                pertanyaan</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-300 ease-out" style="width: 0%"
                                id="progressBar"></div>
                        </div>
                    </div>

                    <div class="space-y-8">
                        @foreach ($questions as $index => $question)
                            <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 question-container"
                                data-question="{{ $index + 1 }}">
                                <!-- Question -->
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                    {{ $index + 1 }}. {{ $question->question }}
                                </h3>

                                <!-- Options -->
                                <div class="space-y-3">
                                    @foreach ($question->randomized_options as $optionKey => $optionValue)
                                        <label
                                            class="flex items-start p-4 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 cursor-pointer transition-colors duration-200 option-label">
                                            <input type="radio" name="answers[{{ $index }}]"
                                                value="{{ $optionKey }}"
                                                class="mt-1 mr-3 text-blue-500 focus:ring-blue-500 question-radio" required
                                                data-question="{{ $index + 1 }}" onchange="updateProgress()">
                                            <div class="flex-1">
                                                <span class="text-gray-700">{{ $optionValue }}</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                @error('answers.' . $index)
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                    </div>

                    <!-- Submit Button -->
                    <div class="bg-white rounded-lg shadow-md p-6 mt-6 sticky bottom-0 z-10">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <button type="submit"
                                class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-70 disabled:cursor-not-allowed"
                                id="submitBtn" disabled>
                                <span class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Selesai & Lihat Hasil MBTI
                                </span>
                            </button>
                            <button type="button" onclick="resetForm()"
                                class="bg-gray-200 text-gray-800 py-3 px-6 rounded-lg font-semibold hover:bg-gray-300 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                Reset Jawaban
                            </button>
                        </div>
                        <p class="text-sm text-gray-500 mt-3 text-center">
                            Pastikan semua pertanyaan telah dijawab sebelum mengirim
                        </p>
                    </div>
                </form>
            </div>
        </div>

        <style>
            .option-label input:checked~div {
                background-color: #EFF6FF;
                border-color: #3B82F6;
            }

            .unanswered-question {
                animation: pulse 2s infinite;
                box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.5);
            }

            @keyframes pulse {
                0% {
                    box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4);
                }

                70% {
                    box-shadow: 0 0 0 10px rgba(239, 68, 68, 0);
                }

                100% {
                    box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
                }
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('mbtiForm');
                const submitBtn = document.getElementById('submitBtn');
                const progressBar = document.getElementById('progressBar');
                const answeredCount = document.getElementById('answered');
                const totalQuestions = {{ App\Http\Controllers\MbtiTestController::TOTAL_QUESTIONS }};
                const questionContainers = document.querySelectorAll('.question-container');

                let answeredQuestions = new Set();

                // Initialize progress
                updateProgress();

                // Handle radio button changes
                document.querySelectorAll('.question-radio').forEach(input => {
                    input.addEventListener('change', function() {
                        const questionId = this.getAttribute('data-question');
                        answeredQuestions.add(questionId);
                        updateProgress();

                        // Remove error highlight
                        const questionContainer = this.closest('.question-container');
                        questionContainer.classList.remove('border-red-500', 'bg-red-50');
                    });
                });

                function updateProgress() {
                    const answered = answeredQuestions.size;
                    const percentage = Math.round((answered / totalQuestions) * 100);

                    progressBar.style.width = percentage + '%';
                    answeredCount.textContent = answered;

                    // Smooth transition for progress bar
                    progressBar.style.transition = 'width 0.5s ease-out';

                    // Enable submit button when all questions are answered
                    submitBtn.disabled = answered !== totalQuestions;

                    // Highlight unanswered questions when trying to submit
                    if (submitBtn.disabled) {
                        highlightUnansweredQuestions();
                    }
                }

                function highlightUnansweredQuestions() {
                    questionContainers.forEach(container => {
                        const questionId = container.getAttribute('data-question');
                        const hasAnswer = answeredQuestions.has(questionId);

                        if (!hasAnswer) {
                            container.classList.add('border-red-500', 'bg-red-50');
                        } else {
                            container.classList.remove('border-red-500', 'bg-red-50');
                        }
                    });
                }

                // Form submission validation
                form.addEventListener('submit', function(e) {
                    if (answeredQuestions.size < totalQuestions) {
                        e.preventDefault();

                        // Scroll to first unanswered question
                        const firstUnanswered = document.querySelector(
                            '.question-container:not(.border-red-500)');
                        if (firstUnanswered) {
                            firstUnanswered.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                            firstUnanswered.classList.add('unanswered-question');
                            setTimeout(() => {
                                firstUnanswered.classList.remove('unanswered-question');
                            }, 3000);
                        }

                        showAlert('Mohon lengkapi semua pertanyaan!',
                            `Anda belum menjawab ${totalQuestions - answeredQuestions.size} pertanyaan.`,
                            'error');
                    } else {
                        // Show loading state
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = `
                        <span class="flex items-center justify-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Memproses Hasil...
                        </span>
                    `;
                    }
                });

                function showAlert(title, message, type) {
                    const alert = document.createElement('div');
                    alert.className = `fixed top-4 left-1/2 transform -translate-x-1/2 ${
                    type === 'error' ? 'bg-red-100 border-red-500 text-red-700' : 'bg-green-100 border-green-500 text-green-700'
                } border-l-4 p-4 rounded shadow-lg z-50 flex items-start max-w-md`;
                    alert.innerHTML = `
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="font-medium">${title}</p>
                        <p class="text-sm">${message}</p>
                    </div>
                `;
                    document.body.appendChild(alert);
                    setTimeout(() => {
                        alert.classList.add('opacity-0', 'transition-opacity', 'duration-300');
                        setTimeout(() => alert.remove(), 300);
                    }, 4000);
                }

                // Initialize answered questions from session if any
                @if (old('answers'))
                    @foreach (old('answers') as $index => $answer)
                        @if ($answer)
                            answeredQuestions.add('{{ $index + 1 }}');
                            const radio = document.querySelector(
                                `input[name="answers[{{ $index }}]"][value="{{ $answer }}"]`);
                            if (radio) radio.checked = true;
                        @endif
                    @endforeach
                    updateProgress();
                @endif
            });

            function resetForm() {
                if (confirm('Apakah Anda yakin ingin mengatur ulang semua jawaban?')) {
                    document.getElementById('mbtiForm').reset();
                    document.getElementById('progressBar').style.width = '0%';
                    document.getElementById('answered').textContent = '0';
                    document.getElementById('submitBtn').disabled = true;

                    // Reset answered questions tracking
                    answeredQuestions = new Set();

                    // Remove all highlights
                    document.querySelectorAll('.question-container').forEach(container => {
                        container.classList.remove('border-red-500', 'bg-red-50', 'unanswered-question');
                    });

                    // Scroll to top
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            }
        </script>

@endsection
