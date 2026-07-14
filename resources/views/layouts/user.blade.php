<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'User Dashboard') | Serenity AI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/user-style.css') }}">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        /* Extra theme custom overrides */
        .sidebar-dark {
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }
        .main-content {
            background: var(--content-bg);
        }
    </style>
    <script>
        // Check local storage or system preference
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>
</head>
<body>

    <div class="app-container" id="app-container">
        
        <!-- Sidebar Dark (Icons) -->
        <aside class="sidebar-dark">
            <div class="logo-icon">
                <i class="ph-fill ph-brain"></i>
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
            <a href="{{ route('articles.index') }}" class="nav-icon {{ request()->routeIs('articles.*') ? 'active' : '' }}" title="Artikel Edukasi">
                <i class="ph-fill ph-book-open"></i>
            </a>
            <a href="{{ route('chatbot') }}" class="nav-icon {{ request()->routeIs('chatbot') ? 'active' : '' }}" title="Konseling AI">
                <i class="ph-fill ph-chat-circle"></i>
            </a>
            
            <form action="{{ route('logout') }}" method="POST" style="margin-top: auto;">
                @csrf
                <button type="submit" class="nav-icon" style="border:none; background:transparent; cursor:pointer;" title="Logout">
                    <i class="ph-fill ph-sign-out" style="color: #f43f5e;"></i>
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
                    <a href="{{ route('articles.index') }}" class="nav-text-item {{ request()->routeIs('articles.*') ? 'active' : '' }}">
                        Artikel
                    </a>
                </li>
                <li>
                    <a href="{{ route('chatbot') }}" class="nav-text-item {{ request()->routeIs('chatbot') ? 'active' : '' }}">
                        Konseling AI
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
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
                    <button class="icon-btn" id="theme-toggle" style="border:none;" title="Ganti Mode Tampilan">
                        <i class="ph-bold ph-moon" id="theme-icon"></i>
                    </button>
                    
                    <div class="user-profile">
                        <div class="user-info d-none d-md-flex flex-column text-end" style="justify-content: center; margin-right: 8px;">
                            <span class="user-name" style="font-size: 14px; font-weight: 700; color: var(--text-dark); line-height: 1.2;">{{ auth()->user()->name ?? 'Pengguna' }}</span>
                            <span class="user-role" style="font-size: 12px; color: var(--text-secondary); font-weight: 600;">Mahasiswa</span>
                        </div>
                        <div class="user-avatar" style="display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, #818cf8, #6366f1); position: relative;">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                            <span style="position: absolute; bottom: -2px; right: -2px; width: 12px; height: 12px; background-color: #10b981; border: 2px solid var(--sidebar-dark); border-radius: 50%;"></span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content with entrance animation -->
            <div class="page-content animated-card">
                @yield('content')
            </div>
        </main>

    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar Toggle
            const toggle = document.getElementById('mobile-toggle');
            const appContainer = document.getElementById('app-container');
            
            toggle.addEventListener('click', function() {
                if (window.innerWidth <= 992) {
                    appContainer.classList.toggle('show-sidebar');
                } else {
                    appContainer.classList.toggle('sidebar-collapsed');
                }
            });

            // Theme Switcher Logic
            const themeToggleBtn = document.getElementById('theme-toggle');
            const themeIcon = document.getElementById('theme-icon');
            
            function updateThemeUI(theme) {
                document.documentElement.setAttribute('data-theme', theme);
                if (theme === 'dark') {
                    themeIcon.className = 'ph-bold ph-sun';
                    themeIcon.style.color = '#f59e0b'; // Gold color for sun icon
                } else {
                    themeIcon.className = 'ph-bold ph-moon';
                    themeIcon.style.color = 'var(--text-secondary)';
                }
            }
            
            // Set initial state
            const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
            updateThemeUI(currentTheme);
            
            themeToggleBtn.addEventListener('click', function() {
                const targetTheme = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
                localStorage.setItem('theme', targetTheme);
                updateThemeUI(targetTheme);
                
                // Event dispatch to update chart color if needed
                window.dispatchEvent(new CustomEvent('themechanged', { detail: { theme: targetTheme } }));
            });
        });
    </script>
</body>
</html>
