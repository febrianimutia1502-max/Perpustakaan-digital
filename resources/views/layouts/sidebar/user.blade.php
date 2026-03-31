<li class="nav-item">
    <a href="{{ route('user.dashboard') }}" class="nav-link {{ Route::is('user.dashboard') ? 'active' : '' }}">
        <i class="bi bi-house-door-fill"></i> Dashboard
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('user.catalog.index') }}" class="nav-link {{ Route::is('user.catalog.*') ? 'active' : '' }}">
        <i class="bi bi-collection-fill"></i> Katalog Buku
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('user.peminjaman.index') }}" class="nav-link {{ Route::is('user.peminjaman.*') ? 'active' : '' }}">
        <i class="bi bi-journal-check"></i> Peminjaman Saya
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('user.koleksi.index') }}" class="nav-link {{ Route::is('user.koleksi.*') ? 'active' : '' }}">
        <i class="bi bi-bookmark-heart-fill"></i> Koleksi Saya
    </a>
</li>