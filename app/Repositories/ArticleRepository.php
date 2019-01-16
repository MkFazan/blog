<?php
/**
 * Created by PhpStorm.
 * User: evnelviv02
 * Date: 2019-01-15
 * Time: 14:42
 */

namespace App\Repositories;


use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleFavorite;
use App\Models\ArticleImage;
use App\User;

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

    /**
     * @return Article[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getBestArticles()
    {
        $array = User::whereRole(User::ADMIN)
            ->join('article_favorites', 'article_favorites.user_id', 'users.id')
            ->select([
                'article_id as id'
            ])
            ->pluck('id')
            ->toArray();

        return Article::with('logotype', 'author')->whereIn('id', $array)->get();
    }

    /**
     * @param $paginate
     * @param bool $category
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getArticlesForCategory($paginate, $category = false)
    {
        if ($category){
            $article_ids = ArticleCategory::whereCategoryId($category)->pluck('article_id')->toArray();

            return Article::with('gallery', 'logotype', 'author', 'category')
                ->whereIn('id', $article_ids)
                ->paginate($paginate);

        }else{
            return Article::with('gallery', 'logotype', 'author', 'category')->paginate($paginate);
        }
    }

    /**
     * @return mixed
     */
    public function getFavoriteArticles()
    {
        return auth()->user()->favorite->pluck('id')->toArray();
    }
}
