@extends('layouts.user')
@section('title', 'Kuesioner Diagnosis Burnout')

@section('content')
<div class="neo-card wizard-container" style="max-width: 800px; margin: 0 auto;">
    <div style="text-align: center; margin-bottom: 32px;">
        <h2 class="question-title">Diagnosis Tingkat Burnout</h2>
        <p class="question-desc">Jawablah pertanyaan berikut sesuai dengan kondisi yang Anda rasakan akhir-akhir ini.</p>
    </div>

    <form action="{{ route('diagnosis.calculate') }}" method="POST">
        @csrf
        
        <div style="display: flex; flex-direction: column; gap: 24px;">
        @foreach($symptoms as $index => $symptom)
        <div class="neo-card" style="padding: 32px; border: 1px solid #e1e8f0; margin-bottom: 0;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                <div style="width: 32px; height: 32px; background: var(--accent-light); color: var(--accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px;">
                    {{ $index + 1 }}
                </div>
                <div style="font-weight: 700; color: var(--text-muted); font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">
                    Dari {{ count($symptoms) }} Pertanyaan
                </div>
            </div>
            <h3 style="font-size: 18px; color: var(--text-dark); margin-bottom: 24px; font-weight: 700; line-height: 1.5;">{{ $symptom->question }}</h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 12px;">
                @php
                    $options = [
                        ['label' => 'Sangat Yakin', 'value' => 1.0],
                        ['label' => 'Yakin', 'value' => 0.8],
                        ['label' => 'Cukup Yakin', 'value' => 0.6],
                        ['label' => 'Kurang Yakin', 'value' => 0.4],
                        ['label' => 'Tidak Yakin', 'value' => 0.2],
                        ['label' => 'Tidak', 'value' => 0.0],
                    ];
                @endphp

                @foreach($options as $opt)
                <label class="option-card" style="display: flex; align-items: center; justify-content: center; position: relative; padding: 14px 10px; text-align: center; cursor: pointer; height: 100%;">
                    <input type="radio" name="symptoms[{{ $symptom->id }}]" value="{{ $opt['value'] }}" required style="position: absolute; opacity: 0; cursor: pointer; height: 0; width: 0;">
                    <div style="font-weight: 700; font-size: 13px; color: var(--text-dark); transition: 0.3s; line-height: 1.2;">{{ $opt['label'] }}</div>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach
        </div>

        <div class="wizard-footer" style="display: flex; justify-content: flex-end; margin-top: 40px;">
            <button type="submit" class="btn-neo" style="padding: 16px 40px; font-size: 16px; box-shadow: 0 10px 20px rgba(9, 132, 227, 0.3);">
                <i class="ph-bold ph-check-circle"></i> Selesaikan & Lihat Hasil
            </button>
        </div>
    </form>
</div>
@endsection
