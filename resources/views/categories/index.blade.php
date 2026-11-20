
@extends('layouts.app')

@section('title', 'Kategori Operator - NETSTORE')
@section('page-heading', 'Kategori Operator')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Kategori Operator</h4>
        <p class="text-muted mb-0">Kelola kategori kartu internet dan operator.</p>
    </div>

    <a href="{{ route('categories.create') }}" class="btn btn-primary px-4">
        <i class="bi bi-plus-lg me-2"></i>Tambah Kategori
    </a>
</div>

<div class="content-card">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">Daftar Kategori</h5>
            <small class="text-muted">Seluruh kategori operator NETSTORE</small>
        </div>

        <form action="{{ route('categories.index') }}" method="GET">
            <div class="input-group">
                <span class="input-group-text bg-white">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" name="search" class="form-control"
                    placeholder="Cari kategori..."
                    value="{{ request('search') }}">
                <button class="btn btn-primary">Cari</button>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th width="60">No</th>
                    <th>Nama Operator</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td class="fw-semibold">
                        {{ $category->name }}
                    </td>

                    <td>{{ $category->description ?? '-' }}</td>

                    <td>
                        @if($category->status)
                            <span class="badge bg-success-subtle text-success">
                                Aktif
                            </span>
                        @else
                            <span class="badge bg-danger-subtle text-danger">
                                Nonaktif
                            </span>
                        @endif
                    </td>

                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('categories.edit', $category->id) }}"
                                class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <form action="{{ route('categories.destroy', $category->id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <i class="bi bi-inbox fs-1 text-muted"></i>
                        <p class="text-muted mt-2 mb-0">
                            Belum ada data kategori operator.
                        </p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $categories->links() }}
    </div>

</div>

@endsection
