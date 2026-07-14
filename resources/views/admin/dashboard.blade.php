@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')

<!-- Welcome Banner -->
<div class="hero-banner-gradient mb-4" style="background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%); border-radius: 16px; padding: 28px 36px; color: white; box-shadow: 0 10px 25px rgba(79, 70, 229, 0.15); position: relative; overflow: hidden; border: none;">
    <div style="position: relative; z-index: 2;">
        <span style="background: rgba(255, 255, 255, 0.15); font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 50px; text-transform: uppercase; letter-spacing: 1px; display: inline-block; margin-bottom: 12px; border: 1px solid rgba(255, 255, 255, 0.15);">Sistem Manajemen AI</span>
        <h2 style="font-weight: 800; color: white; margin-bottom: 6px; font-size: 24px; letter-spacing: -0.5px;">Selamat Datang Kembali, Admin! 👋</h2>
        <p style="font-size: 13px; opacity: 0.9; margin: 0; max-width: 600px; line-height: 1.5;">
            Pantau sebaran tingkat kecemasan & burnout mahasiswa secara real-time dengan menghormati hak privasi persetujuan (*consent*) pengguna.
        </p>
    </div>
    <!-- Decorative Glowing Mesh Elements -->
    <div style="position: absolute; top: -80px; right: -80px; width: 220px; height: 220px; background: rgba(255, 255, 255, 0.1); border-radius: 50%; filter: blur(40px);"></div>
    <div style="position: absolute; bottom: -40px; left: 50%; width: 150px; height: 150px; background: rgba(255, 255, 255, 0.06); border-radius: 50%; filter: blur(30px);"></div>
</div>

<!-- Header & Filter Row -->
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3" style="padding: 0 4px;">
    <div>
        <h3 style="font-weight: 800; color: #2b3674; margin: 0; font-size: 18px; letter-spacing: -0.3px;">Ikhtisar Data</h3>
        <p style="font-size: 12px; color: #a3aed1; margin: 0; margin-top: 2px;">Visualisasi dan laporan statistik kesehatan mental mahasiswa.</p>
    </div>
    
    <!-- Premium Month Filter Form -->
    <form action="{{ route('admin.dashboard') }}" method="GET" class="d-flex align-items-center gap-2">
        <label for="month" style="font-size: 12px; font-weight: 700; color: #a3aed1; margin: 0; white-space: nowrap;">
            <i class="ph ph-funnel" style="margin-right: 2px;"></i> Filter Bulan:
        </label>
        <select name="month" id="month" onchange="this.form.submit()" style="padding: 8px 14px; border-radius: 10px; border: 1px solid #e9edf7; background: #ffffff; font-size: 12px; font-weight: 700; color: #2b3674; cursor: pointer; min-width: 150px; box-shadow: 0 4px 12px rgba(43, 54, 116, 0.02); outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#4f46e5'" onblur="this.style.borderColor='#e9edf7'">
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
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="solid-card" style="padding: 24px; border-radius: 16px; border: none; display: flex; align-items: center; justify-content: space-between; position: relative; overflow: hidden; background: #ffffff; box-shadow: 0 10px 30px rgba(43, 54, 116, 0.02);">
            <div>
                <span style="font-size: 11px; font-weight: 800; color: #a3aed1; text-transform: uppercase; letter-spacing: 0.5px;">{{ $selectedMonth ? 'Pendaftar Baru' : 'Total Mahasiswa' }}</span>
                <h3 style="font-size: 28px; font-weight: 800; color: #2b3674; margin: 4px 0 0 0; line-height: 1;">{{ $totalStudents }}</h3>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(79, 70, 229, 0.08); color: #4f46e5; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">
                <i class="ph-fill ph-users"></i>
            </div>
            <div style="position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: #4f46e5;"></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="solid-card" style="padding: 24px; border-radius: 16px; border: none; display: flex; align-items: center; justify-content: space-between; position: relative; overflow: hidden; background: #ffffff; box-shadow: 0 10px 30px rgba(43, 54, 116, 0.02);">
            <div>
                <span style="font-size: 11px; font-weight: 800; color: #a3aed1; text-transform: uppercase; letter-spacing: 0.5px;">Hasil Diizinkan Share</span>
                <h3 style="font-size: 28px; font-weight: 800; color: #2b3674; margin: 4px 0 0 0; line-height: 1;">{{ $totalSharedDiagnoses }}</h3>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(245, 158, 11, 0.08); color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">
                <i class="ph-fill ph-shield-check"></i>
            </div>
            <div style="position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: #f59e0b;"></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="solid-card" style="padding: 24px; border-radius: 16px; border: none; display: flex; align-items: center; justify-content: space-between; position: relative; overflow: hidden; background: #ffffff; box-shadow: 0 10px 30px rgba(43, 54, 116, 0.02);">
            <div>
                <span style="font-size: 11px; font-weight: 800; color: #a3aed1; text-transform: uppercase; letter-spacing: 0.5px;">Item Gejala Pakar</span>
                <h3 style="font-size: 28px; font-weight: 800; color: #2b3674; margin: 4px 0 0 0; line-height: 1;">{{ $totalSymptoms }}</h3>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(16, 185, 129, 0.08); color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">
                <i class="ph-fill ph-stethoscope"></i>
            </div>
            <div style="position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: #10b981;"></div>
        </div>
    </div>
