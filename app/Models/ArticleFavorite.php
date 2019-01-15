<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleFavorite extends Model
{
    protected $fillable = [
        'article_id',
        'user_id',
    ];

    public $incrementing = false;

    public $timestamps = false;
}
