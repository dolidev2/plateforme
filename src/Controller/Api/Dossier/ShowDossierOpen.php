<?php


namespace App\Controller\Api\Dossier;


use App\Manager\DossierManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ShowDossierOpen
{
    /**
     * @var DossierManager
     */
    protected $dossierManager;

    /**
     * ShowDossierOpen constructor.
     * @param DossierManager $dossierManager
     */
    public function __construct(DossierManager $dossierManager)
    {
        $this->dossierManager = $dossierManager;
    }

    /**
     * @Route(
     *     name="dossier_show_open",
     *     path="/dossiers/{service}/open",
     *     methods={"GET"},
     *     defaults={
     *         "_api_resource_class"=Dossier::class,
     *         "_api_collection_operation_name"="open"
     *     }
     * )
     */
    public function __invoke(Request $request)
    {
        return $this->dossierManager->ShowDossierStatut(0,$request->attributes->get('dossier'));
    }
}