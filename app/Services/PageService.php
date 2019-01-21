<?php
/**
 * Created by PhpStorm.
 * User: evnelviv02
 * Date: 2019-01-16
 * Time: 10:38
 */

namespace App\Services;


use App\Models\Page;
use App\Repositories\PageRepository;
use Illuminate\Support\Facades\DB;

class PageService
{
    /**
     * @var PageRepository
     */
    private $pageRepository;

    /**
     * PageService constructor.
     * @param PageRepository $pageRepository
     */
    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * @param $data
     * @return array
     */
    public function store($data)
    {
        DB::beginTransaction();
        try {
            $this->pageRepository->store($data);

            DB::commit();

            return ['success', 'Successfully created!'];

        } catch (\Throwable $e) {
            DB::rollback();

            return ['error', 'Error!' . $e];
        }
    }

    /**
     * @param Page $page
     * @param $data
     * @return array
     */
    public function update(Page $page, $data)
    {
        DB::beginTransaction();
        try {
            $data['status'] = isset($data['status']) ? $data['status'] : 0;

            $page->update($data);

            DB::commit();

            return ['success', 'Successfully updated!'];

        } catch (\Throwable $e) {
            DB::rollback();

            return ['error', 'Error!' . $e];
        }
    }

    /**
     * @param Page $page
     * @return array
     */
    public function destroy(Page $page)
    {
        DB::beginTransaction();
        try {
            $page->delete();

            DB::commit();

            return ['success', 'Successfully updated!'];

        } catch (\Throwable $e) {
            DB::rollback();

            return ['error', 'Error!' . $e];
        }
    }
}
