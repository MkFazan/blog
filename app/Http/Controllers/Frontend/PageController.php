<?php

namespace App\Http\Controllers\Frontend;

use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\PageRepository;
use App\Repositories\UserRepository;
use App\Services\PageService;
use App\Http\Controllers\Controller;

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

    public function home(){
        return view('frontend.pages.home',[
            'pages' => $this->pageRepository->getPageActive(),
            'categories' => $this->categoryRepository->getCategories(),
            'bestArticles' => $this->articleRepository->getBestArticles(),
            'bloggers' => $this->userRepository->getBloggers()
        ]);
    }
}
