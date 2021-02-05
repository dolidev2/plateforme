<?php

namespace App\Service;

use App\Repository\ComptabiliteRepository;
use App\Repository\FichierComptabiliteRepository;
use Doctrine\ORM\EntityManagerInterface;

class ComptabiliteService {
    private $comptabiliteRepository;
    private $fichierComptabiliteRepository;
    private $em;

    public function __construct(ComptabiliteRepository $comptabiliteRepository, FichierComptabiliteRepository $fichierComptabiliteRepository,
                                EntityManagerInterface $em)
    {
        $this->comptabiliteRepository = $comptabiliteRepository;
        $this->fichierComptabiliteRepository = $fichierComptabiliteRepository;
        $this->em = $em;
    }

    public function afficherDossierByStatut($statut)
    {
        return $this->comptabiliteRepository->findDossierByStatut($statut);
    }

    public function afficherDossierOneByStatut($comptablite,$statut)
    {
        return $this->comptabiliteRepository->findDossierOneByStatut($comptablite,$statut);
    }

    public function afficherFichierFromDossier($comptablite)
    {
        return $this->fichierComptabiliteRepository->findByComptabilite($comptablite);
    }

    public function ModifierStatutDossier($dossier)
    {
        $dossierToUpdate = $this->comptabiliteRepository->findOneById($dossier);
        $dossierToUpdate->setStatut(1); 
        $this->em->flush();
    }
}