@extends('layouts.user')
@section('title', 'Hasil Diagnosis Burnout')
@section('page_title', 'Hasil Diagnosis')
@section('page_subtitle', 'Analisis mendalam tingkat burnout Anda')

@section('content')
<style>
    .result-hero {
        text-align: center;
        padding: 40px 32px;
        border-radius: var(--radius-lg, 16px);
        background: var(--result-bg);
        border: var(--border-glass);
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }
    .result-hero::before {
        content: ''; position: absolute; inset: 0;
        background: var(--result-glow);
        opacity: 0.08; pointer-events: none;
    }
    [data-theme="light"] .result-hero { --result-bg: rgba(255,255,255,0.9); }
    [data-theme="dark"] .result-hero, .result-hero { --result-bg: rgba(13, 20, 38, 0.6); }

    .result-label {
        font-size: 11px; font-weight: 800; text-transform: uppercase;
        letter-spacing: 2px; color: var(--text-secondary); margin-bottom: 32px;
    }

    /* SVG Ring */
    .ring-container {
        position: relative; width: 200px; height: 200px; margin: 0 auto 28px;
    }
    .ring-svg { width: 200px; height: 200px; transform: rotate(-90deg); }
    .ring-bg { fill: none; stroke: rgba(255,255,255,0.06); stroke-width: 10; }
    [data-theme="light"] .ring-bg { stroke: rgba(0,0,0,0.06); }
    .ring-fill {
        fill: none; stroke-width: 10; stroke-linecap: round;
        transition: stroke-dashoffset 1.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .ring-center {
        position: absolute; inset: 0; display: flex; flex-direction: column;
        align-items: center; justify-content: center;
    }
    .ring-value {
        font-size: 42px; font-weight: 900; line-height: 1;
        color: var(--text-dark);
    }
    .ring-value span { font-size: 20px; font-weight: 600; color: var(--text-secondary); }
    .ring-sub {
        font-size: 10px; font-weight: 700; text-transform: uppercase;
        letter-spacing: 1px; color: var(--text-secondary); margin-top: 6px;
    }

    /* Level Badge */
    .level-badge {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 8px 24px; border-radius: 999px; font-size: 13px; font-weight: 700;
        margin-bottom: 12px;
    }
    .level-badge i { font-size: 16px; }

    .level-name {
        font-size: 28px; font-weight: 800; color: var(--text-dark);
        margin-bottom: 10px; letter-spacing: -0.5px;
    }
    .level-desc {
        font-size: 14px; color: var(--text-secondary); max-width: 480px;
        margin: 0 auto; line-height: 1.6;
    }

    /* Color schemes by level */
    .level-normal { --level-color: #10b981; --level-bg: rgba(16, 185, 129, 0.12); --level-glow: rgba(16, 185, 129, 0.3); }
    .level-ringan { --level-color: #22c55e; --level-bg: rgba(34, 197, 94, 0.12); --level-glow: rgba(34, 197, 94, 0.3); }
    .level-sedang { --level-color: #f59e0b; --level-bg: rgba(245, 158, 11, 0.12); --level-glow: rgba(245, 158, 11, 0.3); }
    .level-berat { --level-color: #f97316; --level-bg: rgba(249, 115, 22, 0.12); --level-glow: rgba(249, 115, 22, 0.3); }
    .level-sangat-berat { --level-color: #ef4444; --level-bg: rgba(239, 68, 68, 0.12); --level-glow: rgba(239, 68, 68, 0.3); }

    .level-badge.level-normal { background: rgba(16, 185, 129, 0.12); color: #10b981; }
    .level-badge.level-ringan { background: rgba(34, 197, 94, 0.12); color: #22c55e; }
    .level-badge.level-sedang { background: rgba(245, 158, 11, 0.12); color: #f59e0b; }
    .level-badge.level-berat { background: rgba(249, 115, 22, 0.12); color: #f97316; }
    .level-badge.level-sangat-berat { background: rgba(239, 68, 68, 0.12); color: #ef4444; }

    /* Dimension Cards */
    .dim-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px; }
    .dim-card {
        padding: 24px; border-radius: var(--radius-md, 12px);
        background: rgba(255,255,255,0.03); border: var(--border-glass);
        text-align: center; transition: all 0.3s ease;
    }
    [data-theme="light"] .dim-card { background: rgba(0,0,0,0.02); }
    .dim-card:hover { transform: translateY(-4px); border-color: var(--accent); }
    .dim-label {
        font-size: 11px; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.5px; color: var(--text-secondary); margin-bottom: 8px;
    }
    .dim-value {
        font-size: 28px; font-weight: 800; margin-bottom: 4px;
    }
    .dim-bar-track {
        height: 6px; background: rgba(255,255,255,0.06); border-radius: 3px;
        overflow: hidden; margin-top: 8px;
    }
    [data-theme="light"] .dim-bar-track { background: rgba(0,0,0,0.06); }
    .dim-bar-fill {
        height: 100%; border-radius: 3px;
        transition: width 1.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    /* Symptom List */
    .symptom-section {
        padding: 32px; border-radius: var(--radius-lg, 16px);
        background: rgba(255,255,255,0.03); border: var(--border-glass);
        margin-bottom: 24px;
    }
    [data-theme="light"] .symptom-section { background: rgba(0,0,0,0.02); }
    .symptom-section-title {
        font-size: 16px; font-weight: 800; color: var(--text-dark);
        display: flex; align-items: center; gap: 10px; margin-bottom: 20px;
    }
    .symptom-section-title i { color: var(--accent); font-size: 20px; }
    .symptom-row {
        display: flex; align-items: center; gap: 16px;
        padding: 14px 18px; border-radius: var(--radius-md, 12px);
        margin-bottom: 8px; transition: all 0.2s ease;
        border: 1px solid transparent;
    }
    .symptom-row:hover {
        background: rgba(20, 184, 166, 0.04);
        border-color: rgba(20, 184, 166, 0.1);
    }
    .symptom-row:last-child { margin-bottom: 0; }
    .symptom-code {
        font-size: 10px; font-weight: 800; color: var(--accent);
        background: rgba(20, 184, 166, 0.1); padding: 4px 10px;
        border-radius: 6px; white-space: nowrap;
    }
    .symptom-name {
        flex: 1; font-size: 13px; font-weight: 600; color: var(--text-dark);
    }
    .symptom-freq {
        font-size: 11px; font-weight: 600; color: var(--text-secondary);
        white-space: nowrap;
    }
    .symptom-cf {
        font-size: 12px; font-weight: 700; font-family: 'JetBrains Mono', monospace;
        padding: 4px 12px; border-radius: 8px; white-space: nowrap;
    }
    .cf-high { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
    .cf-mid { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
    .cf-low { background: rgba(16, 185, 129, 0.1); color: #10b981; }

    /* Recommendations */
    .reco-card {
        padding: 32px; border-radius: var(--radius-lg, 16px);
        border: var(--border-glass); margin-bottom: 24px;
        position: relative; overflow: hidden;
    }
    .reco-card::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0;
        height: 3px;
    }
    .reco-card.level-normal::before { background: linear-gradient(90deg, #10b981, #34d399); }
    .reco-card.level-ringan::before { background: linear-gradient(90deg, #22c55e, #4ade80); }
    .reco-card.level-sedang::before { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
    .reco-card.level-berat::before { background: linear-gradient(90deg, #f97316, #fb923c); }
    .reco-card.level-sangat-berat::before { background: linear-gradient(90deg, #ef4444, #f87171); }
    [data-theme="light"] .reco-card { background: rgba(255,255,255,0.8); }
    [data-theme="dark"] .reco-card, .reco-card { background: rgba(13, 20, 38, 0.5); }

    .reco-title {
        font-size: 16px; font-weight: 800; color: var(--text-dark);
        display: flex; align-items: center; gap: 10px; margin-bottom: 16px;
    }
    .reco-title i { font-size: 20px; }
    .reco-list { list-style: none; padding: 0; margin: 0; }
    .reco-list li {
        display: flex; align-items: flex-start; gap: 12px;
        padding: 10px 0; font-size: 13px; color: var(--text-secondary);
        line-height: 1.6;
    }
    .reco-list li i {
        font-size: 16px; margin-top: 2px; flex-shrink: 0;
    }

    /* Actions */
    .result-actions {
        display: flex; justify-content: center; gap: 16px; flex-wrap: wrap;
        margin-top: 8px;
    }

    @media (max-width: 768px) {
        .dim-grid { grid-template-columns: 1fr; }
        .symptom-row { flex-wrap: wrap; }
    }
</style>

@php
    $percentage = round($diagnosis->cf_result * 100, 1);
    $levelCode = $diagnosis->burnoutLevel->code ?? 'B001';
    $levelClass = match($levelCode) {
        'B001' => 'level-normal',
        'B002' => 'level-ringan',
        'B003' => 'level-sedang',
        'B004' => 'level-berat',
        'B005' => 'level-sangat-berat',
        default => 'level-normal',
    };
    $levelIcon = match($levelCode) {
        'B001' => 'ph-fill ph-smiley',
        'B002' => 'ph-fill ph-smiley-meh',
        'B003' => 'ph-fill ph-warning',
        'B004' => 'ph-fill ph-warning-octagon',
        'B005' => 'ph-fill ph-fire',
        default => 'ph-fill ph-smiley',
    };
    $levelColor = match($levelCode) {
        'B001' => '#10b981',
        'B002' => '#22c55e',
        'B003' => '#f59e0b',
        'B004' => '#f97316',
        'B005' => '#ef4444',
        default => '#10b981',
    };

    // SVG Ring calculations
    $radius = 85;
    $circumference = 2 * pi() * $radius;
    $dashOffset = $circumference - ($percentage / 100) * $circumference;

    // Dimension data
    $dimensions = $diagnosis->dimensions ?? [];

    // Recommendations per level
    $recommendations = match($levelCode) {
        'B001' => [
            ['icon' => 'ph-fill ph-check-circle', 'color' => '#10b981', 'text' => 'Kondisi Anda baik! Tetap jaga pola tidur 7-8 jam per hari.'],
            ['icon' => 'ph-fill ph-tree', 'color' => '#10b981', 'text' => 'Luangkan waktu untuk hobi dan kegiatan yang menyenangkan.'],
            ['icon' => 'ph-fill ph-users', 'color' => '#10b981', 'text' => 'Pertahankan hubungan sosial yang sehat dengan teman dan keluarga.'],
        ],
        'B002' => [
            ['icon' => 'ph-fill ph-moon-stars', 'color' => '#22c55e', 'text' => 'Mulai perhatikan kualitas istirahat, tidur teratur setiap malam.'],
            ['icon' => 'ph-fill ph-calendar-check', 'color' => '#22c55e', 'text' => 'Buat jadwal belajar yang realistis, jangan terlalu memaksakan diri.'],
            ['icon' => 'ph-fill ph-person-simple-walk', 'color' => '#22c55e', 'text' => 'Lakukan olahraga ringan 30 menit sehari untuk meningkatkan mood.'],
        ],
        'B003' => [
            ['icon' => 'ph-fill ph-pause-circle', 'color' => '#f59e0b', 'text' => 'Ambil jeda dari tugas akademik, lakukan aktivitas relaksasi secara teratur.'],
            ['icon' => 'ph-fill ph-chats', 'color' => '#f59e0b', 'text' => 'Ceritakan beban akademikmu ke teman dekat, dosen wali, atau konselor kampus.'],
            ['icon' => 'ph-fill ph-list-checks', 'color' => '#f59e0b', 'text' => 'Pecah tugas besar menjadi bagian kecil yang lebih mudah dikelola.'],
            ['icon' => 'ph-fill ph-heart', 'color' => '#f59e0b', 'text' => 'Praktikkan teknik pernapasan atau meditasi 10 menit setiap pagi.'],
        ],
        'B004' => [
            ['icon' => 'ph-fill ph-first-aid', 'color' => '#f97316', 'text' => 'Segera konsultasikan kondisimu ke konselor kampus atau psikolog.'],
            ['icon' => 'ph-fill ph-hand-heart', 'color' => '#f97316', 'text' => 'Minta dukungan emosional dari keluarga dan lingkungan terdekat.'],
            ['icon' => 'ph-fill ph-clock-countdown', 'color' => '#f97316', 'text' => 'Pertimbangkan untuk mengurangi beban SKS jika memungkinkan.'],
            ['icon' => 'ph-fill ph-prohibit', 'color' => '#f97316', 'text' => 'Hindari begadang dan konsumsi kafein berlebihan.'],
        ],
        'B005' => [
            ['icon' => 'ph-fill ph-warning-octagon', 'color' => '#ef4444', 'text' => 'SANGAT DISARANKAN untuk segera menemui psikolog atau psikiater profesional.'],
            ['icon' => 'ph-fill ph-phone-call', 'color' => '#ef4444', 'text' => 'Hubungi hotline kesehatan mental: Into The Light (119 ext 8) atau Sejiwa (119 ext 8).'],
            ['icon' => 'ph-fill ph-users-three', 'color' => '#ef4444', 'text' => 'Jangan menghadapi ini sendirian — libatkan orang tua, dosen, atau mentor.'],
            ['icon' => 'ph-fill ph-calendar-x', 'color' => '#ef4444', 'text' => 'Pertimbangkan untuk mengambil cuti akademik sementara jika diperlukan.'],
            ['icon' => 'ph-fill ph-shield-check', 'color' => '#ef4444', 'text' => 'Prioritaskan kesehatanmu di atas segalanya. Kamu tidak sendirian.'],
        ],
        default => [],
    };
@endphp

<div style="max-width: 800px; margin: 0 auto;">

    <!-- RESULT HERO CARD -->
    <div class="result-hero {{ $levelClass }}" style="--result-glow: {{ $levelColor }};">
        <div class="result-label">Hasil Diagnosis Anda</div>

        <!-- SVG Progress Ring -->
        <div class="ring-container">
            <svg class="ring-svg" viewBox="0 0 200 200">
                <circle class="ring-bg" cx="100" cy="100" r="{{ $radius }}" />
                <circle class="ring-fill" cx="100" cy="100" r="{{ $radius }}"
                    stroke="{{ $levelColor }}"
                    stroke-dasharray="{{ $circumference }}"
                    stroke-dashoffset="{{ $circumference }}"
                    data-target="{{ $dashOffset }}"
                    style="filter: drop-shadow(0 0 8px {{ $levelColor }}40);"
                />
            </svg>
            <div class="ring-center">
                <div class="ring-value" id="ring-counter">0<span>%</span></div>
                <div class="ring-sub">Kepastian CF</div>
            </div>
        </div>

        <!-- Level Badge -->
        <div class="level-badge {{ $levelClass }}">
            <i class="{{ $levelIcon }}"></i>
            {{ $diagnosis->burnoutLevel->name }}
        </div>

        <!-- Level Description -->
        <h1 class="level-name">{{ $diagnosis->burnoutLevel->name }}</h1>
        <p class="level-desc">{{ $diagnosis->burnoutLevel->description }}</p>
    </div>

    <!-- DIMENSION ANALYSIS (if available) -->
    @if(!empty($dimensions))
    <div class="dim-grid">
        @foreach($dimensions as $dimName => $dimValue)
        @php
            $dimPct = round($dimValue * 100, 1);
            $dimColor = $dimPct <= 30 ? '#10b981' : ($dimPct <= 60 ? '#f59e0b' : '#ef4444');
        @endphp
        <div class="dim-card">
            <div class="dim-label">{{ $dimName }}</div>
            <div class="dim-value" style="color: {{ $dimColor }};">{{ $dimPct }}%</div>
            <div class="dim-bar-track">
                <div class="dim-bar-fill" style="width: 0%; background: {{ $dimColor }};" data-width="{{ $dimPct }}%"></div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- RECOMMENDATIONS -->
    <div class="reco-card {{ $levelClass }}">
        <div class="reco-title">
            <i class="ph-fill ph-lightbulb" style="color: {{ $levelColor }};"></i>
            Rekomendasi untuk Anda
        </div>
        <ul class="reco-list">
            @foreach($recommendations as $reco)
            <li>
                <i class="{{ $reco['icon'] }}" style="color: {{ $reco['color'] }};"></i>
                <span>{{ $reco['text'] }}</span>
            </li>
            @endforeach
        </ul>
    </div>

    <!-- SYMPTOM DETAILS -->
    <div class="symptom-section">
        <div class="symptom-section-title">
            <i class="ph-fill ph-list-magnifying-glass"></i>
            Rincian Gejala Terdeteksi
        </div>

        @foreach($diagnosis->details->sortByDesc('cf_result') as $detail)
            @if($detail->cf_user > 0)
            @php
                $cfVal = $detail->cf_result;
                $cfClass = $cfVal >= 0.5 ? 'cf-high' : ($cfVal >= 0.2 ? 'cf-mid' : 'cf-low');
                $freqLabel = match(true) {
                    $detail->cf_user >= 1.0 => 'Hampir Selalu',
                    $detail->cf_user >= 0.8 => 'Sering',
                    $detail->cf_user >= 0.6 => 'Kadang-kadang',
                    $detail->cf_user >= 0.4 => 'Jarang',
                    $detail->cf_user >= 0.2 => 'Hampir Tidak',
                    default => 'Tidak Pernah',
                };
            @endphp
            <div class="symptom-row">
                <span class="symptom-code">{{ $detail->symptom->code }}</span>
                <span class="symptom-name">{{ $detail->symptom->name }}</span>
                <span class="symptom-freq">{{ $freqLabel }}</span>
                <span class="symptom-cf {{ $cfClass }}">{{ number_format($cfVal, 3) }}</span>
            </div>
            @endif
        @endforeach
    </div>

    <!-- ACTIONS -->
    <div class="result-actions" style="margin-bottom: 24px;">
        <a href="{{ route('dashboard') }}" class="btn-neo-secondary" style="padding: 12px 28px;">
            <i class="ph-bold ph-arrow-left"></i> Dashboard
        </a>
        <a href="{{ route('diagnosis.history') }}" class="btn-neo-secondary" style="padding: 12px 28px;">
            <i class="ph-bold ph-clock-counter-clockwise"></i> Riwayat
        </a>
        <a href="{{ route('diagnosis.wizard') }}" class="btn-neo" style="padding: 12px 28px;">
            <i class="ph-bold ph-arrow-counter-clockwise"></i> Ulangi Diagnosis
        </a>
    </div>
</div>

<!-- Entrance Animations -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate SVG ring
    const ringFill = document.querySelector('.ring-fill');
    const targetOffset = parseFloat(ringFill.dataset.target);
    setTimeout(() => { ringFill.style.strokeDashoffset = targetOffset; }, 300);

    // Animate counter number
    const counter = document.getElementById('ring-counter');
    const target = {{ $percentage }};
    let current = 0;
    const duration = 1500;
    const startTime = performance.now();

    function animateCounter(now) {
        const elapsed = now - startTime;
        const progress = Math.min(elapsed / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3); // ease out cubic
        current = (eased * target).toFixed(1);
        counter.innerHTML = current + '<span>%</span>';
        if (progress < 1) requestAnimationFrame(animateCounter);
    }
    setTimeout(() => requestAnimationFrame(animateCounter), 300);

    // Animate dimension bars
    document.querySelectorAll('.dim-bar-fill').forEach((bar, i) => {
        setTimeout(() => { bar.style.width = bar.dataset.width; }, 600 + i * 200);
    });
});
</script>
@endsection
