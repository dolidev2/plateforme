<?php


namespace App\Controller\Api\Fournisseur;


use App\Entity\Fournisseur;
use App\Manager\FournisseurManager;
use Symfony\Component\Routing\Annotation\Route;

class CreateFournisseur
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
     *     name="fournisseur_create",
     *     path="/fournisseurs",
     *     methods={"POST"},
     *     defaults={
     *         "_api_resource_class"=Fournisseur::class,
     *         "_api_collection_operation_name"="post"
     *     }
     * )
     */
    public function __invoke(Fournisseur $data)
    {
        return $this->fournisseurManager->registerFournisseur($data);
    }

}