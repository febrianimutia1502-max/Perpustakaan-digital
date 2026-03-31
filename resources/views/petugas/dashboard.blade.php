@extends('layouts.dashboard')

@section('title', 'Petugas Dashboard')
@section('subtitle', 'Manajemen Operasional Perpustakaan')

@section('content')
<div class="row g-4">
    <div class="col-md-3">
        <div class="stat-card" style="border-left: 4px solid var(--primary-purple);">
            <div class="stat-icon" style="background: rgba(142, 68, 173, 0.1); color: var(--primary-purple);">
                <i class="bi bi-book"></i>
            </div>
            <div>
                <p class="stat-label">Total Buku</p>
                <h4 class="stat-value">{{ \App\Models\Buku::count() }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="border-left: 4px solid #2ecc71;">
            <div class="stat-icon" style="background: rgba(46, 204, 113, 0.1); color: #2ecc71;">
                <i class="bi bi-journal-arrow-up"></i>
            </div>
            <div>
                <p class="stat-label">Sedang Dipinjam</p>
                <h4 class="stat-value">{{ \App\Models\Peminjaman::where('status_peminjaman', 'dipinjam')->count() }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="border-left: 4px solid #3498db;">
            <div class="stat-icon" style="background: rgba(52, 152, 219, 0.1); color: #3498db;">
                <i class="bi bi-people"></i>
            </div>
            <div>
                <p class="stat-label">Total User</p>
                <h4 class="stat-value">{{ \App\Models\User::where('role', 'peminjam')->count() }}</h4>
            </div>
        </div>
    </div>
    @php
        $terlambat = \App\Models\Peminjaman::where('status_peminjaman', 'dipinjam')
            ->where('tanggal_peminjaman', '<', now()->subDays(7))
            ->count();
    @endphp
    <div class="col-md-3">
        <div class="stat-card" style="border-left: 4px solid #e74c3c;">
            <div class="stat-icon" style="background: rgba(231, 76, 60, 0.1); color: #e74c3c;">
                <i class="bi bi-alarm-fill"></i>
            </div>
            <div>
                <p class="stat-label">Terlambat Kembali</p>
                <h4 class="stat-value">{{ $terlambat }}</h4>
                <p class="mb-0" style="font-size:11px; color:#e74c3c;">{{ $terlambat > 0 ? 'Perlu ditindaklanjuti!' : 'Semua tepat waktu' }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-12">
        <div class="section-card">
            <div class="section-header">
                <div class="section-title">
                    <i class="bi bi-star-fill text-warning"></i> Buku Terbaru
                </div>
                <a href="{{ route('petugas.buku.index') }}" class="btn-view-all">Lihat Semua <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="row g-4">
                @php
                    $bukuTerbaru = \App\Models\Buku::with('ulasanbuku')->latest()->take(6)->get();
                @endphp
                @foreach($bukuTerbaru as $buku)
                <div class="col">
                    <a href="#" class="card book-card text-decoration-none">
                        <img src="{{ $buku->cover ? asset('storage/' . $buku->cover) : 'https://via.placeholder.com/300x400?text=' . urlencode($buku->judul) }}" class="book-cover" alt="{{ $buku->judul }}">
                        <div class="card-body p-0 pt-2">
                            <h6 class="book-title">{{ $buku->judul }}</h6>
                            <span class="book-author">{{ $buku->penulis }}</span>
                            @php
                                $avgRating = (int) round($buku->ulasanbuku->avg('rating') ?? 0);
                            @endphp
                            <div class="text-warning mt-1" style="font-size: 12px;">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="bi {{ $i <= $avgRating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                @endfor
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-2">
                                <span class="badge {{ $buku->stok > 0 ? 'bg-success' : 'bg-danger' }}">Stok: {{ $buku->stok }}</span>
                            </div>
                            <div class="text-muted small mt-1">{{ $buku->deskripsi ? \Illuminate\Support\Str::limit($buku->deskripsi, 60) : '-' }}</div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
