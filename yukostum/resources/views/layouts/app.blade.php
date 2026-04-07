<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yukostum - Sewa Kostum Terlengkap</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f4f6f9; /* Warna latar belakang abu-abu sangat muda agar elegan */
        }
    </style>
</head>
<body>

@if(!request()->is('login') && !request()->is('register'))

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-warning" href="/katalog">🎭 Yukostum</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    
                    <li class="nav-item">
                        <a class="nav-link" href="/katalog">Katalog Kostum</a>
                    </li>

                    @auth
                        @if(Auth::user()->role == 'admin')
                            <li class="nav-item"><a class="nav-link" href="/dashboard">📊 Dashboard</a></li>
                            <li class="nav-item"><a class="nav-link" href="/admin/kostum">👕 Kelola Kostum</a></li>
                            <li class="nav-item"><a class="nav-link" href="/admin/users">👥 Kelola Pengguna</a></li>
                        
                        @elseif(Auth::user()->role == 'petugas')
                            <li class="nav-item"><a class="nav-link" href="/dashboard">📊 Dashboard</a></li>
                            <li class="nav-item"><a class="nav-link" href="/admin/kostum">👕 Kelola Kostum</a></li>
                            @elseif(Auth::user()->role == 'pelanggan')
                            <li class="nav-item"><a class="nav-link" href="#">📝 Riwayat Sewa Saya</a></li>
                        @endif
                    @endauth
                </ul>

                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="/login">Masuk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-warning text-dark fw-bold ms-2 px-3 py-1 mt-1" href="/register">Daftar</a>
                        </li>
                    
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-bold text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                👋 Halo, {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                <li>
                                    <form action="/logout" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger fw-bold">🚪 Keluar (Logout)</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
@endif
    <main class="container py-5 min-vh-100">
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm fw-bold" role="alert">
                🚨 {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
        
    </main>

    <footer class="bg-dark text-white text-center py-4 mt-auto">
        <div class="container">
            <p class="mb-0 opacity-75">&copy; {{ date('Y') }} Yukostum. Sistem Penyewaan Kostum Terpercaya.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>