@extends('layouts.dashboard')

@section('title', 'Koleksi Pribadi')

@section('content')
<div class="row">
    @if(session('success'))
        <div class="col-12">
            <div class="alert alert-success">{{ session('success') }}</div>
        </div>
    @endif

    @forelse($koleksi as $item)
    <div class="col-md-3 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title fw-bold text-primary">{{ $item->buku->judul }}</h5>
                <p class="card-text mb-1 text-muted">{{ $item->buku->penulis }}</p>
                <form action="{{ route('user.koleksi.destroy', $item->id) }}" method="POST" class="mt-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger w-100">Hapus dari Koleksi</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card p-5 text-center border-0 shadow-sm">
            <i class="bi bi-bookmark-heart fs-1 text-muted mb-3"></i>
            <h5>Koleksi Anda masih kosong.</h5>
            <p class="text-muted">Cari buku menarik di katalog dan tambahkan ke koleksi Anda!</p>
            <div class="mt-2">
                <a href="{{ route('user.catalog.index') }}" class="btn btn-primary">Lihat Katalog</a>
            </div>
        </div>
    </div>
    @endforelse
</div>
@endsection