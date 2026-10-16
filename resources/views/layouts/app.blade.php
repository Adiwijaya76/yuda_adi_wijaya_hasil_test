<!doctype html>
<html lang="id">
<head>
    @include('layouts.partials.head')
</head>
<body class="app-body">
    @include('layouts.partials.sidebar')

    <div class="app-main d-flex flex-column min-vh-100">
        @include('layouts.partials.topbar')

        <main class="flex-grow-1">
            <div class="container-fluid py-4">
                @yield('content')
            </div>
        </main>

        @include('layouts.partials.footer')
    </div>

    @include('layouts.partials.scripts')
</body>
</html>
