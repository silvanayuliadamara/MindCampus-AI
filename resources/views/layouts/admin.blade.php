<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') | Serenity AI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        .row { margin: 0; }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="brand">
            <div class="brand-logo">
                <i class="ph-fill ph-brain" style="color: #000;"></i>
            </div>
            <div class="brand-title">Serenity AI</div>
            <div class="brand-subtitle">Administrator</div>
        </div>
        
        <div class="menu-label">DASHBOARD</div>
        <ul class="nav-links">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="ph ph-squares-four"></i> <span>Dashboard</span>
                </a>
            </li>
        </ul>

        <div class="menu-label">KNOWLEDGE BASE</div>
        <ul class="nav-links">
            <li>
                <a href="{{ route('admin.symptoms.index') }}" class="{{ request()->routeIs('admin.symptoms.*') ? 'active' : '' }}">
                    <i class="ph ph-stethoscope"></i> <span>Kelola Gejala</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.students.index') }}" class="{{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                    <i class="ph ph-users"></i> <span>Data Mahasiswa</span>
                </a>
            </li>
        </ul>
        
        <div class="btn-logout">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">
                    <i class="ph ph-sign-out" style="display:none;" id="logout-icon"></i> <span id="logout-text">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content" id="main-content">
        <!-- Topbar -->
        <header class="topbar">
            <div class="topbar-left">
                <div class="menu-toggle" id="menu-toggle">
                    <i class="ph ph-list"></i>
                </div>
                <div class="page-title">
                    <h1>@yield('title', 'Dashboard')</h1>
                    <p>Selamat datang kembali, Admin</p>
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
                        <div class="profile-role">Administrator</div>
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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const menuToggle = document.getElementById('menu-toggle');
            
            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            });
            
            // Auto collapse on small screens
            if (window.innerWidth < 768) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            }
        });
    </script>
</body>
</html>
