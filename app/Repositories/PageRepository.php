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
    public static function getPageActive()
    {
        return Page::whereStatus(STATUS_ACTIVE)->pluck('name', 'id');
    }
}
