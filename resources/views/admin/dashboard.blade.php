@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<style>
    /* Premium Dashboard Styles */
    .hero-banner-premium {
        background: var(--bg-surface, #ffffff);
        border-radius: 20px;
        padding: 32px 40px;
        color: var(--text-main, #2b3674);
        box-shadow: 0 10px 25px rgba(43, 54, 116, 0.04);
        border: 1px solid var(--border-color, #f1f5f9);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        gap: 24px;
    }
    .hero-banner-premium::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 6px;
        height: 100%;
        background: linear-gradient(180deg, #2dd4bf 0%, #0d9488 100%);
        border-radius: 4px 0 0 4px;
    }
    
    .stat-card-premium {
        background: var(--bg-surface, #ffffff);
        border-radius: 20px;
        padding: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(43, 54, 116, 0.04);
        border: 1px solid var(--border-color, #f1f5f9);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }
    .stat-card-premium:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(43, 54, 116, 0.08);
        border-color: rgba(79, 70, 229, 0.2);
    }
    .stat-card-premium .icon-box {
        transition: all 0.3s ease;
    }
    .stat-card-premium:hover .icon-box {
        transform: scale(1.1) rotate(5deg);
    }
    .table-premium {
        margin: 0;
        border-collapse: separate;
        border-spacing: 0 8px;
    }
    .table-premium tbody tr {
        transition: all 0.2s ease;
        background: var(--bg-surface, #ffffff);
    }
    .table-premium tbody tr:hover {
        transform: scale(1.01);
        box-shadow: 0 5px 15px rgba(0,0,0,0.03);
        border-radius: 12px;
        z-index: 10;
        position: relative;
    }
    .table-premium td {
        padding: 16px;
        border-top: 1px solid var(--border-color, #f8fafc) !important;
        border-bottom: 1px solid var(--border-color, #f8fafc) !important;
        vertical-align: middle;
    }
    .table-premium td:first-child {
        border-left: 1px solid var(--border-color, #f8fafc) !important;
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
    }
    .table-premium td:last-child {
        border-right: 1px solid var(--border-color, #f8fafc) !important;
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
    }
    .progress-bar-animated {
        transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>

<!-- Welcome Banner -->
<div class="hero-banner-premium mb-4">
    <div style="width: 72px; height: 72px; background: rgba(20, 184, 166, 0.1); border-radius: 20px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 1px solid rgba(20, 184, 166, 0.15);">
        <i class="ph-fill ph-hand-waving" style="font-size: 38px; color: #0d9488;"></i>
    </div>
    <div style="position: relative; z-index: 2;">
        <span style="color: #0d9488; font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; display: inline-block; margin-bottom: 8px;">Dashboard Administrator</span>
        <h2 style="font-weight: 800; color: var(--text-main, #2b3674); margin-bottom: 8px; font-size: 26px; letter-spacing: -0.5px;">Selamat Datang Kembali!</h2>
        <p style="font-size: 14px; color: var(--text-muted, #a3aed1); margin: 0; max-width: 650px; line-height: 1.6;">
            Pantau sebaran tingkat burnout dan interaksi mahasiswa secara real-time. Kelola basis pengetahuan secara dinamis.
        </p>
    </div>
</div>

<!-- Header & Filter Row -->
<div class="d-flex justify-content-end align-items-center mb-4 flex-wrap gap-3" style="padding: 0 4px;">
    <form action="{{ route('admin.dashboard') }}" method="GET" class="d-flex align-items-center gap-2">
        <label for="month" style="font-size: 13px; font-weight: 700; color: var(--text-muted, #a3aed1); margin: 0; white-space: nowrap;">
            <i class="ph ph-funnel" style="margin-right: 4px;"></i> Filter:
        </label>
        <select name="month" id="month" onchange="this.form.submit()" style="padding: 10px 16px; border-radius: 12px; border: 1px solid var(--border-color, #e9edf7); background: var(--bg-surface, #ffffff); font-size: 13px; font-weight: 700; color: var(--text-main, #2b3674); cursor: pointer; min-width: 160px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02); outline: none; transition: all 0.2s;">
            <option value="">Semua Waktu</option>
            @foreach($availableMonths as $monthItem)
                <option value="{{ $monthItem['val'] }}" {{ $selectedMonth == $monthItem['val'] ? 'selected' : '' }}>
                    {{ $monthItem['label'] }}
                </option>
            @endforeach
        </select>
    </form>
</div>

<!-- Stats Row -->
<div class="row g-4 mb-4 mx-0">
    <div class="col-md-4">
        <div class="stat-card-premium" style="justify-content: flex-start; gap: 20px; border-radius: 16px; padding: 24px;">
            <div class="icon-box" style="width: 60px; height: 60px; border-radius: 16px; background: rgba(79, 70, 229, 0.08); color: #4f46e5; display: flex; align-items: center; justify-content: center; font-size: 28px; flex-shrink: 0;">
                <i class="ph-fill ph-users-three"></i>
            </div>
            <div>
                <h3 style="font-size: 26px; font-weight: 800; color: var(--text-main, #2b3674); margin: 0 0 6px 0; line-height: 1;">{{ $totalStudents }}</h3>
                <span style="font-size: 11px; font-weight: 800; color: var(--text-muted, #a3aed1); text-transform: uppercase; letter-spacing: 1px;">{{ $selectedMonth ? 'Pendaftar Baru' : 'Total Mahasiswa' }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card-premium" style="justify-content: flex-start; gap: 20px; border-radius: 16px; padding: 24px;">
            <div class="icon-box" style="width: 60px; height: 60px; border-radius: 16px; background: rgba(245, 158, 11, 0.08); color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 28px; flex-shrink: 0;">
                <i class="ph-fill ph-file-text"></i>
            </div>
            <div>
                <h3 style="font-size: 26px; font-weight: 800; color: var(--text-main, #2b3674); margin: 0 0 6px 0; line-height: 1;">{{ $totalSharedDiagnoses }}</h3>
                <span style="font-size: 11px; font-weight: 800; color: var(--text-muted, #a3aed1); text-transform: uppercase; letter-spacing: 1px;">Hasil Diagnosis</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card-premium" style="justify-content: flex-start; gap: 20px; border-radius: 16px; padding: 24px;">
            <div class="icon-box" style="width: 60px; height: 60px; border-radius: 16px; background: rgba(16, 185, 129, 0.08); color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 28px; flex-shrink: 0;">
                <i class="ph-fill ph-brain"></i>
            </div>
            <div>
                <h3 style="font-size: 26px; font-weight: 800; color: var(--text-main, #2b3674); margin: 0 0 6px 0; line-height: 1;">{{ $totalSymptoms }}</h3>
                <span style="font-size: 11px; font-weight: 800; color: var(--text-muted, #a3aed1); text-transform: uppercase; letter-spacing: 1px;">Basis Aturan Gejala</span>
            </div>
        </div>
    </div>
</div>

<!-- Main Activity Area -->
<div class="row g-4 mx-0">
    <!-- Left Section: Trend & Recent Diagnoses -->
    <div class="col-lg-8 d-flex flex-column gap-4">
        
        <!-- Trend Chart -->
        <div class="neo-card" style="padding: 30px;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 style="font-weight: 800; color: var(--text-main, #2b3674); margin: 0; font-size: 18px;">Tren Diagnosis {{ date('Y') }}</h4>
                    <p style="font-size: 13px; color: var(--text-muted, #a3aed1); margin: 0; margin-top: 4px;">Pergerakan jumlah mahasiswa yang melakukan tes diagnosis setiap bulannya.</p>
                </div>
            </div>
            <div style="position: relative; height: 300px; width: 100%;">
                <canvas id="trendLineChart"></canvas>
            </div>
        </div>

        <div class="neo-card" style="padding: 30px; height: 100%;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 style="font-weight: 800; color: var(--text-main, #2b3674); margin: 0; font-size: 18px;">Aktivitas Diagnosis Terbaru</h4>
                    <p style="font-size: 13px; color: var(--text-muted, #a3aed1); margin: 0; margin-top: 4px;">Hasil inferensi kuesioner mahasiswa yang tercatat di sistem.</p>
                </div>
                <a href="{{ route('admin.students.index') }}" class="btn btn-sm" style="background: rgba(79, 70, 229, 0.08); color: #4f46e5; font-weight: 700; border-radius: 10px; font-size: 13px; padding: 8px 16px; border: none; transition: all 0.2s ease;" onmouseover="this.style.background='#4f46e5'; this.style.color='#ffffff';" onmouseout="this.style.background='rgba(79, 70, 229, 0.08)'; this.style.color='#4f46e5';">
                    Semua Data <i class="ph ph-arrow-right" style="margin-left: 4px;"></i>
                </a>
            </div>
            
            @if(count($recentDiagnoses) > 0)
                <div class="table-responsive">
                    <table class="table table-premium align-middle">
                        <thead style="background: transparent;">
                            <tr>
                                <th style="font-size: 12px; color: var(--text-muted, #a3aed1); text-transform: uppercase; padding: 0 16px 12px 16px; font-weight: 800; border: none; letter-spacing: 0.5px;">Mahasiswa</th>
                                <th style="font-size: 12px; color: var(--text-muted, #a3aed1); text-transform: uppercase; padding: 0 16px 12px 16px; font-weight: 800; border: none; letter-spacing: 0.5px;">Hasil Diagnosis</th>
                                <th style="font-size: 12px; color: var(--text-muted, #a3aed1); text-transform: uppercase; padding: 0 16px 12px 16px; font-weight: 800; border: none; letter-spacing: 0.5px;">Akurasi (CF)</th>
                                <th style="font-size: 12px; color: var(--text-muted, #a3aed1); text-transform: uppercase; padding: 0 16px 12px 16px; text-align: right; font-weight: 800; border: none; letter-spacing: 0.5px;">Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentDiagnoses as $diagnosis)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div style="width: 42px; height: 42px; border-radius: 12px; background: linear-gradient(135deg, rgba(79, 70, 229, 0.1) 0%, rgba(59, 130, 246, 0.1) 100%); color: #4f46e5; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 15px; border: 1px solid rgba(79, 70, 229, 0.1);">
                                                {{ strtoupper(substr($diagnosis->user->name ?? 'M', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div style="font-weight: 700; color: var(--text-main, #2b3674); font-size: 14px; margin-bottom: 2px;">{{ $diagnosis->user->name ?? 'Mahasiswa' }}</div>
                                                <div style="font-size: 12px; color: var(--text-muted, #a3aed1);">{{ $diagnosis->user->profile->nim ?? 'NIM belum diisi' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $badgeColors = [
                                                'B001' => ['bg' => 'rgba(16, 185, 129, 0.1)', 'text' => '#10b981', 'border' => 'rgba(16, 185, 129, 0.2)'], 
                                                'B002' => ['bg' => 'rgba(59, 130, 246, 0.1)', 'text' => '#3b82f6', 'border' => 'rgba(59, 130, 246, 0.2)'], 
                                                'B003' => ['bg' => 'rgba(245, 158, 11, 0.1)', 'text' => '#f59e0b', 'border' => 'rgba(245, 158, 11, 0.2)'], 
                                                'B004' => ['bg' => 'rgba(239, 68, 68, 0.1)', 'text' => '#ef4444', 'border' => 'rgba(239, 68, 68, 0.2)'], 
                                                'B005' => ['bg' => 'rgba(220, 38, 38, 0.1)', 'text' => '#dc2626', 'border' => 'rgba(220, 38, 38, 0.2)'], 
                                            ];
                                            $levelCode = $diagnosis->burnoutLevel->code ?? '';
                                            $color = $badgeColors[$levelCode] ?? ['bg' => 'rgba(107, 114, 128, 0.1)', 'text' => '#6b7280', 'border' => 'rgba(107, 114, 128, 0.2)'];
                                        @endphp
                                        <span style="background: {{ $color['bg'] }}; color: {{ $color['text'] }}; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; border: 1px solid {{ $color['border'] }}; display: inline-flex; align-items: center; gap: 4px;">
                                            <span style="width: 6px; height: 6px; border-radius: 50%; background: {{ $color['text'] }};"></span>
                                            {{ $diagnosis->burnoutLevel->name ?? 'Tidak diketahui' }}
                                        </span>
                                    </td>
                                    <td style="font-weight: 800; color: var(--primary, #4f46e5); font-size: 14px;">
                                        {{ round($diagnosis->cf_result * 100, 1) }}%
                                    </td>
                                    <td style="text-align: right; font-size: 13px; color: var(--text-muted, #a3aed1); font-weight: 600;">
                                        {{ $diagnosis->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="padding: 60px 24px; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                    <div style="width: 64px; height: 64px; border-radius: 50%; background: var(--bg-body, #f8fafc); display: flex; align-items: center; justify-content: center; margin-bottom: 20px; border: 1px solid var(--border-color, #f1f5f9);">
                        <i class="ph ph-empty" style="font-size: 32px; color: var(--text-muted, #cbd5e1);"></i>
                    </div>
                    <h5 style="font-weight: 800; color: var(--text-main, #2b3674); margin-bottom: 8px; font-size: 16px;">Belum Ada Data Diagnosis</h5>
                    <p style="font-size: 13px; color: var(--text-muted, #a3aed1); margin: 0; max-width: 350px; line-height: 1.6;">
                        Data inferensi mahasiswa yang melakukan diagnosis burnout akan otomatis masuk dan ditampilkan di area ini.
                    </p>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Right Section: Distribution Charts & Control -->
    <div class="col-lg-4 d-flex flex-column gap-4">
        <!-- Sebaran Tingkat Burnout -->
        <div class="neo-card" style="padding: 28px;">
            <h4 style="font-weight: 800; color: var(--text-main, #2b3674); font-size: 16px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
                <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(79, 70, 229, 0.1); display: flex; align-items: center; justify-content: center;">
                    <i class="ph-fill ph-chart-donut" style="color: #4f46e5; font-size: 18px;"></i>
                </div>
                Sebaran Tingkat Burnout
            </h4>
            
            <div style="position: relative; height: 300px; width: 100%; display: flex; justify-content: center; align-items: center;">
                <canvas id="burnoutPieChart"></canvas>
            </div>
        </div>

        <!-- Quick Action Control Card -->
        <div class="neo-card" style="padding: 28px; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: white; border: 1px solid rgba(255,255,255,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                <h4 style="font-weight: 800; color: white; font-size: 18px; margin: 0;">Pusat Aturan (Rule Base)</h4>
                <div style="width: 40px; height: 40px; border-radius: 12px; background: rgba(255,255,255,0.1); backdrop-filter: blur(5px); display: flex; align-items: center; justify-content: center;">
                    <i class="ph-fill ph-cpu" style="color: #10b981; font-size: 22px;"></i>
                </div>
            </div>
            <p style="font-size: 13px; opacity: 0.8; line-height: 1.6; margin-bottom: 24px;">
                Tuning bobot pakar (CF Expert) atau tambah gejala stres baru untuk akurasi diagnosis yang lebih valid.
            </p>
            <a href="{{ route('admin.symptoms.index') }}" class="btn w-100" style="background: rgba(255,255,255,0.1); color: white; font-weight: 800; border-radius: 12px; padding: 12px; justify-content: center; font-size: 14px; text-decoration: none; border: 1px solid rgba(255,255,255,0.2); transition: all 0.2s ease; backdrop-filter: blur(5px);" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                Modifikasi Basis Pengetahuan <i class="ph ph-arrow-circle-right" style="margin-left: 4px;"></i>
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const primaryColor = '#0097a7'; // Matching your teal theme
        
        // --- Pie/Doughnut Chart ---
        const burnoutCtx = document.getElementById('burnoutPieChart').getContext('2d');
        const burnoutLabels = {!! json_encode($burnoutLevels->pluck('name')) !!};
        const burnoutData = {!! json_encode($burnoutLevels->pluck('diagnoses_count')) !!};
        
        // Colors mapping based on B001 to B005
        const colors = ['#10b981', '#3b82f6', '#f59e0b', '#ef4444', '#dc2626'];
        
        new Chart(burnoutCtx, {
            type: 'doughnut',
            data: {
                labels: burnoutLabels,
                datasets: [{
                    data: burnoutData,
                    backgroundColor: colors,
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: {
                                family: "'Inter', sans-serif",
                                size: 12,
                                weight: '600'
                            },
                            color: '#64748b'
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { size: 13, family: "'Inter', sans-serif" },
                        bodyFont: { size: 14, weight: 'bold', family: "'Inter', sans-serif" }
                    }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        });

        // --- Trend Line Chart ---
        const trendCtx = document.getElementById('trendLineChart').getContext('2d');
        const trendRaw = {!! json_encode(array_values($trendData)) !!};
        
        // Create gradient
        const gradient = trendCtx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(0, 151, 167, 0.4)');
        gradient.addColorStop(1, 'rgba(0, 151, 167, 0.0)');

        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Total Diagnosis',
                    data: trendRaw,
                    borderColor: primaryColor,
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: primaryColor,
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
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
                        backgroundColor: '#1e293b',
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false,
                        titleFont: { size: 13, family: "'Inter', sans-serif" },
                        bodyFont: { size: 14, weight: 'bold', family: "'Inter', sans-serif" }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: {
                            font: { family: "'Inter', sans-serif", size: 12, weight: '500' },
                            color: '#94a3b8'
                        }
                    },
                    y: {
                        grid: {
                            color: '#f1f5f9',
                            drawBorder: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            font: { family: "'Inter', sans-serif", size: 12, weight: '500' },
                            color: '#94a3b8',
                            stepSize: 1,
                            beginAtZero: true
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
