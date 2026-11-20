
@extends('layouts.app')

@section('title', 'Manajemen Stok')
@section('page-heading', 'Manajemen Stok')

@section('content')

<style>
    .stock-page {
        color: #293650;
    }

    .stock-page .card {
        border: 1px solid #e8edf5;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(31, 51, 87, .06);
    }

    .stock-page .card-body {
        padding: 22px;
    }

    .stock-title {
        font-size: 17px;
        font-weight: 700;
        color: #293b5b;
    }

    .stock-subtitle {
        color: #71809b;
        font-size: 13px;
    }

    .stock-page .form-control {
        border-radius: 7px;
        border-color: #dce3ee;
        font-size: 13px;
        min-height: 42px;
    }

    .stock-page label {
        font-size: 13px;
        font-weight: 600;
        color: #52627e;
    }

    .stock-page .btn {
        border-radius: 7px;
        font-weight: 600;
    }

    .stock-page .table thead th {
        background: #f4f7fc;
        color: #52627e;
        font-size: 12px;
        text-transform: uppercase;
        padding: 14px;
        white-space: nowrap;
    }

    .stock-page .table tbody td {
        font-size: 13px;
        color: #53627e;
        padding: 14px;
        vertical-align: middle;
    }

    .stock-in {
        background: #e5f7ef;
        color: #16865c;
        padding: 6px 10px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 11px;
        white-space: nowrap;
    }

    .stock-out {
        background: #fff0f0;
        color: #dc4b5b;
        padding: 6px 10px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 11px;
        white-space: nowrap;
    }

    .stock-product {
        color: #3478f6;
        font-weight: 700;
    }

    .stock-page .form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 .2rem rgba(13, 110, 253, .12);
    }
</style>

<div class="stock-page">

    <!-- DESKRIPSI -->
    <div class="mb-4">
        <p class="stock-subtitle">
            Kelola stok produk, catat perubahan persediaan,
            dan pantau riwayat stok NETSTORE.
        </p>
    </div>

    <!-- NOTIFIKASI -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>
                <i class="bi bi-exclamation-circle me-2"></i>
                Terjadi kesalahan:
            </strong>

            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FORM PERUBAHAN STOK -->
    <div class="card mb-4">
        <div class="card-body">

            <div class="mb-4">
                <h5 class="stock-title">
                    <i class="bi bi-box-seam text-primary me-2"></i>
                    Form Perubahan Stok
                </h5>

                <p class="stock-subtitle mb-0">
                    Masukkan data stok masuk atau stok keluar produk.
                </p>
            </div>

            <form action="{{ route('stock-movements.store') }}"
                  method="POST">

                @csrf

                <div class="row">

                    <!-- JENIS PERUBAHAN -->
                    <div class="col-md-6 mb-3">
                        <label>Jenis Perubahan Stok</label>

                        <select name="movement_type"
                                class="form-control"
                                required>

                            <option value="">-- Pilih Jenis --</option>

                            <option value="in"
                                {{ old('movement_type') == 'in' ? 'selected' : '' }}>
                                Stok Masuk
                            </option>

                            <option value="out"
                                {{ old('movement_type') == 'out' ? 'selected' : '' }}>
                                Stok Keluar
                            </option>

                        </select>
                    </div>

                    <!-- PILIH PRODUK -->
                    <div class="col-md-6 mb-3">
                        <label>Pilih Produk</label>

                        <select name="product_id"
                                class="form-control"
                                required>

                            <option value="">-- Pilih Produk --</option>

                            @foreach($products as $product)
                                <option value="{{ $product->id }}"
                                    {{ old('product_id') == $product->id ? 'selected' : '' }}>

                                    {{ $product->name }}
                                    - {{ $product->type }}
                                    (Kuota: {{ $product->quota }}, Stok: {{ $product->stock }})

                                </option>
                            @endforeach

                        </select>
                    </div>

                    <!-- JUMLAH STOK -->
                    <div class="col-md-6 mb-3">
                        <label>Jumlah Stok</label>

                        <input type="number"
                               name="quantity"
                               class="form-control"
                               min="1"
                               value="{{ old('quantity') }}"
                               placeholder="Masukkan jumlah stok"
                               required>
                    </div>

                    <!-- KETERANGAN -->
                    <div class="col-md-6 mb-3">
                        <label>Keterangan</label>

                        <input type="text"
                               name="notes"
                               class="form-control"
                               value="{{ old('notes') }}"
                               placeholder="Contoh: Pembelian stok baru">
                    </div>

                </div>

                <!-- TOMBOL -->
                <div class="d-flex justify-content-end gap-2">

                    <button type="reset"
                            class="btn btn-light border">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>
                        Reset
                    </button>

                    <button type="submit"
                            class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Simpan Perubahan Stok
                    </button>

                </div>

            </form>

        </div>
    </div>

    <!-- TABEL RIWAYAT STOK -->
    <div class="card">

        <div class="card-body">

            <div class="mb-4">
                <h5 class="stock-title mb-1">
                    <i class="bi bi-clock-history text-primary me-2"></i>
                    Riwayat Perubahan Stok
                </h5>

                <p class="stock-subtitle mb-0">
                    Daftar seluruh aktivitas perubahan stok produk.
                </p>
            </div>

            <div class="table-responsive">

                <table class="table table-hover">

                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>Nama Produk</th>
                            <th>Tipe</th>
                            <th>Kuota</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Stok Awal</th>
                            <th>Stok Akhir</th>
                            <th>Admin</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($movements as $index => $movement)

                            <tr>

                                <td>
                                    {{ $movements->firstItem() + $index }}
                                </td>

                                <td>
                                    {{ date('d/m/Y H:i', strtotime($movement->created_at)) }}
                                </td>

                                <td>
                                    <strong class="stock-product">
                                        {{ $movement->product_name }}
                                    </strong>
                                </td>

                                <td>
                                    {{ $movement->product_type ?? '-' }}
                                </td>

                                <td>
                                    {{ $movement->product_quota ?? '-' }}
                                </td>

                                <td>
                                    @if($movement->movement_type == 'in')

                                        <span class="stock-in">
                                            <i class="bi bi-arrow-down-circle me-1"></i>
                                            STOK MASUK
                                        </span>

                                    @else

                                        <span class="stock-out">
                                            <i class="bi bi-arrow-up-circle me-1"></i>
                                            STOK KELUAR
                                        </span>

                                    @endif
                                </td>

                                <td>
                                    <strong>
                                        {{ number_format($movement->quantity) }}
                                    </strong>
                                </td>

                                <td>
                                    {{ number_format($movement->stock_before) }}
                                </td>

                                <td>
                                    <strong>
                                        {{ number_format($movement->stock_after) }}
                                    </strong>
                                </td>

                                <td>
                                    {{ $movement->user_name ?? 'Tidak diketahui' }}
                                </td>

                                <td>
                                    {{ $movement->notes ?? '-' }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="11" class="text-center py-5">

                                    <i class="bi bi-box-seam fs-1 text-secondary"></i>

                                    <p class="mb-1 fw-bold mt-3">
                                        Belum Ada Riwayat Stok
                                    </p>

                                    <small class="text-muted">
                                        Aktivitas perubahan stok akan muncul di sini.
                                    </small>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <!-- PAGINATION -->
            <div class="d-flex justify-content-end mt-3">
                {{ $movements->links() }}
            </div>

        </div>
    </div>

</div>

@endsection
