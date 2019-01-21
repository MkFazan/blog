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
        $this->commentRepository->deleteAllCommentsAndTheirResponsesForUser($user->id);
        $user->delete();

        return 'Success delete all information in user!';
    }
}
