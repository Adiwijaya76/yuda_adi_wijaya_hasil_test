@extends('layouts.app')

@section('title', 'Cari Katering')

@section('content')
    <x-page-header title="Cari Katering" subtitle="Temukan katering sesuai kebutuhan kantor Anda" />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('customer.caterings.index') }}" class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label">Kata Kunci</label>
                            <input type="text" class="form-control" name="q" value="{{ request('q') }}" placeholder="Nama, jenis, alamat...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Jenis Makanan</label>
                            <x-select name="food_type" placeholder="Semua Jenis"
                                :selected="request('food_type')"
                                :options="collect($foodTypes)->mapWithKeys(fn ($t) => [$t => $t])->all()" />
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Lokasi</label>
                            <input type="text" class="form-control" name="location" value="{{ request('location') }}" placeholder="Alamat / kota">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fa-solid fa-magnifying-glass me-1"></i> Cari
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-1">
        @forelse ($caterings as $catering)
            <div class="col-xl-4 col-sm-6">
                <div class="card h-100 stat-card">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center mb-2">
                            <span class="stat-icon text-white me-2" style="width:40px;height:40px;font-size:.95rem;background: linear-gradient(135deg, #2563eb, #1d4ed8);">
                                <i class="fa-solid fa-utensils"></i>
                            </span>
                            <h5 class="card-title mb-0">{{ $catering->company_name }}</h5>
                        </div>

                        @if ($catering->food_type)
                            <div><span class="badge bg-primary-subtle text-primary">{{ $catering->food_type }}</span></div>
                        @endif

                        <p class="text-muted mt-2 mb-1 small">
                            <i class="fa-solid fa-location-dot me-1"></i>{{ $catering->address ?? '-' }}
                        </p>
                        @if ($catering->phone)
                            <p class="text-muted mb-2 small">
                                <i class="fa-solid fa-phone me-1"></i>{{ $catering->phone }}
                            </p>
                        @endif

                        <a href="{{ route('customer.caterings.show', $catering) }}" class="btn btn-outline-primary w-100 mt-auto">
                            Lihat Menu <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fa-solid fa-magnifying-glass fs-1 text-muted d-block mb-3"></i>
                        <p class="text-muted mb-0">Tidak ada katering yang cocok dengan pencarian Anda.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <div class="row mt-1">
        <div class="col-12">
            {{ $caterings->links() }}
        </div>
    </div>
@endsection
