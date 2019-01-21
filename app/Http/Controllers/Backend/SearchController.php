<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\BasicSearchRequest;
use App\Http\Requests\FilterRequest;
use App\Models\Category;
use App\Repositories\ArticleRepository;
use App\Services\ArticleService;

class SearchController extends Controller
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;
    /**
     * @var ArticleService
     */
    private $articleService;

    /**
     * SearchController constructor.
     * @param ArticleRepository $articleRepository
     * @param ArticleService $articleService
     */
    public function __construct(ArticleRepository $articleRepository, ArticleService $articleService)
    {
        $this->articleRepository = $articleRepository;
        $this->articleService = $articleService;
    }

    /**
     * @param BasicSearchRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function basicSearch(BasicSearchRequest $request)
    {
        $query = $request->q;

        return response()->json($this->articleService->basicSearch($query));
    }

    /**
     * @param FilterRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function filter(FilterRequest $request)
    {
        $articles = $this->articleService->filter($request->all());

        return view('frontend.pages.filter',[
            'articles' => empty($articles) ? null : $articles,
            'favoriteArticles' => $this->articleRepository->getFavoriteArticles(),
            'nodes' => Category::whereIsRoot()->get()
        ]);
    }
}
