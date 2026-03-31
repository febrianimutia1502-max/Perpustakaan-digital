<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Perpustakaan Digital') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-purple: #8e44ad;
            --secondary-purple: #9b59b6;
            --dark-bg: #1e1e2d;
        }
        body {
            background-color: #f5f6fa;
            font-family: 'Inter', sans-serif;
        }
        .btn-primary {
            background: linear-gradient(to right, #6366F1, #A855F7);
            border: none;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }
        .btn-primary:hover {
            background: linear-gradient(to right, #4f46e5, #9333ea);
            transform: translateY(-1px);
        }
        .text-primary {
            color: #6366F1 !important;
        }
        .bg-primary {
            background: var(--primary-purple) !important;
        }
        .card {
            border-radius: 16px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>
    @yield('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>