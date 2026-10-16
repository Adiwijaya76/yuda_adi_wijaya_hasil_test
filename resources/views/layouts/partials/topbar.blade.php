<header class="app-topbar sticky-top">
    <div class="container-fluid">
        <div class="topbar-inner d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <button type="button" id="sidebar-toggle"
                    class="btn btn-light d-lg-none" aria-label="Buka menu">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="d-none d-lg-block">
                    <span class="page-heading">@yield('title', 'Dashboard')</span>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-light" data-theme-toggle
                    title="Ganti tema" aria-label="Ganti tema terang/gelap">
                    <i class="fa-solid fa-moon" data-theme-icon></i>
                </button>

                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2"
                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-circle-user fs-5 text-primary"></i>
                        <span class="d-none d-sm-inline">{{ auth()->user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li>
                            <span class="dropdown-item-text text-muted small">
                                {{ auth()->user()->isAdmin() ? 'Admin' : (auth()->user()->isMerchant() ? 'Merchant' : 'Customer') }}
                            </span>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fa-solid fa-power-off me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
