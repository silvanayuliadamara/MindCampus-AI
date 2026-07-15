@extends('layouts.user')

@section('title', 'Pengaturan Profil')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 style="font-weight: 800; color: var(--text-dark, #2b3674); margin: 0; font-size: 24px; letter-spacing: -0.5px;">Profil Saya</h3>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #10b981;">
        <i class="ph-fill ph-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card neo-card border-0 mb-4">
        <div class="card-body p-4 p-md-5">
            <div class="row g-5">
                <!-- Left: Profile Info -->
                <div class="col-lg-4 text-center border-end-lg">
                    <div class="avatar mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 120px; height: 120px; font-size: 3.5rem; background: linear-gradient(135deg, #818cf8, #6366f1); color: white; border-radius: 24px;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h4 class="fw-bold mb-1" style="color: var(--text-dark);">{{ $user->name }}</h4>
                    <span class="badge mb-4" style="background: rgba(99, 102, 241, 0.1); color: #6366f1; font-weight: 600; padding: 6px 12px; border-radius: 8px;">Mahasiswa</span>
                    
                    <div class="text-start p-4" style="background: rgba(0,0,0,0.03); border-radius: 16px;">
                        <div class="mb-3">
                            <small style="color: var(--text-muted); display: block; font-weight: 600; margin-bottom: 4px;">Email</small>
                            <span style="color: var(--text-dark); font-weight: 500;">{{ $user->email }}</span>
                        </div>
                        <div class="mb-3">
                            <small style="color: var(--text-muted); display: block; font-weight: 600; margin-bottom: 4px;">NIM</small>
                            <span style="color: var(--text-dark); font-weight: 500;">{{ $user->profile->nim ?? '-' }}</span>
                        </div>
                        <div>
                            <small style="color: var(--text-muted); display: block; font-weight: 600; margin-bottom: 4px;">Terdaftar Sejak</small>
                            <span style="color: var(--text-dark); font-weight: 500;">{{ $user->created_at->translatedFormat('d F Y') }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Right: Form -->
                <div class="col-lg-8">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <ul class="nav nav-pills mb-4" id="profile-tabs" role="tablist" style="background: rgba(0,0,0,0.03); padding: 6px; border-radius: 12px; display: inline-flex;">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fw-semibold" id="data-tab" data-bs-toggle="pill" data-bs-target="#data-pane" type="button" role="tab" style="border-radius: 8px; color: var(--text-dark); padding: 10px 20px;">
                                    <i class="ph ph-user me-2"></i> Data Diri
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-semibold" id="security-tab" data-bs-toggle="pill" data-bs-target="#security-pane" type="button" role="tab" style="border-radius: 8px; color: var(--text-dark); padding: 10px 20px;">
                                    <i class="ph ph-lock-key me-2"></i> Keamanan
                                </button>
                            </li>
                        </ul>
                        
                        <div class="tab-content" id="profile-tabsContent">
                            <!-- DATA TAB -->
                            <div class="tab-pane fade show active" id="data-pane" role="tabpanel" tabindex="0">
                                <div class="row mb-3 g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold" style="color: var(--text-dark);">Nama Lengkap</label>
                                <input type="text" class="form-control custom-input @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold" style="color: var(--text-dark);">Alamat Email</label>
                                <input type="email" class="form-control custom-input @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 g-3 mt-1">
                            <div class="col-md-6">
                                <label for="nim" class="form-label fw-semibold" style="color: var(--text-dark);">NIM</label>
                                <input type="text" class="form-control custom-input @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim', $user->profile->nim ?? '') }}" placeholder="Misal: 1905123456">
                                @error('nim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="major" class="form-label fw-semibold" style="color: var(--text-dark);">Program Studi</label>
                                <input type="text" class="form-control custom-input @error('major') is-invalid @enderror" id="major" name="major" value="{{ old('major', $user->profile->major ?? '') }}" placeholder="Misal: Teknik Informatika">
                                @error('major')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="semester" class="form-label fw-semibold" style="color: var(--text-dark);">Semester</label>
                                <input type="number" min="1" max="14" class="form-control custom-input @error('semester') is-invalid @enderror" id="semester" name="semester" value="{{ old('semester', $user->profile->semester ?? '') }}" placeholder="Misal: 4">
                                @error('semester')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="gender" class="form-label fw-semibold" style="color: var(--text-dark);">Jenis Kelamin</label>
                                <select class="form-select custom-input @error('gender') is-invalid @enderror" id="gender" name="gender">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="L" {{ old('gender', $user->profile->gender ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('gender', $user->profile->gender ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    <option value="R" {{ old('gender', $user->profile->gender ?? '') == 'R' ? 'selected' : '' }}>Rahasia / Tidak Ingin Menyebutkan</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                            </div> <!-- End Data Tab -->
                            
                            <!-- SECURITY TAB -->
                            <div class="tab-pane fade" id="security-pane" role="tabpanel" tabindex="0">
                        <div class="alert mb-4" style="background: rgba(0,0,0,0.03); border: 1px dashed var(--border-color); border-radius: 12px; color: var(--text-muted); padding: 12px 16px;">
                            <i class="ph-fill ph-info me-2 text-muted"></i> Biarkan kosong jika Anda tidak ingin mengubah password.
                        </div>

                        <div class="mb-4">
                            <label for="current_password" class="form-label fw-semibold" style="color: var(--text-dark);">Password Saat Ini</label>
                            <input type="password" class="form-control custom-input @error('current_password') is-invalid @enderror" id="current_password" name="current_password">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-4 g-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold" style="color: var(--text-dark);">Password Baru</label>
                                <input type="password" class="form-control custom-input @error('password') is-invalid @enderror" id="password" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-semibold" style="color: var(--text-dark);">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control custom-input" id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>
                        </div> <!-- End Security Tab -->
                        </div> <!-- End Tab Content -->

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn-neo px-4 py-3">
                                <i class="ph ph-floppy-disk me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <style>
                @media (min-width: 992px) {
                    .border-end-lg {
                        border-right: 1px solid var(--border-glass) !important;
                    }
                }
                .custom-input {
                    border-radius: 10px;
                    padding: 12px 16px;
                    border: var(--border-glass);
                    background: rgba(0, 0, 0, 0.02);
                    color: var(--text-dark);
                    transition: all 0.3s ease;
                }
                .custom-input:focus {
                    border-color: var(--accent);
                    box-shadow: 0 0 0 4px var(--accent-light);
                    background: transparent;
                    color: var(--text-dark);
                }
                [data-theme="dark"] .custom-input {
                    background: rgba(255, 255, 255, 0.03);
                }
                [data-theme="dark"] .custom-input:focus {
                    background: rgba(255, 255, 255, 0.05);
                }
                .nav-pills .nav-link.active {
                    background-color: var(--accent) !important;
                    color: #fff !important;
                    box-shadow: 0 4px 12px var(--accent-light);
                }
                [data-theme="dark"] .nav-pills {
                    background: rgba(255, 255, 255, 0.03) !important;
                }
            </style>
        </div>
    </div>
</div>
@endsection
