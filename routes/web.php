<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ChatbotController;

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->role && auth()->user()->role->name === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('dashboard');
    }
    
    $studentCount = 500 + \App\Models\User::whereHas('role', function($q) {
        $q->where('name', 'mahasiswa');
    })->count();
    
    $diagnosisCount = 1200 + \App\Models\Diagnosis::count();

    return view('home', compact('studentCount', 'diagnosisCount'));
})->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/captcha', [AuthController::class, 'generateCaptcha'])->name('captcha');
Route::get('/captcha-code', function() { return response()->json(['code' => session('captcha_code')]); })->name('captcha.code');

// Password Reset Routes (OTP-based)
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendOtp'])->name('password.otp.send');
Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])->name('password.otp.form');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('password.otp.verify');
Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('password.reset.form');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Shared Routes (Accessible by both Admin and Mahasiswa)
Route::middleware(['auth'])->group(function () {
    Route::get('/diagnosis/result/{id}', [DiagnosisController::class, 'result'])->name('diagnosis.result');
});

// Mahasiswa Routes
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/dashboard', function () {
        $latestDiagnosis = \App\Models\Diagnosis::with('burnoutLevel')
                            ->where('user_id', auth()->id())
                            ->latest()
                            ->first();
                            
        $historyDiagnoses = \App\Models\Diagnosis::where('user_id', auth()->id())
                            ->orderBy('created_at', 'asc')
                            ->take(10) // Limit to last 10 for the chart
                            ->get();
                            
        return view('user.dashboard', compact('latestDiagnosis', 'historyDiagnoses'));
    })->name('dashboard');

    // Diagnosis routes
    Route::get('/diagnosis', [DiagnosisController::class, 'wizard'])->name('diagnosis.wizard');
    Route::post('/diagnosis', [DiagnosisController::class, 'calculate'])->name('diagnosis.calculate');
    Route::get('/diagnosis/history', [DiagnosisController::class, 'history'])->name('diagnosis.history');

    // Article routes
    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');

    // Chatbot routes
    Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot');
    Route::post('/chatbot/send', [ChatbotController::class, 'sendMessage'])->name('chatbot.send');
    Route::post('/chatbot/clear', [ChatbotController::class, 'clearHistory'])->name('chatbot.clear');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
        $selectedMonth = $request->input('month');

        $totalSymptoms = \App\Models\Symptom::count();
        
        $studentsQuery = \App\Models\User::whereHas('role', function($q) {
            $q->where('name', 'mahasiswa');
        });
        if ($selectedMonth) {
            $studentsQuery->whereMonth('created_at', $selectedMonth);
        }
        $totalStudents = $studentsQuery->count();

        // Base query for shared diagnoses
        $diagnosesQuery = \App\Models\Diagnosis::where('is_shared', true);
        if ($selectedMonth) {
            $diagnosesQuery->whereMonth('created_at', $selectedMonth);
        }
        $totalSharedDiagnoses = (clone $diagnosesQuery)->count();
        
        $recentDiagnoses = (clone $diagnosesQuery)
            ->with(['user.profile', 'burnoutLevel'])
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Burnout levels count filtered by month
        $burnoutLevels = \App\Models\BurnoutLevel::withCount(['diagnoses' => function($q) use ($selectedMonth) {
            $q->where('is_shared', true);
            if ($selectedMonth) {
                $q->whereMonth('created_at', $selectedMonth);
            }
        }])->get();

        // Fixed Calendar Months Array (Januari to Desember) with zero-padded values for SQLite/MySQL compat
        $availableMonths = [
            ['val' => '01', 'label' => 'Januari'],
            ['val' => '02', 'label' => 'Februari'],
            ['val' => '03', 'label' => 'Maret'],
            ['val' => '04', 'label' => 'April'],
            ['val' => '05', 'label' => 'Mei'],
            ['val' => '06', 'label' => 'Juni'],
            ['val' => '07', 'label' => 'Juli'],
            ['val' => '08', 'label' => 'Agustus'],
            ['val' => '09', 'label' => 'September'],
            ['val' => '10', 'label' => 'Oktober'],
            ['val' => '11', 'label' => 'November'],
            ['val' => '12', 'label' => 'Desember'],
        ];

        // Monthly Trend Data for Chart.js
        $trendData = array_fill(1, 12, 0);
        $diagnosesThisYear = \App\Models\Diagnosis::where('is_shared', true)
            ->whereYear('created_at', date('Y'))
            ->get();
            
        foreach ($diagnosesThisYear as $d) {
            $m = (int) $d->created_at->format('n');
            $trendData[$m]++;
        }

        return view('admin.dashboard', compact('totalSymptoms', 'totalStudents', 'totalSharedDiagnoses', 'recentDiagnoses', 'burnoutLevels', 'availableMonths', 'selectedMonth', 'trendData'));
    })->name('dashboard');

    Route::resource('symptoms', \App\Http\Controllers\Admin\SymptomController::class);
    Route::resource('students', \App\Http\Controllers\Admin\StudentController::class)->only(['index', 'show', 'destroy']);
    
    Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
});
