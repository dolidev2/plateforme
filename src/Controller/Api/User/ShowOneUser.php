<?php


namespace App\Controller\Api\User;


use App\Manager\UserManager;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ShowOneUser
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
     *     name="user_show_one",
     *     path="/users/{id}",
     *     methods={"GET"},
     *     defaults={
     *         "_api_resource_class"=User::class,
     *         "_api_item_operation_name"="get"
     *     }
     * )
     *
     */
    public function __invoke(Request $request)
    {
        return $this->userManager->showOneUser( $request->attributes->get('id'));
    }
}