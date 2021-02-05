<?php

namespace App\Service;

use App\Repository\ProgrammeMarketingRepository;
use App\Repository\TacheMarketingRepository;
use App\Repository\UserRepository;

class MarketingService {
    private $userRepository;
    private $programmeRepository;
    private $tacheRepository;

    public function __construct(UserRepository $userRepository, ProgrammeMarketingRepository $programmeMarketingRepository,
                                TacheMarketingRepository $tacheMarketingRepository)
    {
        $this->userRepository = $userRepository;
        $this->programmeRepository = $programmeMarketingRepository;
        $this->tacheRepository = $tacheMarketingRepository;
    }

    public function afficherTacheProgrammeByResponsable($programme)
    {
        $data = [
            'Abraham'=>[],
            'Leila'=>[],
            'Elsa'=>[],
            'Ibrahim'=>[],
            'Stéphan'=>[],
            'Awa'=>[],
        ];
        $taches = $this->afficherTacheByPogramme($programme);
        foreach($taches as $th)
        {
            if( $th->getResponsable() == "Abraham")
                array_push($data['Abraham'],$th);

            elseif($th->getResponsable() == "Leila")
                array_push($data['Leila'],$th);

            elseif($th->getResponsable() == "Elsa")
                array_push($data['Elsa'],$th);

            elseif($th->getResponsable() == "Ibrahim")
                array_push($data['Ibrahim'],$th);

            elseif($th->getResponsable() == "Stéphan")
                array_push($data['Stéphan'],$th);
                
            elseif($th->getResponsable() == "Awa")
                array_push($data['Awa'],$th);
        }
        return $data;
    }

    public function afficherTacheByPogramme($programme)
    {
        return $this->tacheRepository->findTacheByProgramme($programme);
    }

    public function afficherPogramme()
    {
        return $this->programmeRepository->findProgrammeOrder();
    }

   
    

    
}