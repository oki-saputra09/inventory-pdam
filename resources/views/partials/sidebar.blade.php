<aside class="sidebar" id="sidebarMenu">
    <div class="brand">
        <div class="brand-logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo PDAM">
        </div>

        <div class="brand-text">
            <h4>INVENDAM</h4>
            <span>Admin Controls</span>
        </div>
    </div>

    <div class="menu-title">Menu Utama</div>

    <ul class="menu">
        <li>
            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                Dashboard
            </a>
        </li>

        <li>
            <a href="{{ route('admin.barang.index') }}"
               class="{{ request()->routeIs('admin.barang.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i>
                Data Barang
            </a>
        </li>

        <li>
            <a href="{{ route('admin.kategori.index') }}"
               class="{{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i>
                Kategori
            </a>
        </li>

        <li>
            <a href="{{ route('admin.supplier.index') }}"
               class="{{ request()->routeIs('admin.supplier.*') ? 'active' : '' }}">
                <i class="bi bi-truck"></i>
                Supplier
            </a>
        </li>

        <li>
            <a href="{{ route('admin.user.index') }}"
               class="{{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                User
            </a>
        </li>
    </ul>

    <div class="menu-title">Transaksi</div>

    <ul class="menu">
        <li>
            <a href="{{ route('admin.barang-masuk.index') }}"
               class="{{ request()->routeIs('admin.barang-masuk.*') ? 'active' : '' }}">
                <i class="bi bi-box-arrow-in-down"></i>
                Barang Masuk
            </a>
        </li>

        <li>
            <a href="{{ route('admin.barang-keluar.index') }}"
               class="{{ request()->routeIs('admin.barang-keluar.*') ? 'active' : '' }}">
                <i class="bi bi-box-arrow-up"></i>
                Barang Keluar
            </a>
        </li>

        <li>
            <a href="{{ route('admin.permintaan-barang.index') }}"
               class="{{ request()->routeIs('admin.permintaan-barang.*') ? 'active' : '' }}">
                <i class="bi bi-clipboard-check"></i>
                Permintaan Barang
            </a>
        </li>
    </ul>

    <div class="menu-title">Laporan</div>

    <ul class="menu">
        <li>
            <a href="{{ route('admin.laporan-stok.index') }}"
               class="{{ request()->routeIs('admin.laporan-stok.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text"></i>
                Laporan Stok
            </a>
        </li>

        <li>
            <a href="{{ route('admin.laporan-transaksi.index') }}"
               class="{{ request()->routeIs('admin.laporan-transaksi.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-bar-graph"></i>
                Laporan Transaksi
            </a>
        </li>

        <li>
            <a href="{{ route('admin.notifikasi-stok.index') }}"
               class="{{ request()->routeIs('admin.notifikasi-stok.*') ? 'active' : '' }}">
                <i class="bi bi-bell"></i>
                Notifikasi Stok
            </a>
        </li>

        <li>
            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf

                <button type="submit" class="logout-btn">
                    <i class="bi bi-box-arrow-left"></i>
                    Logout
                </button>
            </form>
        </li>
    </ul>
</aside>