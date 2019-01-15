<?php
/**
 * Created by PhpStorm.
 * User: evnelviv02
 * Date: 2019-01-15
 * Time: 14:42
 */

namespace App\Repositories;


use App\Models\Article;

class ArticleRepository
{
    /**
     * @param bool $paginate
     * @return mixed
     */
    public function getMyArticle($paginate = false)
    {
        return Article::with('logotype', 'gallery', 'category')->whereAuthorId(auth()->user()->id)->paginate($paginate ? $paginate : config('app.paginate'));
    }

    /**
     * @param bool $paginate
     * @return mixed
     */
    public function getMyFavoriteArticle($paginate = false)
    {
        return auth()->user()->load('favorite');
    }
}
