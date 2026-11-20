
@extends('layouts.app')

@section('title', 'Edit Kategori - NETSTORE')
@section('page-heading', 'Edit Kategori')

@section('content')

<div class="mb-4">
    <a href="{{ route('categories.index') }}" class="text-decoration-none text-muted">
        <i class="bi bi-arrow-left me-2"></i>Kembali ke Kategori
    </a>
</div>

<div class="content-card">

    <div class="mb-4">
        <h5 class="fw-bold mb-1">Edit Kategori Operator</h5>
        <p class="text-muted mb-0">
            Perbarui informasi kategori operator kartu internet.
        </p>
    </div>

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Operator</label>
            <input
                type="text"
                name="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $category->name) }}"
                placeholder="Contoh: Telkomsel"
                required
            >

            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Deskripsi</label>
            <textarea
                name="description"
                rows="4"
                class="form-control @error('description') is-invalid @enderror"
                placeholder="Masukkan deskripsi operator..."
            >{{ old('description', $category->description) }}</textarea>

            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Status Kategori</label>
            <select name="status" class="form-select" required>
                <option value="1" {{ old('status', $category->status) == '1' ? 'selected' : '' }}>
                    Aktif
                </option>

                <option value="0" {{ old('status', $category->status) == '0' ? 'selected' : '' }}>
                    Nonaktif
                </option>
            </select>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('categories.index') }}" class="btn btn-light border">
                Batal
            </a>

            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-save me-2"></i>Update Kategori
            </button>
        </div>

    </form>

</div>

@endsection
