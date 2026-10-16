@extends('layouts.auth')

@section('title', 'Login')
@section('auth_title', 'Masuk ke akun Anda')

@section('content')
    <form method="POST" action="{{ route('login.store') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <div class="input-icon">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                    id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" autofocus>
            </div>
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <div class="input-icon">
                <i class="fa-solid fa-lock"></i>
                <input type="password" class="form-control has-right-icon @error('password') is-invalid @enderror"
                    id="password" name="password" placeholder="Masukkan password">
                <button class="btn-icon-right" type="button" id="password-addon" tabindex="-1"
                    aria-label="Tampilkan password">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>
            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-primary w-100" type="submit">
            <i class="fa-solid fa-right-to-bracket me-1"></i> Masuk
        </button>
    </form>

    <div class="mt-4 text-center">
        <p class="mb-0 small">Belum punya akun?
            <a href="{{ route('register') }}" class="fw-semibold text-primary text-decoration-none">Daftar di sini</a>
        </p>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('password-addon').addEventListener('click', function () {
        var input = document.getElementById('password');
        var icon = this.querySelector('i');
        var show = input.getAttribute('type') === 'password';
        input.setAttribute('type', show ? 'text' : 'password');
        icon.classList.toggle('fa-eye', !show);
        icon.classList.toggle('fa-eye-slash', show);
    });
</script>
@endpush
