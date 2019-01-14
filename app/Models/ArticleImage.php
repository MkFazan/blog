<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleImage extends Model
{
    protected $fillable = [
        'article_id',
        'image_id',
    ];

    public $incrementing = false;

    public $timestamps = false;
}
