
@extends('layouts.app')

@section('title', 'Tambah Pelanggan - NETSTORE')
@section('page-heading', 'Tambah Pelanggan')

@section('content')

<div class="mb-4">
    <a href="{{ route('customers.index') }}" class="text-decoration-none text-muted">
        <i class="bi bi-arrow-left me-2"></i>Kembali ke Pelanggan
    </a>
</div>

<div class="content-card">
    <h5 class="fw-bold mb-1">Tambah Pelanggan Baru</h5>
    <p class="text-muted mb-4">Masukkan informasi pelanggan.</p>

    <form action="{{ route('customers.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Pelanggan</label>
            <input type="text" name="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}"
                placeholder="Masukkan nama pelanggan" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Nomor HP</label>
            <input type="text" name="phone"
                class="form-control @error('phone') is-invalid @enderror"
                value="{{ old('phone') }}"
                placeholder="Contoh: 081234567890" required>
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Alamat</label>
            <textarea name="address" rows="4" class="form-control"
                placeholder="Masukkan alamat pelanggan">{{ old('address') }}</textarea>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('customers.index') }}" class="btn btn-light border">Batal</a>
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-save me-2"></i>Simpan Pelanggan
            </button>
        </div>
    </form>
</div>

@endsection
