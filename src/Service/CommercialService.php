<?php

namespace App\Service;

use App\Repository\CommercialRepository;
use App\Repository\ProspectionRepository;

class CommercialService {

    private $commercialRepository;
    private $prospectionRepository;
    
    public function __construct(CommercialRepository $comercialRepository, ProspectionRepository $prospectionRepository)
    {
        $this->commercialRepository = $comercialRepository;
        $this->prospectionRepository = $prospectionRepository;
    }
    
    public function afficherDossierCommercial($type,$support)
    {
        return $this->commercialRepository->findDossierCours($type,$support);
    }

    public function afficherDossierClocturer($type,$support)
    {
        return $this->commercialRepository->findDossierCloturer($type,$support);
    }

    public function afficherProspectionByStatut($statut)
    {
        return $this->prospectionRepository->findDossierSatut($statut);
    }

}