
@extends('layouts.app')

@section('title', 'Edit Transaksi - NETSTORE')
@section('page-heading', 'Edit Transaksi')

@section('content')

<div class="mb-4">
    <a href="{{ route('transactions.index') }}" class="text-decoration-none text-muted">
        <i class="bi bi-arrow-left me-2"></i>Kembali ke Transaksi
    </a>
</div>

<div class="content-card">
    <h5 class="fw-bold mb-1">Edit Transaksi</h5>
    <p class="text-muted mb-4">Perbarui informasi transaksi penjualan.</p>

    <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label fw-semibold">Kode Transaksi</label>
                <input type="text" name="transaction_code"
                    class="form-control"
                    value="{{ old('transaction_code', $transaction->transaction_code) }}"
                    required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Tanggal Transaksi</label>
                <input type="date" name="transaction_date"
                    class="form-control"
                    value="{{ old('transaction_date', $transaction->transaction_date) }}"
                    required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Pelanggan</label>
                <select name="customer_id" class="form-select" required>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}"
                            {{ old('customer_id', $transaction->customer_id) == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Produk</label>
                <select name="product_id" id="product_id" class="form-select" required>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}"
                            data-price="{{ $product->selling_price }}"
                            data-stock="{{ $product->stock }}"
                            {{ old('product_id', $transaction->product_id) == $product->id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Jumlah Pembelian</label>
                <input type="number" name="quantity" id="quantity"
                    class="form-control"
                    value="{{ old('quantity', $transaction->quantity) }}"
                    min="1" required>
                <small id="stockInfo" class="text-muted"></small>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Harga Produk (Rp)</label>
                <input type="number" name="price" id="price"
                    class="form-control"
                    value="{{ old('price', $transaction->price) }}"
                    min="0" step="0.01" required readonly>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Total Pembayaran (Rp)</label>
                <input type="number" name="total_price" id="total_price"
                    class="form-control"
                    value="{{ old('total_price', $transaction->total_price) }}"
                    min="0" step="0.01" required readonly>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Metode Pembayaran</label>
                <select name="payment_method" class="form-select" required>
                    @foreach(['Tunai', 'Transfer', 'QRIS', 'E-Wallet'] as $method)
                        <option value="{{ $method }}"
                            {{ old('payment_method', $transaction->payment_method) == $method ? 'selected' : '' }}>
                            {{ $method }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Status Transaksi</label>
                <select name="status" class="form-select" required>
                    <option value="completed" {{ old('status', $transaction->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="pending" {{ old('status', $transaction->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="cancelled" {{ old('status', $transaction->status) == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>

        </div>

        <hr class="my-4">

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('transactions.index') }}" class="btn btn-light border">Batal</a>
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-save me-2"></i>Update Transaksi
            </button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
const productSelect = document.getElementById('product_id');
const quantityInput = document.getElementById('quantity');
const priceInput = document.getElementById('price');
const totalInput = document.getElementById('total_price');
const stockInfo = document.getElementById('stockInfo');

function calculateTotal() {
    const option = productSelect.options[productSelect.selectedIndex];
    const price = parseFloat(option?.dataset.price || 0);
    const stock = parseInt(option?.dataset.stock || 0);
    const quantity = parseInt(quantityInput.value || 0);

    priceInput.value = price;
    totalInput.value = price * quantity;

    stockInfo.textContent = option.value
        ? 'Stok tersedia: ' + stock
        : '';

    quantityInput.max = stock || 1;
}

productSelect.addEventListener('change', calculateTotal);
quantityInput.addEventListener('input', calculateTotal);

calculateTotal();
</script>
@endpush
