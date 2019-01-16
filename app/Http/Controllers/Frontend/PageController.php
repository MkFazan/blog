<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Article;
use App\Models\Category;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\PageRepository;
use App\Repositories\UserRepository;
use App\Services\PageService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class PageController extends Controller
{
    /**
     * @var PageService
     */
    private $pageService;
    /**
     * @var PageRepository
     */
    private $pageRepository;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var ArticleRepository
     */
    private $articleRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * PageController constructor.
     * @param PageService $pageService
     * @param PageRepository $pageRepository
     * @param CategoryRepository $categoryRepository
     * @param ArticleRepository $articleRepository
     * @param UserRepository $userRepository
     */
    public function __construct(PageService $pageService, PageRepository $pageRepository, CategoryRepository $categoryRepository, ArticleRepository $articleRepository, UserRepository $userRepository)
    {
        $this->pageService = $pageService;
        $this->pageRepository = $pageRepository;
        $this->categoryRepository = $categoryRepository;
        $this->articleRepository = $articleRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home(){
        return view('frontend.pages.home',[
            'pages' => $this->pageRepository->getPageActive(),
            'categories' => $this->categoryRepository->getCategories(),
            'bestArticles' => $this->articleRepository->getBestArticles(),
            'bloggers' => $this->userRepository->getBloggers()
        ]);
    }

    /**
     * @param bool $paginate
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function categories($paginate = false)
    {
        return view('frontend.pages.category',[
            'articles' => $this->articleRepository->getArticlesForCategory($paginate ? $paginate : config('app.paginate'), false),
            'favoriteArticles' => $this->articleRepository->getFavoriteArticles(),

            'categories' => $this->categoryRepository->getCategories(),
            'pages' => $this->pageRepository->getPageActive(),
            'paginate' => $paginate ? $paginate : config('app.paginate'),
            'route' => Route::currentRouteName()
        ]);
    }

    /**
     * @param Category $category
     * @param bool $paginate
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category(Category $category, $paginate = false)
    {
        return view('frontend.pages.category',[
            'category' => $category,
            'articles' => $this->articleRepository->getArticlesForCategory($paginate ? $paginate : config('app.paginate'), $category->id),
            'favoriteArticles' => $this->articleRepository->getFavoriteArticles(),

            'categories' => $this->categoryRepository->getCategories(),
            'pages' => $this->pageRepository->getPageActive(),
            'paginate' => $paginate ? $paginate : config('app.paginate'),
            'route' => Route::currentRouteName()
        ]);
    }

    /**
     * @param Article $article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function article(Article $article)
    {
        return view('frontend.pages.article',[
            'article' => $article->load('gallery', 'logotype', 'author', 'category', 'comments', 'comments.author', 'comments.answer'),
            'favoriteArticles' => $this->articleRepository->getFavoriteArticles(),

            'categories' => $this->categoryRepository->getCategories(),
            'pages' => $this->pageRepository->getPageActive(),
        ]);
    }

}
