<?php
/**
 * Created by PhpStorm.
 * User: evnelviv02
 * Date: 2019-01-15
 * Time: 13:55
 */

namespace App\Services;


use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleImage;
use App\Models\Image;
use App\Repositories\ArticleRepository;

class ArticleService
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * ArticleService constructor.
     * @param ArticleRepository $articleRepository
     */
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function store($data)
    {
        $image = $this->saveImage($data['logo'], $data['name']);
        $data['logo'] = $image->id;
        $data['author_id'] = auth()->user()->id;

        $article = Article::create($data);
        foreach ($data['categories'] as $category) {
            ArticleCategory::create([
                'article_id' => $article->id,
                'category_id' => $category
            ]);
        }

        return $article;
    }

    /**
     * @param $data
     * @param Article $article
     * @return string
     */
    public function update($data, Article $article)
    {
        if (isset($data['logo'])) {
            $image = $this->saveImage($data['logo'], $data['name']);
            $data['logo'] = $image->id;
        }
        $data['status'] = isset($data['status']) ? $data['status'] : 0;

        $article->update($data);

        $old_categories = $article->category->pluck('id')->toArray();
        $new_categories = $data['categories'];
        foreach ($new_categories as $category) {
            if (in_array($category, $old_categories) && ($key = array_search($category, $old_categories)) !== false){
                unset($old_categories[$key]);
            }else{
                ArticleCategory::create([
                    'article_id' => $article->id,
                    'category_id' => $category
                ]);
            }
        }
        if (!empty($old_categories)){
            ArticleCategory::whereArticleId($article->id)->whereIn('category_id', $old_categories)->delete();
        }

        return 'success';
    }

    public function destroy(Article $article)
    {
        ArticleCategory::whereArticleId($article->id)->delete();
        ArticleImage::whereArticleId($article->id)->delete();

        return $article->delete();
    }

    /**
     * @param Article $article
     * @param $img
     * @return mixed
     */
    public function saveImageGallery(Article $article, $img)
    {
        $image = $this->saveImage($img, $article->name);

        ArticleImage::create([
            'image_id' => $image->id,
            'article_id' => $article->id
        ]);

        return $image;
    }

    /**
     * @param $img
     * @param $display_name
     * @return mixed
     */
    public function saveImage($img, $display_name)
    {
        $img_name = time() . $img->getClientOriginalName();
        $file_path = 'app/public/uploads/';
        $img->move(storage_path($file_path), $img_name);

        $image = Image::create([
            'name' => $img_name,
            'display_name' => $display_name,
            'url' => config('app.url') . '/storage/uploads/' . $img_name
        ]);

        return $image;
    }

    /**
     * @param Article $article
     * @return string
     */
    public function changeFavoriteStatus(Article $article)
    {
        $status = $this->articleRepository->getFavoriteStatus($article);

        if (is_null($status)){
            $this->articleRepository->addArticleToFavorite($article);

            return 'Added article to favorite!';
        }else{
            $this->articleRepository->deleteArticleToFavorite($article);

            return 'Deleted favorite article!';
        }
    }

    /**
     * @param $data
     * @return array
     */
    public function basicSearch($data)
    {
        $articles = $this->articleRepository->basicSearch($data);

        $result = $articles->map(function ($article){
            return [
                'id' => config('app.url') . '/article/' . $article->id,
                'name' => $article->name
            ];
        });

        return [
            'items' => $result,
        ];
    }

    public function filter($data)
    {
        $articles = $this->articleRepository->getAllArticles();

        if (!empty($data['name'])){
            $name = $data['name'];
            $articles = $articles->filter(function ($item) use ($name) {
                return false !== stristr($item->name, $name);
            });
        }
        if (!empty($data['description'])){
            $description = $data['description'];
            $articles = $articles->filter(function ($item) use ($description) {
                return false !== stristr($item->name, $description);
            });
        }
        if (!empty($data['meta_title'])){
            $meta_title = $data['meta_title'];
            $articles = $articles->filter(function ($item) use ($meta_title) {
                return false !== stristr($item->name, $meta_title);
            });
        }
        if (!empty($data['meta_description'])){
            $meta_description = $data['meta_description'];
            $articles = $articles->filter(function ($item) use ($meta_description) {
                return false !== stristr($item->name, $meta_description);
            });
        }
        if (!empty($data['meta_keywords'])){
            $meta_keywords = $data['meta_keywords'];
            $articles = $articles->filter(function ($item) use ($meta_keywords) {
                return false !== stristr($item->name, $meta_keywords);
            });
        }
//        if (!empty($data['author_name'])){
//
//        }

        return $articles;
    }
}
