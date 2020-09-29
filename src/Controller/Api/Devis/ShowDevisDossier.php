<?php


namespace App\Controller\Api\Devis;


use App\Manager\DevisManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ShowDevisDossier
{
    /**
     * @var DevisManager
     */
    protected $devisManager;

    /**
     * ShowDevis constructor.
     * @param DevisManager $serviceManager
     */
    public function __construct(DevisManager  $devisManager)
    {
        $this->devisManager = $devisManager;
    }

    /**
     * @Route(
     *     name="devis_show_dossier",
     *     path="/devis/dossier/{id}",
     *     methods={"GET"},
     *     defaults={
     *         "_api_resource_class"=Devis::class,
     *         "_api_collection_operation_name"="devis_dossier"
     *     }
     * )
     */
    public function __invoke(Request $request)
    {
        return $this->devisManager->ShowDevisDossier($request->attributes->get('id'));
    }
}