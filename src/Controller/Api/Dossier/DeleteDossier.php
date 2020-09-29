<?php


namespace App\Controller\Api\Dossier;


use App\Entity\Dossier;
use App\Manager\DossierManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DeleteDossier
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
     *     name="dossier_delete",
     *     path="/dossiers/{id}",
     *     methods={"DELETE"},
     *     defaults={
     *         "_api_resource_class"=Dossier::class,
     *         "_api_item_operation_name"="delete"
     *     }
     * )
     */
    public function __invoke(Request $request)
    {
        return $this->dossierManager->DeleteDossier($request->attributes->get('id'));
    }
}