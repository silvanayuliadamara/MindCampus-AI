@extends('layouts.user')
@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Serenity AI - Ruang Tenang Mahasiswa Akhir')

@section('content')

<!-- CSS khusus untuk animasi ceria & interaktif -->
<style>
    /* Floating banner illustration */
    .floating-emoji {
        animation: floatEmoji 4s ease-in-out infinite alternate;
        display: inline-block;
    }
    
    @keyframes floatEmoji {
        0% { transform: translateY(0px) rotate(0deg); }
        100% { transform: translateY(-10px) rotate(5deg); }
    }
    
    /* Interactive mood selection animation */
    .mood-btn {
        background: rgba(255, 255, 255, 0.05);
        [data-theme="light"] & {
            background: rgba(0, 0, 0, 0.03);
        }
        border: 1px solid rgba(255, 255, 255, 0.08);
        [data-theme="light"] & {
            border-color: rgba(0, 0, 0, 0.05);
        }
        border-radius: 12px;
        padding: 10px;
        font-size: 24px;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .mood-btn:hover {
        transform: scale(1.2);
        background: rgba(20, 184, 166, 0.15);
        border-color: var(--accent);
    }
    
    .mood-btn:active {
        transform: scale(0.95);
    }
    
    /* Challenge list checkbox anim */
    .challenge-checkbox {
        width: 20px;
        height: 20px;
        flex-shrink: 0;
        accent-color: var(--accent);
        cursor: pointer;
    }
    
    .challenge-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.02);
        [data-theme="light"] & {
            background: rgba(0, 0, 0, 0.02);
        }
        border: 1px solid rgba(255, 255, 255, 0.04);
        [data-theme="light"] & {
            border-color: rgba(0, 0, 0, 0.03);
        }
        transition: all 0.25s ease;
    }
    
    .challenge-item:hover {
        background: rgba(20, 184, 166, 0.04);
        transform: translateX(3px);
    }
    
    .challenge-item.completed {
        background: rgba(16, 185, 129, 0.06);
        border-color: rgba(16, 185, 129, 0.2);
    }
    
    .challenge-item.completed span {
        text-decoration: line-through;
        color: var(--text-muted);
    }

    /* Confetti popping animation simulation on check */
    @keyframes checkPop {
        0% { transform: scale(1); }
        50% { transform: scale(1.15); }
        100% { transform: scale(1); }
    }
    .check-pop-anim {
        animation: checkPop 0.3s ease-out;
    }
</style>

