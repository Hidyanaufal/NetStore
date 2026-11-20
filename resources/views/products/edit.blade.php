
@extends('layouts.app')

@section('title', 'Edit Produk - NETSTORE')
@section('page-heading', 'Edit Produk')

@section('content')

<div class="mb-4">
    <a href="{{ route('products.index') }}" class="text-decoration-none text-muted">
        <i class="bi bi-arrow-left me-2"></i>Kembali ke Data Produk
    </a>
</div>

<div class="content-card">

    <div class="mb-4">
        <h5 class="fw-bold mb-1">Edit Produk Internet</h5>
        <p class="text-muted mb-0">
            Perbarui informasi kartu perdana atau paket internet.
        </p>
    </div>

    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label fw-semibold">Nama Produk</label>
                <input type="text" name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $product->name) }}"
                    required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Kategori Operator</label>
                <select name="category_id" class="form-select" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Jenis Produk</label>
                <select name="type" class="form-select" required>
                    <option value="Kartu Perdana" {{ old('type', $product->type) == 'Kartu Perdana' ? 'selected' : '' }}>Kartu Perdana</option>
                    <option value="Voucher" {{ old('type', $product->type) == 'Voucher' ? 'selected' : '' }}>Voucher</option>
                    <option value="Paket Data" {{ old('type', $product->type) == 'Paket Data' ? 'selected' : '' }}>Paket Data</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Kuota Internet</label>
                <input type="text" name="quota"
                    class="form-control"
                    value="{{ old('quota', $product->quota) }}"
                    required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Masa Aktif</label>
                <input type="text" name="validity_period"
                    class="form-control"
                    value="{{ old('validity_period', $product->validity_period) }}"
                    required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Stok Produk</label>
                <input type="number" name="stock"
                    class="form-control"
                    value="{{ old('stock', $product->stock) }}"
                    min="0" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Harga Beli (Rp)</label>
                <input type="number" name="purchase_price"
                    class="form-control"
                    value="{{ old('purchase_price', $product->purchase_price) }}"
                    min="0" step="0.01" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Harga Jual (Rp)</label>
                <input type="number" name="selling_price"
                    class="form-control"
                    value="{{ old('selling_price', $product->selling_price) }}"
                    min="0" step="0.01" required>
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Deskripsi Produk</label>
                <textarea name="description" rows="4"
                    class="form-control">{{ old('description', $product->description) }}</textarea>
            </div>

        </div>

        <hr class="my-4">

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('products.index') }}" class="btn btn-light border">
                Batal
            </a>

            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-save me-2"></i>Update Produk
            </button>
        </div>

    </form>

</div>

@endsection
