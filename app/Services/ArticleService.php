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
use App\Models\ArticleFavorite;
use App\Models\ArticleImage;
use App\Models\Image;
use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;
use Illuminate\Support\Facades\DB;

class ArticleService
{
    private $articleRepository;
    private $commentRepository;

    /**
     * ArticleService constructor.
     * @param ArticleRepository $articleRepository
     * @param CommentRepository $commentRepository
     */
    public function __construct(ArticleRepository $articleRepository, CommentRepository $commentRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function store($data)
    {
        DB::beginTransaction();
        try {
            $image = $this->saveImage($data['logo'], $data['name']);
            $data['logo'] = $image->id;
            $data['author_id'] = auth()->user()->id;
            $data['status'] = isset($data['status']) ? $data['status'] : 0;
            $data['public'] = isset($data['public']) ? $data['public'] : 0;

            $article = Article::create($data);
            foreach ($data['categories'] as $category) {
                $this->articleRepository->createRelationshipArticleCategory($article->id, $category);
            }

            DB::commit();

            return ['success', 'Successfully created!'];

        } catch (\Throwable $e) {
            DB::rollback();

            return ['error', 'Error! Not found!'];
        }
    }

    /**
     * @param $data
     * @param Article $article
     * @return array
     */
    public function update($data, Article $article)
    {
        DB::beginTransaction();
        try {
            if (isset($data['logo'])) {
                $image = $this->saveImage($data['logo'], $data['name']);
                $data['logo'] = $image->id;
            }
            $data['status'] = isset($data['status']) ? $data['status'] : 0;
            $data['public'] = isset($data['public']) ? $data['public'] : 0;

            $article->update($data);

            $old_categories = $article->category->pluck('id')->toArray();
            $new_categories = $data['categories'];
            foreach ($new_categories as $category) {
                if (in_array($category, $old_categories) && ($key = array_search($category, $old_categories)) !== false){
                    unset($old_categories[$key]);
                }else{
                    $this->articleRepository->createRelationshipArticleCategory($article->id, $category);
                }
            }
            if (!empty($old_categories)){
                $this->articleRepository->deleteRelationshipArticleCategories($article->id, $old_categories);
            }

            DB::commit();

            return ['success', 'Successfully update!'];

        } catch (\Throwable $e) {
            DB::rollback();

            return ['error', 'Error! Not found!'];
        }
    }

    /**
     * @param Article $article
     * @return array
     */
    public function destroy(Article $article)
    {
        DB::beginTransaction();
        try {
            $this->articleRepository->deleteImageRelationsToArticles([$article->id]);
            $this->articleRepository->deleteAllFavoriteForArticles([$article->id]);
            $this->commentRepository->deleteAllCommentsForArticle($article->id);
            $this->articleRepository->deleteArticles([$article->id]);
            DB::commit();

            return ['success', 'Article deleted'];
        } catch (\Throwable $e) {
            DB::rollback();

            return ['error', 'Error! Not found!'];
        }
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
     * @return array
     */
    public function changeFavoriteStatus(Article $article)
    {
        DB::beginTransaction();
        try {
            $status = $this->articleRepository->getFavoriteStatus($article);

            if (is_null($status)){
                $this->articleRepository->addArticleToFavorite($article);
                $message = 'Added article to favorite!';
            }else{
                $this->articleRepository->deleteArticleToFavorite($article);
                $message = 'Deleted favorite article!';
            }
            DB::commit();

            return ['success', $message];

        } catch (\Throwable $e) {
            DB::rollback();

            return ['error', 'Error! Not found!'];
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

    /**
     * @param $data
     * @return mixed
     */
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
        if (!empty($data['author_name'])){
            $author = $data['author_name'];
            $articles = $articles->filter(function ($item) use ($author) {
                return false !== stristr($item->author->name, $author);
            });
        }
        if (isset($data['categories'])){
            if (!empty($data['categories'])){;
                $categories = $data['categories'];
                $articles = $articles->filter(function ($item) use ($categories) {
                    $category = $item->category->pluck('id')->toArray();
                    return false !== !empty(array_uintersect($categories, $category, "strcasecmp"));
                });
            }
        }

        return $articles;
    }
}
