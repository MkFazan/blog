<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Repositories\ArticleRepository;
use App\Services\ArticleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
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
     * Create a new controller instance.
     *
     * @param ArticleService $articleService
     * @param ArticleRepository $articleRepository
     */
    public function __construct(ArticleService $articleService, ArticleRepository $articleRepository)
    {
        $this->middleware('auth');
        $this->articleService = $articleService;
        $this->articleRepository = $articleRepository;
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
        return view('backend.account.blogger.article.index', [
            'articles' => $this->articleRepository->getMyArticle($paginate),
            'title' => 'My articles'
        ]);
    }

    /**
     * @param bool $paginate
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listMyFavoriteArticle($paginate = false)
    {
        return view('backend.account.blogger.article.favorite', [
            'articles' => $this->articleRepository->getMyFavoriteArticle($paginate)->favorite,
            'title' => 'My favorite articles'
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('backend.account.blogger.article.form', [
            'nodes' => Category::whereIsRoot()->get(),
            'title' => 'Create new'
        ]);
    }

    /**
     * @param StoreArticleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreArticleRequest $request)
    {
        DB::beginTransaction();
        try {

           $this->articleService->store($request->except('_token'));
            DB::commit();

            return redirect()->route('my.article')->with('success', 'Successfully created!');

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
        return view('backend.account.blogger.article.form', [
            'nodes' => Category::whereIsRoot()->get(),
            'article' => $article,
            'title' => 'Update '
        ]);
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
        DB::beginTransaction();
        try {
            $this->articleService->update($request->except('_token', '_method', 'MAX_FILE_SIZE'), $article);
            DB::commit();

            return redirect()->route('my.article')->with('success', 'Successfully saved!');

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

            return redirect()->route('my.article')->with('success', 'Article deleted');

        } catch (\Throwable $e) {
            DB::rollback();

            return back()->with('error', 'Error! Not found!');
        }
    }

    /**
     * @param Article $article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Article $article)
    {
        return view('backend.account.blogger.article.show', [
            'article' => $article->load('logotype'),
        ]);
    }
}
