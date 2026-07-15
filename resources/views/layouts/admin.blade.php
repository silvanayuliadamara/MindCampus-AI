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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Global styles */
        
        /* Premium Sidebar Redesign (Match User Theme) */
        .sidebar {
            background: #0097a7 !important; /* Soft Teal Sidebar */
            border-right: none;
            box-shadow: 4px 0 25px rgba(0, 151, 167, 0.15);
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: none; /* Firefox */
            padding-top: 0 !important; /* Remove top padding to align brand with topbar */
        }
        .sidebar::-webkit-scrollbar {
            display: none; /* Safari and Chrome */
        }
        
        .sidebar .brand {
            height: 80px; /* Match topbar height */
            flex-shrink: 0 !important; /* Prevent shrinking if sidebar content is long */
            display: flex;
            flex-direction: row !important;
            align-items: center;
            justify-content: flex-start;
            padding: 0 24px !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            margin-bottom: 24px;
            gap: 12px !important;
            position: sticky;
            top: 0;
            z-index: 10;
            background: #0097a7; /* Keep background solid when scrolling over it */
        }
        
        .sidebar.collapsed .brand {
            justify-content: center !important;
            padding: 0 !important;
        }
        
        .sidebar.collapsed .brand-info {
            display: none;
        }
        
        .sidebar .brand-logo {
            background: #fde047 !important; /* Soft Yellow */
            box-shadow: 0 4px 15px rgba(253, 224, 71, 0.3);
            border-radius: 12px;
            width: 40px !important;
            height: 40px !important;
            font-size: 24px !important;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .sidebar .brand-logo i {
            color: #0097a7 !important; /* Teal icon */
        }
        
        .sidebar .brand-info {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .sidebar .brand-title {
            color: #ffffff !important;
            font-size: 16px;
            letter-spacing: -0.5px;
            font-weight: 800;
            line-height: 1.2;
        }
        
        .sidebar .brand-subtitle {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 700;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 2px;
        }
        
        .menu-label {
            color: rgba(255, 255, 255, 0.5) !important;
            font-size: 11px !important;
            font-weight: 800 !important;
            letter-spacing: 1.5px !important;
            margin-top: 16px !important;
            margin-bottom: 8px !important;
        }
        
        .nav-links li a {
            color: rgba(255, 255, 255, 0.7) !important;
            border-radius: 12px !important;
            margin: 0 8px;
            padding: 10px 16px !important;
            transition: all 0.25s ease !important;
        }
        
        .nav-links li a:hover {
            background: rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
        }
        
        .nav-links li a.active {
            background: rgba(255, 255, 255, 0.25) !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        
        .nav-links li a.active::before {
            display: none !important; /* Remove old square indicator */
        }
        
        .nav-links li a.active i {
            color: #ffffff !important;
        }
        
        .btn-logout {
            margin-top: 16px !important;
            padding: 0 24px 24px 24px !important;
        }
        
        .btn-logout button {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            padding: 12px 16px !important;
            border-radius: 12px !important;
            font-weight: 700 !important;
            font-size: 14px !important;
            transition: all 0.3s ease !important;
            cursor: pointer;
        }
        
        .btn-logout button:hover {
            background: #ef4444 !important; /* Solid Red on hover */
            color: #ffffff !important;
            border-color: #ef4444 !important;
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
            transform: translateY(-2px);
        }
        
        .btn-logout button i {
            font-size: 18px;
        }
        
        .sidebar.collapsed .btn-logout {
            padding: 0 16px 24px 16px !important;
        }
        
        .sidebar.collapsed .btn-logout button {
            padding: 12px 0 !important;
        }
        
        .sidebar.collapsed .btn-logout button span {
            display: none !important;
        }
        
        .sidebar.collapsed .btn-logout button i {
            display: block !important;
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
        
        .menu-toggle {
            border-radius: 10px !important;
            border: 1px solid var(--border-color) !important;
            background: var(--bg-surface) !important;
            color: var(--text-muted) !important;
            transition: all 0.2s ease;
        }
        
        .menu-toggle:hover {
            background: var(--bg-body) !important;
            transform: scale(1.03);
        }
        
        /* Floating Theme Toggle */
        .theme-toggle-floating {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            border-radius: 50% !important;
            background: var(--bg-surface) !important;
            border: 1px solid var(--border-color) !important;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: var(--text-muted) !important;
            cursor: pointer;
            z-index: 9999;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .theme-toggle-floating:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 15px 35px rgba(0,0,0,0.12);
            color: var(--primary) !important;
        }
        
        .avatar {
            background: #0097a7 !important;
            color: #ffffff !important;
            font-weight: 800 !important;
            border-radius: 12px !important;
        }
        
        .btn-primary {
            background-color: #0097a7 !important;
            border-color: #0097a7 !important;
            color: #ffffff !important;
        }
        
        .btn-primary:hover {
            background-color: #008391 !important;
            border-color: #008391 !important;
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
            background: #0097a7 !important;
            color: #ffffff !important;
            border-color: #0097a7 !important;
            box-shadow: 0 4px 10px rgba(0, 151, 167, 0.2) !important;
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
            <div class="brand-info">
                <div class="brand-title">Serenity AI</div>
                <div class="brand-subtitle">Administrator</div>
            </div>
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
        
        <div class="menu-label">PENGATURAN</div>
        <ul class="nav-links">
            <li>
                <a href="{{ route('admin.profile.edit') }}" class="{{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                    <i class="ph ph-user"></i> <span>Profil</span>
                </a>
            </li>
        </ul>
        
        <div class="btn-logout">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">
                    <i class="ph ph-sign-out"></i> <span>Logout</span>
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
            </div>

            <div class="topbar-right">
                <div class="date-display">
                    <i class="ph ph-calendar-blank"></i> {{ date('l, d F Y') }}
                </div>
                
                <div class="dropdown">
                    <div class="profile-widget" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                        <div class="profile-info">
                            <div class="profile-name">{{ auth()->user()->name }}</div>
                            <div class="profile-role">Administrator</div>
                        </div>
                        <div class="avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="border-radius: 12px; margin-top: 15px; min-width: 200px; background: var(--bg-surface); border: 1px solid var(--border-color) !important;">
                        <li>
                            <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="{{ route('admin.profile.edit') }}" style="color: var(--text-main); font-weight: 600;">
                                <i class="ph ph-user text-muted" style="font-size: 18px;"></i> Profil Saya
                            </a>
                        </li>
                        <li><hr class="dropdown-divider" style="border-color: var(--border-color);"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 d-flex align-items-center gap-2 text-danger" style="font-weight: 600;">
                                    <i class="ph ph-sign-out" style="font-size: 18px;"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="page-content">
            @yield('content')
        </div>
    </main>
    
    <!-- Floating Theme Toggle -->
    <div class="theme-toggle-floating" id="theme-toggle" title="Ubah Tema (Terang/Gelap)">
        <i class="ph ph-moon" id="theme-icon"></i>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // SweetAlert for all confirmations
            const forms = document.querySelectorAll('form[onsubmit*="return confirm"]');
            forms.forEach(form => {
                const match = form.getAttribute('onsubmit').match(/confirm\('([^']+)'\)/);
                if (match) {
                    const confirmText = match[1];
                    form.removeAttribute('onsubmit');
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Konfirmasi',
                            text: confirmText,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#ef4444',
                            cancelButtonColor: '#94a3b8',
                            confirmButtonText: 'Ya, Lanjutkan',
                            cancelButtonText: 'Batal',
                            customClass: {
                                popup: 'rounded-4'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                }
            });

            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const menuToggle = document.getElementById('menu-toggle');
            
            // Sidebar State Management
            const savedSidebarState = localStorage.getItem('sidebarState');
            if (savedSidebarState === 'collapsed') {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            }

            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
                
                // Save state
                if (sidebar.classList.contains('collapsed')) {
                    localStorage.setItem('sidebarState', 'collapsed');
                } else {
                    localStorage.setItem('sidebarState', 'full');
                }
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
