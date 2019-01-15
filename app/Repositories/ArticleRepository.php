<?php
/**
 * Created by PhpStorm.
 * User: evnelviv02
 * Date: 2019-01-15
 * Time: 14:42
 */

namespace App\Repositories;


use App\Models\Article;
use App\Models\ArticleFavorite;
use App\Models\ArticleImage;

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
        return Article::with('logotype', 'gallery', 'category')->whereIn('id', auth()->user()->load('favorite')->favorite->pluck('id'))->paginate($paginate ? $paginate : config('app.paginate'));
    }

    /**
     * @param $data
     * @return mixed
     */
    public function deleteImage($data)
    {
        return ArticleImage::whereImageId($data['image_id'])->whereArticleId($data['article_id'])->delete();
    }

    /**
     * @param Article $article
     * @return mixed
     */
    public function getFavoriteStatus(Article $article)
    {
        return ArticleFavorite::whereUserId(auth()->user()->id)->whereArticleId($article->id)->first();
    }

    /**
     * @param Article $article
     * @return mixed
     */
    public function deleteArticleToFavorite(Article $article)
    {
        return ArticleFavorite::whereUserId(auth()->user()->id)->whereArticleId($article->id)->delete();
    }

    /**
     * @param Article $article
     * @return mixed
     */
    public function addArticleToFavorite(Article $article)
    {
        return ArticleFavorite::create([
            'user_id' => auth()->user()->id,
            'article_id' => $article->id,
        ]);
    }
}
