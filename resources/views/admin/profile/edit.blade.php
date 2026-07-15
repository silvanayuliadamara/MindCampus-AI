@extends('layouts.admin')

@section('title', 'Pengaturan Profil')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 style="font-weight: 800; color: var(--text-main, #2b3674); margin: 0; font-size: 24px; letter-spacing: -0.5px;">Profil Administrator</h3>
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
                    <div class="avatar mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 120px; height: 120px; font-size: 3.5rem; background: #0097a7; color: white; border-radius: 24px;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h4 class="fw-bold mb-1" style="color: var(--text-main);">{{ $user->name }}</h4>
                    <span class="badge mb-4" style="background: rgba(0, 151, 167, 0.1); color: #0097a7; font-weight: 600; padding: 6px 12px; border-radius: 8px;">Administrator</span>
                    
                    <div class="text-start p-4" style="background: var(--bg-body); border-radius: 16px;">
                        <div class="mb-3">
                            <small style="color: var(--text-muted); display: block; font-weight: 600; margin-bottom: 4px;">Email</small>
                            <span style="color: var(--text-main); font-weight: 500;">{{ $user->email }}</span>
                        </div>
                        <div>
                            <small style="color: var(--text-muted); display: block; font-weight: 600; margin-bottom: 4px;">Terdaftar Sejak</small>
                            <span style="color: var(--text-main); font-weight: 500;">{{ $user->created_at->translatedFormat('d F Y') }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Right: Form -->
                <div class="col-lg-8">
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <h5 class="fw-bold mb-4" style="color: var(--text-main);"><i class="ph ph-user me-2" style="color: var(--primary);"></i> Informasi Dasar</h5>
                        <div class="row mb-3 g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold" style="color: var(--text-main);">Nama Lengkap</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required style="background: var(--bg-body); border-color: var(--border-color); color: var(--text-main); border-radius: 10px; padding: 12px;">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold" style="color: var(--text-main);">Alamat Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required style="background: var(--bg-body); border-color: var(--border-color); color: var(--text-main); border-radius: 10px; padding: 12px;">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-5" style="border-color: var(--border-color);">

                        <h5 class="fw-bold mb-4" style="color: var(--text-main);"><i class="ph ph-lock-key me-2" style="color: var(--primary);"></i> Ubah Password</h5>
                        <div class="alert mb-4" style="background: var(--bg-body); border: 1px dashed var(--border-color); border-radius: 12px; color: var(--text-muted); padding: 12px 16px;">
                            <i class="ph-fill ph-info me-2 text-muted"></i> Biarkan kosong jika Anda tidak ingin mengubah password.
                        </div>

                        <div class="mb-4">
                            <label for="current_password" class="form-label fw-semibold" style="color: var(--text-main);">Password Saat Ini</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" style="background: var(--bg-body); border-color: var(--border-color); color: var(--text-main); border-radius: 10px; padding: 12px;">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-4 g-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold" style="color: var(--text-main);">Password Baru</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" style="background: var(--bg-body); border-color: var(--border-color); color: var(--text-main); border-radius: 10px; padding: 12px;">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-semibold" style="color: var(--text-main);">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" style="background: var(--bg-body); border-color: var(--border-color); color: var(--text-main); border-radius: 10px; padding: 12px;">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary px-4 py-3" style="border-radius: 12px; font-weight: 700; box-shadow: 0 4px 15px rgba(0, 151, 167, 0.3);">
                                <i class="ph ph-floppy-disk me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <style>
                @media (min-width: 992px) {
                    .border-end-lg {
                        border-right: 1px solid var(--border-color) !important;
                    }
                }
            </style>
        </div>
    </div>
</div>
@endsection
