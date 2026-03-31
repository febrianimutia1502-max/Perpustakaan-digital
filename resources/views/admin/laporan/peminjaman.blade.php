@extends('layouts.dashboard')

@section('title', 'Laporan Peminjaman')

@section('content')
<div class="section-card">
    <form method="GET" action="{{ route('admin.laporan.peminjaman') }}">
        <div class="row g-3 align-items-end mb-4">
            <div class="col-md-3">
                <label for="nama" class="form-label">Filter Nama Peminjam</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ request('nama') }}">
            </div>
            <div class="col-md-3">
                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
            </div>
            <div class="col-md-3">
                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" value="{{ request('tanggal_selesai') }}">
            </div>
            <div class="col-md-auto">
                <button type="submit" class="btn btn-secondary">Filter</button>
                <a href="{{ route('admin.laporan.peminjaman', array_merge(request()->except('print'), ['print' => 'true'])) }}" class="btn btn-primary">
                    <i class="bi bi-printer"></i> Cetak PDF
                </a>
            </div>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Peminjam</th>
                    <th>Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->user->nama_lengkap }}</td>
                    <td>{{ $item->buku->judul }}</td>
                    <td>{{ $item->tanggal_peminjaman }}</td>
                    <td>{{ $item->tanggal_pengembalian ?? '-' }}</td>
                    <td>
                        <span class="badge bg-{{ $item->status_peminjaman == 'selesai' ? 'success' : 'warning' }}">
                            {{ ucfirst($item->status_peminjaman) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data peminjaman.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
