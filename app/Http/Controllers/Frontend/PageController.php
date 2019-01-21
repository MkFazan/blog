<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Article;
use App\Models\Category;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CommentRepository;
use App\Repositories\PageRepository;
use App\Repositories\UserRepository;
use App\Services\PageService;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    private $pageService;
    private $pageRepository;
    private $categoryRepository;
    private $articleRepository;
    private $userRepository;
    private $commentRepository;

    /**
     * PageController constructor.
     * @param PageService $pageService
     * @param PageRepository $pageRepository
     * @param CategoryRepository $categoryRepository
     * @param ArticleRepository $articleRepository
     * @param UserRepository $userRepository
     * @param CommentRepository $commentRepository
     */
    public function __construct(
        PageService $pageService,
        PageRepository $pageRepository,
        CategoryRepository $categoryRepository,
        ArticleRepository $articleRepository,
        UserRepository $userRepository,
        CommentRepository $commentRepository
    )
    {
        $this->pageService = $pageService;
        $this->pageRepository = $pageRepository;
        $this->categoryRepository = $categoryRepository;
        $this->articleRepository = $articleRepository;
        $this->userRepository = $userRepository;
        $this->commentRepository = $commentRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home()
    {
        $bestArticles = $this->articleRepository->getBestArticles();
        $bloggers = $this->userRepository->getBloggers();

        return view('frontend.pages.home', compact('bestArticles', 'bloggers'));
    }

    /**
     * @param bool $paginate
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function categories($paginate = false)
    {
        $articles = $this->articleRepository->getArticlesForCategory($paginate ? $paginate : config('app.paginate'), false);
        $favoriteArticles = $this->articleRepository->getFavoriteArticles();
        $paginate = $paginate ? $paginate : config('app.paginate');
        $route = false;

        return view('frontend.pages.category', compact('articles', 'favoriteArticles', 'paginate', 'route'));
    }

    /**
     * @param Category $category
     * @param bool $paginate
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category(Category $category, $paginate = false)
    {
        $articles = $this->articleRepository->getArticlesForCategory($paginate ? $paginate : config('app.paginate'), $category->id);
        $favoriteArticles = $this->articleRepository->getFavoriteArticles();
        $paginate = $paginate ? $paginate : config('app.paginate');
        $route = $category->id;

        return view('frontend.pages.category', compact('articles', 'favoriteArticles', 'paginate', 'route', 'category'));
    }

    /**
     * @param Article $article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function article(Article $article)
    {
        $article = $article->load('gallery', 'logotype', 'author', 'category', 'comments', 'comments.author');
        $favoriteArticles = $this->articleRepository->getFavoriteArticles();
        $answerComments = $this->commentRepository->getAnswers();

        return view('frontend.pages.article', compact('article', 'favoriteArticles', 'answerComments'));
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function page($slug)
    {
        $page = $this->pageRepository->getPageForSlug($slug);

        return view('frontend.pages.page_template', compact('page'));
    }

}
