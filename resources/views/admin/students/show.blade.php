@extends('layouts.admin')
@section('title', 'Detail Mahasiswa')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.students.index') }}" style="display: inline-flex; align-items: center; gap: 8px; color: var(--text-muted); text-decoration: none; font-weight: 600; font-size: 14px; transition: all 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'">
        <i class="ph-bold ph-arrow-left" style="font-size: 18px;"></i>
        Kembali ke Daftar Mahasiswa
    </a>
</div>
<div class="neo-card" style="padding: 32px; border-radius: 20px; border: none;">
    <div class="row g-4">
    <!-- Profil Mahasiswa -->
    <div class="col-lg-4" style="border-right: 1px dashed rgba(0,0,0,0.1);">
        <div style="text-align: center;">
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
                <div class="mb-3">
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Jenis Kelamin</div>
                    <div style="font-weight: 600; color: var(--text-dark);">
                        {{ ($student->profile->gender ?? '') === 'L' ? 'Laki-laki' : (($student->profile->gender ?? '') === 'P' ? 'Perempuan' : (($student->profile->gender ?? '') === 'R' ? 'Rahasia' : 'Belum diisi')) }}
                    </div>
                </div>
                <div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Tanggal Bergabung</div>
                    <div style="font-weight: 600; color: var(--text-dark);">{{ $student->created_at->format('d M Y') }}</div>
                </div>
            </div>

        </div>
    </div>

    <!-- Riwayat Tes -->
    <div class="col-lg-8">
        <div style="padding-left: 10px;">
            <div class="mb-4">
                <h4 style="font-weight: 800; color: var(--text-dark); margin: 0;">Riwayat Diagnosis Stres</h4>
                <p style="font-size: 14px; color: var(--text-muted); margin: 0; margin-top: 4px;">Hanya menampilkan hasil diagnosis yang diizinkan dibagikan oleh mahasiswa.</p>
            </div>

            <!-- Privacy Notice -->
            @if($privateCount > 0)
            <div style="padding: 16px 20px; border-radius: 12px; background: rgba(245, 158, 11, 0.06); border: 1px solid rgba(245, 158, 11, 0.15); margin-bottom: 20px; display: flex; align-items: flex-start; gap: 12px;">
                <i class="ph-fill ph-shield-check" style="font-size: 22px; color: #f59e0b; flex-shrink: 0; margin-top: 2px;"></i>
                <div>
                    <div style="font-size: 13px; font-weight: 700; color: #d97706; margin-bottom: 4px;">Perlindungan Privasi Aktif</div>
                    <div style="font-size: 12px; color: var(--text-muted); line-height: 1.5;">
                        Mahasiswa ini memiliki <strong>{{ $privateCount }} diagnosis privat</strong> yang tidak dibagikan kepada pihak kampus.
                        Hanya <strong>{{ $sharedCount }} dari {{ $totalDiagnoses }}</strong> diagnosis yang diizinkan untuk ditampilkan di sini.
                    </div>
                </div>
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead style="background: rgba(0,0,0,0.02);">
                        <tr>
                            <th style="font-size: 12px; color: var(--text-muted); text-transform: uppercase;">Tanggal</th>
                            <th style="font-size: 12px; color: var(--text-muted); text-transform: uppercase;">Tingkat Stres</th>
                            <th style="font-size: 12px; color: var(--text-muted); text-transform: uppercase;">Akurasi (CF)</th>

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
                                <td style="font-weight: 800; color: var(--primary);">{{ round($diagnosis->cf_result * 100, 1) }}%</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <div style="padding: 20px;">
                                        <i class="ph-fill ph-lock-key" style="font-size: 40px; color: var(--text-muted); opacity: 0.4; display: block; margin-bottom: 12px;"></i>
                                        <div style="color: var(--text-muted); font-weight: 700; font-size: 14px; margin-bottom: 4px;">Tidak Ada Data yang Dibagikan</div>
                                        <div style="color: var(--text-muted); font-weight: 500; font-size: 12px;">
                                            @if($totalDiagnoses > 0)
                                                Mahasiswa ini telah melakukan {{ $totalDiagnoses }} kali diagnosis, namun memilih untuk menjaga kerahasiaan seluruh hasilnya.
                                            @else
                                                Mahasiswa ini belum pernah melakukan tes diagnosis.
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
