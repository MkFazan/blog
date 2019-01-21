<?php
/**
 * Created by PhpStorm.
 * User: evnelviv02
 * Date: 2019-01-15
 * Time: 18:12
 */

namespace App\Services;


use App\Models\Comment;
use App\Repositories\CommentRepository;
use Illuminate\Support\Facades\DB;

class CommentService
{
    /**
     * @var CommentRepository
     */
    private $commentRepository;

    /**
     * CommentService constructor.
     * @param CommentRepository $commentRepository
     */
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function store($data)
    {
        DB::beginTransaction();
        try {
            $data['author_id'] = auth()->user()->id;
            $this->commentRepository->store($data);

            DB::commit();

            return ['success', 'Comment saved'];

        } catch (\Throwable $e) {
            DB::rollback();

            return ['error', 'Error! Not found!'];
        }

    }

    /**
     * @param Comment $comment
     * @return array
     */
    public function delete(Comment $comment)
    {
        DB::beginTransaction();
        try {
            $this->commentRepository->deleteChildComments($comment);
            $this->commentRepository->delete($comment);

            DB::commit();

            return ['success', 'Comment deleted!'];

        } catch (\Throwable $e) {
            DB::rollback();

            return ['error', 'Error! Not found!'];
        }
    }

    /**
     * @param Comment $comment
     * @return array
     */
    public function approve(Comment $comment)
    {
        DB::beginTransaction();
        try {
            $this->commentRepository->approve($comment);

            DB::commit();

            return ['success', 'Comment approved!'];

        } catch (\Throwable $e) {
            DB::rollback();

            return ['error', 'Error! Not found!'];
        }
    }
}
