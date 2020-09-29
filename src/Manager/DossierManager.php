<?php


namespace App\Manager;


use App\Entity\Dossier;
use App\Repository\DossierRepository;
use Doctrine\ORM\EntityManagerInterface;

class DossierManager
{

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;
    /**
     * @var DossierRepository
     */
    protected $dossierRepository;


    /**
     * DossierManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param DossierRepository $dossierRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        DossierRepository $dossierRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->dossierRepository = $dossierRepository;
    }

    /**
     * @param string $dossier
     * @return Dossier|null
     */
    public function findDossier(string $dossier)
    {
        $dos = $this->dossierRepository->findOneByNomDossier($dossier);

        if ($dos)
        {
            return $dos;
        }

        return null;
    }
    /**
     * @param Dossier $dossier
     * @return array
     * @throws \Exception
     */
    public function registerDossier(Dossier $dossier)
    {
        //Set Statut
        $dossier->setStatut(0);
        //Set Date
        $dossier->setCreatedAt(new \DateTimeImmutable());
        $dossier->setUpdatedAt(new \DateTimeImmutable());

        //Persist & save
        $this->entityManager->persist($dossier);
        $this->entityManager->flush();

        return [
            'statut'=>'SUCCESS',
            'Message'=>"Dossier crée avec succès",
            'Dossier'=>$dossier
        ];

    }

    /**
     * @param Dossier $dossier
     * @return array
     * @throws \Exception
     */
    public function updateDossier(Dossier $dossier)
    {
        //Set Date
        $dossier->setUpdatedAt(new \DateTimeImmutable());

        //Persist & save
        $this->entityManager->persist($dossier);
        $this->entityManager->flush();

        return [
            'statut'=>'SUCCESS',
            'Message'=>"Dossier modifié avec succès",
            'Dossier'=>$dossier
        ];

    }

    public function updateMargeDossier($id, $vente, $cout)
    {
        $dossier = $this->dossierRepository->findOneById($id);

        $dossier->setVente($vente);
        $dossier->setCout($cout);
        $dossier->setUpdatedAt(new \DateTimeImmutable());

        //Persist & save
        $this->entityManager->persist($dossier);
        $this->entityManager->flush();

        return [
            'statut'=>'SUCCESS',
            'Message'=>"Dossier modifié avec succès",
            'Dossier'=>$dossier
        ];

    }


    /**
     * @param Dossier $dossier
     * @return array
     * @throws \Exception
     */
    public function closeDossier($id)
    {
        //Set statut
        $dossier = $this->dossierRepository->findOneById($id);
        $dossier->setStatut(1);
        //Set Date
        $dossier->setUpdatedAt(new \DateTimeImmutable());

        //Persist & save
        $this->entityManager->persist($dossier);
        $this->entityManager->flush();

        return [
            'statut'=>'SUCCESS',
            'Message'=>"Dossier cloturé avec succès",
            'Dossier'=>$dossier
        ];

    }

    /**
     * @return mixed
     */
    public function ShowDossier()
    {
        return $this->dossierRepository->findAll();
    }

    /**
     * @param int $statut
     * @return Dossier|null
     */
    public function ShowDossierStatut( $statut, $service )
    {
        return $this->dossierRepository->findDossierStatut($statut,$service);
    }


    /**
     * @param $id
     * @return Dossier|null
     */
    public function ShowDossierService($id)
    {
        return $this->dossierRepository->findDossierService($id);
    }
    /**
     * @param $id
     * @return Dossier|null
     */
    public function ShowDossierServiceLimit($id)
    {
        return $this->dossierRepository->findDossierServiceLimit($id);
    }


    /**
     * @param $id
     * @return mixed
     */
    public function ShowOneDossier($id)
    {
        return $this->dossierRepository->findById($id);
    }

    /**
     * @param $id
     */
    public function DeleteDossier($id)
    {

        $dossier = $this->dossierRepository->findById($id);
        $this->entityManager->remove($dossier);

        if($this->entityManager->flush())

            return [
                'statut'=> 'SUCCESS',
                'message'=>'Dossier supprimé avec succès',
            ];
    }
}