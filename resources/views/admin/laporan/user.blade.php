@extends('layouts.dashboard')

@section('title', 'Laporan Data User')

@section('content')
<div class="section-card">
    <form method="GET" action="{{ route('admin.laporan.user') }}">
        <div class="row g-3 align-items-end mb-4">
            <div class="col-md-4">
                <label for="nama" class="form-label">Filter Nama User</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ request('nama') }}">
            </div>
            <div class="col-md-auto">
                <button type="submit" class="btn btn-secondary">Filter</button>
                <a href="{{ route('admin.laporan.user', array_merge(request()->except('print'), ['print' => 'true'])) }}" class="btn btn-primary">
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
                    <th>Username</th>
                    <th>Email</th>
                    <th>Nama Lengkap</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->nama_lengkap }}</td>
                    <td>{{ $user->alamat }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data user.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
