<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePageRequest;
use App\Models\Page;
use App\Repositories\PageRepository;
use App\Services\PageService;

class PageController extends Controller
{
    private $pageRepository;
    private $pageService;

    /**
     * PageController constructor.
     * @param PageRepository $pageRepository
     * @param PageService $pageService
     */
    public function __construct(PageRepository $pageRepository, PageService $pageService)
    {
        $this->pageRepository = $pageRepository;
        $this->pageService = $pageService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = $this->pageRepository->getPages(config('app.paginate'));

        return view('backend.dashboard.page.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create ';

        return view('backend.dashboard.page.form', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePageRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePageRequest $request)
    {
        list($status, $message) = $this->pageService->store($request->except('_token', '_method'));

        if ($status == 'success'){
            return redirect()->route('pages.index')->with($status, $message);
        }else{
            return back()->with($status, $message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Page $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        return view('backend.dashboard.page.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Page $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        $title = 'Edit ';

        return view('backend.dashboard.page.form', compact('title', 'page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StorePageRequest $request
     * @param Page $page
     * @return \Illuminate\Http\Response
     */
    public function update(StorePageRequest $request, Page $page)
    {
        list($status, $message) = $this->pageService->update($page, $request->except('_token', '_method'));

        if ($status == 'success'){
            return redirect()->route('pages.index')->with($status, $message);
        }else{
            return back()->with($status, $message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Page $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        list($status, $message) = $this->pageService->destroy($page);

        if ($status == 'success'){
            return redirect()->route('pages.index')->with($status, $message);
        }else{
            return back()->with($status, $message);
        }
    }
}
