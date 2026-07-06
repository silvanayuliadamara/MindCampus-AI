<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Rule extends Model {
    protected $fillable = ['code', 'burnout_level_id', 'description'];
    public function level() { return $this->belongsTo(BurnoutLevel::class, 'burnout_level_id'); }
    public function symptoms() { return $this->belongsToMany(Symptom::class, 'rule_symptoms', 'rule_id', 'symptom_id'); }
}
