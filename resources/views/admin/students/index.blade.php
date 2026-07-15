@extends('layouts.admin')
@section('title', 'Data Mahasiswa')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 style="font-weight: 800; color: var(--text-main, #2b3674); margin: 0; font-size: 24px; letter-spacing: -0.5px;">Data Mahasiswa</h3>
</div>

<div class="neo-card mb-4" style="padding: 24px; border-radius: 20px; border: none;">
    @if(session('success'))
        <div class="alert alert-success" style="border-radius: 12px; font-weight: 600;">
            {{ session('success') }}
        </div>
    @endif


    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead style="background: rgba(0,0,0,0.02);">
                <tr>
                    <th style="font-size: 12px; color: var(--text-muted); text-transform: uppercase;">Nama Lengkap</th>
                    <th style="font-size: 12px; color: var(--text-muted); text-transform: uppercase;">Email</th>
                    <th style="font-size: 12px; color: var(--text-muted); text-transform: uppercase;">Program Studi</th>
                    <th style="font-size: 12px; color: var(--text-muted); text-transform: uppercase;">Tes Dibagikan</th>
                    <th style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    <tr>
                        <td style="font-weight: 700; color: var(--text-dark);">
                            <div class="d-flex align-items-center gap-3">
                                <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(9, 132, 227, 0.1); color: #0984e3; display: flex; align-items: center; justify-content: center; font-weight: 800;">
                                    {{ strtoupper(substr($student->name, 0, 1)) }}
                                </div>
                                {{ $student->name }}
                            </div>
                        </td>
                        <td style="color: var(--text-muted); font-size: 14px;">{{ $student->email }}</td>
                        <td>
                            @if($student->profile && $student->profile->major)
                                <span class="badge" style="background: rgba(0, 184, 148, 0.1); color: #00b894; padding: 6px 10px; border-radius: 6px;">
                                    {{ $student->profile->major }}
                                </span>
                            @else
                                <span class="badge bg-light text-dark" style="padding: 6px 10px; border-radius: 6px;">Belum Diisi</span>
                            @endif
                        </td>
                        <td style="font-weight: 800; color: var(--primary);">
                            @if($student->diagnoses_count > 0)
                                {{ $student->diagnoses_count }} Kali
                            @else
                                <span style="color: var(--text-muted); font-weight: 600;">—</span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <a href="{{ route('admin.students.show', $student->id) }}" class="btn btn-sm" style="background: rgba(9, 132, 227, 0.1); color: #0984e3; border-radius: 8px;">
                                <i class="ph-fill ph-eye"></i> Detail
                            </a>
                            <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data mahasiswa ini secara permanen?');">
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
                        <td colspan="5" class="text-center py-4" style="color: var(--text-muted); font-weight: 600;">Belum ada data mahasiswa terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paging Navigation -->
    <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div style="font-size: 13px; color: var(--text-muted); font-weight: 600;">
            Menampilkan {{ $students->firstItem() ?? 0 }} - {{ $students->lastItem() ?? 0 }} dari {{ $students->total() }} Mahasiswa
        </div>
        <div class="neo-pagination">
            {{ $students->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
