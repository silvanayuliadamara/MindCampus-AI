@extends('layouts.user')
@section('title', 'Riwayat Diagnosis')

@section('content')
<div class="neo-card animated-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; flex-wrap: wrap; gap: 16px;">
        <h2 style="font-size: 20px; font-weight: 800; color: var(--text-dark); margin: 0; display: flex; align-items: center; gap: 10px;">
            <i class="ph-fill ph-clock-counter-clockwise" style="color: var(--accent); font-size: 24px;"></i> Riwayat Diagnosis Anda
        </h2>
        <a href="{{ route('diagnosis.wizard') }}" class="btn-neo" style="padding: 10px 24px; font-size: 13px;">
            <i class="ph-bold ph-plus"></i> Diagnosis Baru
        </a>
    </div>

    @if($diagnoses->count() > 0)
        <div style="display: flex; flex-direction: column; gap: 16px;">
            @foreach($diagnoses as $diag)
            @php
                $percentage = $diag->cf_result * 100;
                $levelColor = 'var(--accent)';
                if ($percentage <= 20) { $levelColor = 'var(--color-normal)'; }
                elseif ($percentage <= 60) { $levelColor = 'var(--color-warning)'; }
                else { $levelColor = 'var(--color-danger)'; }
            @endphp
            <div style="padding: 20px 24px; border-radius: var(--radius-md); display: flex; justify-content: space-between; align-items: center; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); gap: 16px;" class="history-item animated-card">
                <div style="display: flex; align-items: center; gap: 20px;">
                    <div style="width: 56px; height: 56px; border-radius: 50%; border: 3px solid {{ $levelColor }}; display: flex; align-items: center; justify-content: center; background: var(--user-bg); box-shadow: 0 0 10px rgba(255,255,255,0.02); flex-shrink: 0;">
                        <span style="font-size: 13px; font-weight: 800; color: var(--text-dark);">{{ number_format($percentage, 0) }}%</span>
                    </div>
                    <div>
                        <div style="font-weight: 700; color: var(--text-dark); font-size: 16px; margin-bottom: 4px; letter-spacing: -0.3px;">{{ $diag->burnoutLevel->name }}</div>
                        <div style="font-size: 12px; color: var(--text-secondary); display: flex; align-items: center; gap: 6px; font-weight: 500;">
                            <i class="ph ph-calendar-blank" style="font-size: 14px;"></i> {{ $diag->created_at->translatedFormat('d F Y, H:i') }}
                        </div>
                    </div>
                </div>
                
                <a href="{{ route('diagnosis.result', $diag->id) }}" class="btn-neo-secondary" style="padding: 8px 16px; font-size: 12px; border-radius: 8px;">
                    Lihat Detail
                </a>
            </div>
            @endforeach
        </div>
    @else
        <div style="text-align: center; padding: 64px 0;">
            <div style="width: 72px; height: 72px; background: rgba(20, 184, 166, 0.06); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; border: 1px solid rgba(20, 184, 166, 0.15);">
                <i class="ph-fill ph-folder-open" style="font-size: 32px; color: var(--accent);"></i>
            </div>
            <h3 style="color: var(--text-dark); font-size: 16px; font-weight: 700; margin-bottom: 8px;">Belum Ada Riwayat</h3>
            <p style="color: var(--text-secondary); font-size: 13px; max-width: 300px; margin: 0 auto; line-height: 1.5; font-weight: 500;">Anda belum pernah melakukan diagnosis stres akademik (burnout).</p>
        </div>
    @endif
</div>

<style>
    .history-item {
        background: rgba(255, 255, 255, 0.45);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    [data-theme="dark"] .history-item {
        background: rgba(255, 255, 255, 0.02);
        border: var(--border-glass);
    }
    .history-item:hover {
        transform: translateY(-2px);
        background: rgba(255, 255, 255, 0.7);
        border-color: rgba(20, 184, 166, 0.3);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.03);
    }
    [data-theme="dark"] .history-item:hover {
        background: rgba(255, 255, 255, 0.04);
        border-color: rgba(20, 184, 166, 0.3);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
    }
</style>
@endsection
