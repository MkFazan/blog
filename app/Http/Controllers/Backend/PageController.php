<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePageRequest;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.dashboard.page.index', [
            'pages' => Page::paginate(config('app.paginate')),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.dashboard.page.form', [
            'title' => 'Create ',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePageRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePageRequest $request)
    {
        $data = $request->except('_token', '_method');
        dd($data);
        DB::beginTransaction();
        try {
            Page::create($data);

            DB::commit();

            return redirect()->route('pages.index')->with('success', 'Successfully created!');

        } catch (\Throwable $e) {
            DB::rollback();

            return back()->with('error', 'Error!' . $e);
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
        return view('backend.dashboard.page.show', [
            'page' => $page
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Page $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return view('backend.dashboard.page.form', [
            'title' => 'Edit ',
            'page' => $page
        ]);
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
        $data = $request->except('_token', '_method');

        DB::beginTransaction();
        try {
            $data['status'] = isset($data['status']) ? $data['status'] : 0;

            $page->update($data);

            DB::commit();

            return redirect()->route('pages.index')->with('success', 'Successfully updated!');

        } catch (\Throwable $e) {
            DB::rollback();

            return back()->with('error', 'Error!' . $e);
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
        DB::beginTransaction();
        try {
            $page->delete();

            DB::commit();

            return redirect()->route('pages.index')->with('success', 'Successfully updated!');

        } catch (\Throwable $e) {
            DB::rollback();

            return back()->with('error', 'Error!' . $e);
        }
    }
}
