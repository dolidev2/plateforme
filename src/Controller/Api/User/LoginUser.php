<?php


namespace App\Controller\Api\User;

use App\Entity\User;
use App\Manager\UserManager;
use Symfony\Component\Routing\Annotation\Route;

class LoginUser
{
    /**
     * @var UserManager
     */
    protected $userManager;

    /**
     * CreateUser constructor.
     * @param UserManager $userManager
     */
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @Route(
     *     name="user_login",
     *     path="/users/login",
     *     methods={"POST"},
     *     defaults={
     *         "_api_resource_class"=User::class,
     *         "_api_collection_operation_name"="login"
     *     }
     * )
     */
    public function __invoke(User $data)
    {
        return $this->userManager->loginUser($data);
    }

}