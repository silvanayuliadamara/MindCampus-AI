<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'User Dashboard') | Serenity AI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/user-style.css') }}">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>

    <div class="app-container" id="app-container">
        
        <!-- Sidebar Dark (Icons) -->
        <aside class="sidebar-dark">
            <div class="logo-icon">
                <i class="ph-bold ph-brain"></i>
            </div>
            
            <a href="{{ route('dashboard') }}" class="nav-icon {{ request()->routeIs('dashboard') ? 'active' : '' }}" title="Dashboard">
                <i class="ph-fill ph-squares-four"></i>
            </a>
            <a href="{{ route('diagnosis.wizard') }}" class="nav-icon {{ request()->routeIs('diagnosis.wizard') ? 'active' : '' }}" title="Mulai Diagnosis">
                <i class="ph-fill ph-stethoscope"></i>
            </a>
            <a href="{{ route('diagnosis.history') }}" class="nav-icon {{ request()->routeIs('diagnosis.history') ? 'active' : '' }}" title="Riwayat Diagnosis">
                <i class="ph-fill ph-clock-counter-clockwise"></i>
            </a>
            <a href="#" class="nav-icon" title="Artikel Edukasi">
                <i class="ph-fill ph-book-open"></i>
            </a>
            
            <form action="{{ route('logout') }}" method="POST" style="margin-top: auto;">
                @csrf
                <button type="submit" class="nav-icon" style="border:none; background:transparent; cursor:pointer;" title="Logout">
                    <i class="ph-fill ph-sign-out" style="color: #ff7675;"></i>
                </button>
            </form>
        </aside>

        <!-- Sidebar Light (Text Menu) -->
        <aside class="sidebar-light">
            <div class="brand-text">Serenity AI</div>
            
            <ul class="nav-text-menu">
                <li>
                    <a href="{{ route('dashboard') }}" class="nav-text-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('diagnosis.wizard') }}" class="nav-text-item {{ request()->routeIs('diagnosis.wizard') ? 'active' : '' }}">
                        Diagnosis Baru
                    </a>
                </li>
                <li>
                    <a href="{{ route('diagnosis.history') }}" class="nav-text-item {{ request()->routeIs('diagnosis.history') ? 'active' : '' }}">
                        Riwayat
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-text-item">
                        Artikel
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content (Floating White Container) -->
        <main class="main-content">
            <!-- Topbar -->
            <header class="topbar">
                <div style="display: flex; align-items: center; gap: 20px;">
                    <button id="mobile-toggle" class="icon-btn" style="border:none;">
                        <i class="ph-bold ph-list"></i>
                    </button>
                    
                    <div class="page-title-section">
                        <h1 class="page-title">@yield('page_title', 'Dashboard')</h1>
                        <p class="page-subtitle">@yield('page_subtitle', 'Selamat datang kembali')</p>
                    </div>
                </div>

                <div class="topbar-icons">
                    <button class="icon-btn" style="border:none;" title="Mode Gelap">
                        <i class="ph ph-moon" style="font-size: 20px;"></i>
                    </button>
                    
                    <div class="user-profile">
                        <div class="user-info d-none d-md-flex flex-column text-end" style="justify-content: center; margin-right: 8px;">
                            <span class="user-name" style="font-size: 14px; font-weight: 800; color: var(--text-dark); line-height: 1.2;">{{ auth()->user()->name ?? 'Pengguna' }}</span>
                            <span class="user-role" style="font-size: 12px; color: var(--text-muted); font-weight: 600;">Member</span>
                        </div>
                        <div class="user-avatar" style="display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; width: 42px; height: 42px; border-radius: 12px; background: var(--sidebar-dark); position: relative;">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                            <span style="position: absolute; bottom: -2px; right: -2px; width: 14px; height: 14px; background-color: #2ecc71; border: 2px solid #fff; border-radius: 50%;"></span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="page-content">
                @yield('content')
            </div>
        </main>

    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('mobile-toggle');
            const appContainer = document.getElementById('app-container');
            
            toggle.addEventListener('click', function() {
                if (window.innerWidth <= 992) {
                    appContainer.classList.toggle('show-sidebar');
                } else {
                    appContainer.classList.toggle('sidebar-collapsed');
                }
            });
        });
    </script>
</body>
</html>
