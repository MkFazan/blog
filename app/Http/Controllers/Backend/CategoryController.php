<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    /**
     * @var CategoryService
     */
    private $categoryService;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * CategoryController constructor.
     * @param CategoryService $categoryService
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryService $categoryService, CategoryRepository $categoryRepository)
    {
        $this->categoryService = $categoryService;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryRepository->getRootCategories(config('app.paginate'));
        $nodes = $this->categoryRepository->getRootCategories();

        return view('backend.dashboard.category.index', compact('categories', 'nodes'));
    }

    /**
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Category $category)
    {
        $nodes = $this->categoryRepository->getRootCategories();

        return view('backend.dashboard.category.show', compact('category', 'nodes'));
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

        return view('backend.dashboard.category.form', compact('categories', 'nodes', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        list($status, $message) = $this->categoryService->store($request->except('_token'));

        return redirect()->route('categories.index')->with($status, $message);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $categories = $this->categoryRepository->getCategories();
        $nodes = $this->categoryRepository->getRootCategories();
        $children = $this->categoryRepository->getIdChildrenCategoriesForCategory($category);
        $title = 'Update ';

        return view('backend.dashboard.category.form', compact('categories', 'nodes', 'title', 'children', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategoryRequest $request, Category $category)
    {
        list($status, $message) = $this->categoryService->update($category, $request->except('_token', '_method'));

        return redirect()->route('categories.index')->with($status, $message);
    }

    /**
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        list($status, $message) = $this->categoryService->destroy($category);

        if ($status == 'success'){
            return redirect()->route('categories.index')->with($status, $message);
        }else{
            return back()->with($status, $message);
        }
    }
}
