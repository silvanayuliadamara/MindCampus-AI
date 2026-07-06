@extends('layouts.user')
@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Selamat datang kembali, ' . (auth()->user()->name ?? 'Pengguna'))

@section('content')

<!-- Welcome Banner -->
<div class="neo-card mb-4" style="background: linear-gradient(135deg, #0984e3, #6c5ce7); color: white; padding: 32px; border-radius: 20px; border: none; position: relative; overflow: hidden;">
    <!-- Background Patterns -->
    <div style="position: absolute; right: -5%; top: -20%; width: 50%; height: 150%; background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);"></div>
    <div style="position: absolute; right: 20%; bottom: -30%; width: 300px; height: 300px; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);"></div>
    
    <div style="position: relative; z-index: 2; max-width: 650px;">
        <h2 style="font-weight: 800; font-size: 26px; margin-bottom: 8px; letter-spacing: -0.5px;">Halo, {{ auth()->user()->name ?? 'Pengguna' }}! ✨</h2>
        <p style="font-size: 14px; opacity: 0.9; line-height: 1.5; margin-bottom: 20px;">
            Bagaimana kabarmu hari ini? Mari pantau tingkat stres akademikmu secara rutin untuk menjaga kesehatan mental dan performa belajarmu tetap optimal.
        </p>
        <a href="{{ route('diagnosis.wizard') }}" class="btn" style="background: #fff; color: #0984e3; font-weight: 800; font-size: 14px; padding: 10px 24px; border-radius: 50px; box-shadow: 0 8px 20px rgba(0,0,0,0.15); transition: 0.3s; text-decoration: none;">
            Mulai Tes Baru
        </a>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-4 mb-4">
    <!-- Stat 1: Level Stres -->
    <div class="col-md-6 col-xl-3">
        <div class="neo-card h-100" style="padding: 24px; border-radius: 20px; border: 1px solid rgba(0,0,0,0.03);">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <p style="color: var(--text-muted); font-size: 12px; font-weight: 800; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Level Stres</p>
                    <h3 style="color: var(--text-dark); font-size: 32px; font-weight: 900; margin: 0; letter-spacing: -1px;">{{ isset($latestDiagnosis) ? number_format($latestDiagnosis->cf_result * 100, 0) : 0 }}<span style="font-size: 18px; color: var(--text-muted); font-weight: 700;">%</span></h3>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 14px; background: rgba(9, 132, 227, 0.1); color: #0984e3; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                    <i class="ph-fill ph-activity"></i>
                </div>
            </div>
            <div style="width: 100%; height: 6px; background: #f1f2f6; border-radius: 10px; overflow: hidden;">
                <div style="width: {{ isset($latestDiagnosis) ? $latestDiagnosis->cf_result * 100 : 0 }}%; height: 100%; background: #0984e3; border-radius: 10px;"></div>
            </div>
        </div>
    </div>

    <!-- Stat 2: Status Saat Ini -->
    <div class="col-md-6 col-xl-3">
        <div class="neo-card h-100" style="padding: 24px; border-radius: 20px; border: 1px solid rgba(0,0,0,0.03);">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div style="flex: 1; padding-right: 10px;">
                    <p style="color: var(--text-muted); font-size: 12px; font-weight: 800; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Status Saat Ini</p>
                    <h3 style="color: var(--text-dark); font-size: 18px; font-weight: 800; margin: 0; line-height: 1.3;">{{ isset($latestDiagnosis) ? $latestDiagnosis->burnoutLevel->name : 'Belum Ada' }}</h3>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 14px; background: rgba(255, 118, 117, 0.1); color: #ff7675; display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0;">
                    <i class="ph-fill ph-warning-circle"></i>
                </div>
            </div>
            @if(isset($latestDiagnosis))
                <p style="font-size: 12px; color: var(--text-muted); font-weight: 600; margin: 0; margin-top: 14px;"><i class="ph-bold ph-clock"></i> Terakhir: {{ $latestDiagnosis->created_at->diffForHumans() }}</p>
            @else
                <p style="font-size: 12px; color: var(--text-muted); font-weight: 600; margin: 0; margin-top: 14px;">Belum ada diagnosis</p>
            @endif
        </div>
    </div>
    
    <!-- Stat 3: Total Tes -->
    <div class="col-md-6 col-xl-3">
        <div class="neo-card h-100" style="padding: 24px; border-radius: 20px; border: 1px solid rgba(0,0,0,0.03);">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <p style="color: var(--text-muted); font-size: 12px; font-weight: 800; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Total Tes</p>
                    <h3 style="color: var(--text-dark); font-size: 32px; font-weight: 900; margin: 0; letter-spacing: -1px;">{{ count($historyDiagnoses ?? []) }}<span style="font-size: 16px; color: var(--text-muted); font-weight: 700; margin-left: 4px;">Kali</span></h3>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 14px; background: rgba(0, 184, 148, 0.1); color: #00b894; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                    <i class="ph-fill ph-check-square-offset"></i>
                </div>
            </div>
            <p style="font-size: 12px; color: #00b894; font-weight: 700; margin: 0; margin-top: 14px;"><i class="ph-bold ph-trend-up"></i> Terus pantau rutin</p>
        </div>
    </div>

    <!-- Stat 4: Info Akurasi -->
    <div class="col-md-6 col-xl-3">
        <div class="neo-card h-100" style="padding: 24px; border-radius: 20px; border: 1px solid rgba(0,0,0,0.03); background: #f8fbff; box-shadow: none;">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div style="width: 40px; height: 40px; border-radius: 12px; background: #fff; color: #0984e3; display: flex; align-items: center; justify-content: center; font-size: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                    <i class="ph-fill ph-brain"></i>
                </div>
                <h4 style="font-size: 15px; font-weight: 800; color: var(--text-dark); margin: 0;">Akurasi Pakar</h4>
            </div>
            <p style="font-size: 12px; font-weight: 600; color: var(--text-muted); margin-bottom: 12px; line-height: 1.5;">Menggunakan sistem pakar berbasis Certainty Factor.</p>
            <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                <span style="display: inline-block; padding: 4px 10px; background: rgba(9, 132, 227, 0.1); color: #0984e3; border-radius: 6px; font-size: 10px; font-weight: 800;">RELIABEL</span>
                <span style="display: inline-block; padding: 4px 10px; background: rgba(0, 184, 148, 0.1); color: #00b894; border-radius: 6px; font-size: 10px; font-weight: 800;">CEPAT</span>
            </div>
        </div>
    </div>
