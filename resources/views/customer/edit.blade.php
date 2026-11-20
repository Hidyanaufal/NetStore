
@extends('layouts.app')

@section('title', 'Edit Pelanggan - NETSTORE')
@section('page-heading', 'Edit Pelanggan')

@section('content')

<div class="mb-4">
    <a href="{{ route('customers.index') }}" class="text-decoration-none text-muted">
        <i class="bi bi-arrow-left me-2"></i>Kembali ke Pelanggan
    </a>
</div>

<div class="content-card">
    <h5 class="fw-bold mb-1">Edit Data Pelanggan</h5>
    <p class="text-muted mb-4">Perbarui informasi pelanggan.</p>

    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Pelanggan</label>
            <input type="text" name="name"
                class="form-control"
                value="{{ old('name', $customer->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Nomor HP</label>
            <input type="text" name="phone"
                class="form-control"
                value="{{ old('phone', $customer->phone) }}" required>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Alamat</label>
            <textarea name="address" rows="4" class="form-control">{{ old('address', $customer->address) }}</textarea>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('customers.index') }}" class="btn btn-light border">Batal</a>
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-save me-2"></i>Update Pelanggan
            </button>
        </div>
    </form>
</div>

@endsection
