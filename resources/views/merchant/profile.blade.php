@extends('layouts.app')

@section('title', 'Profil Perusahaan')

@section('content')
    <x-page-header title="Profil Perusahaan" subtitle="Lengkapi informasi katering Anda" />

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('merchant.profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-section-title">Informasi Perusahaan</div>

                        <div class="mb-3">
                            <label for="company_name" class="form-label">Nama Perusahaan</label>
                            <div class="input-icon">
                                <i class="fa-solid fa-building"></i>
                                <input type="text" class="form-control @error('company_name') is-invalid @enderror"
                                    id="company_name" name="company_name"
                                    value="{{ old('company_name', $profile?->company_name) }}" placeholder="Nama perusahaan">
                            </div>
                            @error('company_name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="food_type" class="form-label">Jenis Makanan</label>
                                <div class="input-icon">
                                    <i class="fa-solid fa-utensils"></i>
                                    <input type="text" class="form-control @error('food_type') is-invalid @enderror"
                                        id="food_type" name="food_type"
                                        value="{{ old('food_type', $profile?->food_type) }}" placeholder="Nasi Kotak, dll">
                                </div>
                                @error('food_type')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">Nomor Kontak</label>
                                <div class="input-icon">
                                    <i class="fa-solid fa-phone"></i>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone"
                                        value="{{ old('phone', $profile?->phone) }}" placeholder="08xxxxxxxxxx">
                                </div>
                                @error('phone')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-section-title mt-4">Detail & Alamat</div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea class="form-control @error('address') is-invalid @enderror"
                                id="address" name="address" rows="3" placeholder="Alamat lengkap perusahaan">{{ old('address', $profile?->address) }}</textarea>
                            @error('address')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                id="description" name="description" rows="4" placeholder="Ceritakan tentang katering Anda">{{ old('description', $profile?->description) }}</textarea>
                            @error('description')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
