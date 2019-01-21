<?php
/**
 * Created by PhpStorm.
 * User: evnelviv02
 * Date: 2019-01-16
 * Time: 12:53
 */

namespace App\Repositories;


use App\User;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    /**
     * @return mixed
     */
    public function getBloggers()
    {
        return User::with('articles', 'favorite')
            ->whereRole(User::BLOGGER)
            ->select(
                array('*', DB::raw('(SELECT count(*) FROM articles WHERE author_id = users.id) as count_articles'))
            )
            ->orderBy('count_articles','desc')
            ->offset(0)
            ->limit(config('app.count_top_bloggers'))
            ->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getUserForId($id)
    {
        return User::with('articles', 'favorite')->whereId($id)->first();
    }
}
