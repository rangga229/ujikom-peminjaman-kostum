<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yukostum - Sewa Kostum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #fcf4d9;">

    @if(!request()->routeIs('login'))
    <nav class="navbar navbar-expand-lg navbar-dark mb-4 shadow-sm" style="background-color: #2c5e7b;">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="/katalog">
                <img src="{{ asset('images/logo_circle_yukostum.png') }}" alt="Logo Katak" width="45" height="45" class="me-2 rounded-circle border border-white">
                🎭 YUKOSTUM
            </a>
            
            <div class="d-flex align-items-center">
                @auth
                    <span class="text-white me-3 fw-bold">
                        Halo, {{ Auth::user()->name }} 
                        <span class="badge bg-secondary ms-1">{{ strtoupper(Auth::user()->role) }}</span>
                    </span>
                    <form action="/logout" method="POST" class="m-0">
                        @csrf
                        <button class="btn btn-danger btn-sm fw-bold">Keluar</button>
                    </form>
                @else
                    <a href="/login" class="btn btn-light btn-sm fw-bold">Masuk Admin</a>
                @endauth
            </div>
        </div>
    </nav>
    @endif

    <div class="container">
        @yield('content')
    </div>

</body>
</html>