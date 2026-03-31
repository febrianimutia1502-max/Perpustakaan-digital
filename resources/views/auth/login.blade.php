@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h3 class="text-center text-primary mb-4 fw-bold">Login Perpustakaan</h3>
                    
                    @if(session('success'))
                        <div class="alert alert-success small">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="username" value="{{ old('username') }}" required autofocus>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password" required>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100 py-2">Login</button>
                        </div>
                        <div class="text-center">
                            <span class="small text-muted">Belum punya akun? <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-bold">Daftar Sekarang</a></span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center mt-3">
                <a href="/" class="text-muted text-decoration-none small">&larr; Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>
@endsection