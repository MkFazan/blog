<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddImageGalleryRequuest;
use App\Http\Requests\DeleteImageRequest;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Repositories\ArticleRepository;
use App\Services\ArticleService;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    /**
     * @var ArticleService
     */
    private $articleService;
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * ArticleController constructor.
     * @param ArticleService $articleService
     * @param ArticleRepository $articleRepository
     */
    public function __construct(ArticleService $articleService, ArticleRepository $articleRepository)
    {
        $this->articleService = $articleService;
        $this->articleRepository = $articleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.dashboard.article.index', [
            'articles' => Article::with('logotype', 'gallery', 'category')->paginate(config('app.paginate')),
            'best' => auth()->user()->favorite->pluck('id')->toArray()
        ]);
    }

    /**
     * @param Article $article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Article $article)
    {
        return view('backend.dashboard.article.show', [
            'article' => $article->load('logotype'),
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
        DB::beginTransaction();
        try {
            $this->articleService->store($request->except('_token'));

            DB::commit();

            return redirect()->route('articles.index')->with('success', 'Successfully created!');

        } catch (\Throwable $e) {
            DB::rollback();

            return back()->with('error', 'Error! Not found!');
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
    public function update(UpdateArticleRequest $request, Article $article)
    {
        DB::beginTransaction();
        try {
            $this->articleService->update($request->except('_token', '_method', 'MAX_FILE_SIZE'), $article);
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
        DB::beginTransaction();
        try {
            $this->articleService->destroy($article);
            DB::commit();

            return redirect()->route('articles.index')->with('success', 'Article deleted');

        } catch (\Throwable $e) {
            DB::rollback();

            return back()->with('error', 'Error! Not found!');
        }
    }

    /**
     * @param AddImageGalleryRequuest $requuest
     * @return \Illuminate\Http\JsonResponse
     */
    public function addImage(AddImageGalleryRequuest $requuest)
    {
        DB::beginTransaction();
        try {
            $image = $this->articleService->saveImageGallery(Article::find($requuest->article), $requuest->file);
            DB::commit();

            return response()->json(['uploaded' => '/upload/'.$image->name]);

        } catch (\Throwable $e) {
            DB::rollback();

            return back()->with('error', 'Error! Not found!');
        }
    }

    /**
     * @param DeleteImageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteImage(DeleteImageRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->articleRepository->deleteImage($request->all());
            DB::commit();

            return back()->with('success', 'Delete image in gallery');

        } catch (\Throwable $e) {
            DB::rollback();

            return back()->with('error', 'Error! Not found!');
        }
    }

}
