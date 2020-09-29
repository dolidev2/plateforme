<?php


namespace App\Controller\Api\Dossier;


use App\Entity\Dossier;
use App\Manager\DossierManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ShowOneDossier
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
     *     name="dossier_show_one",
     *     path="/dossiers/{id}",
     *     methods={"GET"},
     *     defaults={
     *         "_api_resource_class"=Dossier::class,
     *         "_api_item_operation_name"="get"
     *     }
     * )
     */
    public function __invoke(Request $request)
    {
        return $this->dossierManager->ShowOneDossier($request->attributes->get('id'));
    }
}