</div>

<!-- Main Activity Area -->
<div class="row g-4">
    <!-- Left Section: Recent Diagnoses -->
    <div class="col-lg-8">
        <div class="solid-card" style="border-radius: 16px; border: none; padding: 28px; height: 100%; background: #ffffff; box-shadow: 0 10px 30px rgba(43, 54, 116, 0.02);">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 style="font-weight: 800; color: #2b3674; margin: 0; font-size: 16px; letter-spacing: -0.2px;">Aktivitas Diagnosis Terbaru</h4>
                    <p style="font-size: 12px; color: #a3aed1; margin: 0; margin-top: 2px;">Hasil kuesioner mahasiswa yang disetujui untuk dibagi.</p>
                </div>
                <a href="{{ route('admin.students.index') }}" class="btn btn-sm" style="background: rgba(79, 70, 229, 0.06); color: #4f46e5; font-weight: 700; border-radius: 8px; font-size: 12px; padding: 6px 14px; border: none; transition: all 0.2s ease;" onmouseover="this.style.background='#4f46e5'; this.style.color='#ffffff';" onmouseout="this.style.background='rgba(79, 70, 229, 0.06)'; this.style.color='#4f46e5';">
                    Detail Mahasiswa <i class="ph ph-arrow-right" style="margin-left: 2px;"></i>
                </a>
            </div>
            
            @if(count($recentDiagnoses) > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle" style="margin: 0;">
                        <thead style="background: rgba(0,0,0,0.01); border-bottom: 1px solid var(--border-color);">
                            <tr>
                                <th style="font-size: 11px; color: #a3aed1; text-transform: uppercase; padding: 12px 16px; font-weight: 800; border: none;">Mahasiswa</th>
                                <th style="font-size: 11px; color: #a3aed1; text-transform: uppercase; padding: 12px 16px; font-weight: 800; border: none;">Hasil Diagnosis</th>
                                <th style="font-size: 11px; color: #a3aed1; text-transform: uppercase; padding: 12px 16px; font-weight: 800; border: none;">Akurasi (CF)</th>
                                <th style="font-size: 11px; color: #a3aed1; text-transform: uppercase; padding: 12px 16px; text-align: right; font-weight: 800; border: none;">Tanggal Pengisian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentDiagnoses as $diagnosis)
                                <tr>
                                    <td style="padding: 14px 16px; border-bottom: 1px solid #f8fafc;">
                                        <div class="d-flex align-items-center gap-3">
                                            <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(79, 70, 229, 0.08); color: #4f46e5; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 13px; border: 1px solid rgba(79, 70, 229, 0.12);">
                                                {{ strtoupper(substr($diagnosis->user->name ?? 'M', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div style="font-weight: 700; color: #2b3674; font-size: 13px;">{{ $diagnosis->user->name ?? 'Mahasiswa' }}</div>
                                                <div style="font-size: 11px; color: #a3aed1;">{{ $diagnosis->user->profile->nim ?? 'NIM belum diisi' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding: 14px 16px; border-bottom: 1px solid #f8fafc;">
                                        @php
                                            $badgeColors = [
                                                'B001' => ['bg' => 'rgba(16, 185, 129, 0.08)', 'text' => '#10b981'], 
                                                'B002' => ['bg' => 'rgba(59, 130, 246, 0.08)', 'text' => '#3b82f6'], 
                                                'B003' => ['bg' => 'rgba(245, 158, 11, 0.08)', 'text' => '#f59e0b'], 
                                                'B004' => ['bg' => 'rgba(239, 68, 68, 0.08)', 'text' => '#ef4444'], 
                                                'B005' => ['bg' => 'rgba(220, 38, 38, 0.12)', 'text' => '#dc2626'], 
                                            ];
                                            $levelCode = $diagnosis->burnoutLevel->code ?? '';
                                            $color = $badgeColors[$levelCode] ?? ['bg' => 'rgba(107, 114, 128, 0.08)', 'text' => '#6b7280'];
                                        @endphp
                                        <span class="badge" style="background: {{ $color['bg'] }}; color: {{ $color['text'] }}; padding: 5px 10px; border-radius: 6px; font-size: 11px; font-weight: 700;">
                                            {{ $diagnosis->burnoutLevel->name ?? 'Tidak diketahui' }}
                                        </span>
                                    </td>
                                    <td style="padding: 14px 16px; font-weight: 800; color: #4f46e5; font-size: 13px; border-bottom: 1px solid #f8fafc;">
                                        {{ round($diagnosis->cf_result * 100, 1) }}%
                                    </td>
                                    <td style="padding: 14px 16px; text-align: right; font-size: 12px; color: #a3aed1; font-weight: 600; border-bottom: 1px solid #f8fafc;">
                                        {{ $diagnosis->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="padding: 56px 24px; text-align: center; background: #ffffff; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                    <div style="width: 52px; height: 52px; border-radius: 50%; background: #f8fafc; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; border: 1px solid #f1f5f9;">
                        <i class="ph ph-shield-slash" style="font-size: 22px; color: #cbd5e1;"></i>
                    </div>
                    <h5 style="font-weight: 700; color: #2b3674; margin-bottom: 4px; font-size: 14px;">Belum Ada Sesi Diagnosis Dibagikan</h5>
                    <p style="font-size: 12px; color: #a3aed1; margin: 0; max-width: 320px; line-height: 1.5;">
                        Hasil diagnosis mahasiswa yang disetujui akan ditampilkan secara otomatis di sini.
                    </p>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Right Section: Distribution Charts & Control -->
    <div class="col-lg-4 d-flex flex-column gap-4">
        <!-- Sebaran Tingkat Burnout -->
        <div class="solid-card" style="border-radius: 16px; border: none; padding: 28px; background: #ffffff; box-shadow: 0 10px 30px rgba(43, 54, 116, 0.02);">
            <h4 style="font-weight: 800; color: #2b3674; font-size: 15px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                <i class="ph-fill ph-chart-pie" style="color: #4f46e5; font-size: 18px;"></i> Sebaran Tingkat Burnout
            </h4>
            <div style="display: flex; flex-direction: column; gap: 14px;">
                @foreach($burnoutLevels as $level)
                    @php
                        $percentage = $totalSharedDiagnoses > 0 ? ($level->diagnoses_count / $totalSharedDiagnoses) * 100 : 0;
                        
                        $colors = [
                            'B001' => ['color' => '#10b981'], 
                            'B002' => ['color' => '#3b82f6'], 
                            'B003' => ['color' => '#f59e0b'], 
                            'B004' => ['color' => '#ef4444'], 
                            'B005' => ['color' => '#dc2626'], 
                        ];
                        $colorSet = $colors[$level->code] ?? ['color' => '#6b7280'];
                    @endphp
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-1" style="font-size: 12px;">
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <span style="width: 6px; height: 6px; border-radius: 50%; background: {{ $colorSet['color'] }}; display: inline-block;"></span>
                                <span style="font-weight: 700; color: #2b3674;">{{ $level->name }}</span>
                            </div>
                            <span style="font-weight: 800; color: {{ $colorSet['color'] }};">{{ round($percentage) }}% ({{ $level->diagnoses_count }})</span>
                        </div>
                        <div style="width: 100%; height: 5px; background: #f1f5f9; border-radius: 10px; overflow: hidden;">
                            <div style="width: {{ $percentage }}%; height: 100%; background: {{ $colorSet['color'] }}; border-radius: 10px; transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Quick Action Control Card -->
        <div class="solid-card" style="border-radius: 16px; border: none; padding: 28px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; box-shadow: 0 10px 25px rgba(16, 185, 129, 0.15); border: none;">
            <h4 style="font-weight: 800; color: white; font-size: 16px; margin-bottom: 6px;">Pusat Kontrol Gejala</h4>
            <p style="font-size: 12px; opacity: 0.9; line-height: 1.5; margin-bottom: 20px;">
                Perbarui aturan Certainty Factor atau menambah gejala stres baru untuk analisis yang lebih valid?
            </p>
            <a href="{{ route('admin.symptoms.index') }}" class="btn w-100" style="background: white; color: #059669; font-weight: 800; border-radius: 10px; padding: 10px; justify-content: center; font-size: 13px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); text-decoration: none; border: none; transition: all 0.2s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                Kelola Basis Gejala <i class="ph ph-stethoscope" style="margin-left: 2px;"></i>
            </a>
        </div>

        <!-- Privacy Policy Stats Summary -->
        <div class="solid-card" style="border-radius: 16px; border: none; padding: 28px; background: #ffffff; box-shadow: 0 10px 30px rgba(43, 54, 116, 0.02);">
            <h4 style="font-weight: 800; color: #2b3674; font-size: 14px; margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                <i class="ph-fill ph-shield-check" style="color: #f59e0b; font-size: 18px;"></i> Keamanan Data & Privasi
            </h4>
            <div style="font-size: 12px; color: #a3aed1; line-height: 1.6; margin-bottom: 16px;">
                Serenity AI patuh terhadap kerahasiaan data kesehatan mental mahasiswa. Opsi consent kuesioner menjamin privasi tetap aman.
            </div>
            <div style="background: #f8fafc; border-radius: 10px; padding: 12px 16px; font-size: 12px; border: 1px solid #f1f5f9;">
                <div class="d-flex justify-content-between mb-2">
                    <span style="color: #a3aed1; font-weight: 600;">Status Sharing:</span>
                    <span style="color: #10b981; font-weight: 800;">Aktif (Opt-in)</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span style="color: #a3aed1; font-weight: 600;">Enkripsi DB:</span>
                    <span style="color: #4f46e5; font-weight: 800;">AES-256</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
