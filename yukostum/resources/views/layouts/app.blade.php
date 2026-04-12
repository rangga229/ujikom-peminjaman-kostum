<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yukostum - Sewa Kostum Terlengkap</title>

   <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    
    <link href="{{ asset('assets/css/fonts.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8f9fa;
        }

        /* --- STYLING NAVBAR KHUSUS YUKOSTUM --- */
        .navbar-yukostum {
            background-color: #121212 !important; /* Hitam pekat yang lebih elegan */
            border-bottom: 3px solid #ffc107; /* Garis emas di bawah navbar */
            padding-top: 12px;
            padding-bottom: 12px;
        }

        .navbar-brand {
            font-weight: 800;
            letter-spacing: -0.5px;
            font-size: 1.4rem;
        }

        .nav-item-custom .nav-link {
            color: #a1a1aa !important; /* Abu-abu terang agar tidak menusuk mata */
            font-weight: 600;
            font-size: 0.95rem;
            padding: 8px 16px !important;
            margin: 0 2px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        /* Efek saat menu disentuh */
        .nav-item-custom .nav-link:hover {
            color: #ffc107 !important;
            background-color: rgba(255, 193, 7, 0.1);
        }

        /* Efek khusus untuk menu Dashboard Pelanggan */
        .nav-link-highlight {
            color: #121212 !important;
            background-color: #ffc107 !important;
            box-shadow: 0 4px 10px rgba(255, 193, 7, 0.3);
        }
        .nav-link-highlight:hover {
            background-color: #e0a800 !important;
            transform: translateY(-2px);
        }

        /* Styling Dropdown Profil */
        .user-pill {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        .user-pill:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    @if (!request()->is('login') && !request()->is('register'))
        <nav class="navbar navbar-expand-lg navbar-dark navbar-yukostum sticky-top shadow-sm">
            <div class="container">
                
                <a class="navbar-brand text-warning d-flex align-items-center gap-2" href="/katalog">
                     Yukostum
                </a>

                <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse mt-3 mt-lg-0" id="navbarNav">
                    
                    <ul class="navbar-nav me-auto nav-item-custom">
                        <li class="nav-item"><a class="nav-link" href="/katalog">Katalog Kostum</a></li>

                        @auth
                            @if (Auth::user()->role == 'admin')
                                <li class="nav-item"><a class="nav-link" href="/dashboard">Dashboard</a></li>
                                <li class="nav-item"><a class="nav-link" href="/admin/kostum">Kelola Kostum</a></li>
                                <li class="nav-item"><a class="nav-link" href="/admin/sewa">Riwayat Pesanan</a></li>
                                <li class="nav-item"><a class="nav-link" href="/admin/users">Kelola Pengguna</a></li>
                                <li class="nav-item"><a class="nav-link" href="/admin/logs">Log Sistem</a></li>
                            
                            @elseif(Auth::user()->role == 'petugas')
                                <li class="nav-item"><a class="nav-link" href="/dashboard">Dashboard</a></li>
                                <li class="nav-item"><a class="nav-link" href="/admin/kostum">Kelola Kostum</a></li>
                                <li class="nav-item"><a class="nav-link" href="/admin/sewa">Pesanan Sewa</a></li>
                            
                            @elseif(Auth::user()->role == 'pelanggan')
                                <li class="nav-item"><a class="nav-link" href="/riwayat">Riwayat Sewa Saya</a></li>
                                <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                                    <a class="nav-link nav-link-highlight rounded-pill px-4 text-center" href="/dashboard"> Dashboard</a>
                                </li>
                            @endif
                        @endauth
                    </ul>

                    <ul class="navbar-nav ms-auto align-items-lg-center mt-3 mt-lg-0 gap-2">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link fw-bold text-white px-3" href="/login">Masuk</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-warning text-dark fw-bold rounded-pill px-4 shadow-sm w-100" href="/register">Daftar Sekarang</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 user-pill rounded-pill px-3 py-2 text-white text-decoration-none" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="bg-warning text-dark rounded-circle d-flex justify-content-center align-items-center fw-bold" style="width: 28px; height: 28px; font-size: 13px;">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                    <span class="fw-semibold small">{{ Auth::user()->name }}</span>
                                </a>
                                
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-3 p-2" aria-labelledby="navbarDropdown">
                                    <li>
                                        <form action="/logout" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item rounded-3 text-danger fw-bold py-2 d-flex align-items-center gap-2">
                                                 Keluar (Logout)
                                            </button>
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

    <main class="container py-5 grow">

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm fw-bold rounded-4" role="alert">
                  {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')

    </main>

    <footer class="bg-dark text-white text-center py-4 mt-auto border-top border-secondary">
        <div class="container">
            <h5 class="fw-bold text-warning mb-1">Yukostum</h5>
            <p class="mb-0 text-white-50 small">&copy; {{ date('Y') }} Sistem Penyewaan Kostum Terpercaya.</p>
        </div>
    </footer>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>