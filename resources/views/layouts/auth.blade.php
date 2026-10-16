<!doctype html>
<html lang="id">
<head>
    @include('layouts.partials.head')
</head>
<body class="app-body">
    <div class="min-vh-100 d-flex align-items-center justify-content-center py-5 px-3">
        <div class="w-100" style="max-width: 420px;">
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center mb-3"
                    style="width: 56px; height: 56px; border-radius: 16px; background: linear-gradient(135deg, #2563eb, #1d4ed8); box-shadow: 0 12px 24px -12px rgba(37,99,235,.8);">
                    <i class="fa-solid fa-utensils text-white fs-4"></i>
                </div>
                <h4 class="fw-bold mb-1">Katering Marketplace</h4>
                <p class="text-muted mb-0">@yield('auth_title', 'Masuk ke akun Anda')</p>
            </div>

            <div class="card">
                <div class="card-body p-4 p-sm-5">
                    @yield('content')
                </div>
            </div>

            <div class="text-center mt-3">
                @yield('auth_footer')
            </div>
        </div>
    </div>

    @include('layouts.partials.scripts')
</body>
</html>
