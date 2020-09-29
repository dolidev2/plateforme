<?php


namespace App\Manager;


use App\Entity\Devis;
use App\Repository\DevisRepository;
use Doctrine\ORM\EntityManagerInterface;

class DevisManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;
    /**
     * @var DevisRepository
     */
    protected $devisRepository;


    /**
     * DevisManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param DevisRepository $devisRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        DevisRepository $devisRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->devisRepository = $devisRepository;
    }

    /**
     * @param Devis $devis
     * @return array
     * @throws \Exception
     */
    public function registerDevis(Devis $devis)
    {
        //Set Date
        $devis->setCreatedAt(new \DateTimeImmutable());
        $devis->setUpdatedAt(new \DateTimeImmutable());

        //Persist & save
        $this->entityManager->persist($devis);
        $this->entityManager->flush();

        return [
            'statut'=>'SUCCESS',
            'Message'=>"Devis crée avec succès",
            'Devis'=>$devis
        ];

    }

    /**
     * @param Devis $devis
     * @return array
     * @throws \Exception
     */
    public function updateDevis(Devis $devis)
    {
        //Set Date
        $devis->setUpdatedAt(new \DateTimeImmutable());

        //Persist & save
        $this->entityManager->persist($devis);
        $this->entityManager->flush();

        return [
            'statut'=>'SUCCESS',
            'Message'=>"Devis modifié avec succès",
            'Devis'=>$devis
        ];

    }

    /**
     * @return mixed
     */
    public function ShowDevisDossier($id)
    {
        return $this->devisRepository->findDevisDossier($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function ShowOneDevis($id)
    {
        return $this->devisRepository->findById($id);
    }

    /**
     * @param $id
     */
    public function DeleteDevis($id)
    {

        $devis = $this->devisRepository->findById($id);
        $this->entityManager->remove($devis);

        if($this->entityManager->flush())

            return [
                'statut'=> 'SUCCESS',
                'message'=>'Devis supprimé avec succès',
            ];
    }
}