<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Symptom extends Model {
    protected $fillable = ['category_id', 'code', 'name', 'question', 'mb', 'md', 'cf_expert', 'is_active'];
    public function category() { return $this->belongsTo(SymptomCategory::class, 'category_id'); }
}
