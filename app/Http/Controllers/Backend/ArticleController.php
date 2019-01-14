<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddImageGalleryRequuest;
use App\Http\Requests\DeleteImageRequest;
use App\Http\Requests\StoreArticleRequest;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleImage;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.dashboard.article.index', [
            'articles' => Article::with('logo', 'gallery', 'category')->paginate(config('app.paginate')),
        ]);
    }

    /**
     * @param Article $article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Article $article)
    {
        return view('backend.dashboard.article.show', [
            'article' => $article,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.dashboard.article.form', [
            'categories' => Category::pluck('name', 'id'),
            'nodes' => Category::whereIsRoot()->get(),
            'title' => 'Create new'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreArticleRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function store(StoreArticleRequest $request)
    {
        $data = $request->except('_token');

        DB::beginTransaction();
        try {

            $img = $data['logo'];
            $img_name = time() . $img->getClientOriginalName();
            $file_path = 'app/public/uploads/';
            $img->move(storage_path($file_path), $img_name);
            $image = Image::create([
                'name' => $img_name,
                'display_name' => $data['name'],
                'url' => config('app.url') . '/storage/uploads/' . $img_name
            ]);

            $data['logo'] = $image->id;

            $article = Article::create($data);
            foreach ($data['categories'] as $category) {
                ArticleCategory::create([
                    'article_id' => $article->id,
                    'category_id' => $category
                ]);
            }

            DB::commit();

            return redirect()->route('articles.index')->with('success', 'Successfully created!');

        } catch (\Throwable $e) {
            DB::rollback();

            throw $e;

//            return back()->with('error', 'Error! Not found!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Article $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return view('backend.dashboard.article.form', [
            'categories' => Category::pluck('name', 'id'),
            'nodes' => Category::whereIsRoot()->get(),
            'article' => $article,
            'title' => 'Update '
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreArticleRequest $request
     * @param Article $article
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function update(StoreArticleRequest $request, Article $article)
    {
        $data = $request->except('_token', '_method', 'MAX_FILE_SIZE');

        DB::beginTransaction();
        try {

            if (isset($data['logo'])) {
                $img = $data['logo'];
                $img_name = time() . $img->getClientOriginalName();
                $file_path = 'app/public/uploads/';
                $img->move(storage_path($file_path), $img_name);

                $image = Image::create([
                    'name' => $img_name,
                    'display_name' => $data['name'],
                    'url' => config('app.url') . '/storage/uploads/' . $img_name
                ]);

                $data['logo'] = $image->id;
            }

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

            DB::commit();

            return redirect()->route('articles.index')->with('success', 'Successfully saved!');

        } catch (\Throwable $e) {
            DB::rollback();

            return back()->with('error', 'Error! Not found!');
        }
    }

    /**
     * @param Article $article
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Article $article)
    {
        ArticleCategory::whereArticleId($article->id)->delete();
        ArticleImage::whereArticleId($article->id)->delete();
        $article->delete();

        return redirect()->route('articles.index')->with('error', 'Category can not be deleted because it has articles');
    }

    /**
     * @param AddImageGalleryRequuest $requuest
     * @return \Illuminate\Http\JsonResponse
     */
    public function addImage(AddImageGalleryRequuest $requuest)
    {
        $article = Article::find($requuest->article);
        $img = request()->file;
        $img_name = time() .  request()->file->getClientOriginalName();
        $file_path = 'app/public/uploads/';
        $img->move(storage_path($file_path), $img_name);

        $image = Image::create([
            'name' => $img_name,
            'display_name' => $article->name,
            'url' => config('app.url') . '/storage/uploads/' . $img_name
        ]);

        ArticleImage::create([
            'image_id' => $image->id,
            'article_id' => $article->id
        ]);

        return response()->json(['uploaded' => '/upload/'.$img_name]);
    }

    public function deleteImage(DeleteImageRequest $request)
    {
        $data = $request->all();

        ArticleImage::whereImageId($data['image_id'])->whereArticleId($data['article_id'])->delete();

        return back()->with('success', 'Delete image in gallery');

    }
}
