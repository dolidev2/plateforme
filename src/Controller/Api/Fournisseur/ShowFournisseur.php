<?php


namespace App\Controller\Api\Fournisseur;


use App\Entity\Fournisseur;
use App\Manager\FournisseurManager;
use Symfony\Component\Routing\Annotation\Route;

class ShowFournisseur
{

    /**
     * @var FournisseurManager
     */
    protected $fournisseurManager;

    /**
     * CreateFournisseur constructor.
     * @param FournisseurManager $fournisseurManager
     */
    public function __construct(FournisseurManager  $fournisseurManager)
    {
        $this->fournisseurManager = $fournisseurManager;
    }

    /**
     * @Route(
     *     name="fournisseur_show",
     *     path="/fournisseurs",
     *     methods={"GET"},
     *     defaults={
     *         "_api_resource_class"=Fournisseur::class,
     *         "_api_collection_operation_name"="get"
     *     }
     * )
     */
    public function __invoke()
    {
        return $this->fournisseurManager->ShowFournisseur();
    }
}