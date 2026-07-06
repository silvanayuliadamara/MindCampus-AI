@extends('layouts.admin')
@section('title', 'Detail Mahasiswa')

@section('content')
<div class="row g-4">
    <!-- Profil Mahasiswa -->
    <div class="col-lg-4">
        <div class="neo-card" style="padding: 32px; border-radius: 20px; border: none; text-align: center;">
            <div style="width: 100px; height: 100px; border-radius: 25px; background: rgba(9, 132, 227, 0.1); color: #0984e3; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 40px; margin: 0 auto 20px;">
                {{ strtoupper(substr($student->name, 0, 1)) }}
            </div>
            
            <h4 style="font-weight: 800; color: var(--text-dark); margin-bottom: 5px;">{{ $student->name }}</h4>
            <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 24px;">{{ $student->email }}</p>

            <div class="text-start" style="background: #f8fbff; padding: 20px; border-radius: 16px;">
                <div class="mb-3">
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Nomor Induk / NIM</div>
                    <div style="font-weight: 600; color: var(--text-dark);">{{ $student->profile->nim ?? 'Belum diisi' }}</div>
                </div>
                <div class="mb-3">
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Program Studi</div>
                    <div style="font-weight: 600; color: var(--text-dark);">{{ $student->profile->major ?? 'Belum diisi' }}</div>
                </div>
                <div class="mb-3">
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Semester</div>
                    <div style="font-weight: 600; color: var(--text-dark);">
                        Semester {{ $student->profile->semester ?? '-' }}
                    </div>
                </div>
                <div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Tanggal Bergabung</div>
                    <div style="font-weight: 600; color: var(--text-dark);">{{ $student->created_at->format('d M Y') }}</div>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('admin.students.index') }}" class="btn btn-secondary w-100" style="border-radius: 12px; font-weight: 700; padding: 12px;">Kembali</a>
            </div>
        </div>
    </div>

    <!-- Riwayat Tes -->
    <div class="col-lg-8">
        <div class="neo-card" style="padding: 32px; border-radius: 20px; border: none; height: 100%;">
            <div class="mb-4">
                <h4 style="font-weight: 800; color: var(--text-dark); margin: 0;">Riwayat Diagnosis Stres</h4>
                <p style="font-size: 14px; color: var(--text-muted); margin: 0; margin-top: 4px;">Hasil deteksi tingkat burnout mahasiswa ini.</p>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead style="background: rgba(0,0,0,0.02);">
                        <tr>
                            <th style="font-size: 12px; color: var(--text-muted); text-transform: uppercase;">Tanggal</th>
                            <th style="font-size: 12px; color: var(--text-muted); text-transform: uppercase;">Tingkat Stres</th>
                            <th style="font-size: 12px; color: var(--text-muted); text-transform: uppercase;">Akurasi (CF)</th>
                            <th style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; text-align: right;">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($diagnoses as $diagnosis)
                            <tr>
                                <td style="font-weight: 600; color: var(--text-dark);">{{ $diagnosis->created_at->format('d M Y, H:i') }}</td>
                                <td>
                                    <span class="badge" style="background: rgba(9, 132, 227, 0.1); color: #0984e3; padding: 6px 10px; border-radius: 6px; font-size: 13px;">
                                        {{ $diagnosis->burnoutLevel->name ?? 'Tidak diketahui' }}
                                    </span>
                                </td>
                                <td style="font-weight: 800; color: var(--primary);">{{ $diagnosis->cf_percentage }}%</td>
                                <td style="text-align: right;">
                                    <a href="{{ route('diagnosis.result', $diagnosis->id) }}" target="_blank" class="btn btn-sm" style="background: rgba(0, 184, 148, 0.1); color: #00b894; border-radius: 8px;">
                                        <i class="ph-fill ph-file-text"></i> Lihat Hasil
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4" style="color: var(--text-muted); font-weight: 600;">Mahasiswa ini belum pernah melakukan tes.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
