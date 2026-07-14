<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') | Serenity AI</title>
    <script>
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        .row { margin: 0; }
        
        /* Premium Sidebar Redesign */
        .sidebar {
            background: linear-gradient(180deg, #1e1b4b 0%, #0f172a 100%) !important;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 10px 0 30px rgba(0, 0, 0, 0.15);
        }
        
        .sidebar .brand {
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            padding-bottom: 24px;
            margin-bottom: 24px;
        }
        
        .sidebar .brand-logo {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
            border-radius: 14px;
        }
        
        .sidebar .brand-logo i {
            color: #ffffff !important;
        }
        
        .sidebar .brand-title {
            color: #ffffff !important;
            font-size: 18px;
            letter-spacing: -0.5px;
            font-weight: 800;
        }
        
        .sidebar .brand-subtitle {
            color: #10b981 !important;
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .menu-label {
            color: rgba(255, 255, 255, 0.3) !important;
            font-size: 11px !important;
            font-weight: 800 !important;
            letter-spacing: 1.5px !important;
        }
        
        .nav-links li a {
            color: rgba(255, 255, 255, 0.6) !important;
            border-radius: 12px !important;
            margin: 0 8px;
            padding: 12px 16px !important;
            transition: all 0.25s ease !important;
        }
        
        .nav-links li a:hover {
            background: rgba(255, 255, 255, 0.05) !important;
            color: #ffffff !important;
        }
        
        .nav-links li a.active {
            background: rgba(255, 255, 255, 0.08) !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .nav-links li a.active::before {
            display: none !important; /* Remove old square indicator */
        }
        
        .nav-links li a.active i {
            color: #10b981 !important;
        }
        
        .btn-logout button {
            background: rgba(239, 68, 68, 0.1) !important;
            color: #ef4444 !important;
            border: 1px solid rgba(239, 68, 68, 0.2) !important;
            border-radius: 12px !important;
            font-weight: 700 !important;
            transition: all 0.2s ease !important;
        }
        
        .btn-logout button:hover {
            background: #ef4444 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
        }
        
        /* Premium Card Styling */
        .neo-card, .solid-card {
            background: var(--bg-surface) !important;
            border-radius: 20px !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02) !important;
            border: 1px solid var(--border-color) !important;
            transition: all 0.3s ease;
        }
        
        /* Topbar adjustments */
        .topbar {
            border-bottom: 1px solid var(--border-color) !important;
            background: var(--bg-surface) !important;
            color: var(--text-main) !important;
        }
        
        .theme-toggle, .menu-toggle {
            border-radius: 10px !important;
            border: 1px solid var(--border-color) !important;
            background: var(--bg-surface) !important;
            color: var(--text-muted) !important;
            transition: all 0.2s ease;
        }
        
        .theme-toggle:hover, .menu-toggle:hover {
            background: var(--bg-body) !important;
            transform: scale(1.03);
        }
        
        .avatar {
            background: linear-gradient(135deg, #4361ee 0%, #3f37c9 100%) !important;
            font-weight: 800 !important;
            border-radius: 12px !important;
        }

        /* Custom Premium Pagination Styling */
        .pagination {
            margin: 0 !important;
            gap: 4px;
        }
        .page-item .page-link {
            border: 1px solid var(--border-color) !important;
            color: var(--text-main) !important;
            padding: 8px 14px !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            border-radius: 8px !important;
            background: var(--bg-surface) !important;
            transition: all 0.2s ease !important;
        }
        .page-item.active .page-link {
            background: var(--primary) !important;
            color: #ffffff !important;
            border-color: var(--primary) !important;
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.2) !important;
        }
        .page-item .page-link:hover {
            background: var(--bg-body) !important;
            border-color: var(--border-color) !important;
        }
        .page-item.disabled .page-link {
            opacity: 0.5 !important;
            background: var(--bg-surface) !important;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="brand">
            <div class="brand-logo">
                <i class="ph-fill ph-brain" style="color: #ffffff;"></i>
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
                
                <div class="theme-toggle" id="theme-toggle" style="cursor: pointer;">
                    <i class="ph ph-moon" id="theme-icon"></i>
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

            // Theme Switcher Logic
            const themeToggleBtn = document.getElementById('theme-toggle');
            const themeIcon = document.getElementById('theme-icon');
            
            function updateThemeUI(theme) {
                document.documentElement.setAttribute('data-theme', theme);
                if (theme === 'dark') {
                    themeIcon.className = 'ph ph-sun';
                    themeIcon.style.color = '#f59e0b'; // Gold color for sun icon
                } else {
                    themeIcon.className = 'ph ph-moon';
                    themeIcon.style.color = '';
                }
            }
            
            // Set initial state
            const currentTheme = localStorage.getItem('theme') || 'light';
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
