<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Repositories\CommentRepository;
use App\Services\CommentService;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    private $commentRepository;
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
        $comments = $this->commentRepository->getAllComments();

        return view('backend.dashboard.comment.index', compact('comments'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function moderation()
    {
        $comments = $this->commentRepository->getCommentForModerations();
        $moderation = true;

        return view('backend.dashboard.comment.index', compact('moderation', 'comments'));
    }

    /**
     * @param Comment $comment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(Comment $comment)
    {
        list($status, $message) =  $this->commentService->approve($comment);

        return back()->with($status, $message);
    }

    /**
     * @param Comment $comment
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Comment $comment)
    {
        list($status, $message) =  $this->commentService->delete($comment);

        return back()->with($status, $message);
    }
}
