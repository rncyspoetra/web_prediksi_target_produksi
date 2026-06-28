@extends('adminlte::page')
@section('title', 'Proses Prediksi Regresi')
@vite('resources/views/proses-prediksi/style.css')

@section('content')
    <div class="page-shell">

        {{-- ── Page Header ── --}}
        <div class="page-header">
            <div class="page-header-left">
                <h1>Prediksi Regresi Linear Berganda</h1>
                <p>Hitung dan evaluasi model prediksi target produksi berdasarkan data historis.</p>
            </div>
            <div>
                @if ($persamaan)
                    <form action="{{ route('proses-prediksi.generate') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-generate btn-warning-custom">
                            <i class="fas fa-sync-alt"></i> Generate Ulang
                        </button>
                    </form>
                @else
                    <form action="{{ route('proses-prediksi.generate') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-generate btn-primary-custom">
                            <i class="fas fa-play"></i> Generate Persamaan
                        </button>
                    </form>
                @endif
            </div>
        </div>

        {{-- ── Persamaan Regresi ── --}}
        <div class="section-card">
            <div class="section-card-header">
                <h2 class="section-card-title">
                    <i class="fas fa-square-root-alt"></i>
                    Persamaan Regresi
                </h2>
            </div>
            <div class="section-card-body">
                @if ($persamaan)
                    <div class="coeff-grid">
                        <div class="coeff-tile c-blue">
                            <div class="coeff-label">Intercept (a)</div>
                            <div class="coeff-value">{{ number_format($persamaan->intercept, 4) }}</div>
                        </div>
                        <div class="coeff-tile c-green">
                            <div class="coeff-label">Beta X₁ — Total Tenaga</div>
                            <div class="coeff-value">{{ number_format($persamaan->beta1, 4) }}</div>
                        </div>
                        <div class="coeff-tile c-amber">
                            <div class="coeff-label">Beta X₂ — Tenaga Produktif</div>
                            <div class="coeff-value">{{ number_format($persamaan->beta2, 4) }}</div>
                        </div>
                        <div class="coeff-tile c-red">
                            <div class="coeff-label">Beta X₃ — Jam Kerja</div>
                            <div class="coeff-value">{{ number_format($persamaan->beta3, 4) }}</div>
                        </div>
                    </div>

                    <div class="equation-block">
                        <div class="eq-label">Persamaan Model</div>
                        <div class="eq-formula">
                            Y = {{ number_format($persamaan->intercept, 4) }}
                            + ({{ number_format($persamaan->beta1, 4) }}) X₁
                            + ({{ number_format($persamaan->beta2, 4) }}) X₂
                            + ({{ number_format($persamaan->beta3, 4) }}) X₃
                        </div>
                        <div class="eq-vars">
                            <span class="eq-var-item">X₁ = Total Tenaga</span>
                            <span class="eq-var-item">X₂ = Tenaga Produktif</span>
                            <span class="eq-var-item">X₃ = Jam Kerja</span>
                        </div>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-function"></i>
                        <h5>Belum ada persamaan regresi</h5>
                        <p>Klik <strong>Generate Persamaan</strong> untuk menghitung model regresi linear berganda.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- ── Evaluasi MAPE ── --}}
        <div class="section-card">
            <div class="section-card-header">
                <h2 class="section-card-title">
                    <i class="fas fa-chart-pie"></i>
                    Evaluasi Model — MAPE
                </h2>
            </div>
            <div class="section-card-body">
                @if ($persamaan)
                    <div class="mape-grid">
                        <div class="mape-stat">
                            <div class="mape-number">{{ number_format($mape, 2) }}<span
                                    style="font-size:1rem;font-weight:500;color:var(--ink-3)">%</span></div>
                            <div class="mape-sub">Nilai MAPE</div>
                        </div>
                        <div
                            class="mape-interpretation
                        @if ($mape <= 10) success
                        @elseif ($mape <= 20) info
                        @elseif ($mape <= 50) warning
                        @else danger @endif">
                            @if ($mape <= 10)
                                <div class="interp-badge">Sangat Baik</div>
                                <p>Model memiliki tingkat akurasi yang sangat tinggi, cocok digunakan untuk prediksi.</p>
                            @elseif ($mape <= 20)
                                <div class="interp-badge">Baik</div>
                                <p>Model cukup akurat dan dapat digunakan untuk prediksi produksi.</p>
                            @elseif ($mape <= 50)
                                <div class="interp-badge">Cukup</div>
                                <p>Model masih dapat digunakan, namun disarankan untuk melakukan evaluasi lebih lanjut.</p>
                            @else
                                <div class="interp-badge">Kurang Baik</div>
                                <p>Akurasi model rendah. Pertimbangkan untuk melatih ulang dengan data yang lebih
                                    representatif.</p>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-chart-pie"></i>
                        <h5>Belum ada nilai MAPE</h5>
                        <p>Generate persamaan terlebih dahulu untuk melihat evaluasi model.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- ── Grafik ── --}}
        <div class="section-card">
            <div class="section-card-header">
                <h2 class="section-card-title">
                    <i class="fas fa-chart-line"></i>
                    Target Produksi vs Hasil Prediksi
                </h2>
            </div>
            <div class="section-card-body">
                @if ($prediksi->count())
                    {{-- Custom legend --}}
                    <div style="display:flex;gap:1.25rem;margin-bottom:1rem;font-size:0.78rem;color:var(--ink-3);">
                        <span style="display:flex;align-items:center;gap:6px;">
                            <span
                                style="width:10px;height:10px;border-radius:2px;background:#2d5be3;display:inline-block;"></span>
                            Target Produksi
                        </span>
                        <span style="display:flex;align-items:center;gap:6px;">
                            <span
                                style="width:10px;height:10px;border-radius:2px;background:#0f8c4a;display:inline-block;"></span>
                            Hasil Prediksi
                        </span>
                    </div>
                    <div class="chart-wrap">
                        <canvas id="chartPrediksi" role="img"
                            aria-label="Grafik perbandingan target produksi dan hasil prediksi model regresi.">
                        </canvas>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-chart-line"></i>
                        <h5>Belum ada data prediksi</h5>
                        <p>Generate persamaan untuk melihat grafik perbandingan.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- ── Tabel Hasil Prediksi ── --}}
        <div class="section-card">
            <div class="section-card-header">
                <h2 class="section-card-title">
                    <i class="fas fa-table"></i>
                    Hasil Prediksi
                </h2>
                @if ($prediksi->count())
                    <a href="{{ route('proses-prediksi.export') }}" class="btn-export">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                @endif
            </div>
            <div class="section-card-body" style="padding:0;">
                <div class="data-table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width:48px;">No</th>
                                <th>Total Tenaga</th>
                                <th>Tenaga Produktif</th>
                                <th>Jam Kerja</th>
                                <th>Target Produksi</th>
                                <th>Hasil Prediksi</th>
                                <th>Error</th>
                                <th>% Error</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($prediksi as $item)
                                <tr>
                                    <td>{{ $prediksi->firstItem() + $loop->index }}</td>
                                    <td>{{ $item->dataHistoris->total_tenaga }}</td>
                                    <td>{{ $item->dataHistoris->tenaga_produktif }}</td>
                                    <td>{{ $item->dataHistoris->jam_kerja }}</td>
                                    <td>{{ number_format($item->dataHistoris->target_produksi, 0) }}</td>
                                    <td>{{ number_format($item->hasil_prediksi, 2) }}</td>
                                    <td>{{ number_format($item->nilai_error, 2) }}</td>
                                    <td>
                                        @php $error = $item->persentase_error; @endphp
                                        @if ($error <= 10)
                                            <span class="err-badge success">{{ number_format($error, 2) }}%</span>
                                        @elseif ($error <= 20)
                                            <span class="err-badge info">{{ number_format($error, 2) }}%</span>
                                        @elseif ($error <= 50)
                                            <span class="err-badge warning">{{ number_format($error, 2) }}%</span>
                                        @else
                                            <span class="err-badge danger">{{ number_format($error, 2) }}%</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="empty-state">
                                            <i class="fas fa-inbox"></i>
                                            <h5>Belum ada data</h5>
                                            <p>Generate persamaan untuk mengisi tabel prediksi.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($prediksi->count())
                    <div class="table-footer">
                        {{ $prediksi->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @if ($prediksi->count())
        <script>
            const ctx = document.getElementById('chartPrediksi');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartLabel),
                    datasets: [{
                            label: 'Target Produksi',
                            data: @json($chartAktual),
                            borderColor: '#2d5be3',
                            backgroundColor: 'rgba(45,91,227,0.07)',
                            borderWidth: 2,
                            pointRadius: 3,
                            pointBackgroundColor: '#2d5be3',
                            tension: 0.35,
                            fill: true,
                        },
                        {
                            label: 'Hasil Prediksi',
                            data: @json($chartPrediksi),
                            borderColor: '#0f8c4a',
                            backgroundColor: 'rgba(15,140,74,0.07)',
                            borderWidth: 2,
                            pointRadius: 3,
                            pointBackgroundColor: '#0f8c4a',
                            borderDash: [5, 3],
                            tension: 0.35,
                            fill: true,
                        }
                    ]
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
                            boxShadow: '0 4px 12px rgba(0,0,0,0.08)',
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
                                }
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
    @endif

    @if (session('success'))
        <script>
            Swal.fire({
                type: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                timer: 2000,
                showConfirmButton: false,
                customClass: {
                    popup: 'swal-custom'
                }
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                type: 'error',
                title: 'Gagal',
                text: "{{ session('error') }}"
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                type: 'error',
                title: 'Validasi Gagal',
                html: `{!! implode('<br>', $errors->all()) !!}`
            });
        </script>
    @endif
@endsection
