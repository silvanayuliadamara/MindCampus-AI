<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password | Serenity AI</title>
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
            max-width: 420px;
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
            margin-bottom: 24px;
            line-height: 1.5;
        }

        .form-group { margin-bottom: 20px; }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 500;
            color: #374151;
        }

        input {
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

        input:focus {
            border-color: #0d9488;
            box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.12);
        }

        input::placeholder { color: #9ca3af; }

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
            margin-top: 6px;
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
        }

        .alert-debug {
            background: rgba(217, 119, 6, 0.08);
            border: 1px dashed rgba(217, 119, 6, 0.2);
            color: #92400e;
            padding: 14px;
            border-radius: 10px;
            font-size: 12px;
            margin-bottom: 20px;
            text-align: left;
            word-break: break-all;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="brand">🧠 Serenity AI</div>
        <h2>Lupa Password</h2>
        <p class="subtitle">Masukkan alamat email Anda. Kami akan mengirimkan kode OTP 6 digit untuk proses pemulihan kata sandi.</p>

        @if (session('status'))
            <div class="alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.otp.send') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
                @error('email') <span class="error">{{ $message }}</span> @enderror
            </div>

            <button type="submit">Kirim Kode OTP</button>

            <div style="text-align: center; margin-top: 24px; font-size: 13px; color: #4b5563;">
                Kembali ke <a href="{{ route('login') }}" style="color: #0d9488; text-decoration: none; font-weight: 600;">Halaman Masuk</a>
            </div>
        </form>
    </div>
</body>
</html>
