<meta charset="utf-8" />
<title>@yield('title', 'Katering') | Katering Marketplace</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

<script>
    // Anti-flash: terapkan tema tersimpan sebelum render (persisten, tidak reset saat refresh).
    (function() {
        try {
            var theme = localStorage.getItem('km-theme') || 'light';
            document.documentElement.setAttribute('data-theme', theme);
            document.documentElement.setAttribute('data-bs-theme', theme);
        } catch (e) {}
    })();
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
    rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" rel="stylesheet">

<link href="{{ asset('css/tailwind.css') }}?v={{ @filemtime(public_path('css/tailwind.css')) }}" rel="stylesheet">
<link href="{{ asset('css/app.css') }}?v={{ @filemtime(public_path('css/app.css')) }}" rel="stylesheet">
@stack('styles')
