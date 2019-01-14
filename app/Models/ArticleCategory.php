<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    protected $fillable = [
        'article_id',
        'category_id',
    ];

    public $incrementing = false;

    public $timestamps = false;
}
