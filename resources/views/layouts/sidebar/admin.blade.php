<li class="nav-item">
    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-fill"></i> Dashboard
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.buku.index') }}" class="nav-link {{ Route::is('admin.buku.*') ? 'active' : '' }}">
        <i class="bi bi-book-fill"></i> Katalog Buku
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.peminjaman.index') }}" class="nav-link {{ Route::is('admin.peminjaman.*') ? 'active' : '' }}">
        <i class="bi bi-arrow-left-right"></i> Peminjaman
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.ulasan.index') }}" class="nav-link {{ Route::is('admin.ulasan.*') ? 'active' : '' }}">
        <i class="bi bi-chat-square-text-fill"></i> Ulasan
    </a>
</li>

<li class="menu-label">Manajemen</li>
<li class="nav-item">
    <a href="{{ route('admin.kategori.index') }}" class="nav-link {{ Route::is('admin.kategori.*') ? 'active' : '' }}">
        <i class="bi bi-tags-fill"></i> Kategori
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.petugas.index') }}" class="nav-link {{ Route::is('admin.petugas.*') ? 'active' : '' }}">
        <i class="bi bi-person-badge-fill"></i> Petugas
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.user.index') }}" class="nav-link {{ Route::is('admin.user.*') ? 'active' : '' }}">
        <i class="bi bi-people-fill"></i> Pengguna
    </a>
</li>

@php $laporanActive = Route::is('admin.laporan.*'); @endphp
<li class="nav-item">
    <a href="#laporanSubmenu"
       data-bs-toggle="collapse"
       aria-expanded="{{ $laporanActive ? 'true' : 'false' }}"
       class="nav-link {{ $laporanActive ? 'active' : '' }}">
        <i class="bi bi-file-earmark-bar-graph-fill"></i> Laporan
        <i class="bi bi-chevron-down ms-auto" style="font-size:12px;"></i>
    </a>
    <ul class="collapse list-unstyled {{ $laporanActive ? 'show' : '' }}" id="laporanSubmenu">
        <li>
            <a href="{{ route('admin.laporan.buku') }}"
               class="nav-link ps-4 {{ Route::is('admin.laporan.buku') ? 'active' : '' }}">
               <i class="bi bi-dot"></i> Data Buku
            </a>
        </li>
        <li>
            <a href="{{ route('admin.laporan.peminjaman') }}"
               class="nav-link ps-4 {{ Route::is('admin.laporan.peminjaman') ? 'active' : '' }}">
               <i class="bi bi-dot"></i> Data Peminjaman
            </a>
        </li>
        <li>
            <a href="{{ route('admin.laporan.user') }}"
               class="nav-link ps-4 {{ Route::is('admin.laporan.user') ? 'active' : '' }}">
               <i class="bi bi-dot"></i> Data User
            </a>
        </li>
    </ul>
</li>