<?php


namespace App\Controller\Api\User;


use App\Entity\User;
use App\Manager\UserManager;
use Symfony\Component\Routing\Annotation\Route;

class UpdateUser
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
     *     name="user_update",
     *     path="/users/{id}",
     *     methods={"PUT"},
     *     defaults={
     *         "_api_resource_class"=User::class,
     *         "_api_item_operation_name"="put"
     *     }
     * )
     * @param User $data
     * @return mixed
     */
    public function __invoke(User $data)
    {
        return $this->userManager->updateUser($data);
    }
}