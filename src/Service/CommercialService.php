<?php

namespace App\Service;

use App\Repository\CommercialRepository;

class CommercialService {

    private $commercialRepository;
    
    public function __construct(CommercialRepository $comercialRepository)
    {
        $this->commercialRepository = $comercialRepository;
    }
    
    public function afficherDossierCommercial($type,$support)
    {
        return $this->commercialRepository->findDossierCours($type,$support);
    }

    public function afficherDossierClocturer($type)
    {
        return $this->commercialRepository->findDossierCloturer($type);
    }

}