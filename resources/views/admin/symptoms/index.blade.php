@extends('layouts.admin')
@section('title', 'Kelola Gejala')

@section('content')
<div class="neo-card mb-4" style="padding: 24px; border-radius: 20px; border: none;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 style="font-weight: 800; color: var(--text-dark); margin: 0;">Data Gejala Pakar</h3>
            <p style="font-size: 14px; color: var(--text-muted); margin: 0; margin-top: 4px;">Kelola basis pengetahuan (gejala) dan nilai probabilitas pakar.</p>
        </div>
        <a href="{{ route('admin.symptoms.create') }}" class="btn btn-primary" style="border-radius: 10px; font-weight: 700; padding: 10px 20px;">
            <i class="ph-bold ph-plus"></i> Tambah Gejala
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="border-radius: 12px; font-weight: 600;">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead style="background: rgba(0,0,0,0.02);">
                <tr>
                    <th style="font-size: 12px; color: var(--text-muted); text-transform: uppercase;">Kode</th>
                    <th style="font-size: 12px; color: var(--text-muted); text-transform: uppercase;">Gejala</th>
                    <th style="font-size: 12px; color: var(--text-muted); text-transform: uppercase;">Kategori</th>
                    <th style="font-size: 12px; color: var(--text-muted); text-transform: uppercase;">CF Pakar</th>
                    <th style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($symptoms as $symptom)
                    <tr>
                        <td style="font-weight: 800; color: var(--primary);">{{ $symptom->code }}</td>
                        <td>
                            <div style="font-weight: 700; color: var(--text-dark);">{{ $symptom->name }}</div>
                            <div style="font-size: 12px; color: var(--text-muted);">{{ Str::limit($symptom->question, 50) }}</div>
                        </td>
                        <td>
                            <span class="badge" style="background: rgba(9, 132, 227, 0.1); color: #0984e3; padding: 6px 10px; border-radius: 6px;">
                                {{ $symptom->category->name ?? '-' }}
                            </span>
                        </td>
                        <td style="font-weight: 700; color: var(--text-dark);">
                            {{ $symptom->cf_expert }}
                        </td>
                        <td style="text-align: right;">
                            <a href="{{ route('admin.symptoms.edit', $symptom->id) }}" class="btn btn-sm" style="background: rgba(245, 158, 11, 0.1); color: var(--warning); border-radius: 8px;">
                                <i class="ph-fill ph-pencil-simple"></i>
                            </a>
                            <form action="{{ route('admin.symptoms.destroy', $symptom->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus gejala ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="background: rgba(239, 68, 68, 0.1); color: var(--danger); border-radius: 8px;">
                                    <i class="ph-fill ph-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4" style="color: var(--text-muted); font-weight: 600;">Belum ada data gejala.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Paging Navigation -->
    <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div style="font-size: 13px; color: var(--text-muted); font-weight: 600;">
            Menampilkan {{ $symptoms->firstItem() ?? 0 }} - {{ $symptoms->lastItem() ?? 0 }} dari {{ $symptoms->total() }} Gejala
        </div>
        <div class="neo-pagination">
            {{ $symptoms->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
