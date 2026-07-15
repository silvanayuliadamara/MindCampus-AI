<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Symptom;
use App\Models\BurnoutLevel;
use App\Models\Diagnosis;
use App\Models\DiagnosisDetail;
use App\Models\SymptomCategory;
use Illuminate\Support\Facades\Auth;
use App\Services\CertaintyFactorService;

class DiagnosisController extends Controller
{
    /**
     * Tampilkan halaman kuesioner.
     */
    public function wizard()
    {
        $symptoms = Symptom::where('is_active', true)->get();
        return view('user.diagnosis.wizard', compact('symptoms'));
    }

    /**
     * Hitung hasil CF dan simpan ke database.
     */
    public function calculate(Request $request)
    {
        // Validasi input: wajib mengisi array 'symptoms' (berisi cf_user)
        $request->validate([
            'symptoms' => 'required|array',
            'symptoms.*' => 'numeric|min:0|max:1',
        ]);

        $symptomsInput = $request->input('symptoms');

        // Gunakan CertaintyFactorService untuk perhitungan yang lebih akurat
        $cfService = new CertaintyFactorService();
        $result = $cfService->calculate($symptomsInput);

        $cfGlobalFinal = $result['cf_final'];
        $burnoutLevel = $result['burnout_level'];
        $dimensions = $result['dimensions'];

        // Hitung detail per gejala
        $allSymptoms = Symptom::whereIn('id', array_keys($symptomsInput))->get()->keyBy('id');
        $details = [];

        foreach ($symptomsInput as $symptomId => $cfUser) {
            $symptom = $allSymptoms->get($symptomId);
            if (!$symptom) continue;

            $cfResult = (float) $cfUser * (float) $symptom->cf_expert;

            $details[] = [
                'symptom_id' => $symptomId,
                'cf_user' => $cfUser,
                'cf_result' => $cfResult,
            ];
        }

        // Simpan ke database
        $diagnosis = Diagnosis::create([
            'user_id' => Auth::id(),
            'burnout_level_id' => $burnoutLevel->id,
            'cf_result' => $cfGlobalFinal,
            'is_shared' => $request->has('is_shared'),
        ]);

        // Simpan details
        foreach ($details as $detail) {
            $diagnosis->details()->create($detail);
        }

        return redirect()->route('diagnosis.result', $diagnosis->id);
    }

    /**
     * Tampilkan hasil diagnosis.
     */
    public function result($id)
    {
        $diagnosis = Diagnosis::with(['burnoutLevel', 'details.symptom'])->findOrFail($id);
        
        $user = Auth::user();
        
        // Pastikan user hanya bisa melihat hasilnya sendiri, 
        // kecuali admin dan diagnosis tersebut diizinkan untuk dibagikan (is_shared = true).
        $isOwner = $diagnosis->user_id === $user->id;
        $isAdminAllowed = $user->role && $user->role->name === 'admin' && $diagnosis->is_shared;

        if (!$isOwner && !$isAdminAllowed) {
            abort(403, 'Unauthorized access.');
        }

        // Hitung ulang dimensi dari detail yang tersimpan untuk tampilan
        $dimensions = $this->calculateDimensions($diagnosis);

        return view('user.diagnosis.result', compact('diagnosis', 'dimensions'));
    }

    /**
     * Tampilkan riwayat diagnosis.
     */
    public function history()
    {
        $diagnoses = Diagnosis::with('burnoutLevel')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('user.diagnosis.history', compact('diagnoses'));
    }

    /**
     * Hitung CF per dimensi (kategori) dari detail diagnosis yang tersimpan.
     */
    private function calculateDimensions(Diagnosis $diagnosis): array
    {
        $categories = SymptomCategory::all();
        $dimensionalCf = [];

        foreach ($diagnosis->details as $detail) {
            if ($detail->symptom) {
                $catId = $detail->symptom->category_id;
                if (!isset($dimensionalCf[$catId])) {
                    $dimensionalCf[$catId] = [];
                }
                $dimensionalCf[$catId][] = $detail->cf_result;
            }
        }

        $results = [];
        foreach ($categories as $category) {
            $cfArray = $dimensionalCf[$category->id] ?? [0];
            $results[$category->description ?: $category->name] = $this->combineCfArray($cfArray);
        }

        return $results;
    }

    /**
     * Kombinasi CF array (same formula as CertaintyFactorService).
     */
    private function combineCfArray(array $cfValues): float
    {
        if (count($cfValues) === 0) return 0.0;
        if (count($cfValues) === 1) return $cfValues[0];

        $cfCombine = $cfValues[0];
        for ($i = 1; $i < count($cfValues); $i++) {
            $cfCombine = $cfCombine + ($cfValues[$i] * (1 - $cfCombine));
        }

        return round($cfCombine, 4);
    }
}
