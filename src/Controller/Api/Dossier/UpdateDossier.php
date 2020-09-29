<?php


namespace App\Controller\Api\Dossier;

use App\Entity\Dossier;
use App\Manager\DossierManager;
use Symfony\Component\Routing\Annotation\Route;

class UpdateDossier
{
    /**
     * @var DossierManager
     */
    protected $dossierManager;

    /**
     * UpdateDossier constructor.
     * @param DossierManager $dossierManager
     */
    public function __construct(DossierManager $dossierManager)
    {
        $this->dossierManager = $dossierManager;
    }

    /**
     * @Route(
     *     name="dossier_update",
     *     path="/dossiers/{id}",
     *     methods={"PUT"},
     *     defaults={
     *         "_api_resource_class"=Dossier::class,
     *         "_api_item_operation_name"="put"
     *     }
     * )
     */
    public function __invoke(Dossier $data)
    {
        return $this->dossierManager->updateDossier($data);
    }
}