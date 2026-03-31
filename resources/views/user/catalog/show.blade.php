@extends('layouts.dashboard')

@section('title', $buku->judul)

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="section-card">
            <img src="{{ $buku->cover ? asset('storage/' . $buku->cover) : 'https://via.placeholder.com/300x400?text=' . urlencode($buku->judul) }}" class="book-cover" alt="{{ $buku->judul }}">
        </div>
    </div>
    <div class="col-md-8">
        <div class="section-card">
            <h2 class="fw-bold">{{ $buku->judul }}</h2>
            <p class="text-muted">oleh {{ $buku->penulis }}</p>
            <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="badge {{ $buku->stok > 0 ? 'bg-success' : 'bg-danger' }}">{{ $buku->stok > 0 ? 'Tersedia' : 'Stok Habis' }}</span>
                <span class="badge bg-secondary">Stok: {{ $buku->stok }}</span>
            </div>
            @if($buku->deskripsi)
                <p>{{ $buku->deskripsi }}</p>
            @endif
            <div class="d-flex gap-2 mb-4">
                <button type="button" class="btn {{ $buku->stok > 0 ? 'btn-primary' : 'btn-secondary' }}" {{ $buku->stok > 0 ? '' : 'disabled' }} data-bs-toggle="modal" data-bs-target="#pinjamModal{{ $buku->id }}">
                    Pinjam
                </button>
                <form action="{{ route('user.koleksi.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="buku_id" value="{{ $buku->id }}">
                    <button type="submit" class="btn btn-outline-primary"><i class="bi bi-bookmark-heart"></i> Koleksi</button>
                </form>
            </div>
            <div class="modal fade" id="pinjamModal{{ $buku->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Konfirmasi Peminjaman</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="fw-semibold">{{ $buku->judul }}</div>
                            <div class="text-muted small">Penulis: {{ $buku->penulis }}</div>
                            <div class="text-muted small mt-2">Tanggal kembali (estimasi): {{ now()->addDays(7)->toDateString() }}</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <form action="{{ route('user.peminjaman.store') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="buku_id" value="{{ $buku->id }}">
                                <button type="submit" class="btn btn-primary">Ya, Pinjam</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Rating rata-rata --}}
            @php
                $avgRating = $buku->ulasanbuku->avg('rating') ?? 0;
                $totalUlasan = $buku->ulasanbuku->count();
            @endphp
            <div class="d-flex align-items-center mb-2">
                <div class="text-warning me-2">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="bi {{ $i <= round($avgRating) ? 'bi-star-fill' : 'bi-star' }}"></i>
                    @endfor
                </div>
                <span class="text-muted small">{{ number_format($avgRating, 1) }} / 5 &bull; {{ $totalUlasan }} ulasan</span>
            </div>
        </div>
    </div>
</div>

{{-- ====== SECTION ULASAN ====== --}}
<div class="row mt-2">
    <div class="col-12">
        <div class="section-card">
            <div class="section-header">
                <h5 class="section-title"><i class="bi bi-chat-square-text-fill text-primary"></i> Ulasan Pembaca</h5>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- Form Tulis / Edit Ulasan oleh user yang sudah mengembalikan buku --}}
            @if($peminjamanSelesai)
                <div class="card border-0 bg-light p-3 mb-4">
                    @if($ulasanUser)
                        <h6 class="fw-bold mb-3"><i class="bi bi-pencil-square"></i> Edit Ulasan Kamu</h6>
                        <form action="{{ route('user.ulasan.update', $ulasanUser->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                    @else
                        <h6 class="fw-bold mb-3"><i class="bi bi-chat-left-text"></i> Tulis Ulasan</h6>
                        <form action="{{ route('user.ulasan.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="buku_id" value="{{ $buku->id }}">
                    @endif

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Rating</label>
                            <div class="d-flex gap-1" id="catalogStarContainer">
                                @for($s = 1; $s <= 5; $s++)
                                    <i class="bi {{ ($ulasanUser && $s <= $ulasanUser->rating) ? 'bi-star-fill' : 'bi-star' }} fs-4 text-warning catalog-star"
                                       data-value="{{ $s }}"
                                       style="cursor:pointer;"></i>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="catalogRating" value="{{ $ulasanUser ? $ulasanUser->rating : '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Komentar</label>
                            <textarea name="ulasan" class="form-control" rows="3"
                                placeholder="Bagikan pengalamanmu membaca buku ini..."
                                required>{{ $ulasanUser ? $ulasanUser->ulasan : '' }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">
                            {{ $ulasanUser ? 'Simpan Perubahan' : 'Kirim Ulasan' }}
                        </button>
                    </form>
                </div>
            @endif

            {{-- Daftar semua ulasan --}}
            @if($buku->ulasanbuku->count() > 0)
                @foreach($buku->ulasanbuku->sortByDesc('created_at') as $ulasan)
                    <div class="d-flex gap-3 mb-3 pb-3 border-bottom">
                        <div class="flex-shrink-0">
                            <div style="width:40px;height:40px;background:linear-gradient(135deg,#6366F1,#A855F7);border-radius:10px;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;">
                                {{ strtoupper(substr($ulasan->user->nama_lengkap ?? 'U', 0, 1)) }}
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="fw-semibold" style="font-size:14px;">{{ $ulasan->user->nama_lengkap ?? 'Pengguna' }}</span>
                                <div class="text-warning" style="font-size:13px;">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi {{ $i <= $ulasan->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                    @endfor
                                </div>
                                <span class="text-muted small">{{ $ulasan->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="mb-0" style="font-size:14px;color:#444;">{{ $ulasan->ulasan }}</p>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center text-muted py-4">
                    <i class="bi bi-chat-square fs-1 d-block mb-2"></i>
                    Belum ada ulasan untuk buku ini.
                    @if($peminjamanSelesai)
                        Jadilah yang pertama memberi ulasan!
                    @else
                        Pinjam dan kembalikan buku ini untuk bisa memberi ulasan.
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Star rating interaktif di halaman katalog
const catalogStars = document.querySelectorAll('.catalog-star');
const catalogRatingInput = document.getElementById('catalogRating');

catalogStars.forEach(function(star) {
    star.addEventListener('click', function() {
        const value = this.getAttribute('data-value');
        catalogRatingInput.value = value;
        updateCatalogStars(value);
    });

    star.addEventListener('mouseover', function() {
        updateCatalogStars(this.getAttribute('data-value'));
    });

    star.addEventListener('mouseout', function() {
        updateCatalogStars(catalogRatingInput.value || 0);
    });
});

function updateCatalogStars(value) {
    catalogStars.forEach(function(s, idx) {
        if (idx < value) {
            s.classList.remove('bi-star');
            s.classList.add('bi-star-fill');
        } else {
            s.classList.remove('bi-star-fill');
            s.classList.add('bi-star');
        }
    });
}
</script>
@endsection
