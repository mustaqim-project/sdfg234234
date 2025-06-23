@extends('layouts.app')

@section('title', 'Tes Kesiapan Menikah')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="bg-gradient-to-r from-pink-500 to-rose-500 text-white rounded-lg p-6 mb-8">
            <h1 class="text-3xl font-bold mb-2">Tes Kesiapan Menikah</h1>
            <p class="text-pink-100">Jawab 30 pertanyaan berikut untuk mengetahui tingkat kesiapan Anda dalam menikah.</p>
            <div class="mt-4 flex items-center text-pink-100">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <span>Pilih jawaban yang paling sesuai dengan kondisi Anda saat ini</span>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-medium text-gray-700">Progress</span>
                <span class="text-sm font-medium text-gray-700" id="progress-text">0/30</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-pink-500 h-2 rounded-full transition-all duration-300" style="width: 0%" id="progress-bar"></div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('marriage-test.store') }}" method="POST" id="marriage-test-form">
            @csrf

            <div class="space-y-8">
                @foreach($questions as $index => $question)
                <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
                    <!-- Category Badge -->
                    {{-- <div class="mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                            @if($question->category_name == 'Emotional Maturity') bg-blue-100 text-blue-800
                            @elseif($question->category_name == 'Financial Readiness') bg-green-100 text-green-800
                            @else bg-purple-100 text-purple-800
                            @endif">
                            {{ $question->category_name }}
                        </span>
                    </div> --}}

                    <!-- Question -->
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        {{ $index + 1 }}. {{ $question->question }}
                    </h3>

                    <!-- Options -->
                    <div class="space-y-3">
                        @php
                            $options = json_decode($question->options, true);
                            $shufferedKeys = array_keys($options);
                            shuffle($shufferedKeys);
                        @endphp
                        @foreach($shufferedKeys as $optionKey)
                            <label class="flex items-start p-4 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 cursor-pointer transition-colors duration-200 option-label">
                                <input type="radio"
                                    name="answers[{{ $index }}]"
                                    value="{{ $optionKey }}"
                                    class="mt-1 mr-3 text-pink-500 focus:ring-pink-500"
                                    required
                                    onchange="updateProgress()">
                                <div class="flex-1">
                                    {{-- <span class="font-medium text-pink-600 mr-2">{{ $optionKey }}.</span> --}}
                                    <span class="text-gray-700">{{ $options[$optionKey] }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Submit Button -->
            <div class="mt-10 text-center">
                <button type="submit"
                        class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-pink-500 to-rose-500 text-white font-semibold rounded-lg shadow-lg hover:from-pink-600 hover:to-rose-600 transform hover:scale-105 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                        id="submit-btn"
                        disabled>
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    Selesaikan Tes
                </button>
                <p class="text-sm text-gray-500 mt-2">Pastikan semua pertanyaan telah dijawab</p>
            </div>
        </form>
    </div>
</div>


<script>
function updateProgress() {
    const totalQuestions = 30;
    const answeredQuestions = document.querySelectorAll('input[type="radio"]:checked').length;
    const percentage = (answeredQuestions / totalQuestions) * 100;

    // Update progress bar
    document.getElementById('progress-bar').style.width = percentage + '%';
    document.getElementById('progress-text').textContent = answeredQuestions + '/' + totalQuestions;

    // Enable submit button if all questions answered
    const submitBtn = document.getElementById('submit-btn');
    if (answeredQuestions === totalQuestions) {
        submitBtn.disabled = false;
        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
    } else {
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
    }
}

// Add visual feedback for selected options
document.addEventListener('DOMContentLoaded', function() {
    const radioInputs = document.querySelectorAll('input[type="radio"]');

    radioInputs.forEach(radio => {
        radio.addEventListener('change', function() {
            // Remove selected class from all options in this question
            const questionContainer = this.closest('.bg-white');
            const allLabels = questionContainer.querySelectorAll('.option-label');
            allLabels.forEach(label => {
                label.classList.remove('bg-pink-50', 'border-pink-300');
            });

            // Add selected class to chosen option
            const selectedLabel = this.closest('.option-label');
            selectedLabel.classList.add('bg-pink-50', 'border-pink-300');
        });
    });
});

// Form submission confirmation
document.getElementById('marriage-test-form').addEventListener('submit', function(e) {
    const answeredQuestions = document.querySelectorAll('input[type="radio"]:checked').length;
    if (answeredQuestions < 30) {
        e.preventDefault();
        alert('Harap jawab semua pertanyaan sebelum mengirim!');
        return false;
    }

    if (!confirm('Apakah Anda yakin ingin mengirim jawaban? Pastikan semua jawaban sudah benar.')) {
        e.preventDefault();
        return false;
    }
});
</script>

<style>
.option-label:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.option-label.selected {
    background-color: #fdf2f8;
    border-color: #f9a8d4;
}

input[type="radio"]:checked + div {
    color: #be185d;
}

@media (max-width: 768px) {
    .container {
        padding: 1rem;
    }

    .option-label {
        padding: 0.75rem;
    }
}
</style>
@endsection
