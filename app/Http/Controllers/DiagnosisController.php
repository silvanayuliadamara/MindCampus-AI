<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Symptom;
use App\Models\BurnoutLevel;
use App\Models\Diagnosis;
use App\Models\DiagnosisDetail;
use Illuminate\Support\Facades\Auth;

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
        $allSymptoms = Symptom::whereIn('id', array_keys($symptomsInput))->get()->keyBy('id');

        $cfCombine = 0;
        $details = [];

        foreach ($symptomsInput as $symptomId => $cfUser) {
            $symptom = $allSymptoms->get($symptomId);
            if (!$symptom) continue;

            // CF Pakar sudah tersimpan di database sebagai cf_expert (MB - MD)
            $cfExpert = $symptom->cf_expert;

            // CF Gejala (CF H,E) = CF User * CF Expert
            $cfResult = $cfUser * $cfExpert;

            // Kombinasikan CF dengan rule CF combine (untuk kasus positif)
            if ($cfCombine == 0) {
                $cfCombine = $cfResult;
            } else {
                $cfCombine = $cfCombine + ($cfResult * (1 - $cfCombine));
            }

            // Siapkan data detail untuk disimpan
            $details[] = [
                'symptom_id' => $symptomId,
                'cf_user' => $cfUser,
                'cf_result' => $cfResult,
            ];
        }

        // Tentukan Burnout Level
        $burnoutLevel = BurnoutLevel::where('min_cf', '<=', $cfCombine)
            ->orderBy('min_cf', 'desc')
            ->first();

        if (!$burnoutLevel) {
            // Default jika tidak ketemu (kasus CF sangat kecil / 0)
            $burnoutLevel = BurnoutLevel::where('code', 'B001')->first();
        }

        // Simpan ke database
        $diagnosis = Diagnosis::create([
            'user_id' => Auth::id(),
            'burnout_level_id' => $burnoutLevel->id,
            'cf_result' => $cfCombine,
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
        
        // Pastikan user hanya bisa melihat hasilnya sendiri
        if ($diagnosis->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        return view('user.diagnosis.result', compact('diagnosis'));
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
}
