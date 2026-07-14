@extends('layouts.user')
@section('title', $article->title)
@section('page_title', 'Baca Artikel')
@section('page_subtitle', 'Edukasi Serenity AI')

@section('content')
<div class="row g-4">
    <!-- Main Article Body -->
    <div class="col-lg-8">
        <div class="neo-card animated-card" style="padding: 40px; border-radius: var(--radius-lg);">
            
            <!-- Back Button -->
            <a href="{{ route('articles.index') }}" class="btn-neo-secondary mb-4" style="padding: 8px 16px; font-size: 12px; border-radius: 8px; font-weight: 700;">
                <i class="ph-bold ph-arrow-left"></i> Kembali ke Daftar Artikel
            </a>
            
            <!-- Metadata & Category -->
            @php
                // Map category colors
                $catColor = '#0d9488';
                $catBg = 'rgba(13, 148, 136, 0.12)';
                if ($article->category === 'Mental Health') {
                    $catColor = '#ef4444';
                    $catBg = 'rgba(239, 68, 68, 0.12)';
                } elseif ($article->category === 'Produktivitas') {
                    $catColor = '#d97706';
                    $catBg = 'rgba(217, 119, 6, 0.12)';
                } elseif ($article->category === 'Self-Care') {
                    $catColor = '#10b981';
                    $catBg = 'rgba(16, 185, 129, 0.12)';
                } elseif ($article->category === 'Kesehatan Fisik') {
                    $catColor = '#3b82f6';
                    $catBg = 'rgba(59, 130, 246, 0.12)';
                }
            @endphp
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px; flex-wrap: wrap;">
                <span style="display: inline-block; padding: 4px 12px; background: {{ $catBg }}; color: {{ $catColor }}; border-radius: 6px; font-size: 11px; font-weight: 800; border: 1px solid rgba(255,255,255,0.05);">
                    {{ strtoupper($article->category) }}
                </span>
                <span style="font-size: 12px; color: var(--text-secondary); font-weight: 600; display: flex; align-items: center; gap: 4px;">
                    <i class="ph ph-calendar-blank"></i> {{ $article->created_at->translatedFormat('d F Y') }}
                </span>
                <span style="font-size: 12px; color: var(--text-secondary); font-weight: 600; display: flex; align-items: center; gap: 4px;">
                    <i class="ph ph-clock"></i> {{ $article->read_time }} menit baca
                </span>
            </div>

            <!-- Title -->
            <h1 style="font-size: 24px; font-weight: 800; color: var(--text-dark); line-height: 1.4; margin-bottom: 24px; letter-spacing: -0.5px;">
                {{ $article->title }}
            </h1>

            <hr style="border: 0; border-top: 1px solid rgba(255,255,255,0.05); [data-theme='light'] & { border-color: rgba(0,0,0,0.06); } margin-bottom: 24px;">

            <!-- Article Body with Typography Styling -->
            <div class="article-rich-text" style="color: var(--text-dark); font-size: 14.5px; line-height: 1.8; font-weight: 500;">
                {!! nl2br(preg_replace('/### (.*?)\n/', '<h3 style="font-size: 18px; font-weight: 800; color: var(--text-dark); margin-top: 28px; margin-bottom: 12px; display: block; letter-spacing: -0.3px;">$1</h3>', preg_replace('/(\d\.\s\*\*.*?\*\*)/', '<br>$1', $article->content))) !!}
            </div>
        </div>
    </div>

    <!-- Recommendations (Right Column) -->
    <div class="col-lg-4">
        <div class="neo-card" style="padding: 28px; border-radius: var(--radius-lg); position: sticky; top: 24px;">
            <h4 style="font-size: 16px; font-weight: 800; color: var(--text-dark); margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                <i class="ph ph-sparkle" style="color: var(--accent); font-size: 18px;"></i> Rekomendasi Artikel
            </h4>
            
            <div style="display: flex; flex-direction: column; gap: 16px;">
                @forelse($recommendations as $rec)
                    @php
                        $recColor = '#0d9488';
                        $recBg = 'rgba(13, 148, 136, 0.12)';
                        if ($rec->category === 'Mental Health') {
                            $recColor = '#ef4444';
                            $recBg = 'rgba(239, 68, 68, 0.12)';
                        } elseif ($rec->category === 'Produktivitas') {
                            $recColor = '#d97706';
                            $recBg = 'rgba(217, 119, 6, 0.12)';
                        } elseif ($rec->category === 'Self-Care') {
                            $recColor = '#10b981';
                            $recBg = 'rgba(16, 185, 129, 0.12)';
                        } elseif ($rec->category === 'Kesehatan Fisik') {
                            $recColor = '#3b82f6';
                            $recBg = 'rgba(59, 130, 246, 0.12)';
                        }
                    @endphp
                    <a href="{{ route('articles.show', $rec->slug) }}" class="rec-link-card" style="display: block; text-decoration: none; padding: 16px; border-radius: 12px; border: var(--border-glass); background: rgba(255,255,255,0.01); transition: all 0.2s ease;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <span style="font-size: 9px; font-weight: 800; color: {{ $recColor }}; background: {{ $recBg }}; padding: 2px 8px; border-radius: 4px;">
                                {{ strtoupper($rec->category) }}
                            </span>
                            <span style="font-size: 10px; color: var(--text-secondary); font-weight: 500;">
                                {{ $rec->read_time }} mnt
                            </span>
                        </div>
                        <h5 style="font-size: 13px; font-weight: 700; color: var(--text-dark); line-height: 1.4; margin: 0; transition: color 0.2s ease;" class="rec-title">
                            {{ $rec->title }}
                        </h5>
                    </a>
                @empty
                    <p style="font-size: 12px; color: var(--text-muted); font-weight: 500;">Tidak ada rekomendasi lain.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
    .rec-link-card:hover {
        background: rgba(20, 184, 166, 0.04) !important;
        border-color: rgba(20, 184, 166, 0.2) !important;
        transform: translateY(-1px);
    }
    .rec-link-card:hover .rec-title {
        color: var(--accent) !important;
    }
    .article-rich-text blockquote {
        background: rgba(20, 184, 166, 0.05);
        border-left: 4px solid var(--accent);
        padding: 12px 20px;
        margin: 20px 0;
        border-radius: 0 8px 8px 0;
        font-style: italic;
    }
</style>
@endsection
