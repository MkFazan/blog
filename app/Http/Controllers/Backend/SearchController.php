<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\BasicSearchRequest;
use App\Http\Requests\FilterRequest;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Services\ArticleService;

class SearchController extends Controller
{
    private $articleRepository;
    private $articleService;
    private $categoryRepository;

    /**
     * SearchController constructor.
     * @param ArticleRepository $articleRepository
     * @param ArticleService $articleService
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(ArticleRepository $articleRepository, ArticleService $articleService, CategoryRepository $categoryRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->articleService = $articleService;
        $this->categoryRepository = $categoryRepository;
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
        $favoriteArticles = $this->articleRepository->getFavoriteArticles();
        $nodes = $this->categoryRepository->getRootCategories();

        return view('frontend.pages.filter', compact('articles', 'favoriteArticles', 'nodes'));
    }
}
