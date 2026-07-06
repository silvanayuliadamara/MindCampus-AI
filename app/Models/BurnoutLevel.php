<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class BurnoutLevel extends Model {
    protected $fillable = ['code', 'name', 'description', 'min_cf', 'max_cf'];
}
