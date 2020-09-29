<?php


namespace App\Manager;

use App\Entity\Fournisseur;
use App\Repository\FournisseurRepository;
use Doctrine\ORM\EntityManagerInterface;

class FournisseurManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;
    /**
     * @var FournisseurRepository
     */
    protected $fournisseurRepository;


    /**
     *FournisseurManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param FournisseurRepository $fournisseurRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        FournisseurRepository $fournisseurRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->fournisseurRepository = $fournisseurRepository;
    }

    /**
     * @param string $fournisseur
     * @return Fournisseur|null
     */
    public function findFournisseur(string $fournisseur)
    {
        $four = $this->fournisseurRepository->findOneByNomFournisseur($fournisseur);

        if ($four)
        {
            return $four;
        }

        return null;
    }

    /**
     * @param Fournisseur $fournisseur
     * @return array
     * @throws \Exception
     */
    public function registerFournisseur(Fournisseur $fournisseur)
    {
        if($this->findFournisseur($fournisseur->getNomFournisseur()))
        {
            return [
                'statut'=>'FAILURE',
                'Message'=>"Fournisseur éxiste déjà",
            ];
        }

        //Set Date
        $fournisseur->setCreatedAt(new \DateTimeImmutable());
        $fournisseur->setUpdatedAt(new \DateTimeImmutable());

        //Persist & save
        $this->entityManager->persist($fournisseur);
        $this->entityManager->flush();

        return [
            'statut'=>'SUCCESS',
            'Message'=>"Fournisseur crée avec succès",
            'Fournisseur'=>$fournisseur
        ];

    }

    /**
     * @param Fournisseur $fournisseur
     * @return array
     * @throws \Exception
     */
    public function updateFournisseur(Fournisseur $fournisseur)
    {
        //Set Date
        $fournisseur->setUpdatedAt(new \DateTimeImmutable());

        //Persist & save
        $this->entityManager->persist($fournisseur);
        $this->entityManager->flush();

        return [
            'statut'=>'SUCCESS',
            'Message'=>"Fournisseur modifié avec succès",
            'Fournisseur'=>$fournisseur
        ];

    }

    /**
     * @return mixed
     */
    public function ShowFournisseur()
    {
        return $this->fournisseurRepository->findFournisseur();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function ShowOneFournisseur($id)
    {
        return $this->fournisseurRepository->findOneById($id);
    }

    /**
     * @param $id
     */
    public function DeleteFournisseur($id)
    {
        $fournisseur = $this->fournisseurRepository->findById($id);
        $this->entityManager->remove($fournisseur);
        if($this->entityManager->flush())

            return [
                'statut'=> 'SUCCESS',
                'message'=>'Fournisseur supprimé avec succès'
            ];
    }

}