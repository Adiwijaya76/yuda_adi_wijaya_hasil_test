@extends('layouts.auth')

@section('title', 'Registrasi')
@section('auth_title', 'Buat akun baru')

@section('content')
    <form method="POST" action="{{ route('register.store') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <div class="input-icon">
                <i class="fa-solid fa-user"></i>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                    id="name" name="name" value="{{ old('name') }}" placeholder="Nama lengkap / perusahaan" autofocus>
            </div>
            @error('name')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <div class="input-icon">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                    id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com">
            </div>
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Daftar sebagai</label>
            <x-select name="role" id="role" placeholder="-- Pilih Role --"
                :options="['merchant' => 'Merchant (Perusahaan Katering)', 'customer' => 'Customer (Kantor)']" />
            @error('role')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-icon">
                <i class="fa-solid fa-lock"></i>
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                    id="password" name="password" placeholder="Minimal 8 karakter">
            </div>
            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <div class="input-icon">
                <i class="fa-solid fa-lock"></i>
                <input type="password" class="form-control" id="password_confirmation"
                    name="password_confirmation" placeholder="Ulangi password">
            </div>
        </div>

        <button class="btn btn-primary w-100" type="submit">
            <i class="fa-solid fa-user-plus me-1"></i> Daftar
        </button>
    </form>

    <div class="mt-4 text-center">
        <p class="mb-0 small">Sudah punya akun?
            <a href="{{ route('login') }}" class="fw-semibold text-primary text-decoration-none">Masuk di sini</a>
        </p>
    </div>
@endsection
