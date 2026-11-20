
@extends('layouts.app')

@section('title', 'Transaksi - NETSTORE')
@section('page-heading', 'Transaksi Penjualan')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Transaksi Penjualan</h4>
        <p class="text-muted mb-0">Kelola seluruh transaksi penjualan internet.</p>
    </div>
    <a href="{{ route('transactions.create') }}" class="btn btn-primary px-4">
        <i class="bi bi-plus-lg me-2"></i>Tambah Transaksi
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="content-card">
            <p class="text-muted mb-1">Total Transaksi</p>
            <h3 class="fw-bold">{{ $transactions->total() }}</h3>
            <i class="bi bi-receipt fs-2 text-primary"></i>
        </div>
    </div>
</div>

<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">Riwayat Penjualan</h5>
            <small class="text-muted">Daftar transaksi pelanggan</small>
        </div>

        <form action="{{ route('transactions.index') }}" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control"
                    placeholder="Cari kode transaksi..."
                    value="{{ request('search') }}">
                <button class="btn btn-primary">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Kode Transaksi</th>
                    <th>Pelanggan</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                <tr>
                    <td>{{ $transactions->firstItem() + $loop->index }}</td>
                    <td class="fw-semibold">{{ $transaction->transaction_code }}</td>
                    <td>{{ $transaction->customer->name ?? '-' }}</td>
                    <td>{{ $transaction->product->name ?? '-' }}</td>
                    <td>{{ $transaction->quantity }}</td>
                    <td class="fw-semibold">
                        Rp{{ number_format($transaction->total_price, 0, ',', '.') }}
                    </td>
                    <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d/m/Y') }}</td>
                    <td>
                        @if($transaction->status == 'completed')
                            <span class="badge bg-success">Selesai</span>
                        @elseif($transaction->status == 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @else
                            <span class="badge bg-danger">Dibatalkan</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('transactions.edit', $transaction->id) }}"
                                class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <form action="{{ route('transactions.destroy', $transaction->id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-5">
                        <i class="bi bi-receipt fs-1 text-muted"></i>
                        <p class="text-muted mt-2">Belum ada transaksi penjualan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $transactions->links() }}
</div>

@endsection
