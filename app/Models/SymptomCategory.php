<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class SymptomCategory extends Model {
    protected $fillable = ['name', 'description'];
    public function symptoms() { return $this->hasMany(Symptom::class, 'category_id'); }
}
