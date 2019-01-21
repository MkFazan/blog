<?php
/**
 * Created by PhpStorm.
 * User: evnelviv02
 * Date: 2019-01-15
 * Time: 18:12
 */

namespace App\Repositories;


use App\Models\Comment;

class CommentRepository
{
    /**
     * @return mixed
     */
    public function getAnswers()
    {
        return Comment::with('author')
            ->where('parent_id', '!=', null)
            ->whereStatus(STATUS_ACTIVE)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function store($data)
    {
        return Comment::create($data);
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllComments()
    {
        return Comment::with('author')
            ->paginate(config('app.paginate'));
    }

    /**
     * @return mixed
     */
    public function getCommentForModerations()
    {
        return Comment::with('author')
            ->whereStatus(STATUS_DISABLED)
            ->paginate(config('app.paginate'));
    }

    /**
     * @param Comment $comment
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Comment $comment)
    {
        return $comment->delete();
    }

    /**
     * @param Comment $comment
     * @return bool
     */
    public function approve(Comment $comment)
    {
        return $comment->update(['status' => STATUS_ACTIVE]);
    }

    /**
     * @param Comment $comment
     * @return mixed
     */
    public function deleteChildComments(Comment $comment)
    {
        return Comment::whereParentId($comment->id)->delete();
    }

    /**
     * @param $user
     * @return mixed
     */
    public function deleteAllCommentsAndTheirResponsesForUser($user)
    {
        $comments = Comment::where('author_id', $user)->pluck('id')->toArray();

        return Comment::whereIn('id', $comments)->orWhereIn('parent_id', $comments)->delete();
    }

    /**
     * @param $article
     * @return mixed
     */
    public function deleteAllCommentsForArticle($article)
    {
        return Comment::where('article_id', $article)->delete();
    }
}
