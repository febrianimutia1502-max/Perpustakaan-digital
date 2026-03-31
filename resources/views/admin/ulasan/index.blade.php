@extends('layouts.dashboard')

@section('title', 'Manajemen Ulasan')

@section('content')
<div class="card p-4 shadow-sm border-0">
    <h5 class="fw-bold mb-4"><i class="bi bi-chat-square-text-fill me-2 text-primary"></i>Manajemen Ulasan Buku</h5>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Buku</th>
                    <th>Pengguna</th>
                    <th>Rating</th>
                    <th>Ulasan</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($ulasan as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div class="fw-semibold" style="max-width:180px;">{{ $item->buku->judul ?? '-' }}</div>
                        <div class="text-muted small">{{ $item->buku->penulis ?? '' }}</div>
                    </td>
                    <td>{{ $item->user->nama_lengkap ?? '-' }}</td>
                    <td>
                        <div class="text-warning" style="font-size:14px; white-space:nowrap;">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi {{ $i <= $item->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                            @endfor
                        </div>
                        <span class="badge bg-secondary">{{ $item->rating }}/5</span>
                    </td>
                    <td style="max-width:260px;">
                        <span style="font-size:13px;">{{ \Str::limit($item->ulasan, 100) }}</span>
                    </td>
                    <td>
                        <span style="font-size:12px;" class="text-muted">{{ $item->created_at->format('d/m/Y H:i') }}</span>
                    </td>
                    <td>
                        <form action="{{ route('admin.ulasan.destroy', $item->id) }}" method="POST"
                              onsubmit="return confirm('Hapus ulasan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-chat-square fs-1 d-block mb-2"></i>
                        Belum ada ulasan dari pengguna.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="text-muted small mt-2">
        Total: <strong>{{ $ulasan->count() }}</strong> ulasan
    </div>
</div>
@endsection
