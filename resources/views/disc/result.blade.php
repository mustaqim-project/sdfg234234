@extends('layouts.app')

@section('title', 'Hasil Tes DISC')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Header Card -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-check-circle"></i> Hasil Tes DISC Anda</h4>
                </div>
                <div class="card-body text-center">
                    <h5>Tipe Kepribadian Dominan: <span class="badge badge-primary badge-lg">{{ $dominantType }}</span></h5>
                    <p class="text-muted">Berikut adalah breakdown skor kepribadian DISC Anda</p>
                </div>
            </div>

            <!-- Chart Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5><i class="fas fa-chart-bar"></i> Grafik Skor DISC</h5>
                </div>
                <div class="card-body">
                    <canvas id="discChart" width="400" height="200"></canvas>
                </div>
            </div>

            <!-- Detailed Results -->
            <div class="row">
                @php
                $discTypes = [
                    'D' => [
                        'name' => 'Dominance',
                        'color' => 'danger',
                        'icon' => 'fa-crown',
                        'description' => 'Suka mengambil kendali, langsung pada intinya, membuat keputusan sulit, dan memimpin.'
                    ],
                    'I' => [
                        'name' => 'Influence',
                        'color' => 'warning',
                        'icon' => 'fa-users',
                        'description' => 'Mudah mempengaruhi orang lain, suka bersosialisasi, motivator, dan optimis.'
                    ],
                    'S' => [
                        'name' => 'Steadiness',
                        'color' => 'success',
                        'icon' => 'fa-balance-scale',
                        'description' => 'Suka lingkungan stabil, sabar, pendengar yang baik, menghindari konflik.'
                    ],
                    'C' => [
                        'name' => 'Conscientiousness',
                        'color' => 'info',
                        'icon' => 'fa-search',
                        'description' => 'Memperhatikan detail, suka menganalisis, mengikuti prosedur dengan ketat.'
                    ]
                ];
                @endphp

                @foreach($discTypes as $key => $type)
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-{{ $type['color'] }} text-white">
                            <h6 class="mb-0">
                                <i class="fas {{ $type['icon'] }}"></i>
                                {{ $type['name'] }} ({{ $key }})
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <p class="text-muted mb-2">{{ $type['description'] }}</p>
                                    <div class="progress">
                                        <div class="progress-bar bg-{{ $type['color'] }}"
                                             role="progressbar"
                                             style="width: {{ ($discResult[$key] / 16) * 100 }}%"
                                             aria-valuenow="{{ $discResult[$key] }}"
                                             aria-valuemin="0"
                                             aria-valuemax="16">
                                        </div>
                                    </div>
                                    <small class="text-muted">{{ number_format(($discResult[$key] / 16) * 100, 1) }}%</small>
                                </div>
                                <div class="col-4 text-center">
                                    <h2 class="text-{{ $type['color'] }} mb-0">{{ $discResult[$key] }}</h2>
                                    <small class="text-muted">dari 16</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Action Buttons -->
            <div class="card">
                <div class="card-body text-center">
                    <a href="{{ route('disc.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-redo"></i> Ulangi Tes
                    </a>
                    <button onclick="printResult()" class="btn btn-outline-success">
                        <i class="fas fa-print"></i> Cetak Hasil
                    </button>
                    <button onclick="shareResult()" class="btn btn-outline-info">
                        <i class="fas fa-share"></i> Bagikan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.badge-lg {
    font-size: 1.2em;
    padding: 10px 15px;
}

.progress {
    height: 20px;
}

.card {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

@media print {
    .btn {
        display: none;
    }

    .card {
        box-shadow: none;
        border: 1px solid #dee2e6 !important;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data untuk chart
    const discData = @json($discResult);
    const ctx = document.getElementById('discChart').getContext('2d');

    // Konfigurasi chart
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Dominance (D)', 'Influence (I)', 'Steadiness (S)', 'Conscientiousness (C)'],
            datasets: [{
                label: 'Skor DISC',
                data: [discData.D, discData.I, discData.S, discData.C],
                backgroundColor: [
                    'rgba(220, 53, 69, 0.8)',   // danger
                    'rgba(255, 193, 7, 0.8)',   // warning
                    'rgba(40, 167, 69, 0.8)',   // success
                    'rgba(23, 162, 184, 0.8)'   // info
                ],
                borderColor: [
                    'rgba(220, 53, 69, 1)',
                    'rgba(255, 193, 7, 1)',
                    'rgba(40, 167, 69, 1)',
                    'rgba(23, 162, 184, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 16,
                    ticks: {
                        stepSize: 2
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const percentage = ((context.parsed.y / 16) * 100).toFixed(1);
                            return `${context.parsed.y}/16 (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
});

// Function untuk print hasil
function printResult() {
    window.print();
}

// Function untuk share hasil
function shareResult() {
    const discData = @json($discResult);
    const dominantType = '{{ $dominantType }}';

    const text = `Hasil Tes DISC saya:\n` +
                `Tipe Dominan: ${dominantType}\n` +
                `D: ${discData.D}/16, I: ${discData.I}/16, S: ${discData.S}/16, C: ${discData.C}/16`;

    if (navigator.share) {
        navigator.share({
            title: 'Hasil Tes DISC',
            text: text
        });
    } else {
        // Fallback - copy to clipboard
        navigator.clipboard.writeText(text).then(function() {
            alert('Hasil berhasil disalin ke clipboard!');
        });
    }
}
</script>
@endsection
