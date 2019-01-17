<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Repositories\CommentRepository;
use App\Services\CommentService;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * @var CommentRepository
     */
    private $commentRepository;
    /**
     * @var CommentService
     */
    private $commentService;

    /**
     * CommentController constructor.
     * @param CommentRepository $commentRepository
     * @param CommentService $commentService
     */
    public function __construct(CommentRepository $commentRepository, CommentService $commentService)
    {
        $this->commentRepository = $commentRepository;
        $this->commentService = $commentService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.dashboard.comment.index', [
            'comments' => $this->commentRepository->getAllComments(),
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function moderation()
    {
        return view('backend.dashboard.comment.index', [
            'comments' => $this->commentRepository->getCommentForModerations(),
            'moderation' => true
        ]);
    }

    /**
     * @param Comment $comment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(Comment $comment)
    {
        DB::beginTransaction();
        try {
            $this->commentRepository->approve($comment);

            DB::commit();

            return back()->with('success', 'Comment approved!');

        } catch (\Throwable $e) {
            DB::rollback();

            return back()->with('error', 'Error! Not found!');
        }
    }

    /**
     * @param Comment $comment
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Comment $comment)
    {
        DB::beginTransaction();
        try {
            $this->commentService->delete($comment);

            DB::commit();

            return back()->with('success', 'Comment deleted!');

        } catch (\Throwable $e) {
            DB::rollback();

            return back()->with('error', 'Error! Not found!');
        }
    }
}