<!-- Row 1: Welcome Banner & Daily Check-in -->
<div class="row g-4 mb-4">
    <!-- Welcome Banner (Left) -->
    <div class="col-lg-8">
        <div class="neo-card h-100 animated-card" style="background: linear-gradient(135deg, rgba(20, 184, 166, 0.25) 0%, rgba(16, 185, 129, 0.2) 100%); border: 1px solid rgba(255, 255, 255, 0.12); padding: 32px; border-radius: 20px; position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: center;">
            <div style="position: absolute; right: -5%; top: -20%; width: 50%; height: 150%; background: radial-gradient(circle, rgba(20, 184, 166, 0.2) 0%, transparent 70%);"></div>
            <div style="position: absolute; right: 20%; bottom: -30%; width: 300px; height: 300px; background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 60%);"></div>
            
            <div style="position: relative; z-index: 2; max-width: 580px;">
                <span class="floating-emoji" style="font-size: 32px; margin-bottom: 12px;">🌿</span>
                <h2 id="greeting-text" style="font-weight: 800; font-size: 26px; margin-bottom: 8px; color: #fff; letter-spacing: -0.5px;">Halo, {{ auth()->user()->name ?? 'Mahasiswa' }}! ✨</h2>
                <p id="encouragement-text" style="font-size: 14px; color: var(--text-secondary); line-height: 1.6; margin-bottom: 24px;">
                    Bagaimana kabarmu hari ini? Mari pantau tingkat stres akademikmu secara rutin untuk menjaga kesehatan mental dan performa belajarmu tetap optimal.
                </p>
                <div>
                    <a href="{{ route('diagnosis.wizard') }}" class="btn-neo">
                        Mulai Diagnosis Stres <i class="ph-bold ph-stethoscope" style="font-size: 18px;"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Daily Mood Check-in (Right - Cheerful UX) -->
    <div class="col-lg-4">
        <div class="neo-card h-100 animated-card" style="padding: 28px; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <h4 style="font-size: 16px; font-weight: 800; color: var(--text-dark); margin: 0; margin-bottom: 6px;">Mood Check-In</h4>
                <p style="font-size: 12px; color: var(--text-secondary); margin-bottom: 20px;">Bagaimana perasaanmu sekarang?</p>
                
                <div style="display: flex; justify-content: center; flex-wrap: wrap; gap: 10px; margin-bottom: 20px;">
                    <button class="mood-btn" onclick="checkInMood('😊', 'Hebat! Pertahankan energi positifmu untuk menyelesaikan tugas hari ini! 🚀')" title="Happy">😊</button>
                    <button class="mood-btn" onclick="checkInMood('😴', 'Ngerasa capek ya? Tarik napas, regangkan badan, dan istirahat 15 menit yuk. ☕')" title="Tired">😴</button>
                    <button class="mood-btn" onclick="checkInMood('🤯', 'Stres menumpuk? Tenang, kerjakan satu per satu secara perlahan. Kamu pasti bisa! 💪')" title="Stressed">🤯</button>
                    <button class="mood-btn" onclick="checkInMood('😔', 'Ada hari yang berat, dan itu wajar banget. Jangan ragu buat cerita ke teman terdekat ya. ❤️')" title="Sad">😔</button>
                    <button class="mood-btn" onclick="checkInMood('😎', 'Mantap! Energi penuh untuk menaklukkan skripsi hari ini. Semangat! 🔥')" title="Energetic">😎</button>
                </div>
            </div>

            <!-- Mood Feedback Message -->
            <div id="mood-feedback" style="background: rgba(20, 184, 166, 0.08); border: 1px solid rgba(20, 184, 166, 0.15); border-radius: 12px; padding: 14px 16px; display: none; animation: fadeInUp 0.4s ease;">
                <div style="display: flex; gap: 12px; align-items: flex-start;">
                    <span id="mood-feedback-emoji" style="font-size: 22px;">😊</span>
                    <p id="mood-feedback-text" style="font-size: 12px; color: var(--text-dark); margin: 0; line-height: 1.5; font-weight: 500;"></p>
                </div>
            </div>
            
            <div id="mood-placeholder" style="text-align: center; padding: 14px; border: 1px dashed rgba(255,255,255,0.06); [data-theme='light'] & { border-color: rgba(0,0,0,0.06); } border-radius: 12px; font-size: 11px; color: var(--text-secondary); font-weight: 500;">
                Klik emotikon di atas untuk mendapatkan saran cepat! 💡
            </div>
        </div>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-4 mb-4">
    <!-- Stat 1: Level Stres -->
    <div class="col-md-6 col-xl-3">
        <div class="neo-card h-100 animated-card" style="padding: 24px;">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <p style="color: var(--text-secondary); font-size: 11px; font-weight: 800; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 1px;">Level Stres</p>
                    <h3 style="color: var(--text-dark); font-size: 32px; font-weight: 800; margin: 0; letter-spacing: -1px;">
                        {{ isset($latestDiagnosis) ? number_format($latestDiagnosis->cf_result * 100, 0) : 0 }}<span style="font-size: 18px; color: var(--text-muted); font-weight: 700;">%</span>
                    </h3>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 14px; background: rgba(20, 184, 166, 0.15); color: var(--accent); display: flex; align-items: center; justify-content: center; font-size: 24px; box-shadow: 0 0 15px rgba(20, 184, 166, 0.15);">
                    <i class="ph-fill ph-activity"></i>
                </div>
            </div>
            @php
                $percentage = isset($latestDiagnosis) ? $latestDiagnosis->cf_result * 100 : 0;
                $color = 'var(--accent)';
                if ($percentage <= 20) { $color = 'var(--color-normal)'; }
                elseif ($percentage <= 60) { $color = 'var(--color-warning)'; }
                else { $color = 'var(--color-danger)'; }
            @endphp
            <div style="width: 100%; height: 6px; background: rgba(255,255,255,0.05); [data-theme='light'] & { background: rgba(0,0,0,0.05); } border-radius: 10px; overflow: hidden; margin-top: 16px;">
                <div style="width: {{ $percentage }}%; height: 100%; background: {{ $color }}; border-radius: 10px; box-shadow: 0 0 10px {{ $color }}; transition: width 1s ease;"></div>
            </div>
        </div>
    </div>

    <!-- Stat 2: Status Saat Ini -->
    <div class="col-md-6 col-xl-3">
        <div class="neo-card h-100 animated-card" style="padding: 24px;">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div style="flex: 1; padding-right: 10px;">
                    <p style="color: var(--text-secondary); font-size: 11px; font-weight: 800; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 1px;">Status Saat Ini</p>
                    <h3 style="color: var(--text-dark); font-size: 18px; font-weight: 800; margin: 0; line-height: 1.3;">
                        {{ isset($latestDiagnosis) ? $latestDiagnosis->burnoutLevel->name : 'Belum Ada' }}
                    </h3>
                </div>
                @php
                    $statusBg = 'rgba(16, 185, 129, 0.15)';
                    $statusColor = 'var(--color-normal)';
                    if(isset($latestDiagnosis)) {
                        $cf = $latestDiagnosis->cf_result;
                        if($cf > 0.6) {
                            $statusBg = 'rgba(244, 63, 94, 0.15)';
                            $statusColor = 'var(--color-danger)';
                        } elseif($cf > 0.2) {
                            $statusBg = 'rgba(245, 158, 11, 0.15)';
                            $statusColor = 'var(--color-warning)';
                        }
                    }
                @endphp
                <div style="width: 48px; height: 48px; border-radius: 14px; background: {{ $statusBg }}; color: {{ $statusColor }}; display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0; box-shadow: 0 0 15px {{ $statusBg }};">
                    <i class="ph-fill ph-warning-circle"></i>
                </div>
            </div>
            @if(isset($latestDiagnosis))
                <p style="font-size: 12px; color: var(--text-secondary); font-weight: 500; margin: 0; margin-top: 14px; display: flex; align-items: center; gap: 4px;">
                    <i class="ph ph-clock"></i> Terakhir: {{ $latestDiagnosis->created_at->diffForHumans() }}
                </p>
            @else
                <p style="font-size: 12px; color: var(--text-muted); font-weight: 500; margin: 0; margin-top: 14px;">Belum ada diagnosis</p>
            @endif
        </div>
    </div>
    
    <!-- Stat 3: Total Tes -->
    <div class="col-md-6 col-xl-3">
        <div class="neo-card h-100 animated-card" style="padding: 24px;">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <p style="color: var(--text-secondary); font-size: 11px; font-weight: 800; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 1px;">Total Tes</p>
                    <h3 style="color: var(--text-dark); font-size: 32px; font-weight: 800; margin: 0; letter-spacing: -1px;">
                        {{ count($historyDiagnoses ?? []) }}<span style="font-size: 16px; color: var(--text-secondary); font-weight: 700; margin-left: 4px;">Kali</span>
                    </h3>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 14px; background: rgba(16, 185, 129, 0.15); color: var(--color-normal); display: flex; align-items: center; justify-content: center; font-size: 24px; box-shadow: 0 0 15px rgba(16, 185, 129, 0.15);">
                    <i class="ph-fill ph-check-square-offset"></i>
                </div>
            </div>
            <p style="font-size: 12px; color: var(--color-normal); font-weight: 700; margin: 0; margin-top: 14px; display: flex; align-items: center; gap: 4px;">
                <i class="ph-bold ph-trend-up"></i> Terus pantau kesehatanmu
            </p>
        </div>
    </div>

    <!-- Stat 4: Info Akurasi -->
    <div class="col-md-6 col-xl-3">
        <div class="neo-card h-100 animated-card" style="padding: 24px; background: rgba(255,255,255,0.01);">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div style="width: 40px; height: 40px; border-radius: 12px; background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255,255,255,0.08); color: var(--accent); display: flex; align-items: center; justify-content: center; font-size: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.2); [data-theme='light'] & { background: #fff; border-color: rgba(0,0,0,0.06); }">
                    <i class="ph-fill ph-shield-check"></i>
                </div>
                <h4 style="font-size: 14px; font-weight: 800; color: var(--text-dark); margin: 0;">Akurasi Ilmiah</h4>
            </div>
            <p style="font-size: 11px; font-weight: 500; color: var(--text-secondary); margin-bottom: 12px; line-height: 1.5;">Metodologi Certainty Factor & standar instrumen MBI.</p>
            <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                <span style="display: inline-block; padding: 4px 10px; background: rgba(20, 184, 166, 0.12); color: var(--accent); border-radius: 6px; font-size: 9px; font-weight: 800; border: 1px solid rgba(20, 184, 166, 0.2);">RELIABEL</span>
                <span style="display: inline-block; padding: 4px 10px; background: rgba(16, 185, 129, 0.12); color: var(--color-normal); border-radius: 6px; font-size: 9px; font-weight: 800; border: 1px solid rgba(16, 185, 129, 0.2);">MEDIS</span>
            </div>
        </div>
    </div>
