@php
    $isAdmin = auth()->user()->isAdmin();
    $isMerchant = auth()->user()->isMerchant();
    $homeRoute = $isAdmin ? 'admin.dashboard' : ($isMerchant ? 'merchant.dashboard' : 'customer.dashboard');
@endphp

<aside id="app-sidebar" class="app-sidebar" aria-label="Navigasi utama">
    <div class="app-brand d-flex align-items-center gap-3 px-3 py-3">
        <span class="brand-badge">
            <i class="fa-solid fa-utensils"></i>
        </span>
        <span class="brand-text">
            Katering
            <span>Marketplace</span>
        </span>
    </div>

    <div class="nav-section-title">Menu Utama</div>

    <ul class="nav flex-column px-2 pb-4">
        @if ($isAdmin)
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <span class="nav-icon"><i class="fa-solid fa-gauge-high"></i></span> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <span class="nav-icon"><i class="fa-solid fa-users"></i></span> Pengguna
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.merchants.*') ? 'active' : '' }}" href="{{ route('admin.merchants.index') }}">
                    <span class="nav-icon"><i class="fa-solid fa-store"></i></span> Merchant
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                    <span class="nav-icon"><i class="fa-solid fa-cart-shopping"></i></span> Pesanan
                </a>
            </li>
        @elseif ($isMerchant)
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('merchant.dashboard') ? 'active' : '' }}" href="{{ route('merchant.dashboard') }}">
                    <span class="nav-icon"><i class="fa-solid fa-gauge-high"></i></span> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('merchant.menus.*') ? 'active' : '' }}" href="{{ route('merchant.menus.index') }}">
                    <span class="nav-icon"><i class="fa-solid fa-utensils"></i></span> Kelola Menu
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('merchant.orders.*') ? 'active' : '' }}" href="{{ route('merchant.orders.index') }}">
                    <span class="nav-icon"><i class="fa-solid fa-cart-shopping"></i></span> Pesanan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('merchant.profile.*') ? 'active' : '' }}" href="{{ route('merchant.profile.edit') }}">
                    <span class="nav-icon"><i class="fa-solid fa-building"></i></span> Profil Perusahaan
                </a>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}" href="{{ route('customer.dashboard') }}">
                    <span class="nav-icon"><i class="fa-solid fa-gauge-high"></i></span> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('customer.caterings.*') ? 'active' : '' }}" href="{{ route('customer.caterings.index') }}">
                    <span class="nav-icon"><i class="fa-solid fa-magnifying-glass"></i></span> Cari Katering
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('customer.orders.*') ? 'active' : '' }}" href="{{ route('customer.orders.index') }}">
                    <span class="nav-icon"><i class="fa-solid fa-receipt"></i></span> Riwayat Pesanan
                </a>
            </li>
        @endif
    </ul>
</aside>

<div id="sidebar-backdrop" class="d-none d-lg-none position-fixed top-0 start-0 w-100 h-100"
    style="background: rgba(15,23,42,.55); z-index: 1040;"></div>
