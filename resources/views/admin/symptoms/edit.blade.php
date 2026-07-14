@extends('layouts.admin')
@section('title', 'Edit Gejala')

@section('content')
<div class="neo-card" style="padding: 32px; border-radius: 20px; border: none; max-width: 800px;">
    <h3 style="font-weight: 800; color: var(--text-dark); margin-bottom: 24px;">Edit Data Gejala</h3>

    @if ($errors->any())
        <div class="alert alert-danger" style="border-radius: 12px;">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.symptoms.update', $symptom->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <label style="font-weight: 700; font-size: 13px; color: var(--text-muted); margin-bottom: 8px;">Kategori Gejala</label>
                <select name="category_id" class="form-control" style="border-radius: 10px; padding: 12px; background: #f8fbff; border: 1px solid rgba(0,0,0,0.05);" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ (old('category_id') ?? $symptom->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label style="font-weight: 700; font-size: 13px; color: var(--text-muted); margin-bottom: 8px;">Kode Gejala</label>
                <input type="text" name="code" class="form-control" style="border-radius: 10px; padding: 12px; background: #f8fbff; border: 1px solid rgba(0,0,0,0.05);" value="{{ old('code', $symptom->code) }}" required>
            </div>
        </div>

        <div class="mb-4">
            <label style="font-weight: 700; font-size: 13px; color: var(--text-muted); margin-bottom: 8px;">Nama Gejala</label>
            <input type="text" name="name" class="form-control" style="border-radius: 10px; padding: 12px; background: #f8fbff; border: 1px solid rgba(0,0,0,0.05);" value="{{ old('name', $symptom->name) }}" required>
        </div>

        <div class="mb-4">
            <label style="font-weight: 700; font-size: 13px; color: var(--text-muted); margin-bottom: 8px;">Pertanyaan Kuesioner</label>
            <textarea name="question" rows="3" class="form-control" style="border-radius: 10px; padding: 12px; background: #f8fbff; border: 1px solid rgba(0,0,0,0.05);" required>{{ old('question', $symptom->question) }}</textarea>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <label style="font-weight: 700; font-size: 13px; color: var(--text-muted); margin-bottom: 8px;">Measure of Belief (MB)</label>
                <input type="number" step="0.01" min="0" max="1" name="mb" class="form-control" style="border-radius: 10px; padding: 12px; background: #f8fbff; border: 1px solid rgba(0,0,0,0.05);" value="{{ old('mb', $symptom->mb) }}" required>
            </div>
            <div class="col-md-4">
                <label style="font-weight: 700; font-size: 13px; color: var(--text-muted); margin-bottom: 8px;">Measure of Disbelief (MD)</label>
                <input type="number" step="0.01" min="0" max="1" name="md" class="form-control" style="border-radius: 10px; padding: 12px; background: #f8fbff; border: 1px solid rgba(0,0,0,0.05);" value="{{ old('md', $symptom->md) }}" required>
            </div>
            <div class="col-md-4">
                <label style="font-weight: 700; font-size: 13px; color: var(--text-muted); margin-bottom: 8px;">CF Pakar</label>
                <input type="number" step="0.01" min="0" max="1" name="cf_expert" class="form-control" style="border-radius: 10px; padding: 12px; background: #f8fbff; border: 1px solid rgba(0,0,0,0.05);" value="{{ old('cf_expert', $symptom->cf_expert) }}" required>
            </div>
        </div>

        <div class="d-flex gap-3">
            <button type="submit" class="btn btn-primary" style="border-radius: 10px; font-weight: 700; padding: 12px 24px;">Update Data</button>
            <a href="{{ route('admin.symptoms.index') }}" class="btn btn-secondary" style="border-radius: 10px; font-weight: 700; padding: 12px 24px; text-decoration: none;">Batal</a>
        </div>
    </form>
</div>
@endsection
