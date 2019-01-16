<?php
/**
 * Created by PhpStorm.
 * User: evnelviv02
 * Date: 2019-01-15
 * Time: 18:12
 */

namespace App\Services;


use App\Models\Comment;

class CommentService
{
    public function store($data)
    {
        $data['author_id'] = auth()->user()->id;

        return Comment::create($data);
    }
}
