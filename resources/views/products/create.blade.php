
@extends('layouts.app')

@section('title', 'Tambah Produk - NETSTORE')
@section('page-heading', 'Tambah Produk')

@section('content')

<div class="mb-4">
    <a href="{{ route('products.index') }}" class="text-decoration-none text-muted">
        <i class="bi bi-arrow-left me-2"></i>Kembali ke Data Produk
    </a>
</div>

<div class="content-card">

    <div class="mb-4">
        <h5 class="fw-bold mb-1">Tambah Produk Internet</h5>
        <p class="text-muted mb-0">
            Masukkan informasi kartu perdana atau paket internet baru.
        </p>
    </div>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label fw-semibold">Nama Produk</label>
                <input type="text" name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}"
                    placeholder="Contoh: Telkomsel 10GB"
                    required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Kategori Operator</label>
                <select name="category_id"
                    class="form-select @error('category_id') is-invalid @enderror"
                    required>
                    <option value="">-- Pilih Operator --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Jenis Produk</label>
                <select name="type" class="form-select" required>
                    <option value="">-- Pilih Jenis --</option>
                    <option value="Kartu Perdana" {{ old('type') == 'Kartu Perdana' ? 'selected' : '' }}>Kartu Perdana</option>
                    <option value="Voucher" {{ old('type') == 'Voucher' ? 'selected' : '' }}>Voucher</option>
                    <option value="Paket Data" {{ old('type') == 'Paket Data' ? 'selected' : '' }}>Paket Data</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Kuota Internet</label>
                <input type="text" name="quota"
                    class="form-control"
                    value="{{ old('quota') }}"
                    placeholder="Contoh: 10 GB"
                    required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Masa Aktif</label>
                <input type="text" name="validity_period"
                    class="form-control"
                    value="{{ old('validity_period') }}"
                    placeholder="Contoh: 30 Hari"
                    required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Stok Produk</label>
                <input type="number" name="stock"
                    class="form-control"
                    value="{{ old('stock', 0) }}"
                    min="0"
                    required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Harga Beli (Rp)</label>
                <input type="number" name="purchase_price"
                    class="form-control"
                    value="{{ old('purchase_price') }}"
                    min="0" step="0.01"
                    placeholder="Contoh: 30000"
                    required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Harga Jual (Rp)</label>
                <input type="number" name="selling_price"
                    class="form-control"
                    value="{{ old('selling_price') }}"
                    min="0" step="0.01"
                    placeholder="Contoh: 35000"
                    required>
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Deskripsi Produk</label>
                <textarea name="description" rows="4"
                    class="form-control"
                    placeholder="Masukkan deskripsi produk...">{{ old('description') }}</textarea>
            </div>

        </div>

        <hr class="my-4">

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('products.index') }}" class="btn btn-light border">
                Batal
            </a>

            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-save me-2"></i>Simpan Produk
            </button>
        </div>

    </form>

</div>

@endsection
