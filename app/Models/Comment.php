<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'text',
        'parent_id',
        'article_id',
        'author_id',
        'status',
    ];
}
