@extends('layouts.dashboard')

@section('title', 'Laporan Data Buku')

@section('content')
<div class="section-card">
    <form method="GET" action="{{ route('admin.laporan.buku') }}">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="nama" class="form-label">Filter Nama Buku</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ request('nama') }}">
            </div>
            <div class="col-md-auto">
                <button type="submit" class="btn btn-secondary">Filter</button>
                <a href="{{ route('admin.laporan.buku', array_merge(request()->except('print'), ['print' => 'true'])) }}" class="btn btn-primary">
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
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun Terbit</th>
                </tr>
            </thead>
            <tbody>
                @forelse($buku as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->penulis }}</td>
                    <td>{{ $item->penerbit }}</td>
                    <td>{{ $item->tahun_terbit }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data buku.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
