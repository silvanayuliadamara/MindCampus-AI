<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DiagnosisController;

Route::get('/', function () {
    // Arahkan sementara ke login untuk mempermudah development
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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
    Route::get('/diagnosis/result/{id}', [DiagnosisController::class, 'result'])->name('diagnosis.result');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        $totalSymptoms = \App\Models\Symptom::count();
        $totalLevels = \App\Models\BurnoutLevel::count();
        $totalDiagnoses = \App\Models\Diagnosis::count();
        return view('admin.dashboard', compact('totalSymptoms', 'totalLevels', 'totalDiagnoses'));
    })->name('dashboard');

    Route::resource('symptoms', \App\Http\Controllers\Admin\SymptomController::class);
    Route::resource('students', \App\Http\Controllers\Admin\StudentController::class)->only(['index', 'show', 'destroy']);
});
