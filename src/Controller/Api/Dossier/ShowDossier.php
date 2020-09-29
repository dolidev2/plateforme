<?php


namespace App\Controller\Api\Dossier;

use App\Manager\DossierManager;
use Symfony\Component\Routing\Annotation\Route;

class ShowDossier
{
    /**
     * @var DossierManager
     */
    protected $dossierManager;

    /**
     * ShowDossier constructor.
     * @param DossierManager $dossierManager
     */
    public function __construct(DossierManager $dossierManager)
    {
        $this->dossierManager = $dossierManager;
    }

    /**
     * @Route(
     *     name="dossier_show",
     *     path="/dossiers",
     *     methods={"GET"},
     *     defaults={
     *         "_api_resource_class"=Dossier::class,
     *         "_api_collection_operation_name"="get"
     *     }
     * )
     */
    public function __invoke()
    {
        return $this->dossierManager->ShowDossier();
    }
}