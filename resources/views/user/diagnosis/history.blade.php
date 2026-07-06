@extends('layouts.user')
@section('title', 'Riwayat Diagnosis')

@section('content')
<div class="neo-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h2><i class="ph-fill ph-clock-counter-clockwise" style="color: var(--primary);"></i> Riwayat Diagnosis</h2>
        <a href="{{ route('diagnosis.wizard') }}" class="btn btn-primary">
            <i class="ph-bold ph-plus"></i> Diagnosis Baru
        </a>
    </div>

    @if($diagnoses->count() > 0)
        <div style="display: flex; flex-direction: column; gap: 16px;">
            @foreach($diagnoses as $diag)
            <div style="padding: 24px; border-radius: var(--radius-md); border: 1px solid var(--border-color); background: var(--bg-body); display: flex; justify-content: space-between; align-items: center; transition: all 0.3s ease;">
                <div style="display: flex; align-items: center; gap: 24px;">
                    <div style="width: 64px; height: 64px; border-radius: 50%; border: 4px solid rgba(99, 102, 241, 0.15); display: flex; align-items: center; justify-content: center; background: #fff;">
                        <span style="font-size: 16px; font-weight: 700; color: var(--primary);">{{ number_format($diag->cf_result * 100, 0) }}%</span>
                    </div>
                    <div>
                        <div style="font-weight: 700; color: var(--text-primary); font-size: 18px; margin-bottom: 4px;">{{ $diag->burnoutLevel->name }}</div>
                        <div style="font-size: 13px; color: var(--text-secondary); display: flex; align-items: center; gap: 6px;">
                            <i class="ph ph-calendar-blank"></i> {{ $diag->created_at->translatedFormat('d F Y, H:i') }}
                        </div>
                    </div>
                </div>
                
                <a href="{{ route('diagnosis.result', $diag->id) }}" class="btn btn-secondary">
                    Lihat Detail
                </a>
            </div>
            @endforeach
        </div>
    @else
        <div style="text-align: center; padding: 64px 0;">
            <i class="ph-fill ph-folder-open" style="font-size: 64px; color: var(--border-color); margin-bottom: 16px;"></i>
            <h3 style="color: var(--text-secondary); margin-bottom: 8px;">Belum Ada Riwayat</h3>
            <p style="color: var(--text-muted); font-size: 14px;">Anda belum pernah melakukan diagnosis kelelahan akademis.</p>
        </div>
    @endif
</div>
@endsection
