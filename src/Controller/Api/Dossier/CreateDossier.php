<?php


namespace App\Controller\Api\Dossier;


use App\Entity\Dossier;
use App\Manager\DossierManager;
use Symfony\Component\Routing\Annotation\Route;

class CreateDossier
{
    /**
     * @var DossierManager
     */
    protected $dossierManager;

    /**
     * CreateDossier constructor.
     * @param DossierManager $dossierManager
     */
    public function __construct(DossierManager $dossierManager)
    {
        $this->dossierManager = $dossierManager;
    }

    /**
     * @Route(
     *     name="dossier_create",
     *     path="/dossiers",
     *     methods={"POST"},
     *     defaults={
     *         "_api_resource_class"=Dossier::class,
     *         "_api_collection_operation_name"="post"
     *     }
     * )
     */
    public function __invoke(Dossier $data)
    {
        return $this->dossierManager->registerDossier($data);
    }
}