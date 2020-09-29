<?php

namespace App\Controller\Api\User;


use App\Entity\User;
use App\Manager\UserManager;

class PasswordResetUser
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
     * @param User $data
     * @return array|string[]
     */
    public function __invoke(User $data)
    {
        return $this->userManager->passwordReset($data);
    }
}