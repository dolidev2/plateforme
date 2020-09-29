<?php


namespace App\Controller\Api\User;

use App\Manager\UserManager;
use Symfony\Component\Routing\Annotation\Route;

class ShowUser
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
     *     name="user_show",
     *     path="/users",
     *     methods={"GET"},
     *     defaults={
     *         "_api_resource_class"=User::class,
     *         "_api_collection_operation_name"="get"
     *     }
     * )
     * @return mixed
     */
    public function __invoke()
    {
        return $this->userManager->showUser();
    }

}