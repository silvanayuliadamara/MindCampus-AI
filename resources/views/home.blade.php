<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serenity AI — Ruang Tenang Mahasiswa Akhir</title>
    <meta name="description" content="Serenity AI membantu mahasiswa tingkat akhir mendeteksi dan mengelola burnout akademik dengan teknologi Certainty Factor yang terpercaya.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        /* ===== RESET & BASE ===== */
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', sans-serif;
            background: #0a0f1a;
            color: #e2e8f0;
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* ===== ANIMATED BACKGROUND ===== */
        .bg-grid {
            position: fixed; inset: 0; z-index: 0;
            background-image:
                linear-gradient(rgba(20, 184, 166, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(20, 184, 166, 0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
        }
        .bg-glow-1, .bg-glow-2, .bg-glow-3 {
            position: fixed; border-radius: 50%; filter: blur(120px);
            pointer-events: none; z-index: 0;
        }
        .bg-glow-1 {
            width: 600px; height: 600px; top: -15%; left: -10%;
            background: rgba(13, 148, 136, 0.15);
            animation: glowDrift1 12s ease-in-out infinite alternate;
        }
        .bg-glow-2 {
            width: 500px; height: 500px; bottom: -10%; right: -5%;
            background: rgba(16, 185, 129, 0.12);
            animation: glowDrift2 15s ease-in-out infinite alternate;
        }
        .bg-glow-3 {
            width: 400px; height: 400px; top: 40%; left: 50%;
            background: rgba(99, 102, 241, 0.08);
            animation: glowDrift3 18s ease-in-out infinite alternate;
        }
        @keyframes glowDrift1 { to { transform: translate(60px, 40px) scale(1.15); } }
        @keyframes glowDrift2 { to { transform: translate(-50px, -30px) scale(1.1); } }
        @keyframes glowDrift3 { to { transform: translate(-30px, 60px) scale(0.9); } }

        /* ===== UTILITY ===== */
        .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; position: relative; z-index: 1; }
        .accent { color: #14b8a6; }
        .gradient-text {
            background: linear-gradient(135deg, #14b8a6, #10b981, #6366f1, #14b8a6);
            background-size: 300% 300%;
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientFlow 8s ease infinite;
        }
        @keyframes gradientFlow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 14px 32px; border-radius: 14px; font-weight: 600;
            font-size: 1rem; text-decoration: none; cursor: pointer;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: none; font-family: 'Inter', sans-serif;
        }
        .btn-primary {
            background: linear-gradient(135deg, #0d9488, #10b981);
            color: #fff; box-shadow: 0 4px 20px rgba(13, 148, 136, 0.35);
        }
        .btn-primary:hover {
            transform: translateY(-3px) scale(1.03);
            box-shadow: 0 8px 30px rgba(13, 148, 136, 0.5);
        }
        .btn-outline {
            background: transparent; color: #14b8a6;
            border: 2px solid rgba(20, 184, 166, 0.4);
        }
        .btn-outline:hover {
            background: rgba(20, 184, 166, 0.1); transform: translateY(-3px);
            border-color: #14b8a6;
        }
        .section-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(20, 184, 166, 0.1); border: 1px solid rgba(20, 184, 166, 0.2);
            border-radius: 999px; padding: 6px 18px; font-size: 0.8rem; font-weight: 600;
            color: #14b8a6; letter-spacing: 0.5px; text-transform: uppercase;
            margin-bottom: 16px;
        }
        .section-title {
            font-size: clamp(2rem, 4vw, 2.8rem); font-weight: 800;
            line-height: 1.2; margin-bottom: 16px;
        }
        .section-desc {
            font-size: 1.1rem; color: #94a3b8; max-width: 600px; line-height: 1.7;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            padding: 16px 0;
            background: rgba(10, 15, 26, 0.6);
            backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255,255,255,0.04);
            transition: all 0.3s ease;
        }
        .navbar.scrolled {
            padding: 10px 0;
            background: rgba(10, 15, 26, 0.9);
            box-shadow: 0 4px 30px rgba(0,0,0,0.3);
        }
        .navbar .container {
            display: flex; align-items: center; justify-content: space-between;
        }
        .nav-brand {
            display: flex; align-items: center; gap: 12px;
            text-decoration: none; color: #fff;
        }
        .nav-brand-icon {
            width: 42px; height: 42px; border-radius: 12px;
            background: linear-gradient(135deg, #0d9488, #10b981);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; color: #fff;
            box-shadow: 0 4px 15px rgba(13, 148, 136, 0.4);
        }
        .nav-brand span {
            font-size: 1.3rem; font-weight: 700;
        }
        .nav-links { display: flex; align-items: center; gap: 8px; list-style: none; }
        .nav-links a {
            color: #94a3b8; text-decoration: none; padding: 8px 16px;
            border-radius: 10px; font-size: 0.9rem; font-weight: 500;
            transition: all 0.25s ease;
        }
        .nav-links a:hover { color: #fff; background: rgba(255,255,255,0.06); }
        .nav-actions { display: flex; align-items: center; gap: 12px; }
        .nav-actions .btn { padding: 10px 24px; font-size: 0.9rem; }
        .mobile-menu-btn {
            display: none; background: none; border: none; color: #fff;
            font-size: 1.5rem; cursor: pointer; padding: 8px;
        }

        /* ===== HERO ===== */
        .hero {
            min-height: 100vh; display: flex; align-items: center;
            padding: 120px 0 80px;
        }
        .hero .container {
            display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center;
        }
        .hero-tag {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(20, 184, 166, 0.08); border: 1px solid rgba(20, 184, 166, 0.15);
            border-radius: 999px; padding: 8px 20px; font-size: 0.85rem;
            color: #14b8a6; margin-bottom: 24px; font-weight: 500;
            animation: fadeInUp 0.8s ease backwards;
        }
        .hero-tag .pulse-dot {
            width: 8px; height: 8px; border-radius: 50%; background: #14b8a6;
            animation: pulse 2s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.5); }
        }
        .hero h1 {
            font-size: clamp(2.5rem, 5vw, 3.8rem); font-weight: 900;
            line-height: 1.1; margin-bottom: 24px;
            animation: fadeInUp 0.8s ease 0.15s backwards;
        }
        .hero-desc {
            font-size: 1.15rem; color: #94a3b8; line-height: 1.8;
            margin-bottom: 36px; max-width: 520px;
            animation: fadeInUp 0.8s ease 0.3s backwards;
        }
        .hero-actions {
            display: flex; gap: 16px; flex-wrap: wrap;
            animation: fadeInUp 0.8s ease 0.45s backwards;
        }
        .hero-stats {
            display: flex; gap: 40px; margin-top: 48px;
            animation: fadeInUp 0.8s ease 0.6s backwards;
        }
        .hero-stat-value {
            font-size: 2rem; font-weight: 800; color: #fff;
        }
        .hero-stat-label {
            font-size: 0.8rem; color: #64748b; font-weight: 500;
            text-transform: uppercase; letter-spacing: 0.5px;
        }

        /* Hero Visual */
        .hero-visual {
            position: relative; display: flex; justify-content: center; align-items: center;
            animation: fadeInUp 1s ease 0.3s backwards;
        }
        .hero-orb {
            width: 420px; height: 420px; border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, rgba(20, 184, 166, 0.2), rgba(16, 185, 129, 0.08), transparent 70%);
            border: 1px solid rgba(20, 184, 166, 0.1);
            position: relative;
            animation: orbFloat 6s ease-in-out infinite alternate;
        }
        @keyframes orbFloat {
            0% { transform: translateY(0) scale(1); }
            100% { transform: translateY(-20px) scale(1.03); }
        }
        .hero-orb::before {
            content: ''; position: absolute; inset: -30px; border-radius: 50%;
            border: 1px dashed rgba(20, 184, 166, 0.12);
            animation: orbSpin 30s linear infinite;
        }
        .hero-orb::after {
            content: ''; position: absolute; inset: -60px; border-radius: 50%;
            border: 1px dashed rgba(99, 102, 241, 0.08);
            animation: orbSpin 45s linear infinite reverse;
        }
        @keyframes orbSpin { to { transform: rotate(360deg); } }

        .orb-icon {
            position: absolute; display: flex; align-items: center; justify-content: center;
            width: 60px; height: 60px; border-radius: 16px;
            background: rgba(10, 15, 26, 0.8);
            backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(20, 184, 166, 0.15);
            font-size: 1.5rem; color: #14b8a6;
            box-shadow: 0 8px 30px rgba(0,0,0,0.3);
            animation: iconFloat1 6s ease-in-out infinite alternate;
        }
        .orb-icon:nth-child(1) { top: 10%; left: -5%; animation: iconFloat1 5s ease-in-out infinite alternate; }
        .orb-icon:nth-child(2) { top: 5%; right: 0%; animation: iconFloat2 6s ease-in-out infinite alternate; }
        .orb-icon:nth-child(3) { bottom: 15%; left: -8%; animation: iconFloat3 7s ease-in-out infinite alternate; }
        .orb-icon:nth-child(4) { bottom: 5%; right: -3%; animation: iconFloat4 8s ease-in-out infinite alternate; }
        @keyframes iconFloat1 {
            0% { transform: translateY(0) rotate(0deg); }
            100% { transform: translateY(-15px) rotate(8deg); }
        }
        @keyframes iconFloat2 {
            0% { transform: translateY(0) rotate(0deg); }
            100% { transform: translateY(-12px) translateX(6px) rotate(-8deg); }
        }
        @keyframes iconFloat3 {
            0% { transform: translateY(0) rotate(0deg); }
            100% { transform: translateY(-10px) translateX(-6px) rotate(-12deg); }
        }
        @keyframes iconFloat4 {
            0% { transform: translateY(0) rotate(0deg); }
            100% { transform: translateY(-16px) rotate(10deg); }
        }
        .orb-center-icon {
            position: absolute; inset: 0; display: flex; align-items: center;
            justify-content: center; font-size: 5rem; color: #14b8a6;
            filter: drop-shadow(0 0 30px rgba(20, 184, 166, 0.3));
        }

        /* ===== FEATURES ===== */
        .features { padding: 100px 0; }
        .features-header { text-align: center; margin-bottom: 60px; }
        .features-header .section-desc { margin: 0 auto; }
        .features-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;
        }
        .feature-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 20px; padding: 36px; position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .feature-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0;
            height: 3px; background: linear-gradient(90deg, transparent, #14b8a6, transparent);
            opacity: 0; transition: opacity 0.4s ease;
        }
        .feature-card:hover {
            transform: translateY(-8px);
            background: rgba(255,255,255,0.05);
            border-color: rgba(20, 184, 166, 0.2);
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .feature-card:hover::before { opacity: 1; }
        .feature-icon {
            width: 56px; height: 56px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; margin-bottom: 20px;
            background: linear-gradient(135deg, rgba(20, 184, 166, 0.15), rgba(20, 184, 166, 0.05));
            color: #14b8a6;
        }
        .feature-card h3 {
            font-size: 1.15rem; font-weight: 700; color: #fff; margin-bottom: 10px;
        }
        .feature-card p {
            font-size: 0.9rem; color: #94a3b8; line-height: 1.7;
        }

        /* ===== HOW IT WORKS ===== */
        .how-it-works { padding: 100px 0; }
        .how-it-works-header { text-align: center; margin-bottom: 60px; }
        .how-it-works-header .section-desc { margin: 0 auto; }
        .steps-grid {
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 32px;
            position: relative;
        }
        .steps-grid::before {
            content: ''; position: absolute; top: 48px; left: 12.5%; right: 12.5%;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(20, 184, 166, 0.3), rgba(20, 184, 166, 0.3), transparent);
        }
        .step-card { text-align: center; position: relative; }
        .step-number {
            width: 56px; height: 56px; border-radius: 50%;
            background: linear-gradient(135deg, #0d9488, #10b981);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; font-weight: 800; color: #fff;
            margin: 0 auto 20px;
            box-shadow: 0 4px 20px rgba(13, 148, 136, 0.35);
            position: relative; z-index: 2;
        }
        .step-card h3 {
            font-size: 1.05rem; font-weight: 700; color: #fff; margin-bottom: 8px;
        }
        .step-card p {
            font-size: 0.85rem; color: #94a3b8; line-height: 1.6;
        }

        /* ===== STATS BANNER ===== */
        .stats-banner {
            padding: 60px 0;
        }
        .stats-inner {
            background: linear-gradient(135deg, rgba(13, 148, 136, 0.12), rgba(16, 185, 129, 0.06));
            border: 1px solid rgba(20, 184, 166, 0.15);
            border-radius: 24px; padding: 60px 40px;
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 32px;
            text-align: center;
        }
        .stat-item {}
        .stat-number {
            font-size: 2.5rem; font-weight: 900;
            background: linear-gradient(135deg, #14b8a6, #10b981);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .stat-label {
            font-size: 0.9rem; color: #94a3b8; margin-top: 4px; font-weight: 500;
        }

        /* ===== TESTIMONIALS ===== */
        .testimonials { padding: 100px 0; }
        .testimonials-header { text-align: center; margin-bottom: 60px; }
        .testimonials-header .section-desc { margin: 0 auto; }
        .testimonials-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;
        }
        .testimonial-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 20px; padding: 32px; position: relative;
            transition: all 0.3s ease;
        }
        .testimonial-card:hover {
            transform: translateY(-4px);
            border-color: rgba(20, 184, 166, 0.15);
        }
        .testimonial-stars {
            display: flex; gap: 4px; margin-bottom: 16px; color: #fbbf24; font-size: 0.9rem;
        }
        .testimonial-text {
            font-size: 0.95rem; color: #cbd5e1; line-height: 1.7;
            margin-bottom: 20px; font-style: italic;
        }
        .testimonial-author {
            display: flex; align-items: center; gap: 12px;
        }
        .testimonial-avatar {
            width: 44px; height: 44px; border-radius: 50%;
            background: linear-gradient(135deg, #0d9488, #6366f1);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; color: #fff; font-size: 1rem;
        }
        .testimonial-name {
            font-size: 0.9rem; font-weight: 600; color: #fff;
        }
        .testimonial-role {
            font-size: 0.78rem; color: #64748b;
        }

        /* ===== CTA ===== */
        .cta-section { padding: 100px 0 120px; }
        .cta-inner {
            text-align: center;
            background: linear-gradient(135deg, rgba(13, 148, 136, 0.15), rgba(99, 102, 241, 0.08));
            border: 1px solid rgba(20, 184, 166, 0.12);
            border-radius: 32px; padding: 80px 40px;
            position: relative; overflow: hidden;
        }
        .cta-inner::before {
            content: ''; position: absolute; top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: radial-gradient(circle, rgba(20, 184, 166, 0.06), transparent 50%);
            animation: ctaPulse 8s ease-in-out infinite;
        }
        @keyframes ctaPulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 1; }
        }
        .cta-inner > * { position: relative; z-index: 1; }
        .cta-inner .section-title { margin-bottom: 16px; }
        .cta-inner .section-desc { margin: 0 auto 36px; }
        .cta-actions { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; }

        /* ===== FOOTER ===== */
        .footer {
            border-top: 1px solid rgba(255,255,255,0.05);
            padding: 40px 0;
        }
        .footer .container {
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 16px;
        }
        .footer-text { font-size: 0.85rem; color: #64748b; }
        .footer-links { display: flex; gap: 24px; list-style: none; }
        .footer-links a {
            color: #64748b; text-decoration: none; font-size: 0.85rem;
            transition: color 0.25s ease;
        }
        .footer-links a:hover { color: #14b8a6; }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .reveal {
            opacity: 0; transform: translateY(35px) scale(0.97);
            transition: opacity 1.1s cubic-bezier(0.16, 1, 0.3, 1), transform 1.1s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal.visible {
            opacity: 1; transform: translateY(0) scale(1);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .hero .container { grid-template-columns: 1fr; text-align: center; }
            .hero-desc { margin: 0 auto 36px; }
            .hero-actions { justify-content: center; }
            .hero-stats { justify-content: center; }
            .hero-visual { display: none; }
            .features-grid { grid-template-columns: repeat(2, 1fr); }
            .steps-grid { grid-template-columns: repeat(2, 1fr); }
            .steps-grid::before { display: none; }
            .stats-inner { grid-template-columns: repeat(2, 1fr); }
            .testimonials-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .nav-links { display: none; }
            .mobile-menu-btn { display: block; }
            .features-grid { grid-template-columns: 1fr; }
            .steps-grid { grid-template-columns: 1fr; }
            .stats-inner { grid-template-columns: 1fr; }
            .hero h1 { font-size: 2.2rem; }
            .hero-stats { flex-direction: column; gap: 16px; align-items: center; }
        }

        /* ===== MOBILE DRAWER ===== */
        .mobile-drawer {
            position: fixed; inset: 0; z-index: 200;
            visibility: hidden; opacity: 0; transition: all 0.35s ease;
        }
        .mobile-drawer.open { visibility: visible; opacity: 1; }
        .mobile-drawer-overlay {
            position: absolute; inset: 0; background: rgba(0,0,0,0.6);
            backdrop-filter: blur(4px);
        }
        .mobile-drawer-panel {
            position: absolute; top: 0; right: 0; bottom: 0;
            width: 280px; background: #111827; padding: 24px;
            transform: translateX(100%); transition: transform 0.35s ease;
            display: flex; flex-direction: column; gap: 8px;
        }
        .mobile-drawer.open .mobile-drawer-panel { transform: translateX(0); }
        .mobile-drawer-close {
            align-self: flex-end; background: none; border: none;
            color: #94a3b8; font-size: 1.5rem; cursor: pointer; padding: 8px;
        }
        .mobile-drawer a {
            display: block; color: #cbd5e1; text-decoration: none;
            padding: 12px 16px; border-radius: 10px; font-size: 1rem; font-weight: 500;
            transition: background 0.25s ease;
        }
        .mobile-drawer a:hover { background: rgba(255,255,255,0.06); }
    </style>
</head>
<body>
    <!-- Background Effects -->
    <div class="bg-grid"></div>
    <div class="bg-glow-1"></div>
    <div class="bg-glow-2"></div>
    <div class="bg-glow-3"></div>

    <!-- NAVBAR -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <a href="/" class="nav-brand">
                <div class="nav-brand-icon"><i class="ph-fill ph-brain"></i></div>
                <span>Serenity AI</span>
            </a>
            <ul class="nav-links">
                <li><a href="#features">Fitur</a></li>
                <li><a href="#how-it-works">Cara Kerja</a></li>
                <li><a href="#testimonials">Testimoni</a></li>
            </ul>
            <div class="nav-actions">
                <a href="{{ route('login') }}" class="btn btn-outline" style="font-size: 0.9rem; padding: 10px 24px;">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-primary" style="font-size: 0.9rem; padding: 10px 24px;">Daftar Gratis</a>
            </div>
            <button class="mobile-menu-btn" id="mobile-menu-btn">
                <i class="ph-bold ph-list"></i>
            </button>
        </div>
    </nav>

    <!-- MOBILE DRAWER -->
    <div class="mobile-drawer" id="mobile-drawer">
        <div class="mobile-drawer-overlay" id="drawer-overlay"></div>
        <div class="mobile-drawer-panel">
            <button class="mobile-drawer-close" id="drawer-close"><i class="ph-bold ph-x"></i></button>
            <a href="#features">Fitur</a>
            <a href="#how-it-works">Cara Kerja</a>
            <a href="#testimonials">Testimoni</a>
            <hr style="border-color: rgba(255,255,255,0.08); margin: 8px 0;">
            <a href="{{ route('login') }}">Masuk</a>
            <a href="{{ route('register') }}" style="color: #14b8a6; font-weight: 600;">Daftar Gratis</a>
        </div>
    </div>

    <!-- HERO SECTION -->
    <section class="hero" id="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-tag">
                    <span class="pulse-dot"></span>
                    Platform Deteksi Burnout #1 di Kampus
                </div>
                <h1>Kenali <span class="gradient-text">Burnout</span> Sebelum Terlambat.</h1>
                <p class="hero-desc">
                    Serenity AI membantu mahasiswa tingkat akhir mendeteksi dan mengelola burnout akademik 
                    menggunakan teknologi <strong>Certainty Factor</strong> yang tervalidasi secara ilmiah.
                </p>
                <div class="hero-actions">
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        <i class="ph-bold ph-rocket-launch"></i> Mulai Diagnosis Gratis
                    </a>
                    <a href="#how-it-works" class="btn btn-outline">
                        <i class="ph-bold ph-play-circle"></i> Pelajari Lebih
                    </a>
                </div>
                <div class="hero-stats">
                    <div>
                        <div class="hero-stat-value" id="counter-users">{{ $studentCount }}+</div>
                        <div class="hero-stat-label">Mahasiswa</div>
                    </div>
                    <div>
                        <div class="hero-stat-value">98%</div>
                        <div class="hero-stat-label">Akurasi</div>
                    </div>
                    <div>
                        <div class="hero-stat-value">24/7</div>
                        <div class="hero-stat-label">Tersedia</div>
                    </div>
                </div>
            </div>
            <div class="hero-visual">
                <div class="hero-orb">
                    <div class="orb-icon"><i class="ph-fill ph-brain"></i></div>
                    <div class="orb-icon"><i class="ph-fill ph-heart-half"></i></div>
                    <div class="orb-icon"><i class="ph-fill ph-chart-line-up"></i></div>
                    <div class="orb-icon"><i class="ph-fill ph-shield-check"></i></div>
                    <div class="orb-center-icon"><i class="ph-fill ph-stethoscope"></i></div>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section class="features" id="features">
        <div class="container">
            <div class="features-header reveal">
                <div class="section-badge"><i class="ph-bold ph-sparkle"></i> Fitur Unggulan</div>
                <h2 class="section-title">Semua yang Kamu Butuhkan untuk <span class="gradient-text">Tetap Sehat Mental</span></h2>
                <p class="section-desc">Platform lengkap yang dirancang khusus untuk mendampingi perjalanan akademikmu hingga wisuda.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card reveal">
                    <div class="feature-icon"><i class="ph-fill ph-stethoscope"></i></div>
                    <h3>Diagnosis Cerdas</h3>
                    <p>Algoritma Certainty Factor yang menganalisis gejala burnout berdasarkan riset psikologi terkini dan memberikan hasil yang akurat.</p>
                </div>
                <div class="feature-card reveal">
                    <div class="feature-icon" style="background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(99, 102, 241, 0.05)); color: #818cf8;">
                        <i class="ph-fill ph-chart-line-up"></i>
                    </div>
                    <h3>Tracking Progress</h3>
                    <p>Pantau perkembangan tingkat burnout-mu dari waktu ke waktu melalui grafik interaktif dan riwayat diagnosis terperinci.</p>
                </div>
                <div class="feature-card reveal">
                    <div class="feature-icon" style="background: linear-gradient(135deg, rgba(244, 63, 94, 0.15), rgba(244, 63, 94, 0.05)); color: #f43f5e;">
                        <i class="ph-fill ph-heart-half"></i>
                    </div>
                    <h3>Self-Care Tips</h3>
                    <p>Dapatkan rekomendasi perawatan diri yang dipersonalisasi sesuai tingkat dan pola burnout yang terdeteksi.</p>
                </div>
                <div class="feature-card reveal">
                    <div class="feature-icon" style="background: linear-gradient(135deg, rgba(251, 191, 36, 0.15), rgba(251, 191, 36, 0.05)); color: #fbbf24;">
                        <i class="ph-fill ph-book-open"></i>
                    </div>
                    <h3>Artikel Edukasi</h3>
                    <p>Koleksi artikel berkualitas seputar kesehatan mental, strategi coping, dan tips menghadapi tekanan akademik.</p>
                </div>
                <div class="feature-card reveal">
                    <div class="feature-icon" style="background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(34, 197, 94, 0.05)); color: #22c55e;">
                        <i class="ph-fill ph-shield-check"></i>
                    </div>
                    <h3>Privasi Terjamin</h3>
                    <p>Data diagnosismu terenkripsi dan hanya bisa diakses olehmu sendiri. Keamanan dan privasi adalah prioritas kami.</p>
                </div>
                <div class="feature-card reveal">
                    <div class="feature-icon" style="background: linear-gradient(135deg, rgba(168, 85, 247, 0.15), rgba(168, 85, 247, 0.05)); color: #a855f7;">
                        <i class="ph-fill ph-lightning"></i>
                    </div>
                    <h3>Hasil Instan</h3>
                    <p>Dapatkan analisis mendalam dalam hitungan detik. Tidak perlu menunggu atau membuat janji konsultasi.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section class="how-it-works" id="how-it-works">
        <div class="container">
            <div class="how-it-works-header reveal">
                <div class="section-badge"><i class="ph-bold ph-path"></i> Cara Kerja</div>
                <h2 class="section-title">Empat Langkah Menuju <span class="gradient-text">Ketenangan</span></h2>
                <p class="section-desc">Proses diagnosis yang simpel, cepat, dan berbasis riset ilmiah.</p>
            </div>
            <div class="steps-grid">
                <div class="step-card reveal">
                    <div class="step-number">1</div>
                    <h3>Daftar Akun</h3>
                    <p>Buat akun gratis dengan email kampusmu dalam 30 detik.</p>
                </div>
                <div class="step-card reveal">
                    <div class="step-number">2</div>
                    <h3>Pilih Gejala</h3>
                    <p>Jawab pertanyaan interaktif seputar kondisi fisik & mentalmu saat ini.</p>
                </div>
                <div class="step-card reveal">
                    <div class="step-number">3</div>
                    <h3>Analisis AI</h3>
                    <p>Sistem menganalisis jawabanmu menggunakan metode Certainty Factor.</p>
                </div>
                <div class="step-card reveal">
                    <div class="step-number">4</div>
                    <h3>Lihat Hasil</h3>
                    <p>Dapatkan tingkat burnout, rekomendasi, dan tips perawatan diri.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- STATS BANNER -->
    <section class="stats-banner reveal">
        <div class="container">
            <div class="stats-inner">
                <div class="stat-item">
                    <div class="stat-number">{{ $studentCount }}+</div>
                    <div class="stat-label">Mahasiswa Terbantu</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $diagnosisCount }}+</div>
                    <div class="stat-label">Diagnosis Selesai</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">Tingkat Akurasi</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">4.9</div>
                    <div class="stat-label">Rating Pengguna</div>
                </div>
            </div>
        </div>
    </section>

    <!-- TESTIMONIALS -->
    <section class="testimonials" id="testimonials">
        <div class="container">
            <div class="testimonials-header reveal">
                <div class="section-badge"><i class="ph-bold ph-chat-circle-text"></i> Testimoni</div>
                <h2 class="section-title">Kata Mereka tentang <span class="gradient-text">Serenity AI</span></h2>
                <p class="section-desc">Cerita nyata dari mahasiswa yang telah merasakan manfaat platform kami.</p>
            </div>
            <div class="testimonials-grid">
                <div class="testimonial-card reveal">
                    <div class="testimonial-stars">
                        <i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i>
                    </div>
                    <p class="testimonial-text">"Serenity AI membantu saya menyadari bahwa saya sedang mengalami burnout berat saat mengerjakan skripsi. Rekomendasi yang diberikan sangat actionable dan relevan."</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">RA</div>
                        <div>
                            <div class="testimonial-name">Rina Aisyah</div>
                            <div class="testimonial-role">Mahasiswa Psikologi, Semester 8</div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card reveal">
                    <div class="testimonial-stars">
                        <i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i>
                    </div>
                    <p class="testimonial-text">"Tracking progress-nya keren banget! Saya bisa lihat perkembangan mental health saya dari minggu ke minggu. Fitur ini bikin saya lebih aware sama diri sendiri."</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">BK</div>
                        <div>
                            <div class="testimonial-name">Budi Kurniawan</div>
                            <div class="testimonial-role">Mahasiswa Teknik Informatika, Semester 7</div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card reveal">
                    <div class="testimonial-stars">
                        <i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star-half"></i>
                    </div>
                    <p class="testimonial-text">"Sebagai mahasiswa yang tinggal jauh dari keluarga, platform ini seperti punya teman curhat yang bisa dipercaya. Artikel-artikelnya juga sangat membantu."</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">DP</div>
                        <div>
                            <div class="testimonial-name">Dewi Putri</div>
                            <div class="testimonial-role">Mahasiswa Farmasi, Semester 8</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-inner reveal">
                <div class="section-badge"><i class="ph-bold ph-rocket-launch"></i> Mulai Sekarang</div>
                <h2 class="section-title">Siap Menjaga Kesehatan <span class="gradient-text">Mentalmu?</span></h2>
                <p class="section-desc">Bergabung dengan ratusan mahasiswa lainnya yang telah mengambil langkah pertama menuju ketenangan batin.</p>
                <div class="cta-actions">
                    <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 16px 40px; font-size: 1.05rem;">
                        <i class="ph-bold ph-user-plus"></i> Daftar Gratis Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline">
                        <i class="ph-bold ph-sign-in"></i> Sudah Punya Akun
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <div class="footer-text">
                &copy; {{ date('Y') }} Serenity AI. Dibuat dengan <span style="color: #f43f5e;">❤</span> untuk mahasiswa Indonesia.
            </div>
            <ul class="footer-links">
                <li><a href="#features">Fitur</a></li>
                <li><a href="#how-it-works">Cara Kerja</a></li>
                <li><a href="#testimonials">Testimoni</a></li>
                <li><a href="{{ route('login') }}">Masuk</a></li>
            </ul>
        </div>
    </footer>

    <script>
        // ===== NAVBAR SCROLL EFFECT =====
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 50);
        });

        // ===== MOBILE DRAWER =====
        const mobileBtn = document.getElementById('mobile-menu-btn');
        const drawer = document.getElementById('mobile-drawer');
        const drawerOverlay = document.getElementById('drawer-overlay');
        const drawerClose = document.getElementById('drawer-close');

        mobileBtn.addEventListener('click', () => drawer.classList.add('open'));
        drawerOverlay.addEventListener('click', () => drawer.classList.remove('open'));
        drawerClose.addEventListener('click', () => drawer.classList.remove('open'));
        drawer.querySelectorAll('a').forEach(a => {
            a.addEventListener('click', () => drawer.classList.remove('open'));
        });

        // ===== SCROLL REVEAL =====
        const revealElements = document.querySelectorAll('.reveal');
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    setTimeout(() => entry.target.classList.add('visible'), i * 80);
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
        revealElements.forEach(el => revealObserver.observe(el));

        // ===== SMOOTH SCROLL =====
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const offset = 80;
                    const top = target.getBoundingClientRect().top + window.pageYOffset - offset;
                    window.scrollTo({ top, behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>
