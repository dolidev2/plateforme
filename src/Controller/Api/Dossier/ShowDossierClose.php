<?php


namespace App\Controller\Api\Dossier;


use App\Manager\DossierManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ShowDossierClose
{
    /**
     * @var DossierManager
     */
    protected $dossierManager;

    /**
     * ShowDossierClose constructor.
     * @param DossierManager $dossierManager
     */
    public function __construct(DossierManager $dossierManager)
    {
        $this->dossierManager = $dossierManager;
    }

    /**
     * @Route(
     *     name="dossier_show_close",
     *     path="/dossiers/{service}/close",
     *     methods={"GET"},
     *     defaults={
     *         "_api_resource_class"=Dossier::class,
     *         "_api_collection_operation_name"="close"
     *     }
     * )
     */
    public function __invoke(Request $request)
    {
        return $this->dossierManager->ShowDossierStatut(1,$request->attributes->get('dossier'));
    }
}