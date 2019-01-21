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
    public function home(){
        return view('frontend.pages.home',[
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

            'paginate' => $paginate ? $paginate : config('app.paginate'),
            'route' => false
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

            'paginate' => $paginate ? $paginate : config('app.paginate'),
            'route' => $category->id
        ]);
    }

    /**
     * @param Article $article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function article(Article $article)
    {
        return view('frontend.pages.article',[
            'article' => $article->load('gallery', 'logotype', 'author', 'category', 'comments', 'comments.author'),
            'favoriteArticles' => $this->articleRepository->getFavoriteArticles(),
            'answerComments' => $this->commentRepository->getAnswers(),
        ]);
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function page($slug)
    {
        return view('frontend.pages.page_template',[
            'page' => $this->pageRepository->getPageForSlug($slug)
        ]);
    }

}
