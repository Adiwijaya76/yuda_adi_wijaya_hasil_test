@php $user = $user ?? null; @endphp

<div class="form-section-title">Informasi Akun</div>

<div class="row g-3">
    <div class="col-md-6">
        <label for="name" class="form-label">Nama</label>
        <div class="input-icon">
            <i class="fa-solid fa-user"></i>
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                id="name" name="name" value="{{ old('name', $user?->name) }}" placeholder="Nama pengguna">
        </div>
        @error('name')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="email" class="form-label">Email</label>
        <div class="input-icon">
            <i class="fa-solid fa-envelope"></i>
            <input type="email" class="form-control @error('email') is-invalid @enderror"
                id="email" name="email" value="{{ old('email', $user?->email) }}" placeholder="nama@email.com">
        </div>
        @error('email')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="role" class="form-label">Role</label>
        <x-select name="role" id="role" placeholder="Pilih Role" :selected="$user?->role"
            :options="collect($roles)->mapWithKeys(fn ($r) => [$r => ucfirst($r)])->all()" />
        @error('role')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-section-title mt-4">Keamanan</div>

<div class="row g-3">
    <div class="col-md-6">
        <label for="password" class="form-label">
            Password
            @if ($user)
                <span class="text-muted fw-normal">(kosongkan jika tidak diubah)</span>
            @endif
        </label>
        <div class="input-icon">
            <i class="fa-solid fa-lock"></i>
            <input type="password" class="form-control @error('password') is-invalid @enderror"
                id="password" name="password" placeholder="Minimal 8 karakter">
        </div>
        @error('password')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
        <div class="input-icon">
            <i class="fa-solid fa-lock"></i>
            <input type="password" class="form-control" id="password_confirmation"
                name="password_confirmation" placeholder="Ulangi password">
        </div>
    </div>
</div>
