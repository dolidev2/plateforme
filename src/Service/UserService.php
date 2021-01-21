<?php


namespace App\Service;


use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class UserService
{

    private $user;
    private $session;
    private $dossierService;

    public function __construct(UserRepository $userRepository,SessionInterface $session,DossierService $dossierService)
    {
        $this->user = $userRepository;
        $this->dossierService = $dossierService;
        $this->session = $session;
    }

    public function userSession($user){

        return   $this->session->set('user',$user);
    }

    public function dossierSession(){

        return   $this->session->set('dossier',$this->dossierService->bilanDossier());
    }


    public function userInfo()
    {
       return $this->user->findUserInfo();
      
    }

}