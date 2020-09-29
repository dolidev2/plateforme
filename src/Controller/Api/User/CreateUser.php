<?php


namespace App\Controller\Api\User;


use App\Manager\UserManager;
use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;


class  CreateUser
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
     *     name="user_create",
     *     path="/users",
     *     methods={"POST"},
     *     defaults={
     *         "_api_resource_class"=User::class,
     *         "_api_collection_operation_name"="post"
     *     }
     * )
     */
    public function __invoke(User $data)
    {

      return $this->userManager->registerUser($data);
    }

}