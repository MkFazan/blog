<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'name',
        'text',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status',
    ];
}
