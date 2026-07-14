<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP | Serenity AI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

        body {
            background: #f0fdf4;
            background-image:
                radial-gradient(circle at 20% 50%, rgba(13, 148, 136, 0.08), transparent 40%),
                radial-gradient(circle at 80% 20%, rgba(16, 185, 129, 0.06), transparent 40%);
            color: #0f172a;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            padding: 48px 40px;
            border-radius: 20px;
            width: 100%;
            max-width: 440px;
            border: 1px solid rgba(13, 148, 136, 0.12);
            box-shadow: 0 8px 32px rgba(13, 148, 136, 0.08), 0 1px 4px rgba(0,0,0,0.04);
            text-align: center;
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
            margin-bottom: 8px;
            font-size: 20px;
            font-weight: 600;
            color: #0f172a;
        }

        .subtitle {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 24px;
            line-height: 1.5;
        }

        .form-group { margin-bottom: 20px; }

        .otp-input-group {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 20px;
        }

        .otp-input {
            width: 50px;
            height: 54px;
            border-radius: 12px;
            border: 1.5px solid rgba(13, 148, 136, 0.2);
            background: #ffffff;
            color: #0f172a;
            font-size: 22px;
            font-weight: 700;
            text-align: center;
            outline: none;
            transition: all 0.2s ease;
        }

        .otp-input:focus {
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
            margin-top: 8px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(13, 148, 136, 0.25);
        }

        button:hover {
            background: #0b7a6f;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(13, 148, 136, 0.3);
        }

        button:active { transform: translateY(0); }

        .error {
            color: #ef4444;
            font-size: 12px;
            margin-bottom: 15px;
            display: block;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.08);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: #065f46;
            padding: 14px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
            line-height: 1.5;
            text-align: left;
        }

        .alert-debug {
            background: rgba(217, 119, 6, 0.08);
            border: 1px dashed rgba(217, 119, 6, 0.2);
            color: #92400e;
            padding: 14px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
            text-align: center;
        }

        .otp-back-link {
            position: absolute;
            left: 24px;
            top: 24px;
            color: #6b7280;
            font-size: 20px;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .otp-back-link:hover { color: #0d9488; }
    </style>
</head>
<body>
    <div class="login-card" style="position: relative;">
        <!-- Back Link -->
        <a href="{{ route('password.request') }}" class="otp-back-link" title="Kembali">
            <i class="ph-bold ph-arrow-left"></i>
        </a>

        <div class="brand" style="margin-top: 10px;">🧠 Serenity AI</div>
        <h2>Verifikasi Kode OTP</h2>
        <p class="subtitle">Kode OTP telah dikirimkan ke email:<br><strong>{{ session('reset_email') }}</strong></p>

        @if (session('status'))
            <div class="alert-success">
                <div style="display: flex; gap: 8px; align-items: flex-start;">
                    <i class="ph-bold ph-info" style="font-size: 18px; margin-top: 2px;"></i>
                    <span>{{ session('status') }}</span>
                </div>
            </div>
        @endif

        @if (session('debug_otp'))
            <div class="alert-debug">
                <strong>Kode OTP Simulasi (Developer Mode):</strong><br>
                <span id="debugOtpText" style="font-size: 24px; font-weight: 800; color: #d97706; letter-spacing: 4px; display: inline-block; margin-top: 6px;">{{ session('debug_otp') }}</span>
            </div>
        @endif

        <form action="{{ route('password.otp.verify') }}" method="POST" id="otpForm">
            @csrf

            <!-- Hidden input that aggregates OTP codes -->
            <input type="hidden" name="otp" id="otpValue">

            <div class="otp-input-group">
                <input type="text" maxlength="1" inputmode="numeric" class="otp-input" required autofocus>
                <input type="text" maxlength="1" inputmode="numeric" class="otp-input" required>
                <input type="text" maxlength="1" inputmode="numeric" class="otp-input" required>
                <input type="text" maxlength="1" inputmode="numeric" class="otp-input" required>
                <input type="text" maxlength="1" inputmode="numeric" class="otp-input" required>
                <input type="text" maxlength="1" inputmode="numeric" class="otp-input" required>
            </div>

            @error('otp') <span class="error">{{ $message }}</span> @enderror

            <button type="submit">Verifikasi Kode</button>

            <div style="text-align: center; margin-top: 24px; font-size: 13px; color: #4b5563;">
                Salah memasukkan email? <a href="{{ route('password.request') }}" style="color: #0d9488; text-decoration: none; font-weight: 600;">Ubah Email</a>
            </div>
        </form>
    </div>

    <script>
        const otpInputs = document.querySelectorAll('.otp-input');
        const otpValue = document.getElementById('otpValue');
        const otpForm = document.getElementById('otpForm');

        otpInputs.forEach((input, index) => {
            // Only allow digits
            input.addEventListener('input', (e) => {
                input.value = input.value.replace(/[^0-9]/g, '');

                // Advance to next input box
                if (input.value && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
                
                // Automatically submit form if all boxes are filled
                if (Array.from(otpInputs).every(inp => inp.value.length === 1)) {
                    submitOtp();
                }
            });

            // Backspace deletes current digit and goes back
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace') {
                    if (!input.value && index > 0) {
                        otpInputs[index - 1].value = '';
                        otpInputs[index - 1].focus();
                    } else {
                        input.value = '';
                    }
                    e.preventDefault();
                }
            });
            
            // Paste event allows pasting 6 digit OTP
            input.addEventListener('paste', (e) => {
                const data = e.clipboardData.getData('text').trim();
                if (data.length === 6 && /^\d+$/.test(data)) {
                    otpInputs.forEach((inp, idx) => {
                        inp.value = data[idx];
                    });
                    submitOtp();
                    e.preventDefault();
                }
            });
        });

        function submitOtp() {
            otpValue.value = Array.from(otpInputs).map(inp => inp.value).join('');
            otpForm.submit();
        }

        otpForm.addEventListener('submit', (e) => {
            otpValue.value = Array.from(otpInputs).map(inp => inp.value).join('');
        });
    </script>
</body>
</html>
