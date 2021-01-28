<?php

namespace App\Service;

use App\Repository\CreationRepository;
use App\Repository\UserRepository;

class PaoService {

    private $creationRepository;
    private $userRepository;
    
    public function __construct(CreationRepository $creationRepository,UserRepository $userRepository) {
       
        $this->creationRepository = $creationRepository;
        $this->userRepository = $userRepository;

    }

    public function afficherCreations($type)
    {
       return $this->creationRepository->findCreationOrder($type);
    }


    public function afficherUserPao($service)
    {
      return $this->userRepository->findUserPao($service);
    }

    public function afficherCreationsByUser($user)
    {
        return $this->creationRepository->findCreationByUser($user);
              
    }

    public function CreationsFromPaoUser($service)
    {
        $user = $this->afficherUserPao($service);
        $data = [];

        foreach ($user as $us){

            $item = array(
                'user' => $us,
                'creation' => $this->afficherCreationsByUser($us->getId()),
            );
            array_push($data, $item);
        }

        return $data;
              
    }
 
 

}