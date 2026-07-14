<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'burnout_level_id',
        'cf_result',
        'is_shared',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function burnoutLevel()
    {
        return $this->belongsTo(BurnoutLevel::class);
    }

    public function details()
    {
        return $this->hasMany(DiagnosisDetail::class);
    }
}
