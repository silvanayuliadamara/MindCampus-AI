@extends('layouts.admin')
@section('title', 'Tambah Gejala')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.symptoms.index') }}" class="btn btn-sm btn-light" style="border-radius: 10px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 10px rgba(0,0,0,0.05); background: white; border: 1px solid var(--border-color, #e9edf7);">
        <i class="ph-bold ph-arrow-left" style="font-size: 18px;"></i>
    </a>
    <h3 style="font-weight: 800; color: var(--text-main, #2b3674); margin: 0; font-size: 24px; letter-spacing: -0.5px;">Tambah Gejala Baru</h3>
</div>

<div class="neo-card" style="padding: 32px; border-radius: 20px; border: none;">

    @if ($errors->any())
        <div class="alert alert-danger" style="border-radius: 12px;">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.symptoms.store') }}" method="POST">
        @csrf
        
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <label style="font-weight: 700; font-size: 13px; color: var(--text-muted); margin-bottom: 8px;">Kategori Gejala</label>
                <select name="category_id" class="form-control" style="border-radius: 10px; padding: 12px; background: #f8fbff; border: 1px solid rgba(0,0,0,0.05);" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label style="font-weight: 700; font-size: 13px; color: var(--text-muted); margin-bottom: 8px;">Kode Gejala (Contoh: G01)</label>
                <input type="text" name="code" class="form-control" style="border-radius: 10px; padding: 12px; background: #f8fbff; border: 1px solid rgba(0,0,0,0.05);" value="{{ old('code') }}" required>
            </div>
        </div>

        <div class="mb-4">
            <label style="font-weight: 700; font-size: 13px; color: var(--text-muted); margin-bottom: 8px;">Nama Gejala</label>
            <input type="text" name="name" class="form-control" style="border-radius: 10px; padding: 12px; background: #f8fbff; border: 1px solid rgba(0,0,0,0.05);" value="{{ old('name') }}" required>
        </div>

        <div class="mb-4">
            <label style="font-weight: 700; font-size: 13px; color: var(--text-muted); margin-bottom: 8px;">Pertanyaan Kuesioner</label>
            <textarea name="question" rows="3" class="form-control" style="border-radius: 10px; padding: 12px; background: #f8fbff; border: 1px solid rgba(0,0,0,0.05);" required>{{ old('question') }}</textarea>
            <small class="text-muted">Contoh: Apakah Anda merasa lelah sepanjang waktu?</small>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <label style="font-weight: 700; font-size: 13px; color: var(--text-muted); margin-bottom: 8px;">Measure of Belief (MB)</label>
                <input type="number" step="0.01" min="0" max="1" name="mb" class="form-control" style="border-radius: 10px; padding: 12px; background: #f8fbff; border: 1px solid rgba(0,0,0,0.05);" value="{{ old('mb') }}" required>
            </div>
            <div class="col-md-4">
                <label style="font-weight: 700; font-size: 13px; color: var(--text-muted); margin-bottom: 8px;">Measure of Disbelief (MD)</label>
                <input type="number" step="0.01" min="0" max="1" name="md" class="form-control" style="border-radius: 10px; padding: 12px; background: #f8fbff; border: 1px solid rgba(0,0,0,0.05);" value="{{ old('md') }}" required>
            </div>
            <div class="col-md-4">
                <label style="font-weight: 700; font-size: 13px; color: var(--text-muted); margin-bottom: 8px;">CF Pakar (Otomatis)</label>
                <input type="number" step="0.01" min="0" max="1" name="cf_expert" class="form-control" style="border-radius: 10px; padding: 12px; background: #f8fbff; border: 1px solid rgba(0,0,0,0.05);" value="{{ old('cf_expert') }}" required>
            </div>
        </div>

        <div class="d-flex gap-3">
            <button type="submit" class="btn btn-primary" style="border-radius: 10px; font-weight: 700; padding: 12px 24px;">Simpan Data</button>
            <a href="{{ route('admin.symptoms.index') }}" class="btn btn-secondary" style="border-radius: 10px; font-weight: 700; padding: 12px 24px; text-decoration: none;">Batal</a>
        </div>
    </form>
</div>
@endsection
