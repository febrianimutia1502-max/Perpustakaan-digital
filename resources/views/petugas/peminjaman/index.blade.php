@extends('layouts.dashboard')

@section('title', 'Kelola Peminjaman')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0">Riwayat Peminjaman</h5>
    </div>
    <div class="card-body">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th width="50">No</th>
                    <th>Nama User</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->user->nama_lengkap }}</td>
                    <td>{{ $item->buku->judul }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->toDateString() }}</td>
                    <td>
                        @if($item->tanggal_pengembalian)
                            {{ \Carbon\Carbon::parse($item->tanggal_pengembalian)->toDateString() }}
                        @else
                            {{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->addDays(7)->toDateString() }}
                        @endif
                    </td>
                    <td>
                        @php
                            $statusLabel = match ($item->status_peminjaman) {
                                'pending' => 'Menunggu',
                                'dipinjam' => 'Dipinjam',
                                'dikembalikan' => 'Dikembalikan',
                                'ditolak' => 'Ditolak',
                                default => 'Selesai',
                            };
                            $statusClass = match ($item->status_peminjaman) {
                                'pending' => 'text-bg-warning',
                                'dipinjam' => 'text-bg-primary',
                                'dikembalikan' => 'text-bg-info',
                                'ditolak' => 'text-bg-danger',
                                default => 'text-bg-success',
                            };
                        @endphp
                        <span class="badge rounded-pill {{ $statusClass }}">{{ $statusLabel }}</span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}">Detail</button>
                        @if($item->status_peminjaman === 'pending')
                            <form action="{{ route($role . '.peminjaman.confirm', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Setujui</button>
                            </form>
                            <form action="{{ route($role . '.peminjaman.reject', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                            </form>
                        @elseif($item->status_peminjaman === 'dikembalikan')
                            <form action="{{ route($role . '.peminjaman.confirm-return', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Selesaikan</button>
                            </form>
                        @endif
                    </td>
                </tr>

                <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Peminjaman</h5>
                                <button class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        @if($item->buku->cover)
                                            <img src="{{ asset('storage/' . $item->buku->cover) }}" class="img-fluid rounded">
                                        @else
                                            <img src="{{ 'https://via.placeholder.com/300x400?text=' . urlencode($item->buku->judul) }}" class="img-fluid rounded">
                                        @endif
                                    </div>
                                    <div class="col-md-8">
                                        <div class="mb-2"><strong>Username:</strong> {{ $item->user->username }}</div>
                                        <div class="mb-2"><strong>Nama User:</strong> {{ $item->user->nama_lengkap }}</div>
                                        <div class="mb-2"><strong>Email:</strong> {{ $item->user->email }}</div>
                                        <div class="mb-2"><strong>Alamat:</strong> {{ $item->user->alamat }}</div>
                                        <div class="mb-2"><strong>Judul Buku:</strong> {{ $item->buku->judul }}</div>
                                        <div class="mb-2"><strong>Tanggal Pinjam:</strong> {{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->toDateString() }}</div>
                                        <div class="mb-2"><strong>Tanggal Kembali:</strong>
                                            @if($item->tanggal_pengembalian)
                                                {{ \Carbon\Carbon::parse($item->tanggal_pengembalian)->toDateString() }}
                                            @else
                                                {{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->addDays(7)->toDateString() }}
                                            @endif
                                        </div>
                                        <div class="mb-2"><strong>Status:</strong> <span class="badge rounded-pill {{ $statusClass }}">{{ $statusLabel }}</span></div>
                                        <div class="mb-2"><strong>Stok Saat Ini:</strong> {{ $item->buku->stok }}</div>
                                        <div class="mb-2"><strong>Kategori:</strong>
                                            @foreach($item->buku->kategoribuku as $kat)
                                                <span class="badge bg-secondary">{{ $kat->nama_kategori }}</span>
                                            @endforeach
                                        </div>
                                        <div class="mb-2"><strong>Deskripsi:</strong></div>
                                        <div class="text-muted">{{ $item->buku->deskripsi ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4">Belum ada data peminjaman.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection
