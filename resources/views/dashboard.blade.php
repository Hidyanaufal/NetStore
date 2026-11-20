
@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-heading', 'Dashboard Analitik')

@push('styles')
<style>
    .welcome-section {
        margin-bottom: 24px;
    }

    .stat-card {
        background: #fff;
        border: none;
        border-radius: 14px;
        padding: 25px;
        height: 100%;
        box-shadow: 0 3px 12px rgba(0,0,0,.04);
    }

    .stat-card .stat-title {
        color: #64748b;
        font-size: 15px;
        margin-bottom: 12px;
    }

    .stat-card .stat-number {
        font-size: 29px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .stat-card .stat-description {
        font-size: 14px;
        color: #16a34a;
        margin: 0;
    }

    .stat-icon {
        font-size: 36px;
    }

    .chart-card {
        background: #fff;
        border: none;
        border-radius: 14px;
        padding: 25px;
        height: 100%;
        box-shadow: 0 3px 12px rgba(0,0,0,.04);
    }

    .chart-title {
        font-size: 19px;
        font-weight: 700;
        margin-bottom: 25px;
        color: #1e293b;
    }

    .chart-container {
        position: relative;
        height: 300px;
    }

    .table-card {
        background: #fff;
        border: none;
        border-radius: 14px;
        padding: 25px;
        box-shadow: 0 3px 12px rgba(0,0,0,.04);
    }

    .empty-message {
        text-align: center;
        color: #94a3b8;
        padding: 25px;
    }
</style>
@endpush

@section('content')

<div class="container-fluid px-0">

    {{-- SELAMAT DATANG --}}
    <div class="welcome-section">
        <h4 class="fw-bold mb-2">
            Selamat Datang di NETSTORE 👋
        </h4>

        <p class="text-muted mb-0">
            Berikut ringkasan aktivitas penjualan kartu internet.
        </p>
    </div>

    {{-- STATISTIK --}}
    <div class="row g-4 mb-4">

        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="stat-title">Total Produk</div>
                        <div class="stat-number">
                            {{ number_format($totalProducts) }}
                        </div>
                        <p class="stat-description">Produk tersedia</p>
                    </div>
                    <div class="stat-icon text-primary">
                        <i class="bi bi-phone"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="stat-title">Kategori Operator</div>
                        <div class="stat-number">
                            {{ number_format($totalCategories) }}
                        </div>
                        <p class="stat-description">Kategori terdaftar</p>
                    </div>
                    <div class="stat-icon text-info">
                        <i class="bi bi-sim"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="stat-title">Total Pelanggan</div>
                        <div class="stat-number">
                            {{ number_format($totalCustomers) }}
                        </div>
                        <p class="stat-description">Pelanggan terdaftar</p>
                    </div>
                    <div class="stat-icon text-warning">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="stat-title">Total Transaksi</div>
                        <div class="stat-number">
                            {{ number_format($totalTransactions) }}
                        </div>
                        <p class="stat-description">Transaksi tercatat</p>
                    </div>
                    <div class="stat-icon text-success">
                        <i class="bi bi-cart-check"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- PENDAPATAN DAN STOK --}}
    <div class="row g-4 mb-4">

        <div class="col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="stat-title">Total Pendapatan</div>
                        <div class="stat-number">
                            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                        </div>
                        <p class="stat-description">Dari transaksi selesai</p>
                    </div>
                    <div class="stat-icon text-success">
                        <i class="bi bi-wallet2"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="stat-title">Total Stok Produk</div>
                        <div class="stat-number">
                            {{ number_format($totalStock) }}
                        </div>
                        <p class="stat-description">Unit stok tersedia</p>
                    </div>
                    <div class="stat-icon text-primary">
                        <i class="bi bi-box-seam"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- GRAFIK PENJUALAN DAN DONUT --}}
    <div class="row g-4 mb-4">

        <div class="col-lg-8">
            <div class="chart-card">
                <h5 class="chart-title">Grafik Penjualan</h5>

                <div class="chart-container">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="chart-card">
                <h5 class="chart-title">
                    Produk Berdasarkan Operator
                </h5>

                <div class="chart-container">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>

    </div>

    {{-- GRAFIK TRANSAKSI PER OPERATOR --}}
    <div class="row g-4 mb-4">

        <div class="col-12">
            <div class="chart-card">

                <h5 class="chart-title">
                    Grafik Transaksi per Operator
                </h5>

                <p class="text-muted small">
                    Perbandingan jumlah transaksi selesai setiap operator
                    selama tahun {{ now()->year }}.
                </p>

                <div class="chart-container">
                    <canvas id="operatorMonthlyChart"></canvas>
                </div>

            </div>
        </div>

    </div>

    {{-- TRANSAKSI TERBARU DAN STOK MENIPIS --}}
    <div class="row g-4 mb-4">

        <div class="col-lg-8">
            <div class="table-card">
                <h5 class="chart-title">Transaksi Terbaru</h5>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>Kode</th>
                                <th>Pelanggan</th>
                                <th>Produk</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($recentTransactions as $transaction)
                                <tr>
                                    <td class="fw-semibold">
                                        {{ $transaction->transaction_code }}
                                    </td>

                                    <td>
                                        {{ $transaction->customer->name ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $transaction->product->name ?? '-' }}
                                    </td>

                                    <td>
                                        Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                    </td>

                                    <td>
                                        @if($transaction->status == 'completed')
                                            <span class="badge bg-success">Selesai</span>
                                        @elseif($transaction->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @else
                                            <span class="badge bg-danger">Dibatalkan</span>
                                        @endif
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="5" class="empty-message">
                                        Belum ada transaksi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        {{-- STOK MENIPIS --}}
        <div class="col-lg-4">
            <div class="table-card">
                <h5 class="chart-title">Peringatan Stok Menipis</h5>

                @forelse($lowStock as $product)
                    <div class="d-flex justify-content-between align-items-center border-bottom py-3">

                        <div>
                            <div class="fw-semibold">
                                {{ $product->name }}
                            </div>

                            <small class="text-muted">
                                {{ $product->category->name ?? '-' }}
                            </small>
                        </div>

                        <span class="badge bg-danger">
                            {{ $product->stock }} stok
                        </span>

                    </div>

                @empty
                    <div class="empty-message">
                        Semua stok produk masih aman.
                    </div>
                @endforelse

            </div>
        </div>

    </div>

</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // GRAFIK PENJUALAN
    const salesLabels = @json($salesLabels);
    const salesData = @json($salesChart);

    new Chart(document.getElementById('salesChart'), {
        type: 'line',

        data: {
            labels: salesLabels,

            datasets: [{
                label: 'Total Penjualan (Rp)',
                data: salesData,
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.12)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 4
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    position: 'top'
                },

                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' +
                                new Intl.NumberFormat('id-ID')
                                .format(context.raw);
                        }
                    }
                }
            },

            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' +
                                new Intl.NumberFormat('id-ID')
                                .format(value);
                        }
                    }
                }
            }
        }
    });


    // DONUT CHART PRODUK PER OPERATOR
    const categoryLabels = @json($categoryLabels);
    const categoryCounts = @json($categoryCounts);

    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',

        data: {
            labels: categoryLabels,

            datasets: [{
                label: 'Jumlah Produk',
                data: categoryCounts,

                backgroundColor: [
                    '#ef4444',
                    '#f97316',
                    '#2563eb',
                    '#7c3aed',
                    '#16a34a',
                    '#0891b2',
                    '#eab308'
                ],

                borderColor: '#ffffff',
                borderWidth: 2,
                hoverOffset: 8
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    position: 'bottom'
                }
            },

            cutout: '55%'
        }
    });


    // GRAFIK TRANSAKSI SETIAP OPERATOR PER BULAN
    const operatorDatasets = @json($operatorMonthlyDatasets);

    const operatorColors = [
        '#ef4444',
        '#f97316',
        '#2563eb',
        '#7c3aed',
        '#16a34a'
    ];

    new Chart(document.getElementById('operatorMonthlyChart'), {
        type: 'line',

        data: {
            labels: salesLabels,

            datasets: operatorDatasets.map((item, index) => ({
                label: item.label,
                data: item.data,

                borderColor: operatorColors[index % operatorColors.length],
                backgroundColor: operatorColors[index % operatorColors.length],

                borderWidth: 3,
                tension: 0.4,
                fill: false,

                pointRadius: 4,
                pointHoverRadius: 6
            }))
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
                    display: true,
                    position: 'bottom'
                },

                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' +
                                context.raw + ' transaksi';
                        }
                    }
                }
            },

            scales: {
                y: {
                    beginAtZero: true,

                    ticks: {
                        precision: 0,
                        stepSize: 1
                    },

                    title: {
                        display: true,
                        text: 'Jumlah Transaksi'
                    }
                },

                x: {
                    title: {
                        display: true,
                        text: 'Bulan'
                    }
                }
            }
        }
    });

});
</script>

@endpush
