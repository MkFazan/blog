<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Services\ArticleService;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    private $articleService;
    private $articleRepository;
    private $categoryRepository;

    /**
     * Create a new controller instance.
     *
     * @param ArticleService $articleService
     * @param ArticleRepository $articleRepository
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(ArticleService $articleService, ArticleRepository $articleRepository, CategoryRepository $categoryRepository)
    {
        $this->middleware('auth');
        $this->articleService = $articleService;
        $this->articleRepository = $articleRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('backend.account.index');
    }

    /**
     * @param bool $paginate
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listMyArticle($paginate = false)
    {
        $articles = $this->articleRepository->getMyArticle($paginate);
        $title = 'My articles';

        return view('backend.account.blogger.article.index', compact('articles', 'title', 'paginate'));
    }

    /**
     * @param Article $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatusFavorite(Article $article)
    {
        list($status, $message) = $this->articleService->changeFavoriteStatus($article);

        return back()->with($status, $message);
    }

    /**
     * @param bool $paginate
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listMyFavoriteArticle($paginate = false)
    {
        $articles = $this->articleRepository->getMyFavoriteArticle($paginate);
        $title = 'My favorite articles';

        return view('backend.account.blogger.article.favorite', compact('articles', 'title', 'paginate'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = 'Create new';
        $nodes = $this->categoryRepository->getRootCategories();

        return view('backend.account.blogger.article.form', compact('title', 'nodes'));
    }

    /**
     * @param StoreArticleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreArticleRequest $request)
    {
        list($status, $message) = $this->articleService->store($request->except('_token'));

        if($status == 'success'){
            return redirect()->route('my.article')->with($status, $message);
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
        $title = 'Update ';
        $nodes = $this->categoryRepository->getRootCategories();

        return view('backend.account.blogger.article.form', compact('title', 'nodes', 'article'));
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
            return redirect()->route('my.article')->with($status, $message);
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
            return redirect()->route('my.article')->with($status, $message);
        }else{
            return back()->with($status, $message);
        }
    }

    /**
     * @param Article $article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Article $article)
    {
        $article->load('logotype');

        return view('backend.account.blogger.article.show', compact('article'));
    }
}
