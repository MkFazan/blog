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

        if (empty(auth()->user())){
            return Article::with('logotype', 'author')
                ->whereIn('id', $array)
                ->whereStatus(STATUS_ACTIVE)
                ->wherePublic(STATUS_ACTIVE)
                ->get();
        }else{
            return Article::with('logotype', 'author')
                ->whereIn('id', $array)
                ->whereStatus(STATUS_ACTIVE)
                ->get();
        }
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

            if (empty(auth()->user())) {
                return Article::with('gallery', 'logotype', 'author', 'category')
                    ->whereStatus(STATUS_ACTIVE)
                    ->wherePublic(STATUS_ACTIVE)
                    ->whereIn('id', $article_ids)
                    ->paginate($paginate);
            }else{
                return Article::with('gallery', 'logotype', 'author', 'category')
                    ->whereStatus(STATUS_ACTIVE)
                    ->whereIn('id', $article_ids)
                    ->paginate($paginate);
            }

        }else{
            if (empty(auth()->user())) {
                return Article::with('gallery', 'logotype', 'author', 'category')
                    ->whereStatus(STATUS_ACTIVE)
                    ->wherePublic(STATUS_ACTIVE)
                    ->paginate($paginate);
            }else{
                return Article::with('gallery', 'logotype', 'author', 'category')
                    ->whereStatus(STATUS_ACTIVE)
                    ->paginate($paginate);
            }
        }
    }

    /**
     * @return mixed
     */
    public function getFavoriteArticles()
    {
        return empty(auth()->user()) ? [] : auth()->user()->favorite->pluck('id')->toArray();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function basicSearch($data)
    {
        return Article::whereStatus(STATUS_ACTIVE)
            ->where(function ($query) use($data) {
                $query->orWhere('name', 'like', '%' . $data . '%')
                    ->orWhere('description', 'like', '%' . $data . '%')
                    ->orWhere('meta_title', 'like', '%' . $data . '%')
                    ->orWhere('meta_description', 'like', '%' . $data . '%')
                    ->orWhere('meta_keywords', 'like', '%' . $data . '%');
            })
            ->get();
    }

    /**
     * @return mixed
     */
    public function getAllArticles()
    {
        return Article::with('author', 'category')
            ->whereStatus(STATUS_ACTIVE)
            ->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function deleteArticles($data)
    {
        ArticleCategory::whereIn('article_id', $data)->delete();

        return Article::whereIn('id', $data)->delete();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function deleteAllFavoriteForArticles($data)
    {
        return ArticleFavorite::whereIn('article_id', $data)->delete();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function deleteAllFavoriteForUser($data)
    {
        return ArticleFavorite::where('user_id', $data)->delete();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function deleteImageRelationsToArticles($data)
    {
        return ArticleImage::whereIn('article_id', $data)->delete();
    }

    /**
     * @param $article
     * @param $category
     * @return mixed
     */
    public function createRelationshipArticleCategory($article, $category)
    {
        return ArticleCategory::create([
            'article_id' => $article,
            'category_id' => $category
        ]);
    }

    /**
     * @param $article
     * @param $categories
     * @return mixed
     */
    public function deleteRelationshipArticleCategories($article, $categories)
    {
        return ArticleCategory::whereArticleId($article)->whereIn('category_id', $categories)->delete();
    }
}
