<?php

namespace App\Service;

use App\Repository\UserRepository;
use App\Repository\FactureRepository;

class DirectionService {

    private $factureRepository;
    private $userRepository;
    
    public function __construct(FactureRepository $factureRepository,UserRepository $userRepository) {
       
        $this->factureRepository = $factureRepository;
        $this->userRepository = $userRepository;

    }

    public function FactureFromPaoUser($service,$type)
    {
        $user = $this->afficherUserDirection($service);
        $data = [];

        foreach ($user as $us){
            $item = array(
                'user' => $us,
                'creation' => $this->afficherFactureByUser($us->getId(),$type),
            );
            array_push($data, $item);
        }
        return $data; 
    }

    public function afficherUserDirection($service)
    {
      return $this->userRepository->findUserDirection($service);
    }


    public function afficherFactureByUser($user,$type)
    {
        return $this->creationRepository->findFactureByUser($user,$type);     
    }

    public function dateConvertToTwoDate($date){

        $dateExplode = explode("-",$date);
        $year = $dateExplode[0];
        $month =  $dateExplode[1];
        $dateDebut=  $year.'-'. $month.'-1 00:00:00';
        $dateFin=  $year.'-'. $month.'-31 23:59:59';
       
        
        return 
        [
            'debut'=>$dateDebut,
            'fin'=>$dateFin,
        ];

    }
    public function afficherFacture($type, $date)
    {
       $dateConvert = $this->dateConvertToTwoDate($date);
       return $this->factureRepository->findFactureOrder($type,$dateConvert['debut'],$dateConvert['fin']);
    }


  
   

   

}