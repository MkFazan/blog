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
    /**
     * @return mixed
     */
    public static function getCategories()
    {
        return Category::pluck('name', 'id');
    }

    /**
     * @param bool $paginate
     * @return mixed
     */
    public function getRootCategories($paginate = false)
    {
        if ($paginate){
            return Category::whereIsRoot()->paginate($paginate);
        }else{
            return Category::whereIsRoot()->get();
        }
    }

    /**
     * @param $data
     * @return mixed
     */
    public function store($data)
    {
        return Category::create($data);
    }

    /**
     * @param Category $category
     * @return mixed
     */
    public function getIdChildrenCategoriesForCategory(Category $category)
    {
        return Category::whereDescendantOf($category)->pluck('id')->toArray();
    }
}
