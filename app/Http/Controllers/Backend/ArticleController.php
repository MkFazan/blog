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
use App\Repositories\CategoryRepository;
use App\Services\ArticleService;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    private $articleService;
    private $articleRepository;
    private $categoryRepository;

    /**
     * ArticleController constructor.
     * @param ArticleService $articleService
     * @param ArticleRepository $articleRepository
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(ArticleService $articleService, ArticleRepository $articleRepository, CategoryRepository $categoryRepository)
    {
        $this->articleService = $articleService;
        $this->articleRepository = $articleRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::with('logotype', 'gallery', 'category')->paginate(config('app.paginate'));
        $best = auth()->user()->favorite->pluck('id')->toArray();

        return view('backend.dashboard.article.index', compact('articles', 'best'));
    }

    /**
     * @param Article $article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Article $article)
    {
        $article->load('logotype');

        return view('backend.dashboard.article.show', compact('article'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categoryRepository->getCategories();
        $nodes = $this->categoryRepository->getRootCategories();
        $title = 'Create new';

        return view('backend.dashboard.article.form', compact('categories', 'nodes', 'title'));
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
        list($status, $message) = $this->articleService->store($request->except('_token'));

        if($status == 'success'){
            return redirect()->route('articles.index')->with($status, $message);
        }else{
            return back()->with($status, $message);
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
        $categories = $this->categoryRepository->getCategories();
        $nodes = $this->categoryRepository->getRootCategories();
        $title = 'Update ';

        return view('backend.dashboard.article.form', compact('categories', 'nodes', 'article', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateArticleRequest $request
     * @param Article $article
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        list($status, $message) = $this->articleService->update($request->except('_token', '_method', 'MAX_FILE_SIZE'), $article);

        if($status == 'success'){
            return redirect()->route('articles.index')->with($status, $message);
        }else{
            return back()->with($status, $message);
        }
    }

    /**
     * @param Article $article
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Article $article)
    {
        list($status, $message) = $this->articleService->destroy($article);

        if($status == 'success'){
            return redirect()->route('articles.index')->with($status, $message);
        }else{
            return back()->with($status, $message);
        }
    }

    /**
     * @param AddImageGalleryRequuest $requuest
     * @return \Illuminate\Http\JsonResponse
     */
    public function addImage(AddImageGalleryRequuest $requuest)
    {
        list($status, $message) = $this->articleService->saveImageGallery($this->articleRepository->getArticleForId($requuest->article), $requuest->file);

        if($status == 'success'){
            return response()->json(['uploaded' => '/upload/'.$status]);
        }else{
            return back()->with($status, $message);
        }
    }

    /**
     * @param DeleteImageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteImage(DeleteImageRequest $request)
    {
        list($status, $message) = $this->articleService->deleteImage($request->all());

        return back()->with($status, $message);
    }

}
