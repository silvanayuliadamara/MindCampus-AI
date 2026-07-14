<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | Serenity AI</title>
    <!-- Bootstrap 5 CSS (Used mainly for grid system) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        .row { margin: 0; }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-logo">
                <i class="ph-fill ph-brain" style="color: #000;"></i>
            </div>
            <div class="brand-title">Serenity AI</div>
            <div class="brand-subtitle">
                {{ auth()->user()->role->name === 'admin' ? 'Admin Administrator' : 'Mahasiswa Reguler' }}
            </div>
        </div>
        
        <div class="menu-label">DASHBOARD</div>
        <ul class="nav-links">
            @if(auth()->user()->role->name === 'admin')
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="ph ph-squares-four"></i> Dashboard
                    </a>
                </li>
            @else
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="ph ph-squares-four"></i> Dashboard
                    </a>
                </li>
            @endif
        </ul>

        <div class="menu-label">AKADEMIK & DIAGNOSIS</div>
        <ul class="nav-links">
            @if(auth()->user()->role->name === 'admin')
                <li><a href="#"><i class="ph ph-stethoscope"></i> Kelola Gejala</a></li>
                <li><a href="#"><i class="ph ph-users"></i> Data Mahasiswa</a></li>
            @else
                <li>
                    <a href="{{ route('diagnosis.wizard') }}" class="{{ request()->routeIs('diagnosis.*') && !request()->routeIs('diagnosis.history') ? 'active' : '' }}">
                        <i class="ph ph-stethoscope"></i> Mulai Diagnosis
                    </a>
                </li>
                <li>
                    <a href="{{ route('diagnosis.history') }}" class="{{ request()->routeIs('diagnosis.history') ? 'active' : '' }}">
                        <i class="ph ph-clock-counter-clockwise"></i> Riwayat Diagnosis
                    </a>
                </li>
                <li><a href="#"><i class="ph ph-book-open"></i> Artikel Edukasi</a></li>
            @endif
        </ul>
        
        <div class="btn-logout">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Topbar -->
        <header class="topbar">
            <div class="topbar-left">
                <div class="menu-toggle">
                    <i class="ph ph-list"></i>
                </div>
                <div class="page-title">
                    <h1>@yield('title', 'Dashboard')</h1>
                    <p>Selamat datang kembali, {{ explode(' ', auth()->user()->name)[0] }}</p>
                </div>
            </div>

            <div class="topbar-right">
                <div class="date-display">
                    <i class="ph ph-calendar-blank"></i> {{ date('l, d F Y') }}
                </div>
                
                <div class="theme-toggle">
                    <i class="ph ph-moon"></i>
                </div>
                
                <div class="profile-widget">
                    <div class="profile-info">
                        <div class="profile-name">{{ auth()->user()->name }}</div>
                        <div class="profile-role">{{ auth()->user()->role->name === 'admin' ? 'Administrator' : 'Mahasiswa' }}</div>
                    </div>
                    <div class="avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="page-content">
            @yield('content')
        </div>
    </main>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
