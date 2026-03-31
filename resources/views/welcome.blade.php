<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-purple: #8e44ad;
            --secondary-purple: #9b59b6;
            --dark-bg: #1e1e2d;
        }
        .hero-section {
            background: linear-gradient(rgba(30, 30, 45, 0.8), rgba(30, 30, 45, 0.8)), url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            height: 100vh;
            color: white;
            display: flex;
            align-items: center;
        }
        .btn-success {
            background: linear-gradient(to right, #6366F1, #A855F7);
            border: none;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }
        .btn-success:hover {
            background: linear-gradient(to right, #4f46e5, #9333ea);
            transform: translateY(-1px);
        }
        .text-success {
            color: #6366F1 !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-success" href="#">PERPUS DIGITAL</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            @php
                                $dashboard = Auth::user()->role == 'admin' ? 'admin.dashboard' : (Auth::user()->role == 'petugas' ? 'petugas.dashboard' : 'user.dashboard');
                            @endphp
                            <a class="btn btn-success px-4" href="{{ route($dashboard) }}">Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-success ms-lg-3 px-4" href="{{ route('register') }}">Daftar</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <header class="hero-section">
        <div class="container text-center">
            <h1 class="display-3 fw-bold mb-4">Selamat Datang di <br> Perpustakaan Digital</h1>
            <p class="lead mb-5">Akses ribuan buku dengan mudah, cepat, dan di mana saja. <br> Mari tingkatkan minat baca bersama kami.</p>
            @guest
                <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 py-3 fw-bold text-success">Mulai Membaca</a>
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-5 py-3 fw-bold">Login Member</a>
                </div>
            @endguest
        </div>
    </header>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>