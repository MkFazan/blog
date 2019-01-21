<?php
/**
 * Created by PhpStorm.
 * User: evnelviv02
 * Date: 2019-01-16
 * Time: 10:38
 */

namespace App\Repositories;


use App\Models\Page;

class PageRepository
{
    /**
     * @return mixed
     */
    public static function getPageActive()
    {
        return Page::whereStatus(STATUS_ACTIVE)->pluck('name', 'slug');
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function getPageForSlug($slug)
    {
        return Page::whereSlug($slug)->first();
    }

    /**
     * @param $paginate
     * @return mixed
     */
    public function getPages($paginate)
    {
        return Page::paginate($paginate);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function store($data)
    {
        return Page::create($data);
    }

}
