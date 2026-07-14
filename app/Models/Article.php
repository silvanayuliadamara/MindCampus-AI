<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'summary',
        'content',
        'category',
        'read_time',
        'image_url',
    ];
}
