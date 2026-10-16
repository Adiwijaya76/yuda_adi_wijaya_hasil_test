@if ($menu->photo)
    <img src="{{ asset('storage/'.$menu->photo) }}" alt="{{ $menu->name }}" class="rounded-3 border"
        style="width: 44px; height: 44px; object-fit: cover;">
@else
    <span class="d-inline-flex align-items-center justify-content-center rounded-3 border text-muted"
        style="width: 44px; height: 44px; background: var(--km-body-bg);">
        <i class="fa-solid fa-image"></i>
    </span>
@endif
