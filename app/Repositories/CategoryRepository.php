<?php
/**
 * Created by PhpStorm.
 * User: evnelviv02
 * Date: 2019-01-16
 * Time: 10:44
 */

namespace App\Repositories;


use App\Models\Category;

class CategoryRepository
{
    public static function getCategories()
    {
        return Category::pluck('name', 'id');
    }
}
