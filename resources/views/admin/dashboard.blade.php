@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')

<!-- Stats Row -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="solid-card stat-card">
            <div class="stat-icon primary">
                <i class="ph-fill ph-stethoscope"></i>
            </div>
            <div class="stat-details">
                <h3>{{ $totalSymptoms ?? 12 }}</h3>
                <p>Total Gejala</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="solid-card stat-card">
            <div class="stat-icon warning">
                <i class="ph-fill ph-chart-bar"></i>
            </div>
            <div class="stat-details">
                <h3>{{ $totalLevels ?? 5 }}</h3>
                <p>Level Burnout</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="solid-card stat-card">
            <div class="stat-icon success">
                <i class="ph-fill ph-users"></i>
            </div>
            <div class="stat-details">
                <h3>{{ $totalDiagnoses ?? 0 }}</h3>
                <p>Sesi Diagnosis</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Activity Area -->
<div class="row">
    <div class="col-12">
        <div class="solid-card">
            <h4 class="mb-1" style="font-size: 18px;">Aktivitas Terbaru</h4>
            <p class="text-muted mb-4" style="font-size: 14px;">Aktivitas sistem terbaru (Data Dummy)</p>
            
            <div class="table-responsive">
                <table class="table table-borderless align-middle">
                    <thead style="border-bottom: 1px solid var(--border-color);">
                        <tr>
                            <th class="text-muted" style="font-size: 12px; padding-bottom: 16px;">NO</th>
                            <th class="text-muted" style="font-size: 12px; padding-bottom: 16px;">MAHASISWA</th>
                            <th class="text-muted" style="font-size: 12px; padding-bottom: 16px;">HASIL BURNOUT</th>
                            <th class="text-muted" style="font-size: 12px; padding-bottom: 16px;">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="pt-3">1</td>
                            <td class="pt-3 fw-semibold text-main">Dimas</td>
                            <td class="pt-3">Burnout Sedang</td>
                            <td class="pt-3"><span class="badge bg-success-subtle text-success">Selesai</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
