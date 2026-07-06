<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Serenity AI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

        body {
            background: #f0f4ff;
            background-image:
                radial-gradient(circle at 20% 50%, rgba(99, 102, 241, 0.08), transparent 40%),
                radial-gradient(circle at 80% 20%, rgba(139, 92, 246, 0.06), transparent 40%);
            color: #1e1b4b;
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
            border: 1px solid rgba(99, 102, 241, 0.12);
            box-shadow: 0 8px 32px rgba(99, 102, 241, 0.08), 0 1px 4px rgba(0,0,0,0.04);
        }

        .brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 8px;
            font-size: 22px;
            font-weight: 700;
            background: linear-gradient(to right, #4f46e5, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        h2 {
            text-align: center;
            margin-bottom: 8px;
            font-size: 20px;
            font-weight: 600;
            color: #1e1b4b;
        }

        .subtitle {
            text-align: center;
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 32px;
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
            border: 1.5px solid rgba(99, 102, 241, 0.2);
            background: #ffffff;
            color: #1e1b4b;
            font-size: 14px;
            box-sizing: border-box;
            transition: all 0.2s ease;
            outline: none;
        }

        input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12);
        }

        input::placeholder { color: #9ca3af; }

        button {
            width: 100%;
            padding: 13px;
            background: #6366f1;
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            margin-top: 8px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);
        }

        button:hover {
            background: #4f46e5;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(99, 102, 241, 0.3);
        }

        button:active { transform: translateY(0); }

        .error {
            color: #ef4444;
            font-size: 12px;
            margin-top: 6px;
            display: block;
        }

        .demo-info {
            margin-top: 28px;
            padding: 16px;
            background: rgba(99, 102, 241, 0.05);
            border: 1px solid rgba(99, 102, 241, 0.12);
            border-radius: 10px;
            font-size: 12px;
            color: #4b5563;
            text-align: center;
        }

        .demo-info p { margin: 2px 0; }
        .demo-info strong { color: #6366f1; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="brand">🧠 Serenity AI</div>
        <h2>Selamat Datang Kembali</h2>
        <p class="subtitle">Masuk untuk melanjutkan diagnosis Anda</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
                @error('email') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit">Masuk</button>

            <div class="demo-info">
                <p><strong>Akun Demo:</strong></p>
                <p>Admin: admin@serenity.com | pass: password</p>
                <p>Mahasiswa: dimas@serenity.com | pass: password</p>
            </div>
        </form>
    </div>
</body>
</html>
