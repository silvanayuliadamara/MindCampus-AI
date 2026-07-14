<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun | Serenity AI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

        body {
            background: #f0fdf4;
            background-image:
                radial-gradient(circle at 10% 30%, rgba(13, 148, 136, 0.08), transparent 45%),
                radial-gradient(circle at 90% 70%, rgba(16, 185, 129, 0.06), transparent 45%);
            color: #0f172a;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 40px 20px;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            padding: 40px;
            border-radius: 20px;
            width: 100%;
            max-width: 650px;
            border: 1px solid rgba(13, 148, 136, 0.12);
            box-shadow: 0 8px 32px rgba(13, 148, 136, 0.08), 0 1px 4px rgba(0,0,0,0.04);
        }

        .brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 8px;
            font-size: 22px;
            font-weight: 700;
            background: linear-gradient(to right, #0d9488, #2dd4bf);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        h2 {
            text-align: center;
            margin-bottom: 8px;
            font-size: 20px;
            font-weight: 600;
            color: #0f172a;
        }

        .subtitle {
            text-align: center;
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 32px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 576px) {
            .form-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }
        }

        .form-group { margin-bottom: 16px; }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 500;
            color: #374151;
        }

        input, select {
            width: 100%;
            padding: 12px 16px;
            border-radius: 10px;
            border: 1.5px solid rgba(13, 148, 136, 0.2);
            background: #ffffff;
            color: #0f172a;
            font-size: 14px;
            box-sizing: border-box;
            transition: all 0.2s ease;
            outline: none;
        }

        input:focus, select:focus {
            border-color: #0d9488;
            box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.12);
        }

        button {
            width: 100%;
            padding: 13px;
            background: #0d9488;
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            margin-top: 16px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(13, 148, 136, 0.25);
        }

        button:hover {
            background: #0b7a6f;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(13, 148, 136, 0.3);
        }

        .error {
            color: #ef4444;
            font-size: 12px;
            margin-top: 6px;
            display: block;
        }
    </style>
