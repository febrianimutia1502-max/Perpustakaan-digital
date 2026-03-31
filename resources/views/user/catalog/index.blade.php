@extends('layouts.dashboard')

@section('title', 'Katalog Buku')

@section('content')
<div class="row">
    @if(session('success'))
        <div class="col-12">
            <div class="alert alert-success">{{ session('success') }}</div>
        </div>
    @endif
    @if(session('error'))
        <div class="col-12">
            <div class="alert alert-danger">{{ session('error') }}</div>
        </div>
    @endif

    @foreach($buku as $item)
    <div class="col-md-3 mb-4">
        <div class="section-card h-100 p-3 d-flex flex-column">
            <a href="{{ route('user.catalog.show', $item->id) }}" class="text-decoration-none">
                <img src="{{ $item->cover ? asset('storage/' . $item->cover) : 'https://via.placeholder.com/300x400?text=' . urlencode($item->judul) }}" class="book-cover" alt="{{ $item->judul }}">
                <div class="card-body p-0 pt-2">
                    <h6 class="book-title">{{ $item->judul }}</h6>
                    <span class="book-author">{{ $item->penulis }}</span>
                    @php
                        $avgRating = (int) round($item->ulasanbuku->avg('rating') ?? 0);
                    @endphp
                    <div class="text-warning mt-1" style="font-size: 12px;">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="bi {{ $i <= $avgRating ? 'bi-star-fill' : 'bi-star' }}"></i>
                        @endfor
                    </div>
                </div>
            </a>
            <div class="text-muted small mt-2">Stok: {{ $item->stok }}</div>
            <div class="d-flex gap-2 mt-auto pt-3">
                <button type="button" class="btn btn-sm w-100 flex-grow-1 {{ $item->stok > 0 ? 'btn-primary' : 'btn-secondary' }}" {{ $item->stok > 0 ? '' : 'disabled' }} data-bs-toggle="modal" data-bs-target="#pinjamModal{{ $item->id }}">
                    Pinjam
                </button>
                <form action="{{ route('user.koleksi.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="buku_id" value="{{ $item->id }}">
                    <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-bookmark-heart"></i></button>
                </form>
            </div>
        </div>

        <div class="modal fade" id="pinjamModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Peminjaman</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="fw-semibold">{{ $item->judul }}</div>
                        <div class="text-muted small">Penulis: {{ $item->penulis }}</div>
                        <div class="text-muted small mt-2">Tanggal kembali (estimasi): {{ now()->addDays(7)->toDateString() }}</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('user.peminjaman.store') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="buku_id" value="{{ $item->id }}">
                            <button type="submit" class="btn btn-primary">Ya, Pinjam</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
