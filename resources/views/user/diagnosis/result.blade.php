@extends('layouts.user')
@section('title', 'Hasil Diagnosis Burnout')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    
    <div class="neo-card" style="text-align: center; margin-bottom: 32px; position: relative; overflow: hidden;">
        <!-- Background accent based on severity (simulation) -->
        <div style="position: absolute; top: -50%; left: -10%; width: 300px; height: 300px; background: rgba(99, 102, 241, 0.15); filter: blur(60px); border-radius: 50%; z-index: -1;"></div>
        
        <h2 style="color: var(--text-secondary); font-size: 18px; margin-bottom: 24px; text-transform: uppercase; letter-spacing: 1px;">Hasil Diagnosis Anda</h2>
        
        <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 24px;">
            <div style="width: 180px; height: 180px; border-radius: 50%; border: 12px solid var(--primary); display: flex; align-items: center; justify-content: center; flex-direction: column; background: #fff; box-shadow: 0 8px 32px rgba(99, 102, 241, 0.2);">
                <span style="font-size: 42px; font-weight: 800; color: var(--text-primary); line-height: 1;">{{ number_format($diagnosis->cf_result * 100, 1) }}<span style="font-size: 24px;">%</span></span>
                <span style="font-size: 12px; color: var(--text-muted); margin-top: 4px; font-weight: 600;">Kepastian</span>
            </div>
        </div>

        <h1 style="font-size: 32px; color: var(--text-primary); margin-bottom: 12px;">{{ $diagnosis->burnoutLevel->name }}</h1>
        <p style="font-size: 16px; color: var(--text-secondary); max-width: 500px; margin: 0 auto; line-height: 1.6;">
            {{ $diagnosis->burnoutLevel->description }}
        </p>
    </div>

    <div class="neo-card">
        <h3 style="margin-bottom: 24px; font-size: 20px; color: var(--text-primary); display: flex; align-items: center; gap: 8px;">
            <i class="ph-fill ph-list-magnifying-glass" style="color: var(--primary);"></i> Rincian Gejala Terdeteksi
        </h3>
        
        <div style="display: flex; flex-direction: column; gap: 16px;">
            @foreach($diagnosis->details as $detail)
                @if($detail->cf_user > 0)
                <div style="padding: 16px; border-radius: var(--radius-sm); border: 1px solid var(--border-color); background: rgba(255, 255, 255, 0.5); display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="font-weight: 600; color: var(--text-primary); font-size: 15px; margin-bottom: 4px;">{{ $detail->symptom->name }}</div>
                        <div style="font-size: 13px; color: var(--text-secondary);">Input Keyakinan: {{ $detail->cf_user * 100 }}%</div>
                    </div>
                    <div style="font-weight: 700; color: var(--primary); background: rgba(99, 102, 241, 0.1); padding: 6px 12px; border-radius: 20px; font-size: 14px;">
                        CF: {{ number_format($detail->cf_result, 3) }}
                    </div>
                </div>
                @endif
            @endforeach
        </div>
        
        <div style="margin-top: 32px; display: flex; justify-content: center; gap: 16px;">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                <i class="ph-bold ph-arrow-left"></i> Kembali ke Dashboard
            </a>
            <a href="{{ route('diagnosis.wizard') }}" class="btn btn-primary">
                <i class="ph-bold ph-arrow-counter-clockwise"></i> Ulangi Diagnosis
            </a>
        </div>
    </div>
</div>
@endsection
