
@extends('layouts.app')

@section('title', 'Data Produk - NETSTORE')
@section('page-heading', 'Data Produk')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Data Produk</h4>
        <p class="text-muted mb-0">
            Kelola produk kartu perdana dan paket internet.
        </p>
    </div>

    <a href="{{ route('products.create') }}" class="btn btn-primary px-4">
        <i class="bi bi-plus-lg me-2"></i>Tambah Produk
    </a>
</div>

<div class="row g-3 mb-4">

    <div class="col-md-4">
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">Total Produk</p>
                    <h4 class="fw-bold mb-0">{{ $products->total() }}</h4>
                </div>
                <i class="bi bi-box-seam fs-1 text-primary"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">Stok Menipis</p>
                    <h4 class="fw-bold mb-0">{{ $lowStock ?? 0 }}</h4>
                </div>
                <i class="bi bi-exclamation-triangle fs-1 text-warning"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">Total Kategori</p>
                    <h4 class="fw-bold mb-0">{{ $totalCategories ?? 0 }}</h4>
                </div>
                <i class="bi bi-tags fs-1 text-success"></i>
            </div>
        </div>
    </div>

</div>

<div class="content-card">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">Daftar Produk Internet</h5>
            <small class="text-muted">Informasi produk dan persediaan stok</small>
        </div>

        <form action="{{ route('products.index') }}" method="GET">
            <div class="input-group">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Cari produk..."
                    value="{{ request('search') }}"
                >
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
                    <th>Nama Produk</th>
                    <th>Operator</th>
                    <th>Jenis</th>
                    <th>Kuota</th>
                    <th>Masa Aktif</th>
                    <th>Harga Jual</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $products->firstItem() + $loop->index }}</td>

                    <td class="fw-semibold">
                        {{ $product->name }}
                    </td>

                    <td>
                        <span class="badge bg-primary-subtle text-primary">
                            {{ $product->category->name ?? '-' }}
                        </span>
                    </td>

                    <td>{{ $product->type }}</td>

                    <td>{{ $product->quota }}</td>

                    <td>{{ $product->validity_period }}</td>

                    <td class="fw-semibold">
                        Rp{{ number_format($product->selling_price, 0, ',', '.') }}
                    </td>

                    <td>
                        @if($product->stock <= 5)
                            <span class="badge bg-danger">
                                {{ $product->stock }} (Menipis)
                            </span>
                        @elseif($product->stock <= 15)
                            <span class="badge bg-warning text-dark">
                                {{ $product->stock }} (Terbatas)
                            </span>
                        @else
                            <span class="badge bg-success">
                                {{ $product->stock }} (Tersedia)
                            </span>
                        @endif
                    </td>

                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('products.edit', $product->id) }}"
                                class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <form action="{{ route('products.destroy', $product->id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
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
                        <i class="bi bi-box-seam fs-1 text-muted"></i>
                        <p class="text-muted mt-2 mb-0">
                            Belum ada produk yang tersedia.
                        </p>
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    <div class="mt-3">
        {{ $products->links() }}
    </div>

</div>

@endsection