</head>
<body>
    <div class="register-card">
        <div class="brand">🧠 Serenity AI</div>
        <h2>Registrasi Akun Baru</h2>
        <p class="subtitle">Silakan isi formulir di bawah ini untuk memulai diagnosis Anda</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-grid">
                <!-- Nama Lengkap -->
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Dimas Aditya" required autofocus>
                    @error('name') <span class="error">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="dimas@email.com" required>
                    @error('email') <span class="error">{{ $message }}</span> @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <div style="position: relative;">
                        <input type="password" id="password" name="password" placeholder="Min. 8 Karakter" required style="padding-right: 48px;" autocomplete="new-password">
                        <button type="button" id="toggle-password" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #6b7280; padding: 4px; display: flex; align-items: center; justify-content: center; width: auto; box-shadow: none; margin: 0; outline: none;">
                            <i class="ph ph-eye-slash" id="eye-icon-pass" style="font-size: 20px;"></i>
                        </button>
                    </div>
                    @error('password') <span class="error">{{ $message }}</span> @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <div style="position: relative;">
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi Password" required style="padding-right: 48px;" autocomplete="new-password">
                        <button type="button" id="toggle-password-confirm" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #6b7280; padding: 4px; display: flex; align-items: center; justify-content: center; width: auto; box-shadow: none; margin: 0; outline: none;">
                            <i class="ph ph-eye-slash" id="eye-icon-confirm" style="font-size: 20px;"></i>
                        </button>
                    </div>
                </div>

                <!-- Universitas -->
                <div class="form-group">
                    <label for="university">Universitas</label>
                    <input type="text" id="university" name="university" value="{{ old('university') }}" placeholder="Universitas Indonesia" required>
                    @error('university') <span class="error">{{ $message }}</span> @enderror
                </div>

                <!-- Jurusan -->
                <div class="form-group">
                    <label for="major">Jurusan</label>
                    <input type="text" id="major" name="major" value="{{ old('major') }}" placeholder="Teknik Informatika" required>
                    @error('major') <span class="error">{{ $message }}</span> @enderror
                </div>

                <!-- Semester -->
                <div class="form-group">
                    <label for="semester">Semester</label>
                    <input type="number" id="semester" name="semester" min="1" max="14" value="{{ old('semester', 8) }}" required>
                    @error('semester') <span class="error">{{ $message }}</span> @enderror
                </div>

                <!-- Jenis Kelamin -->
                <div class="form-group">
                    <label for="gender">Jenis Kelamin</label>
                    <select id="gender" name="gender" required>
                        <option value="P" {{ old('gender') === 'P' ? 'selected' : '' }}>Perempuan</option>
                        <option value="L" {{ old('gender') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="R" {{ old('gender') === 'R' ? 'selected' : '' }}>Rahasia</option>
                    </select>
                    @error('gender') <span class="error">{{ $message }}</span> @enderror
                </div>

                <!-- Captcha -->
                <div class="form-group" style="grid-column: span 2;">
                    <label for="captcha">Verifikasi Keamanan (Captcha)</label>
                    @if(config('app.debug'))
                        <span id="debug-captcha" style="display: none;">{{ session('captcha_code') }}</span>
                    @endif
                    <div style="display: flex; gap: 12px; align-items: center;">
                        <div id="captcha-container" style="display: flex; align-items: center; border-radius: 10px; overflow: hidden; background: #fff; border: 1.5px solid rgba(13, 148, 136, 0.2);">
                            <img src="{{ route('captcha') }}" id="captcha-img" alt="Captcha" style="height: 44px; display: block;">
                        </div>
                        <button type="button" id="btn-refresh" style="width: 44px; height: 44px; margin: 0; padding: 0; background: #f1f5f9; color: #475569; display: flex; align-items: center; justify-content: center; border-radius: 10px; border: 1.5px solid rgba(13, 148, 136, 0.2); cursor: pointer; box-shadow: none; outline: none; transition: all 0.2s ease;">
                            <i class="ph ph-arrow-clockwise" id="refresh-icon" style="font-size: 20px;"></i>
                        </button>
                        <input type="text" id="captcha" name="captcha" placeholder="Masukkan Kode Captcha" required style="flex: 1;" autocomplete="off">
                    </div>
                    @error('captcha') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>

            <button type="submit">Daftar Akun & Masuk</button>

            <div style="text-align: center; margin-top: 24px; font-size: 13px; color: #4b5563;">
                Sudah punya akun? <a href="{{ route('login') }}" style="color: #0d9488; text-decoration: none; font-weight: 600;">Masuk Sekarang</a>
            </div>
        </form>
    </div>

    <script>
        // Toggle Password
        document.getElementById('toggle-password').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon-pass');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.className = 'ph ph-eye';
            } else {
                passwordInput.type = 'password';
                eyeIcon.className = 'ph ph-eye-slash';
            }
        });

        // Toggle Confirm Password
        document.getElementById('toggle-password-confirm').addEventListener('click', function() {
            const confirmInput = document.getElementById('password_confirmation');
            const eyeIcon = document.getElementById('eye-icon-confirm');
            
            if (confirmInput.type === 'password') {
                confirmInput.type = 'text';
                eyeIcon.className = 'ph ph-eye';
            } else {
                confirmInput.type = 'password';
                eyeIcon.className = 'ph ph-eye-slash';
            }
        });

        // Refresh Captcha
        document.getElementById('btn-refresh').addEventListener('click', function() {
            const captchaImg = document.getElementById('captcha-img');
            const icon = document.getElementById('refresh-icon');
            
            // Add rotate animation class to icon
            icon.style.transform = 'rotate(360deg)';
            icon.style.transition = 'transform 0.5s ease';
            
            // Update image source with cache-buster
            captchaImg.src = "{{ route('captcha') }}?t=" + Date.now();
            
            // Fetch updated code for testing/debugging
            fetch("{{ route('captcha.code') }}?t=" + Date.now())
                .then(res => res.json())
                .then(data => {
                    const debugSpan = document.getElementById('debug-captcha');
                    if (debugSpan) {
                        debugSpan.innerText = data.code;
                    }
                })
                .catch(err => console.error(err));
            
            // Reset icon rotation after animation finishes
            setTimeout(() => {
                icon.style.transform = 'rotate(0deg)';
                icon.style.transition = 'none';
            }, 500);
        });
    </script>
</body>
</html>
