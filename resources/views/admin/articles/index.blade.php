@extends('layouts.admin')

@section('title', 'Kelola Artikel')
@section('page_title', 'Kelola Artikel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 style="font-weight: 800; color: var(--text-main); margin: 0; font-size: 24px; letter-spacing: -0.5px;">Kelola Artikel</h3>
    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary d-flex align-items-center gap-2 px-4 py-2" style="border-radius: 12px; font-weight: 600;">
        <i class="ph ph-plus-circle" style="font-size: 20px;"></i> Tambah Artikel
    </a>
</div>

<div class="card neo-card border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 custom-table">
                <thead style="background: var(--bg-body);">
                    <tr>
                        <th class="ps-4 py-3" style="color: var(--text-muted); font-weight: 600; font-size: 13px;">JUDUL ARTIKEL</th>
                        <th class="py-3" style="color: var(--text-muted); font-weight: 600; font-size: 13px;">KATEGORI</th>
                        <th class="py-3" style="color: var(--text-muted); font-weight: 600; font-size: 13px;">WAKTU BACA</th>
                        <th class="py-3" style="color: var(--text-muted); font-weight: 600; font-size: 13px;">DIBUAT PADA</th>
                        <th class="text-end pe-4 py-3" style="color: var(--text-muted); font-weight: 600; font-size: 13px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($articles as $article)
                    <tr>
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center gap-3">
                                @if($article->image_url)
                                    <div class="avatar-sm rounded-3" style="width: 48px; height: 48px; background-image: url('{{ $article->image_url }}'); background-size: cover; background-position: center; border: 1px solid var(--border-color);"></div>
                                @else
                                    <div class="avatar-sm rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: rgba(0, 151, 167, 0.1); border: 1px solid var(--border-color); color: #0097a7;">
                                        <i class="ph ph-image" style="font-size: 24px;"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-1 fw-bold" style="color: var(--text-main); font-size: 15px;">{{ $article->title }}</h6>
                                    <small class="text-muted d-block text-truncate" style="max-width: 250px;">{{ $article->summary }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="py-3">
                            <span class="badge" style="background: rgba(0, 151, 167, 0.1); color: #0097a7; font-weight: 600; padding: 6px 12px; border-radius: 8px;">
                                {{ $article->category }}
                            </span>
                        </td>
                        <td class="py-3">
                            <span style="color: var(--text-main); font-weight: 500;">
                                <i class="ph ph-clock text-muted me-1"></i> {{ $article->read_time }} mnt
                            </span>
                        </td>
                        <td class="py-3">
                            <span style="color: var(--text-muted); font-size: 14px;">{{ $article->created_at->translatedFormat('d M Y') }}</span>
                        </td>
                        <td class="text-end pe-4 py-3">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn btn-sm btn-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b; border-radius: 8px;" title="Edit Artikel">
                                    <i class="ph ph-pencil-simple" style="font-size: 18px;"></i>
                                </a>
                                <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-icon" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border-radius: 8px;" title="Hapus Artikel">
                                        <i class="ph ph-trash" style="font-size: 18px;"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="empty-state d-flex flex-column align-items-center justify-content-center">
                                <i class="ph ph-article text-muted mb-3" style="font-size: 48px; opacity: 0.5;"></i>
                                <h6 class="fw-bold" style="color: var(--text-main);">Belum Ada Artikel</h6>
                                <p class="text-muted mb-0">Klik tombol "Tambah Artikel" untuk membuat artikel pertama.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($articles->hasPages())
    <div class="card-footer bg-transparent border-top p-4 d-flex justify-content-end">
        {{ $articles->links() }}
    </div>
    @endif
</div>

<style>
    .custom-table td {
        border-bottom: 1px solid var(--border-color);
        background: transparent;
    }
    .custom-table tbody tr:last-child td {
        border-bottom: none;
    }
    .custom-table tbody tr:hover td {
        background: rgba(0,0,0,0.015);
    }
    [data-theme="dark"] .custom-table tbody tr:hover td {
        background: rgba(255,255,255,0.02);
    }
    .btn-icon {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        border: none;
    }
    .btn-icon:hover {
        transform: translateY(-2px);
    }
</style>
@endsection
