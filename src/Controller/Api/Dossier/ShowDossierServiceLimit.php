<?php


namespace App\Controller\Api\Dossier;


use App\Manager\DossierManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ShowDossierServiceLimit
{
    /**
     * @var DossierManager
     */
    protected $dossierManager;

    /**
     * ShowDossierServiceLimit constructor.
     * @param DossierManager $dossierManager
     */
    public function __construct(DossierManager $dossierManager)
    {
        $this->dossierManager = $dossierManager;
    }

    /**
     * @Route(
     *     name="dossier_show_service_limit",
     *     path="/dossiers/{service}/service",
     *     methods={"GET"},
     *     defaults={
     *         "_api_resource_class"=Dossier::class,
     *         "_api_collection_operation_name"="dossier_service_limit"
     *     }
     * )
     */
    public function __invoke(Request $request)
    {
        return $this->dossierManager->ShowDossierServiceLimit($request->attributes->get('service'));
    }
}