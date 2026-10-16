<!doctype html>
<html lang="id" data-theme="light">
<head>
    <meta charset="utf-8" />
    <title>@yield('code') | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        (function () {
            try {
                var t = localStorage.getItem('km-theme') || 'light';
                document.documentElement.setAttribute('data-theme', t);
            } catch (e) {}
        })();
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; background: #f1f5f9; }
        [data-theme='dark'] body { background: #0f172a; color: #e2e8f0; }
    </style>
</head>
<body>
    <div class="min-vh-100 d-flex align-items-center justify-content-center p-3">
        <div class="text-center">
            <div class="d-inline-flex align-items-center justify-content-center mb-3"
                style="width: 72px; height: 72px; border-radius: 20px; background: linear-gradient(135deg, #2563eb, #1e40af);">
                <i class="fa-solid fa-triangle-exclamation text-white fs-2"></i>
            </div>
            <h1 class="display-3 fw-bold text-primary mb-0">@yield('code')</h1>
            <h4 class="mt-2">@yield('title')</h4>
            <p class="text-muted">@yield('message')</p>
            <a href="{{ route('login') }}" class="btn btn-primary mt-2">
                <i class="fa-solid fa-house me-1"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
