<?php


namespace App\Controller\Api\Fournisseur;


use App\Entity\Fournisseur;
use App\Manager\FournisseurManager;
use Symfony\Component\Routing\Annotation\Route;

class UpdateFournisseur
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
     *     name="fournisseur_update",
     *     path="/fournisseurs/{id}",
     *     methods={"PUT"},
     *     defaults={
     *         "_api_resource_class"=Fournisseur::class,
     *         "_api_item_operation_name"="put"
     *     }
     * )
     */
    public function __invoke(Fournisseur $data)
    {
        return $this->fournisseurManager->updateFournisseur($data);
    }
}