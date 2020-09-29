<?php


namespace App\Controller\Api\Dossier;

use App\Manager\DossierManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ShowDossierService
{
    /**
     * @var DossierManager
     */
    protected $dossierManager;

    /**
     * ShowDossierService constructor.
     * @param DossierManager $dossierManager
     */
    public function __construct(DossierManager $dossierManager)
    {
        $this->dossierManager = $dossierManager;
    }

    /**
     * @Route(
     *     name="dossier_show_service",
     *     path="/dossiers/{service}/service",
     *     methods={"GET"},
     *     defaults={
     *         "_api_resource_class"=Dossier::class,
     *         "_api_collection_operation_name"="dossier_service"
     *     }
     * )
     */
    public function __invoke(Request $request)
    {
        return $this->dossierManager->ShowDossierService($request->attributes->get('service'));
    }
}