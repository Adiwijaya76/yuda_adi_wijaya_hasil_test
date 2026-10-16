@extends('layouts.app')

@section('title', $merchant->company_name)

@section('content')
    <x-page-header :title="$merchant->company_name" subtitle="Pilih menu & lakukan checkout">
        <x-slot:actions>
            <a href="{{ route('customer.caterings.index') }}" class="btn btn-light">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </x-slot:actions>
    </x-page-header>

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <span class="stat-icon text-white me-2" style="width:44px;height:44px;font-size:1rem;background: linear-gradient(135deg, #2563eb, #1d4ed8);">
                            <i class="fa-solid fa-store"></i>
                        </span>
                        <div>
                            <h5 class="card-title mb-0">{{ $merchant->company_name }}</h5>
                            @if ($merchant->food_type)
                                <span class="badge bg-primary-subtle text-primary mt-1">{{ $merchant->food_type }}</span>
                            @endif
                        </div>
                    </div>
                    <p class="text-muted mb-2 small">
                        <i class="fa-solid fa-location-dot me-1"></i>{{ $merchant->address ?? '-' }}
                    </p>
                    @if ($merchant->phone)
                        <p class="text-muted mb-2 small">
                            <i class="fa-solid fa-phone me-1"></i>{{ $merchant->phone }}
                        </p>
                    @endif
                    @if ($merchant->description)
                        <p class="text-muted mb-0 small">{{ $merchant->description }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Menu & Checkout</h5>

                    <form method="POST" action="{{ route('customer.checkout.store') }}">
                        @csrf
                        <input type="hidden" name="merchant_profile_id" value="{{ $merchant->id }}">

                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Menu</th>
                                        <th class="text-end">Harga</th>
                                        <th class="text-center" style="width: 120px">Porsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($merchant->menus as $menu)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if ($menu->photo)
                                                        <img src="{{ asset('storage/'.$menu->photo) }}" alt="{{ $menu->name }}" class="rounded me-2" height="40">
                                                    @endif
                                                    <div>
                                                        <span class="fw-medium">{{ $menu->name }}</span>
                                                        @if (! $menu->is_available)
                                                            <div><span class="badge bg-danger-subtle text-danger">Tidak tersedia</span></div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-end">Rp {{ number_format((float) $menu->price, 0, ',', '.') }}</td>
                                            <td class="text-center">
                                                @if ($menu->is_available)
                                                    <input type="number" class="form-control form-control-sm text-center"
                                                        name="items[{{ $loop->index }}][quantity]" min="0" value="0"
                                                        @error('items.'.$loop->index.'.quantity') is-invalid @enderror>
                                                    <input type="hidden" name="items[{{ $loop->index }}][menu_id]" value="{{ $menu->id }}">
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">Belum ada menu.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <hr class="my-4">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="delivery_date" class="form-label">Tanggal Pengiriman</label>
                                <input type="date" class="form-control @error('delivery_date') is-invalid @enderror"
                                    id="delivery_date" name="delivery_date" value="{{ old('delivery_date') }}" min="{{ now()->toDateString() }}">
                                @error('delivery_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="delivery_address" class="form-label">Alamat Pengiriman</label>
                                <input type="text" class="form-control @error('delivery_address') is-invalid @enderror"
                                    id="delivery_address" name="delivery_address" value="{{ old('delivery_address') }}" placeholder="Alamat kantor">
                                @error('delivery_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        @error('items')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-check me-1"></i> Checkout
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
