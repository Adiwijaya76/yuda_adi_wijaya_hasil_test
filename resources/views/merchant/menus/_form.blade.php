@php $menu = $menu ?? null; @endphp

<div class="form-section-title">Detail Menu</div>

<div class="mb-3">
    <label for="name" class="form-label">Nama Menu</label>
    <div class="input-icon">
        <i class="fa-solid fa-utensils"></i>
        <input type="text" class="form-control @error('name') is-invalid @enderror"
            id="name" name="name" value="{{ old('name', $menu?->name) }}" placeholder="Contoh: Nasi Kotak Ayam Bakar">
    </div>
    @error('name')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Deskripsi</label>
    <textarea class="form-control @error('description') is-invalid @enderror"
        id="description" name="description" rows="3" placeholder="Jelaskan isi & keunggulan menu">{{ old('description', $menu?->description) }}</textarea>
    @error('description')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="row g-3">
    <div class="col-md-6">
        <label for="price" class="form-label">Harga per Porsi (Rp)</label>
        <div class="input-icon">
            <i class="fa-solid fa-money-bill-wave"></i>
            <input type="number" step="0.01" min="0.01"
                class="form-control @error('price') is-invalid @enderror"
                id="price" name="price" value="{{ old('price', isset($menu) ? (float) $menu->price : '') }}" placeholder="25000">
        </div>
        @error('price')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="photo" class="form-label">Foto Menu</label>
        <label for="photo" class="file-drop @error('photo') file-drop-invalid @enderror">
            <input type="file" id="photo" name="photo" accept="image/*" hidden>
            <i class="fa-solid fa-cloud-arrow-up"></i>
            <span class="file-drop-text">
                Klik untuk pilih foto
                <small>JPG, JPEG, PNG, WEBP · maks 2MB</small>
            </span>
        </label>
        @error('photo')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>
</div>

@if (isset($menu) && $menu->photo)
    <div class="mt-3 d-flex align-items-center gap-3 p-2 rounded-3" style="background: var(--km-body-bg); width: fit-content;">
        <img src="{{ asset('storage/'.$menu->photo) }}" alt="{{ $menu->name }}" class="rounded-3 border" height="56">
        <span class="text-muted small">Foto saat ini</span>
    </div>
@endif

<div class="form-check form-switch mt-4">
    <input type="checkbox" class="form-check-input" id="is_available" name="is_available" value="1"
        @checked(old('is_available', $menu?->is_available ?? true))>
    <label class="form-check-label fw-medium" for="is_available">Menu tersedia untuk dipesan</label>
</div>
