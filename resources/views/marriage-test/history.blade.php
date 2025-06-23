@extends('layouts.app')

@section('title', 'Riwayat Tes Kesiapan Menikah')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header -->
            <div class="card shadow mb-4">
                <div class="card-header bg-info text-white">
                    <h3 class="mb-0">
                        <i class="fas fa-history"></i> Riwayat Tes Kesiapan Menikah
                    </h3>
                </div>
            </div>

            <!-- Test History Summary -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="mb-3">Hasil Tes Terakhir</h4>
                            <div class="test-summary">
                                <div class="row">
                                    <div class="col-sm-6 mb-3">
                                        <div class="info-item">
                                            <label class="text-muted">Tanggal Tes:</label>
                                            <div class="info-value">
                                                <i class="fas fa-calendar"></i>
                                                {{ date('d F Y', strtotime($result['test_date'])) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <div class="info-item">
                                            <label class="text-muted">Waktu Tes:</label>
                                            <div class="info-value">
                                                <i class="fas fa-clock"></i>
                                                {{ date('H:i', strtotime($result['test_time'])) }} WIB
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="score-display">
                                <div class="score-circle-small mb-2">
                                    <span class="score-text">{{ $result['percentage'] }}%</span>
                                </div>
                                <h5 class="text-{{ $result['level'] == 'Sangat Siap' ? 'success' : ($result['level'] == 'Siap' ? 'primary' : ($result['level'] == 'Cukup Siap' ? 'warning' : 'danger')) }}">
                                    {{ $result['level'] }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Results -->
            <div class="card shadow mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie"></i> Detail Hasil per Kategori
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($result['categories'] as $categoryId => $category)
                            <div class="col-md-4 mb-4">
                                <div class="category-card h-100">
                                    <div class="category-header">
                                        <h6 class="category-title">{{ $category['name'] }}</h6>
                                    </div>
                                    <div class="category-body text-center">
                                        <div class="progress-circle mb-3">
                                            <div class="progress-circle-inner">
                                                <span class="percentage">{{ $category['percentage'] }}%</span>
                                            </div>
                                            <svg class="progress-circle-svg" width="80" height="80">
                                                <circle
                                                    cx="40"
                                                    cy="40"
                                                    r="35"
                                                    stroke="#e9ecef"
                                                    stroke-width="6"
                                                    fill="none"
                                                />
                                                <circle
                                                    cx="40"
                                                    cy="40"
                                                    r="35"
                                                    stroke="{{ $category['percentage'] >= 70 ? '#28a745' : ($category['percentage'] >= 50 ? '#ffc107' : '#dc3545') }}"
                                                    stroke-width="6"
                                                    fill="none"
                                                    stroke-linecap="round"
                                                    stroke-dasharray="{{ 2 * pi() * 35 }}"
                                                    stroke-dashoffset="{{ 2 * pi() * 35 * (1 - $category['percentage'] / 100) }}"
                                                    transform="rotate(-90 40 40)"
                                                />
                                            </svg>
                                        </div>
                                        <div class="score-details">
                                            <small class="text-muted">
                                                {{ $category['score'] }} dari {{ $category['max_score'] }} poin
                                            </small>
                                        </div>
                                        <div class="category-status mt-2">
                                            <span class="badge badge-{{ $category['percentage'] >= 70 ? 'success' : ($category['percentage'] >= 50 ? 'warning' : 'danger') }}">
                                                @if($category['percentage'] >= 80)
                                                    Sangat Baik
                                                @elseif($category['percentage'] >= 60)
                                                    Baik
                                                @elseif($category['percentage'] >= 40)
                                                    Cukup
                                                @else
                                                    Perlu Perbaikan
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Recommendations History -->
            @if(!empty($result['recommendations']))
            <div class="card shadow mb-4">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-lightbulb"></i> Rekomendasi yang Diberikan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="recommendations-grid">
                        @foreach($result['recommendations'] as $index => $recommendation)
                            <div class="recommendation-card mb-3">
                                <div class="d-flex">
                                    <div class="recommendation-icon">
                                        <i class="fas fa-{{ $index % 4 == 0 ? 'heart' : ($index % 4 == 1 ? 'dollar-sign' : ($index % 4 == 2 ? 'comments' : 'book')) }}"></i>
                                    </div>
                                    <div class="recommendation-content">
                                        <p class="mb-0">{{ $recommendation }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="card shadow">
                <div class="card-body text-center">
                    <div class="action-buttons">
                        <a href="{{ route('marriage-test.index') }}" class="btn btn-primary btn-lg mr-3">
                            <i class="fas fa-redo"></i> Ulangi Tes
                        </a>

                        <button onclick="exportToPDF()" class="btn btn-success btn-lg mr-3">
                            <i class="fas fa-file-pdf"></i> Export PDF
                        </button>

                        <button onclick="shareResult()" class="btn btn-info btn-lg">
                            <i class="fas fa-share"></i> Bagikan Hasil
                        </button>
                    </div>

                    <div class="mt-4">
                        <small class="text-muted">
                            <i class="fas fa-shield-alt"></i>
                            Data tes Anda tersimpan dengan aman dan bersifat rahasia.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .info-item {
        margin-bottom: 15px;
    }

    .info-item label {
        font-size: 0.9em;
        font-weight: 600;
        display: block;
        margin-bottom: 5px;
    }

    .info-value {
        font-size: 1.1em;
        color: #333;
    }

    .info-value i {
        color: #6c757d;
        margin-right: 8px;
    }

    .score-circle-small {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(45deg, #007bff, #28a745);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        position: relative;
    }

    .score-circle-small::before {
        content: '';
        position: absolute;
        width: 65px;
        height: 65px;
        background: white;
        border-radius: 50%;
    }

    .score-text {
        font-size: 1.2rem;
        font-weight: bold;
        color: #333;
        position: relative;
        z-index: 1;
    }

    .category-card {
        border: 1px solid #dee2e6;
        border-radius: 10px;
        padding: 20px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        transition: transform 0.3s ease;
    }

    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .category-title {
        font-weight: 600;
        color: #495057;
        margin-bottom: 15px;
        text-align: center;
    }

    .progress-circle {
        position: relative;
        display: inline-block;
    }

    .progress-circle-inner {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1;
    }

    .percentage {
        font-size: 1rem;
        font-weight: bold;
        color: #333;
    }

    .recommendation-card {
        background: #fff3cd;
        border-left: 4px solid #ffc107;
        padding: 15px;
        border-radius: 8px;
    }

    .recommendation-icon {
        width: 40px;
        height: 40px;
        background: #ffc107;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        flex-shrink: 0;
    }

    .recommendation-icon i {
        color: white;
        font-size: 1.1em;
    }

    .recommendation-content {
        flex: 1;
        align-self: center;
    }

    .action-buttons .btn {
        margin: 5px;
    }

    @media (max-width: 768px) {
        .action-buttons .btn {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }

        .col-md-4 {
            margin-bottom: 20px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
function exportToPDF() {
    // Implementasi export ke PDF
    alert('Fitur export PDF akan segera tersedia!');
}

function shareResult() {
    if (navigator.share) {
        navigator.share({
            title: 'Hasil Tes Kesiapan Menikah',
            text: 'Saya baru saja menyelesaikan tes kesiapan menikah dengan hasil {{ $result["level"] }} ({{ $result["percentage"] }}%)',
            url: window.location.href
        });
    } else {
        // Fallback untuk browser yang tidak support Web Share API
        const textArea = document.createElement('textarea');
        textArea.value = `Hasil Tes Kesiapan Menikah: {{ $result["level"] }} ({{ $result["percentage"] }}%)`;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);

        alert('Link hasil tes telah disalin ke clipboard!');
    }
}

// Animate progress circles on page load
document.addEventListener('DOMContentLoaded', function() {
    const circles = document.querySelectorAll('.progress-circle-svg circle:last-child');

    circles.forEach(circle => {
        const dashOffset = circle.style.strokeDashoffset;
        circle.style.strokeDashoffset = circle.getAttribute('stroke-dasharray');

        setTimeout(() => {
            circle.style.transition = 'stroke-dashoffset 2s ease-in-out';
            circle.style.strokeDashoffset = dashOffset;
        }, 500);
    });
});
</script>
@endpush
@endsection
