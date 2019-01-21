<?php
/**
 * Created by PhpStorm.
 * User: evnelviv02
 * Date: 2019-01-16
 * Time: 10:44
 */

namespace App\Services;


use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    private $categoryRepository;

    /**
     * CategoryService constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function store($data)
    {
        DB::beginTransaction();
        try {
            $this->categoryRepository->store($data);
            DB::commit();

            return ['success', 'Category store'];
        } catch (\Throwable $e) {
            DB::rollback();

            return ['error', 'Error! Not found!'];
        }
    }

    /**
     * @param Category $category
     * @param $data
     * @return array
     */
    public function update(Category $category, $data)
    {
        DB::beginTransaction();
        try {
            $category->update($data);
            DB::commit();

            return ['success', 'Category updated'];
        } catch (\Throwable $e) {
            DB::rollback();

            return ['error', 'Error! Not found!'];
        }
    }

    /**
     * @param $category
     * @return bool
     */
    public function validateForDeleted($category)
    {
        $category->load('article');

        if (count($category->article) == 0 || count($category->descendants)) {
            $validation = true;
            foreach ($category->descendants as $child) {
                $status = $this->getArticleForCategory($child);
                if (count($status)) {
                    $validation = false;
                    break;
                } else {
                    $validation = true;
                }
            }
            return $validation;
        } else {
            return false;
        }
    }

    /**
     * @param $category
     * @return mixed
     */
    public function getArticleForCategory($category)
    {
        $category->load('article');

        return $category->article;
    }

    /**
     * @param Category $category
     * @return array
     */
    public function destroy(Category $category)
    {
        DB::beginTransaction();
        try {
            if ($this->validateForDeleted($category)) {
                $category->delete();
                DB::commit();

                return ['success', 'Category delete!'];
            } else {
                DB::rollback();

                return ['error', 'Category can not be deleted because it has articles'];
            }
        } catch (\Throwable $e) {
            DB::rollback();

            return ['error', 'Error! Not found!'];
        }
    }
}
