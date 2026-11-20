
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'NETSTORE')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background: #f5f7fb;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: #172554;
            color: white;
            padding: 25px 18px;
            overflow-y: auto;
            z-index: 1000;
        }

        .brand {
            font-size: 23px;
            font-weight: 700;
            margin-bottom: 40px;
        }

        .sidebar a {
            display: block;
            color: #cbd5e1;
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 8px;
            transition: 0.2s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #2563eb;
            color: white;
        }

        .sidebar i {
            margin-right: 12px;
        }

        /* LOGOUT BUTTON */
        .logout-button {
            display: block;
            width: 100%;
            color: #cbd5e1;
            background: transparent;
            border: none;
            text-align: left;
            padding: 12px 15px;
            border-radius: 8px;
            transition: 0.2s;
            font-size: 15px;
        }

        .logout-button:hover {
            background: #dc2626;
            color: white;
        }

        .logout-button i {
            margin-right: 12px;
        }

        /* MAIN CONTENT */
        .main-content {
            margin-left: 250px;
            padding: 25px;
            min-width: 0;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* TOPBAR */
        .topbar {
            background: white;
            padding: 18px 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        /* USER PROFILE */
        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            font-size: 30px;
            color: #2563eb;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 14px;
            font-weight: 700;
            color: #293b5b;
        }

        .user-email {
            font-size: 11px;
            color: #71809b;
        }

        /* CONTENT CARD */
        .content-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        }

        /* IMAGE */
        img {
            max-width: 100%;
            height: auto;
        }

        /* BOOTSTRAP ICON */
        .bi {
            vertical-align: middle;
        }

        .sidebar .bi,
        .btn .bi {
            font-size: 1rem;
        }

        /* TABLE */
        .table-responsive {
            overflow-x: auto;
        }

        /* PAGINATION */
        .pagination {
            margin-bottom: 0;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .sidebar {
                width: 190px;
                padding: 20px 12px;
            }

            .main-content {
                margin-left: 190px;
                padding: 15px;
            }

            .topbar {
                padding: 15px;
                flex-wrap: wrap;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">

        <!-- BRAND -->
        <div class="brand">
            <i class="bi bi-wifi"></i> NETSTORE
        </div>

        <small class="text-secondary">MENU UTAMA</small>

        <!-- DASHBOARD -->
        <a href="{{ route('dashboard') }}"
           class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid"></i> Dashboard
        </a>

        <!-- KATEGORI -->
        <a href="{{ route('categories.index') }}"
           class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
            <i class="bi bi-tags"></i> Kategori Operator
        </a>

        <!-- PRODUK -->
        <a href="{{ route('products.index') }}"
           class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
            <i class="bi bi-phone"></i> Data Produk
        </a>

        <!-- PELANGGAN -->
        <a href="{{ route('customers.index') }}"
           class="{{ request()->routeIs('customers.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Pelanggan
        </a>

        <!-- TRANSAKSI -->
        <a href="{{ route('transactions.index') }}"
           class="{{ request()->routeIs('transactions.*') ? 'active' : '' }}">
            <i class="bi bi-cart"></i> Transaksi
        </a>

        <!-- MANAJEMEN STOK -->
        <a href="{{ route('stock-movements.index') }}"
           class="{{ request()->routeIs('stock-movements.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> Manajemen Stok
        </a>

        <hr class="border-secondary">

        <small class="text-secondary">PENGATURAN</small>

        <!-- PENGATURAN -->
        <a href="#">
            <i class="bi bi-gear"></i> Pengaturan
        </a>

        <!-- LOGOUT -->
        <form action="{{ route('logout') }}" method="POST"
              onsubmit="return confirm('Apakah kamu yakin ingin logout?')">

            @csrf

            <button type="submit" class="logout-button">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>

        </form>

    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- TOPBAR -->
        <div class="topbar">

            <div>
                <h5 class="fw-bold mb-1">
                    @yield('page-heading', 'Dashboard')
                </h5>

                <small class="text-muted">
                    Sistem Informasi Penjualan Kartu Internet
                </small>
            </div>

            <!-- INFORMASI PENGGUNA LOGIN -->
            <div class="user-profile">

                <i class="bi bi-person-circle user-avatar"></i>

                <div class="user-info">

                    <span class="user-name">
                        {{ auth()->user()->name }}
                    </span>

                    <span class="user-email">
                        {{ auth()->user()->email }}
                    </span>

                </div>

            </div>

        </div>

        <!-- SUCCESS MESSAGE -->
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

        <!-- ERROR MESSAGE -->
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">

                <i class="bi bi-exclamation-circle me-2"></i>

                {{ session('error') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>

            </div>
        @endif

        <!-- PAGE CONTENT -->
        @yield('content')

    </div>

    <!-- BOOTSTRAP JAVASCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

</body>
</html>
