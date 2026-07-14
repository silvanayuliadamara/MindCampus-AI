@extends('layouts.user')
@section('title', 'Artikel Edukasi')
@section('page_title', 'Artikel Edukasi')
@section('page_subtitle', 'Pusat literasi kesehatan mental dan strategi belajar untuk mahasiswa akhir')

@section('content')
<div class="mb-4">
    <!-- Category Filter Bar -->
    <div style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center; margin-bottom: 24px;">
        <span style="font-size: 13px; font-weight: 700; color: var(--text-secondary); margin-right: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Kategori:</span>
        
        <a href="{{ route('articles.index') }}" class="btn-filter {{ !$category ? 'active' : '' }}">
            Semua
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('articles.index', ['category' => $cat]) }}" class="btn-filter {{ $category === $cat ? 'active' : '' }}">
                {{ $cat }}
            </a>
        @endforeach
    </div>

    <!-- Articles Grid -->
    @if($articles->count() > 0)
        <div class="row g-4">
            @foreach($articles as $art)
                @php
                    // Map category to color scheme
                    $catColor = '#0d9488'; // teal default
                    $catBg = 'rgba(13, 148, 136, 0.12)';
                    if ($art->category === 'Mental Health') {
                        $catColor = '#ef4444'; // red/rose
                        $catBg = 'rgba(239, 68, 68, 0.12)';
                    } elseif ($art->category === 'Produktivitas') {
                        $catColor = '#d97706'; // amber
                        $catBg = 'rgba(217, 119, 6, 0.12)';
                    } elseif ($art->category === 'Self-Care') {
                        $catColor = '#10b981'; // emerald
                        $catBg = 'rgba(16, 185, 129, 0.12)';
                    } elseif ($art->category === 'Kesehatan Fisik') {
                        $catColor = '#3b82f6'; // blue
                        $catBg = 'rgba(59, 130, 246, 0.12)';
                    }
                @endphp
                <div class="col-md-6 col-lg-4 col-xl-4 d-flex">
                    <div class="neo-card animated-card d-flex flex-column justify-content-between h-100 w-100" style="padding: 24px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border-radius: var(--radius-lg); position: relative; overflow: hidden;">
                        
                        <!-- Premium abstract card glow background -->
                        <div style="position: absolute; right: -20px; top: -20px; width: 80px; height: 80px; border-radius: 50%; background: {{ $catColor }}; opacity: 0.04; filter: blur(20px);"></div>
                        
                        <div>
                            <!-- Header Info -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span style="display: inline-block; padding: 4px 10px; background: {{ $catBg }}; color: {{ $catColor }}; border-radius: 6px; font-size: 10px; font-weight: 800; border: 1px solid rgba(255,255,255,0.05);">
                                    {{ strtoupper($art->category) }}
                                </span>
                                <span style="font-size: 11px; color: var(--text-secondary); font-weight: 600; display: flex; align-items: center; gap: 4px;">
                                    <i class="ph ph-clock" style="font-size: 13px;"></i> {{ $art->read_time }} mnt baca
                                </span>
                            </div>
                            
                            <!-- Title -->
                            <h4 style="font-size: 16px; font-weight: 800; color: var(--text-dark); line-height: 1.4; margin-bottom: 12px; height: 44px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; letter-spacing: -0.3px;">
                                {{ $art->title }}
                            </h4>
                            
                            <!-- Summary -->
                            <p style="font-size: 12.5px; color: var(--text-secondary); line-height: 1.6; margin-bottom: 24px; font-weight: 500; height: 60px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                                {{ $art->summary }}
                            </p>
                        </div>
                        
                        <!-- Footer Action -->
                        <div style="border-top: 1px solid rgba(255,255,255,0.03); [data-theme='light'] & { border-color: rgba(0,0,0,0.04); } pt-3; width: 100%;">
                            <a href="{{ route('articles.show', $art->slug) }}" class="btn-neo-secondary w-100" style="padding: 10px 16px; font-size: 12px; border-radius: 10px; justify-content: center; font-weight: 700;">
                                Baca Selengkapnya <i class="ph-bold ph-arrow-right" style="font-size: 12px; margin-left: 2px;"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="neo-card" style="text-align: center; padding: 64px 0;">
            <div style="width: 72px; height: 72px; background: rgba(20, 184, 166, 0.06); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; border: 1px solid rgba(20, 184, 166, 0.15);">
                <i class="ph-fill ph-book-open" style="font-size: 32px; color: var(--accent);"></i>
            </div>
            <h3 style="color: var(--text-dark); font-size: 16px; font-weight: 700; margin-bottom: 8px;">Belum Ada Artikel</h3>
            <p style="color: var(--text-secondary); font-size: 13px; max-width: 320px; margin: 0 auto; line-height: 1.5; font-weight: 500;">Tidak ada artikel yang sesuai dengan kategori filter saat ini.</p>
        </div>
    @endif
</div>

<style>
    .btn-filter {
        display: inline-block;
        padding: 8px 18px;
        background: rgba(255, 255, 255, 0.03);
        border: var(--border-glass);
        color: var(--text-secondary);
        border-radius: 10px;
        text-decoration: none;
        font-weight: 700;
        font-size: 13px;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    [data-theme='light'] .btn-filter {
        background: #fff;
        border: 1px solid rgba(0,0,0,0.06);
        box-shadow: 0 2px 6px rgba(0,0,0,0.03);
    }
    .btn-filter:hover {
        background: rgba(255, 255, 255, 0.06);
        color: var(--text-dark);
        transform: translateY(-1px);
        [data-theme='light'] & {
            background: #f1f5f9;
        }
    }
    .btn-filter.active {
        background: linear-gradient(135deg, #14b8a6, #0d9488) !important;
        color: #fff !important;
        border-color: transparent !important;
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.3) !important;
    }
</style>
@endsection
