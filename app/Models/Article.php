<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'logo',
        'name',
        'description',
        'meta_description',
        'meta_title',
        'meta_keywords',
        'parent_id',
        'author_id',
        'status',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function logotype()
    {
        return $this->hasOne(Image::class, 'id', 'logo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function gallery()
    {
        return $this->belongsToMany(Image::class, 'article_images');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function category()
    {
        return $this->belongsToMany(Category::class, 'article_categories');
    }

    public function author()
    {
        return $this->hasOne(User::class, 'id', 'author_id');
    }
}
