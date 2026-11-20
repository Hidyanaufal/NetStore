
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - NETSTORE</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f5f7fb;
            font-family: 'Segoe UI', sans-serif;
            padding: 20px;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: white;
            padding: 38px;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(23, 37, 84, .09);
        }

        .brand-icon {
            width: 65px;
            height: 65px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
            background: #172554;
            color: white;
            border-radius: 15px;
            font-size: 30px;
        }

        .brand-name {
            color: #172554;
            font-size: 27px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .form-control {
            min-height: 46px;
            border-radius: 8px;
            border-color: #dce3ee;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .12);
        }

        .btn-login {
            min-height: 46px;
            border-radius: 8px;
            background: #2563eb;
            border: none;
            font-weight: 600;
        }

        .btn-login:hover {
            background: #1d4ed8;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #52627e;
        }
    </style>
</head>

<body>

    <div class="login-card">

        <div class="text-center mb-4">

            <div class="brand-icon mb-3">
                <i class="bi bi-wifi"></i>
            </div>

            <div class="brand-name">NETSTORE</div>

            <p class="text-muted small mt-2 mb-0">
                Sistem Informasi Penjualan Kartu Internet
            </p>

        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger small">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">

            @csrf

            <div class="mb-3">

                <label class="form-label">Email</label>

                <input type="email"
                       name="email"
                       class="form-control"
                       placeholder="Masukkan email"
                       value="{{ old('email') }}"
                       autocomplete="username"
                       required
                       autofocus>

            </div>

            <div class="mb-3">

                <label class="form-label">Password</label>

                <input type="password"
                       name="password"
                       class="form-control"
                       placeholder="Masukkan password"
                       autocomplete="current-password"
                       required>

            </div>

            <div class="mb-4">

                <div class="form-check">
                    <input type="checkbox"
                           name="remember"
                           value="1"
                           class="form-check-input"
                           id="remember">

                    <label class="form-check-label small text-muted"
                           for="remember">
                        Ingat saya
                    </label>
                </div>

            </div>

            <button type="submit"
                    class="btn btn-primary btn-login w-100">
                <i class="bi bi-box-arrow-in-right me-2"></i>
                Login
            </button>

        </form>

        <div class="text-center mt-4">
            <small class="text-muted">
                &copy; {{ date('Y') }} NETSTORE. All Rights Reserved.
            </small>
        </div>

    </div>

</body>
</html>