</div>

<!-- Chart & Challenge Row -->
<div class="row g-4">
    <!-- Chart (Left) -->
    <div class="col-lg-8">
        <div class="neo-card h-100 animated-card" style="padding: 30px;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 style="font-size: 18px; font-weight: 800; color: var(--text-dark); margin: 0; margin-bottom: 4px;">Grafik Perjalanan Stres</h4>
                    <p style="font-size: 13px; color: var(--text-secondary); font-weight: 500; margin: 0;">Perkembangan tingkat stres dari 10 diagnosis terakhir</p>
                </div>
                @if(isset($latestDiagnosis))
                    <a href="{{ route('diagnosis.history') }}" class="btn-neo-secondary" style="padding: 8px 16px; font-size: 12px;">Lihat Semua</a>
                @endif
            </div>
            <div style="position: relative; height: 300px; width: 100%;">
                <canvas id="stressChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Right Column: Cheerful Wellness Challenge & Tips -->
    <div class="col-lg-4">
        <div class="neo-card h-100 animated-card" style="padding: 30px; display: flex; flex-direction: column;">
            <h4 style="font-size: 18px; font-weight: 800; color: var(--text-dark); margin-bottom: 16px; margin-top: 0;">Misi Sehat Hari Ini</h4>
            <p style="font-size: 12px; color: var(--text-secondary); margin-bottom: 20px;">Tantangan kecil untuk melepas penat skripsimu:</p>
            
            <!-- Habit Challenge Checklist -->
            <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 24px;">
                <div class="challenge-item" id="chall-1">
                    <input type="checkbox" class="challenge-checkbox" onchange="toggleChallenge('chall-1')">
                    <span style="font-size: 13px; font-weight: 600;">Minum air putih 2 liter 💧</span>
                </div>
                <div class="challenge-item" id="chall-2">
                    <input type="checkbox" class="challenge-checkbox" onchange="toggleChallenge('chall-2')">
                    <span style="font-size: 13px; font-weight: 600;">Tutup laptop maksimal jam 20:00 💻</span>
                </div>
                <div class="challenge-item" id="chall-3">
                    <input type="checkbox" class="challenge-checkbox" onchange="toggleChallenge('chall-3')">
                    <span style="font-size: 13px; font-weight: 600;">Jalan kaki santai 10 menit 🚶</span>
                </div>
            </div>

            <!-- Dynamic Cheerful Tips -->
            <div style="background: rgba(255,255,255,0.02); [data-theme='light'] & { background: rgba(0,0,0,0.02); } border-radius: 16px; padding: 20px; border: 1px dashed rgba(255,255,255,0.1); [data-theme='light'] & { border-color: rgba(0,0,0,0.08); } text-align: center;">
                <div style="font-size: 20px; margin-bottom: 10px; color: #fdcb6e;">💡</div>
                <h5 style="font-size: 14px; font-weight: 800; color: var(--text-dark); margin-bottom: 6px;">Tips Kebugaran</h5>
                <p id="daily-tip-text" style="font-size: 12px; font-weight: 500; color: var(--text-secondary); line-height: 1.6; margin: 0; min-height: 58px;">
                    "Beristirahat bukanlah kemalasan, melainkan investasi penting agar fokus belajarmu esok hari lebih tajam."
                </p>
                <button onclick="cycleTips()" class="btn-neo-secondary" style="padding: 6px 14px; font-size: 11px; margin-top: 12px; border-radius: 8px;">
                    Tips Lainnya <i class="ph ph-arrow-clockwise"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Cheerful greeting generator based on time
    document.addEventListener('DOMContentLoaded', function() {
        const greeting = document.getElementById('greeting-text');
        const encouragement = document.getElementById('encouragement-text');
        const name = "{{ explode(' ', auth()->user()->name)[0] }}";
        
        const hour = new Date().getHours();
        let greetingMsg = `Halo, ${name}! ✨`;
        let encouragementMsg = "Bagaimana kabarmu hari ini? Mari pantau stres akademikmu secara rutin untuk menjaga mental tetap prima.";
        
        if (hour >= 5 && hour < 12) {
            greetingMsg = `Selamat pagi, ${name}! 🌅`;
            encouragementMsg = "Semoga pagimu menyenangkan! Ingat untuk sarapan sebelum berkutat dengan skripsi ya. Selalu ada harapan hari ini! 💚";
        } else if (hour >= 12 && hour < 17) {
            greetingMsg = `Selamat siang, ${name}! ☀️`;
            encouragementMsg = "Siang yang produktif! Tapi jangan lupa istirahat makan siang dan berdiri sejenak meregangkan badan ya. 🌿";
        } else if (hour >= 17 && hour < 21) {
            greetingMsg = `Selamat sore, ${name}! 🌇`;
            encouragementMsg = "Matahari mulai tenggelam, saatnya bersantai. Selesaikan tugasmu perlahan dan mulailah bersantai. Rileks yuk! 🍃";
        } else {
            greetingMsg = `Selamat malam, ${name}! 🌙`;
            encouragementMsg = "Malam yang sunyi. Sangat disarankan tidak begadang agar sistem imun dan fokus mentalmu kembali segar besok pagi! 💤";
        }
        
        greeting.innerHTML = greetingMsg;
        encouragement.innerHTML = encouragementMsg;
    });

    // Mood interactive check-in
    function checkInMood(emoji, message) {
        const placeholder = document.getElementById('mood-placeholder');
        const feedback = document.getElementById('mood-feedback');
        const fbEmoji = document.getElementById('mood-feedback-emoji');
        const fbText = document.getElementById('mood-feedback-text');
        
        placeholder.style.display = 'none';
        feedback.style.display = 'block';
        fbEmoji.innerHTML = emoji;
        fbText.innerHTML = message;
        
        // Add popping animation class
        feedback.classList.remove('check-pop-anim');
        void feedback.offsetWidth; // trigger reflow
        feedback.classList.add('check-pop-anim');
    }

    // Toggle daily habits checkmark
    function toggleChallenge(id) {
        const item = document.getElementById(id);
        const checkbox = item.querySelector('.challenge-checkbox');
        
        if (checkbox.checked) {
            item.classList.add('completed');
            item.classList.add('check-pop-anim');
            setTimeout(() => item.classList.remove('check-pop-anim'), 300);
        } else {
            item.classList.remove('completed');
        }
    }

    // Dynamic tips swapper
    const wellnessTips = [
        "\"Beristirahat bukanlah kemalasan, melainkan investasi penting agar fokus belajarmu esok hari lebih tajam.\" 🌿",
        "\"Teknik Pomodoro: Belajar 25 menit, lalu istirahat penuh 5 menit. Cara sederhana cegah burnout otak!\" ⏱️",
        "\"Mata lelah menatap layar? Gunakan aturan 20-20-20: setiap 20 menit, lihatlah objek sejauh 20 kaki selama 20 detik.\" 👀",
        "\"Skripsi/tugas akhir adalah maraton, bukan sprint. Yang terpenting adalah konsistensi langkah kecil Anda.\" 🏃‍♂️",
        "\"Satu kalimat selesai ditulis hari ini sudah merupakan progress luar biasa. Apresiasi usahamu sendiri!\" 📝"
    ];
    let currentTipIndex = 0;
    
    function cycleTips() {
        currentTipIndex = (currentTipIndex + 1) % wellnessTips.length;
        const tipText = document.getElementById('daily-tip-text');
        tipText.style.opacity = 0;
        setTimeout(() => {
            tipText.innerHTML = wellnessTips[currentTipIndex];
            tipText.style.opacity = 1;
        }, 150);
    }

    // Chart JS
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('stressChart');
        if (!ctx) return;
        
        const context = ctx.getContext('2d');
        const rawData = @json($historyDiagnoses ?? []);
        
        const labels = rawData.map(item => {
            const d = new Date(item.created_at);
            return d.getDate() + '/' + (d.getMonth()+1);
        });
        
        const data = rawData.map(item => Math.round(item.cf_result * 100));
        
        let gradient = context.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(20, 184, 166, 0.25)');
        gradient.addColorStop(1, 'rgba(20, 184, 166, 0.0)');
        
        new Chart(context, {
            type: 'line',
            data: {
                labels: labels.length > 0 ? labels : ['Belum ada data'],
                datasets: [{
                    label: 'Tingkat Burnout (%)',
                    data: data.length > 0 ? data : [0],
                    borderColor: '#14b8a6',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#022c22',
                    pointBorderColor: '#14b8a6',
                    pointBorderWidth: 3,
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: '#14b8a6',
                    pointHoverBorderColor: '#022c22',
                    pointHoverBorderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#021e17',
                        borderColor: 'rgba(255, 255, 255, 0.1)',
                        borderWidth: 1,
                        titleFont: { size: 12, family: 'Plus Jakarta Sans', weight: 'bold' },
                        bodyFont: { size: 14, family: 'Plus Jakarta Sans', weight: 'bold' },
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + '% Kelelahan';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#64748b',
                            font: { family: 'Plus Jakarta Sans', weight: 'bold', size: 11 },
                            stepSize: 25,
                            callback: function(value) { return value + '%'; }
                        }
                    },
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: {
                            color: '#64748b',
                            font: { family: 'Plus Jakarta Sans', weight: 'bold', size: 11 }
                        }
                    }
                },
                interaction: { intersect: false, mode: 'index' }
            }
        });
    });
</script>
@endsection
