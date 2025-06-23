@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Hasil Tes MBTI Anda</h3>
                </div>

                <div class="card-body">
                    @if(isset($mbtiResult))
                        <div class="text-center mb-4">
                            <div class="mbti-badge mb-3">
                                <span class="badge bg-info text-dark display-4 py-3 px-4 rounded-pill">{{ $mbtiResult }}</span>
                            </div>
                            <h2 class="text-primary">{{ $mbtiDescription['title'] }}</h2>
                        </div>

                        <div class="mbti-description bg-light p-4 rounded mb-4">
                            <p class="lead">{{ $mbtiDescription['description'] }}</p>
                        </div>

                        <div class="mbti-dimensions mb-4">
                            <h4 class="text-center mb-3">Penjelasan Dimensi MBTI Anda</h4>
                            <div class="row">
                                @php
                                    $dimensions = [
                                        substr($mbtiResult, 0, 1) => [
                                            'E' => 'Ekstrovert (E) - Berenergi dari interaksi sosial',
                                            'I' => 'Introvert (I) - Berenergi dari waktu menyendiri'
                                        ],
                                        substr($mbtiResult, 1, 1) => [
                                            'S' => 'Sensing (S) - Fokus pada fakta dan detail konkret',
                                            'N' => 'Intuition (N) - Fokus pada pola dan kemungkinan'
                                        ],
                                        substr($mbtiResult, 2, 1) => [
                                            'T' => 'Thinking (T) - Membuat keputusan berdasarkan logika',
                                            'F' => 'Feeling (F) - Membuat keputusan berdasarkan nilai dan empati'
                                        ],
                                        substr($mbtiResult, 3, 1) => [
                                            'J' => 'Judging (J) - Terstruktur dan suka perencanaan',
                                            'P' => 'Perceiving (P) - Fleksibel dan spontan'
                                        ]
                                    ];
                                @endphp

                                @foreach($dimensions as $key => $dimension)
                                    <div class="col-md-6 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $key }} - {{ explode(')', $dimension[$key])[0] }})</h5>
                                                <p class="card-text">{{ substr(explode(')', $dimension[$key])[1], 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('mbti.index') }}" class="btn btn-outline-primary me-2">Ulangi Tes</a>
                            <button class="btn btn-primary" onclick="window.print()">Cetak Hasil</button>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <p>Anda belum mengikuti tes MBTI. Silakan ikuti tes terlebih dahulu.</p>
                            <a href="{{ route('mbti.index') }}" class="btn btn-warning">Ambil Tes MBTI</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .mbti-badge {
        font-family: 'Arial', sans-serif;
        font-weight: bold;
        letter-spacing: 2px;
    }

    .mbti-description {
        border-left: 5px solid var(--bs-primary);
    }

    @media print {
        .card-header, .btn {
            display: none;
        }

        body {
            background: white !important;
            color: black !important;
        }

        .card {
            border: none;
            box-shadow: none;
        }
    }
</style>
@endsection
