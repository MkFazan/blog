<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.dashboard.category.index', [
            'categories' => Category::whereParentId(null)->paginate(config('app.paginate')),
//            'nodes' => Category::get()->toTree()

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.dashboard.category.form', [
            'categories' => Category::whereParentId(null)->pluck('name', 'id'),
            'title' => 'Create new'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
//        dd($request->except('_token'));
        Category::create($request->except('_token'));

        return redirect()->route('categories.index')->with('success', 'Successfully created!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('faq::category.edit', [
            'category' => $category,
            'categories' => [null => 'Root'] + $this->faqServices->listCategoryTree('line')
        ]);
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
        $this->faqServices->updateCategory($category, $request->except('_token', '_method'));

        return redirect()->route('faq.categories.index')->with('success', 'Successfully saved!');
    }

    /**
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        if ($this->validateForDeleted($category)) {
            $category->delete();

            return redirect()->route('faq.categories.index')->with('success', 'Successfully deleted!');
        } else {
            return back()->with('error', 'Category can not be deleted because it has articles');
        }
    }

    /**
     * @param $category
     * @return bool
     */
    public function validateForDeleted($category)
    {
        $category->load('articles');

        if (count($category->articles) == 0 || count($category->descendants)) {
            $validation = true;
            foreach ($category->descendants as $child) {
                $status = $this->getArticleForCategory($child);
                if (count($status)) {
                    $validation = false;
                    break;
                } else {
                    $validation = true;
                }
            }
            return $validation;
        } else {
            return false;
        }
    }
}
