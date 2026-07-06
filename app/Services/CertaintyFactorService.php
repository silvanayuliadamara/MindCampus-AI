<?php

namespace App\Services;

use App\Models\Symptom;
use App\Models\BurnoutLevel;
use App\Models\SymptomCategory;

class CertaintyFactorService
{
    /**
     * Kalkulasi utama algoritma Certainty Factor.
     * 
     * @param array $userAnswers [ symptom_id => cf_user_value ]
     * @return array
     */
    public function calculate(array $userAnswers): array
    {
        $symptoms = Symptom::whereIn('id', array_keys($userAnswers))->get();
        
        $dimensionalCf = [];
        $globalCfValues = [];

        // 1. Hitung CF tiap gejala (CF_Gejala = CF_User * CF_Pakar)
        foreach ($symptoms as $symptom) {
            $cfUser = (float) $userAnswers[$symptom->id];
            $cfExpert = (float) $symptom->cf_expert;
            
            $cfResult = $cfUser * $cfExpert;
            
            // Simpan per dimensi (category)
            if (!isset($dimensionalCf[$symptom->category_id])) {
                $dimensionalCf[$symptom->category_id] = [];
            }
            $dimensionalCf[$symptom->category_id][] = $cfResult;
            
            // Simpan untuk perhitungan global
            $globalCfValues[] = $cfResult;
        }

        // 2. Kombinasi CF secara berurutan (Sequential Combine)
        $cfGlobalFinal = $this->combineCfArray($globalCfValues);
        
        // 3. Kombinasi CF per Dimensi (untuk analisis mendalam di laporan)
        $dimensionResults = [];
        $categories = SymptomCategory::all();
        
        foreach ($categories as $category) {
            $cfArray = $dimensionalCf[$category->id] ?? [0];
            $dimensionResults[$category->name] = $this->combineCfArray($cfArray);
        }

        // 4. Map ke Tingkat Burnout (Berdasarkan range min_cf & max_cf)
        $burnoutLevel = BurnoutLevel::where('min_cf', '<=', $cfGlobalFinal)
            ->where('max_cf', '>=', $cfGlobalFinal)
            ->first();

        // Jika perhitungan meleset dari range (sangat jarang terjadi jika data seed benar)
        if (!$burnoutLevel) {
            $burnoutLevel = BurnoutLevel::orderBy('min_cf', 'asc')->first();
        }

        return [
            'cf_final' => $cfGlobalFinal,
            'confidence_percentage' => round($cfGlobalFinal * 100, 2),
            'burnout_level' => $burnoutLevel,
            'dimensions' => $dimensionResults
        ];
    }

    /**
     * Algoritma Kombinasi Multiple CF (Asumsi nilai postitif semua pada diagnosis burnout).
     * Rumus: CF_Combine = CF_old + CF_new * (1 - CF_old)
     */
    private function combineCfArray(array $cfValues): float
    {
        if (count($cfValues) === 0) {
            return 0.0;
        }

        if (count($cfValues) === 1) {
            return $cfValues[0];
        }

        $cfCombine = $cfValues[0];

        for ($i = 1; $i < count($cfValues); $i++) {
            $cfNew = $cfValues[$i];
            $cfCombine = $cfCombine + ($cfNew * (1 - $cfCombine));
        }

        return round($cfCombine, 4);
    }
}
