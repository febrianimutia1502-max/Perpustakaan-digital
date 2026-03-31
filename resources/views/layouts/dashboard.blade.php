<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Perpustakaan Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-bg: #1E293B;
            --sidebar-active-bg: linear-gradient(to right, #6366F1, #A855F7);
            --primary-purple: #6366F1;
            --sidebar-width: 260px;
            --body-bg: #F1F5F9;
        }
        body {
            background-color: var(--body-bg);
            font-family: 'Inter', sans-serif;
            color: #2f3542;
        }
        #sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            background-color: var(--sidebar-bg);
            color: #a2a3b7;
            transition: all 0.3s;
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }
        #sidebar.active {
            margin-left: calc(-1 * var(--sidebar-width));
        }
        .sidebar-header {
            padding: 25px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .logo-box {
            width: 40px;
            height: 40px;
            background: var(--sidebar-active-bg);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            box-shadow: 0 4px 10px rgba(142, 68, 173, 0.3);
        }
        .sidebar-header h5 {
            margin: 0;
            color: white;
            font-weight: 700;
            font-size: 18px;
            line-height: 1.2;
        }
        .sidebar-header span {
            font-size: 12px;
            color: #565674;
            display: block;
        }
        .sidebar-menu {
            flex: 1;
            padding: 10px 15px;
            overflow-y: auto;
        }
        .menu-label {
            font-size: 11px;
            text-transform: uppercase;
            font-weight: 700;
            color: #464e5f;
            margin: 20px 0 10px 15px;
            letter-spacing: 1px;
        }
        .nav-link {
            color: #a2a3b7;
            padding: 12px 15px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 5px;
            font-weight: 500;
            transition: all 0.2s;
        }
        .nav-link:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.05);
        }
        .nav-link.active {
            background: var(--sidebar-active-bg);
            color: white;
            box-shadow: 0 4px 15px rgba(142, 68, 173, 0.4);
        }
        .nav-link i {
            font-size: 18px;
        }
        .sidebar-footer {
            padding: 20px;
            background-color: #1b1b28;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }
        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.03);
            padding: 10px;
            border-radius: 12px;
            text-decoration: none;
        }
        .user-avatar {
            width: 35px;
            height: 35px;
            background: var(--primary-purple);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
        }
        .user-info {
            flex: 1;
            overflow: hidden;
        }
        .user-name {
            display: block;
            color: white;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
        }
        .user-role {
            display: block;
            color: #565674;
            font-size: 11px;
        }
        .logout-btn {
            color: #a2a3b7;
            background: none;
            border: none;
            padding: 0;
            font-size: 18px;
            transition: color 0.2s;
        }
        .logout-btn:hover {
            color: #e74c3c;
        }
        #content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s;
        }
        #content.active {
            margin-left: 0;
        }
        .top-navbar {
            background: transparent;
            padding: 20px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .content-body {
            padding: 0 30px 30px 30px;
        }
        .page-title h3 {
            font-weight: 700;
            margin: 0;
            color: #181c32;
        }
        .page-title span {
            color: #b5b5c3;
            font-size: 14px;
        }
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            border: none;
            box-shadow: 0 0 20px rgba(0,0,0,0.02);
            display: flex;
            align-items: center;
            gap: 15px;
            height: 100%;
        }
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        .stat-label {
            color: #b5b5c3;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 2px;
        }
        .stat-value {
            color: #181c32;
            font-size: 24px;
            font-weight: 700;
            margin: 0;
        }
        .section-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            border: none;
            box-shadow: 0 0 20px rgba(0,0,0,0.02);
            margin-bottom: 30px;
        }
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .section-title {
            font-weight: 700;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .book-card {
            border: none;
            transition: transform 0.2s;
        }
        .book-card:hover {
            transform: translateY(-5px);
        }
        .book-cover {
            border-radius: 12px;
            width: 100%;
            aspect-ratio: 3/4;
            object-fit: cover;
            margin-bottom: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .book-title {
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 2px;
            color: #181c32;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .book-author {
            color: #b5b5c3;
            font-size: 12px;
        }
        .btn-view-all {
            color: var(--primary-purple);
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
        }
        .btn-view-all:hover {
            text-decoration: underline;
        }
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -var(--sidebar-width);
            }
            #sidebar.active {
                margin-left: 0;
            }
            #content {
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <div class="logo-box">
                <i class="bi bi-book-half"></i>
            </div>
            <div>
                <h5>Perpustakaan</h5>
                <span>Digital Library System</span>
            </div>
        </div>

        <div class="sidebar-menu">
            <ul class="nav flex-column">
                @if(Auth::user()->role == 'admin')
                    @include('layouts.sidebar.admin')
                @elseif(Auth::user()->role == 'petugas')
                    @include('layouts.sidebar.petugas')
                @else
                    @include('layouts.sidebar.user')
                @endif
            </ul>
        </div>

        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->nama_lengkap, 0, 1)) }}
                </div>
                <div class="user-info">
                    <span class="user-name">{{ Auth::user()->nama_lengkap }}</span>
                    <span class="user-role">{{ ucfirst(Auth::user()->role) }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div id="content">
        <div class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <button type="button" id="sidebarCollapse" class="btn btn-white shadow-sm rounded-3">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <div class="page-title">
                    <h3>@yield('title')</h3>
                    <span>@yield('subtitle', 'Selamat datang di Perpustakaan Digital')</span>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="search-box d-none d-md-block">
                    <!-- Search could go here -->
                </div>
                <!-- Notifications, etc. -->
            </div>
        </div>

        <div class="content-body">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('sidebarCollapse').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('content').classList.toggle('active');
        });
    </script>
    @yield('scripts')
</body>
</html>