<?php
/**
 * Created by PhpStorm.
 * User: evnelviv02
 * Date: 2019-01-16
 * Time: 12:53
 */

namespace App\Services;


use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    private $userRepository;
    private $articleRepository;
    private $commentRepository;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param ArticleRepository $articleRepository
     * @param CommentRepository $commentRepository
     */
    public function __construct(UserRepository $userRepository, ArticleRepository $articleRepository, CommentRepository $commentRepository)
    {
        $this->userRepository = $userRepository;
        $this->articleRepository = $articleRepository;
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param $data
     * @return array
     */
    public function deleteAllInformationForUser($data)
    {
        DB::beginTransaction();
        try {
            if (Hash::check($data['password'], auth()->user()->password)){
                $user = $this->userRepository->getUserForId($data['user_id']);
                $articles = $user->articles->pluck('id')->toArray();
                $this->articleRepository->deleteArticles($articles);
                $this->articleRepository->deleteAllFavoriteForArticles($articles);
                $this->articleRepository->deleteAllFavoriteForUser($user->id);
                $this->articleRepository->deleteImageRelationsToArticles($articles);
                $this->commentRepository->deleteAllCommentsAndTheirResponsesForUser($user->id);
                $user->delete();

                DB::commit();

                return ['success', 'Success delete all information in user!'];
            }else{
                DB::commit();

                return ['error', 'wrong password'];
            }
        } catch (\Throwable $e) {
            DB::rollback();

            return ['error', 'Error! Not found!'];
        }
    }

    /**
     * @param User $user
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        DB::beginTransaction();
        try {
            $user->load('articles', 'favorite');

            if (count($user->articles) > 0 or count($user->favorite) > 0)
            {
                return ['redirect', ''];
            }
            $user->delete();

            DB::commit();

            return ['success', 'Used deleted!'];

        } catch (\Throwable $e) {
            DB::rollback();

            return ['error', 'Error!' . $e];
        }
    }

    /**
     * @param $data
     * @return array
     */
    public function store($data)
    {
        DB::beginTransaction();
        try {
            $data['password'] = Hash::make($data['password']);
            $this->userRepository->store($data);

            DB::commit();

            return ['success', 'User created!'];

        } catch (\Throwable $e) {
            DB::rollback();

            return ['error', 'Error! Not found!'];
        }
    }

    /**
     * @param User $user
     * @param $data
     * @return array
     */
    public function update(User $user, $data)
    {
        DB::beginTransaction();
        try {
            if (Hash::check($data['current_password'], $user->password)){

                $data['status'] = isset($data['status']) ? $data['status'] : 0;

                $user->update($data);

                DB::commit();

                return ['success', 'User created!'];
            }else{
                return ['error', 'Error! Current password failed!'];
            }
        } catch (\Throwable $e) {
            DB::rollback();

            return ['error', 'Error!' . $e];
        }
    }
}