</div>

<!-- Chart & Recommendation Row -->
<div class="row g-4">
    <!-- Chart -->
    <div class="col-lg-8">
        <div class="neo-card h-100" style="padding: 30px; border-radius: 24px;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 style="font-size: 18px; font-weight: 800; color: var(--text-dark); margin: 0; margin-bottom: 4px;">Grafik Perjalanan Stres</h4>
                    <p style="font-size: 13px; color: var(--text-muted); font-weight: 600; margin: 0;">Perkembangan dari 10 tes terakhir</p>
                </div>
                @if(isset($latestDiagnosis))
                    <a href="{{ route('diagnosis.history') }}" class="btn btn-sm" style="background: var(--accent-light); color: var(--accent); border-radius: 8px; font-weight: 800; font-size: 12px; padding: 8px 16px; text-decoration: none;">Lihat Semua</a>
                @endif
            </div>
            <div style="position: relative; height: 300px; width: 100%;">
                <canvas id="stressChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Right Column: Info -->
    <div class="col-lg-4">
        <div class="neo-card h-100" style="padding: 30px; border-radius: 24px; display: flex; flex-direction: column;">
            <h4 style="font-size: 18px; font-weight: 800; color: var(--text-dark); margin-bottom: 24px; margin-top: 0;">Rekomendasi</h4>
            
            <div style="flex: 1; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; background: #f8fbff; border-radius: 16px; padding: 24px; border: 1px dashed #dcdde1; margin-bottom: 24px;">
                <div style="width: 56px; height: 56px; background: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fdcb6e; font-size: 28px; box-shadow: 0 8px 20px rgba(0,0,0,0.06); margin-bottom: 16px;">
                    <i class="ph-fill ph-lightbulb"></i>
                </div>
                <h5 style="font-size: 15px; font-weight: 800; color: var(--text-dark); margin-bottom: 8px;">Tips Harian</h5>
                <p style="font-size: 13px; font-weight: 600; color: var(--text-muted); line-height: 1.6; margin: 0;">Luangkan waktu 15 menit setiap hari untuk relaksasi tanpa gadget agar pikiran tetap jernih.</p>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px; background: #fff; border-radius: 16px; border: 1px solid rgba(0,0,0,0.04); box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; border-radius: 12px; background: var(--accent); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                        <i class="ph-fill ph-bell-ringing"></i>
                    </div>
                    <div>
                        <h4 style="font-size: 14px; font-weight: 800; color: var(--text-dark); margin: 0; margin-bottom: 2px;">Pengingat Tes</h4>
                        <p style="font-size: 11px; font-weight: 600; color: var(--text-muted); margin: 0;">Aktifkan notifikasi</p>
                    </div>
                </div>
                <label class="switch" style="position: relative; display: inline-block; width: 40px; height: 22px;">
                    <input type="checkbox" checked style="opacity: 0; width: 0; height: 0;">
                    <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: var(--accent); border-radius: 34px; transition: 0.4s;">
                        <span style="position: absolute; content: ''; height: 16px; width: 16px; left: 3px; bottom: 3px; background-color: white; border-radius: 50%; transform: translateX(18px); transition: 0.4s;"></span>
                    </span>
                </label>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('stressChart');
        if (!ctx) return;
        
        const context = ctx.getContext('2d');
        const rawData = @json($historyDiagnoses ?? []);
        
        // Format labels (tanggal)
        const labels = rawData.map(item => {
            const d = new Date(item.created_at);
            return d.getDate() + '/' + (d.getMonth()+1);
        });
        
        // Format data (CF result dalam persen)
        const data = rawData.map(item => Math.round(item.cf_result * 100));
        
        // Gradient fill
        let gradient = context.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(9, 132, 227, 0.3)');
        gradient.addColorStop(1, 'rgba(9, 132, 227, 0.0)');
        
        new Chart(context, {
            type: 'line',
            data: {
                labels: labels.length > 0 ? labels : ['Belum ada data'],
                datasets: [{
                    label: 'Tingkat Burnout (%)',
                    data: data.length > 0 ? data : [0],
                    borderColor: '#0984e3',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#0984e3',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.4 // Smooth curve
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#2d3436',
                        titleFont: { size: 13, family: 'Nunito' },
                        bodyFont: { size: 14, family: 'Nunito', weight: 'bold' },
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + '% Stres';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: {
                            color: 'rgba(0,0,0,0.04)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#b2bec3',
                            font: { family: 'Nunito', weight: 'bold' },
                            stepSize: 25,
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: '#b2bec3',
                            font: { family: 'Nunito', weight: 'bold' }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
            }
        });
    });
</script>
@endsection
