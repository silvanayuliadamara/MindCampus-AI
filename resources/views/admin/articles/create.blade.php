@extends('layouts.admin')

@section('title', 'Tambah Artikel Baru')
@section('page_title', 'Tambah Artikel')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.articles.index') }}" class="text-decoration-none d-inline-flex align-items-center gap-2" style="color: var(--text-muted); font-weight: 600;">
        <i class="ph ph-arrow-left"></i> Kembali ke Daftar Artikel
    </a>
</div>

<div class="card neo-card border-0">
    <div class="card-body p-4 p-md-5">
        <form action="{{ route('admin.articles.store') }}" method="POST">
            @csrf
            
            <div class="row g-4">
                <div class="col-md-12">
                    <label for="title" class="form-label fw-semibold" style="color: var(--text-main);">Judul Artikel</label>
                    <input type="text" class="form-control custom-input @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required placeholder="Masukkan judul artikel yang menarik...">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="category" class="form-label fw-semibold" style="color: var(--text-main);">Kategori</label>
                    <input type="text" class="form-control custom-input @error('category') is-invalid @enderror" id="category" name="category" value="{{ old('category') }}" required placeholder="Contoh: Kesehatan Mental, Motivasi">
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="read_time" class="form-label fw-semibold" style="color: var(--text-main);">Waktu Baca (Menit)</label>
                    <div class="input-group">
                        <input type="number" min="1" class="form-control custom-input @error('read_time') is-invalid @enderror" id="read_time" name="read_time" value="{{ old('read_time') }}" required placeholder="5">
                        <span class="input-group-text" style="background: rgba(0,0,0,0.03); border: 1px solid var(--border-color); color: var(--text-muted); border-radius: 0 10px 10px 0;">menit</span>
                    </div>
                    @error('read_time')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label for="image_url" class="form-label fw-semibold" style="color: var(--text-main);">URL Gambar Sampul (Cover Image)</label>
                    <input type="url" class="form-control custom-input @error('image_url') is-invalid @enderror" id="image_url" name="image_url" value="{{ old('image_url') }}" required placeholder="https://images.unsplash.com/photo-...">
                    <small class="text-muted mt-1 d-block"><i class="ph ph-info"></i> Masukkan link URL gambar yang valid (berawalan http/https).</small>
                    @error('image_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label for="summary" class="form-label fw-semibold" style="color: var(--text-main);">Ringkasan (Summary)</label>
                    <textarea class="form-control custom-input @error('summary') is-invalid @enderror" id="summary" name="summary" rows="3" required placeholder="Tuliskan ringkasan singkat dari artikel ini (max 250 karakter)...">{{ old('summary') }}</textarea>
                    @error('summary')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label for="content" class="form-label fw-semibold" style="color: var(--text-main);">Isi Artikel</label>
                    <textarea class="form-control custom-input @error('content') is-invalid @enderror" id="content" name="content" rows="12" required placeholder="Tuliskan isi lengkap artikel di sini...">{{ old('content') }}</textarea>
                    <small class="text-muted mt-1 d-block"><i class="ph ph-info"></i> Mendukung format paragraf standar.</small>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <hr class="my-4" style="border-color: var(--border-color);">

            <div class="d-flex justify-content-end gap-3">
                <a href="{{ route('admin.articles.index') }}" class="btn btn-light px-4 py-2 fw-semibold" style="border-radius: 10px;">Batal</a>
                <button type="submit" class="btn btn-primary px-4 py-2 d-flex align-items-center gap-2 fw-bold" style="border-radius: 10px;">
                    <i class="ph ph-paper-plane-tilt"></i> Terbitkan Artikel
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .custom-input {
        border-radius: 10px;
        padding: 12px 16px;
        border: 1px solid var(--border-color);
        background: var(--bg-body);
        color: var(--text-main);
        transition: all 0.3s ease;
    }
    .custom-input:focus {
        border-color: #0097a7;
        box-shadow: 0 0 0 4px rgba(0, 151, 167, 0.1);
        background: transparent;
    }
    
    .input-group > .custom-input {
        border-radius: 10px 0 0 10px;
    }
</style>
@endsection
