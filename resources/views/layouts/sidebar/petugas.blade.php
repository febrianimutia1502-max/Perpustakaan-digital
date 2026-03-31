<li class="nav-item">
    <a href="{{ route('petugas.dashboard') }}" class="nav-link {{ Route::is('petugas.dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-fill"></i> Dashboard
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('petugas.buku.index') }}" class="nav-link {{ Route::is('petugas.buku.*') ? 'active' : '' }}">
        <i class="bi bi-book-fill"></i> Katalog Buku
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('petugas.peminjaman.index') }}" class="nav-link {{ Route::is('petugas.peminjaman.*') ? 'active' : '' }}">
        <i class="bi bi-arrow-left-right"></i> Peminjaman
    </a>
</li>

<li class="nav-item">
    <a href="#laporanSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="nav-link">
        <i class="bi bi-file-earmark-bar-graph-fill"></i> Laporan
    </a>
    <ul class="collapse list-unstyled" id="laporanSubmenu">
        <li>
            <a href="{{ route('petugas.laporan.buku') }}" class="nav-link">Data Buku</a>
        </li>
        <li>
            <a href="{{ route('petugas.laporan.peminjaman') }}" class="nav-link">Data Peminjaman</a>
        </li>
    </ul>
</li>