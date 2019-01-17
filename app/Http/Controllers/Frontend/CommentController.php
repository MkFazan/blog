<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Services\CommentService;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * @var CommentService
     */
    private $commentService;

    /**
     * CommentController constructor.
     * @param CommentService $commentService
     */
    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCommentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->commentService->store($request->except('_token'));

            DB::commit();

            return back()->with('success', 'Comment saved');

        } catch (\Throwable $e) {
            DB::rollback();

            return back()->with('error', 'Error! Not found!');
        }
    }
}
