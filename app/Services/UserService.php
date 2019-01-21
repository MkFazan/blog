<?php
/**
 * Created by PhpStorm.
 * User: evnelviv02
 * Date: 2019-01-16
 * Time: 12:53
 */

namespace App\Services;


use App\Repositories\ArticleRepository;
use App\Repositories\UserRepository;

class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param ArticleRepository $articleRepository
     */
    public function __construct(UserRepository $userRepository, ArticleRepository $articleRepository)
    {
        $this->userRepository = $userRepository;
        $this->articleRepository = $articleRepository;
    }

    /**
     * @param $data
     * @return string
     */
    public function deleteAllInformationForUser($data)
    {
        $user = $this->userRepository->getUserForId($data['user_id']);
        $articles = $user->articles->pluck('id')->toArray();
        $this->articleRepository->deleteArticles($articles);
        $this->articleRepository->deleteAllFavoriteForArticles($articles);
        $this->articleRepository->deleteAllFavoriteForUser($user->id);
        $this->articleRepository->deleteImageRelationsToArticles($articles);
        $user->delete();

        return 'Success delete all information in user!';
    }
}
