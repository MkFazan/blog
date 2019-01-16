<?php
/**
 * Created by PhpStorm.
 * User: evnelviv02
 * Date: 2019-01-16
 * Time: 12:53
 */

namespace App\Repositories;


use App\User;

class UserRepository
{
    /**
     * @return mixed
     */
    public function getBloggers()
    {
        return User::with('articles', 'favorite')->whereRole(User::BLOGGER)->get();
    }
}
