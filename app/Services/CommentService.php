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
        $data['author_id'] = auth()->user()->id;

        return $this->commentRepository->store($data);
    }

    /**
     * @param Comment $comment
     * @return string
     * @throws \Exception
     */
    public function delete(Comment $comment)
    {
        $this->commentRepository->deleteChildComments($comment);
        $this->commentRepository->delete($comment);

        return 'success';
    }
}
