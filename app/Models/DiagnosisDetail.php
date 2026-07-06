<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiagnosisDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'diagnosis_id',
        'symptom_id',
        'cf_user',
        'cf_result',
    ];

    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class);
    }

    public function symptom()
    {
        return $this->belongsTo(Symptom::class);
    }
}
