<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            $role = Auth::user()->role->name;
            if ($role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        $code = Str::upper(Str::random(5));
        session(['captcha_code' => $code]);
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'university' => ['required', 'string', 'max:255'],
            'major' => ['required', 'string', 'max:255'],
            'semester' => ['required', 'integer', 'min:1', 'max:14'],
            'gender' => ['required', 'in:L,P,R'],
            'captcha' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (Str::upper($value) !== session('captcha_code')) {
                        $fail('Kode captcha yang dimasukkan salah.');
                    }
                }
            ],
        ], [
            'captcha.required' => 'Kolom captcha wajib diisi.',
        ]);

        $mahasiswaRole = Role::where('name', 'mahasiswa')->first();
        if (!$mahasiswaRole) {
            return back()->withErrors(['email' => 'Role mahasiswa tidak ditemukan.']);
        }

        // Create User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $mahasiswaRole->id,
        ]);

        // Create Profile
        $user->profile()->create([
            'university' => $request->university,
            'major' => $request->major,
            'semester' => $request->semester,
            'gender' => $request->gender,
        ]);

        // Autologin
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.exists' => 'Alamat email tidak ditemukan.',
        ]);

        $otp = random_int(100000, 999999);

        session([
            'reset_email' => $request->email,
            'reset_otp_hash' => Hash::make($otp),
            'reset_otp_expires_at' => now()->addMinutes(5)->timestamp,
            'reset_otp_verified' => false,
        ]);

        // Send simulated OTP email (logs to storage/logs/laravel.log)
        Mail::raw("Kode OTP reset kata sandi Serenity AI Anda adalah {$otp}. Kode ini berlaku selama 5 menit.", function($message) use ($request) {
            $message->to($request->email)->subject("Kode OTP Reset Kata Sandi Serenity AI");
        });

        return redirect()->route('password.otp.form')->with([
            'status' => 'Kode OTP telah dikirim ke email Anda!',
            'debug_otp' => $otp
        ]);
    }

    public function showVerifyOtp()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request');
        }

        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.digits' => 'Kode OTP harus terdiri dari 6 digit.',
        ]);

        if (!session('reset_email') || !session('reset_otp_hash')) {
            return redirect()->route('password.request');
        }

        if (now()->timestamp > session('reset_otp_expires_at')) {
            session()->forget([
                'reset_email',
                'reset_otp_hash',
                'reset_otp_expires_at',
                'reset_otp_verified',
            ]);

            return redirect()
                ->route('password.request')
                ->withErrors(['email' => 'Kode OTP sudah kedaluwarsa. Silakan minta kode baru.']);
        }

        if (!Hash::check($request->otp, session('reset_otp_hash'))) {
            return back()->withErrors(['otp' => 'Kode OTP tidak sesuai.']);
        }

        session(['reset_otp_verified' => true]);

        return redirect()->route('password.reset.form');
    }

    public function showResetPassword()
    {
        if (!session('reset_email') || !session('reset_otp_verified')) {
            return redirect()->route('password.request');
        }

        return view('auth.reset-password', [
            'email' => session('reset_email')
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!session('reset_email') || !session('reset_otp_verified')) {
            return redirect()->route('password.request');
        }

        $user = User::where('email', session('reset_email'))->firstOrFail();
        $user->password = Hash::make($request->password);
        $user->save();

        session()->forget([
            'reset_email',
            'reset_otp_hash',
            'reset_otp_expires_at',
            'reset_otp_verified',
        ]);

        return redirect()->route('login')->with('status', 'Password Anda berhasil disetel ulang! Silakan masuk dengan password baru.');
    }

    public function generateCaptcha(Request $request)
    {
        if ($request->has('t') || !session('captcha_code')) {
            $code = Str::upper(Str::random(5));
            session(['captcha_code' => $code]);
        } else {
            $code = session('captcha_code');
        }

        // Create a beautiful SVG captcha
        $width = 150;
        $height = 46;
        
        $svg = "<svg xmlns='http://www.w3.org/2000/svg' width='{$width}' height='{$height}' viewBox='0 0 {$width} {$height}' style='background: #f8fafc; border-radius: 8px; border: 1px solid rgba(13, 148, 136, 0.2);'>";
        
        // Add some noise (grid lines)
        for ($i = 0; $i < 5; $i++) {
            $x1 = random_int(0, $width);
            $y1 = random_int(0, $height);
            $x2 = random_int(0, $width);
            $y2 = random_int(0, $height);
            $svg .= "<line x1='{$x1}' y1='{$y1}' x2='{$x2}' y2='{$y2}' stroke='rgba(13, 148, 136, 0.15)' stroke-width='1.5'/>";
        }
        
        // Add characters
        $chars = str_split($code);
        $fontSizes = [22, 24, 26];
        $colors = ['#0d9488', '#0f766e', '#115e59', '#14b8a6', '#0f172a'];
        
        foreach ($chars as $index => $char) {
            $x = 20 + ($index * 24) + random_int(-3, 3);
            $y = 30 + random_int(-4, 4);
            $angle = random_int(-15, 15);
            $fontSize = $fontSizes[array_rand($fontSizes)];
            $color = $colors[array_rand($colors)];
            
            $svg .= "<text x='{$x}' y='{$y}' font-family='Courier New, monospace, sans-serif' font-weight='800' font-size='{$fontSize}' fill='{$color}' transform='rotate({$angle} {$x} {$y})'>{$char}</text>";
        }

        // Add some circles for more noise
        for ($i = 0; $i < 6; $i++) {
            $cx = random_int(0, $width);
            $cy = random_int(0, $height);
            $r = random_int(2, 4);
            $svg .= "<circle cx='{$cx}' cy='{$cy}' r='{$r}' fill='rgba(20, 184, 166, 0.15)'/>";
        }

        $svg .= "</svg>";
        
        return response($svg, 200)->header('Content-Type', 'image/svg+xml');
    }
}
