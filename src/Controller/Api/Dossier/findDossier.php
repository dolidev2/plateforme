<?php


namespace App\Controller\Api\Dossier;


use App\Manager\DossierManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class findDossier
{
    /**
     * @var DossierManager
     */
    protected $dossierManager;

    /**
     * ShowOnwDossier constructor.
     * @param DossierManager $dossierManager
     */
    public function __construct(DossierManager $dossierManager)
    {
        $this->dossierManager = $dossierManager;
    }

    /**
     * @Route(
     *     name="dossier_show_find",
     *     path="/dossiers/{name}/dossiers",
     *     methods={"GET"},
     *     defaults={
     *         "_api_resource_class"=Dossier::class,
     *         "_api_collection_operation_name"="get"
     *     }
     * )
     */
    public function __invoke(Request $request)
    {
        return $this->dossierManager->findDossier($request->attributes->get('name'));
    }
}