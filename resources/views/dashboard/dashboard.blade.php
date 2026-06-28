@extends('adminlte::page')
@section('title', 'Dashboard')
@vite('resources/views/dashboard/style.css')

@section('content')
    <div class="page-shell">

        {{-- ── Page Header ── --}}
        <div class="page-header">
            <h1>Dashboard</h1>
            <p>Ringkasan data historis dan tren target produksi.</p>
        </div>

        {{-- ── Stat Tiles ── --}}
        <div class="stat-grid">
            <div class="stat-tile t-blue">
                <div class="stat-icon"><i class="fas fa-database"></i></div>
                <div class="stat-value">{{ $totalData }}</div>
                <div class="stat-label">Total Data Historis</div>
            </div>
            <div class="stat-tile t-green">
                <div class="stat-icon"><i class="fas fa-bullseye"></i></div>
                <div class="stat-value">{{ number_format($avgTarget, 0) }}</div>
                <div class="stat-label">Rata-rata Target</div>
            </div>
            <div class="stat-tile t-amber">
                <div class="stat-icon"><i class="fas fa-clock"></i></div>
                <div class="stat-value">{{ number_format($avgJam, 1) }}</div>
                <div class="stat-label">Rata-rata Jam Kerja</div>
            </div>
            <div class="stat-tile t-red">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-value">{{ number_format($avgProduktif, 0) }}</div>
                <div class="stat-label">Rata-rata Tenaga Produktif</div>
            </div>
        </div>

        {{-- ── Chart Card ── --}}
        <div class="section-card">
            <div class="section-card-header">
                <h2 class="section-card-title">7 Data Terakhir — Target Produksi</h2>
            </div>
            <div class="section-card-body">
                <div class="chart-legend">
                    <span>
                        <span class="legend-dot" style="background:#2d5be3;"></span>
                        Target Produksi
                    </span>
                </div>
                <div class="chart-wrap">
                    <canvas id="lineChart" role="img"
                        aria-label="Grafik target produksi dari 7 data historis terakhir.">
                    </canvas>
                </div>
            </div>
        </div>

    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = @json(range(1, count($chartData)));
        const data = @json($chartData->pluck('target_produksi'));

        new Chart(document.getElementById('lineChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Target Produksi',
                    data: data,
                    borderColor: '#2d5be3',
                    backgroundColor: 'rgba(45,91,227,0.07)',
                    borderWidth: 2,
                    pointRadius: 4,
                    pointBackgroundColor: '#2d5be3',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    tension: 0.35,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#ffffff',
                        borderColor: '#e3e5eb',
                        borderWidth: 1,
                        titleColor: '#0f1117',
                        bodyColor: '#4a4d5a',
                        padding: 10,
                        callbacks: {
                            title: ctx => 'Data ke-' + ctx[0].label,
                            label: ctx => ' Target: ' + ctx.parsed.y.toLocaleString('id-ID')
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            color: '#f0f1f4',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#8b8e9c',
                            font: {
                                size: 11
                            },
                            callback: v => 'Data ' + (v + 1)
                        }
                    },
                    y: {
                        beginAtZero: false,
                        grid: {
                            color: '#f0f1f4',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#8b8e9c',
                            font: {
                                size: 11
                            },
                            callback: v => v.toLocaleString('id-ID')
                        }
                    }
                }
            }
        });
    </script>
@endsection
