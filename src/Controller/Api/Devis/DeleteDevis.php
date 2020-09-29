<?php


namespace App\Controller\Api\Devis;


use App\Manager\DevisManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DeleteDevis
{
    /**
     * @var DevisManager
     */
    protected $devisManager;

    /**
     * DeleteDevis constructor.
     * @param DevisManager $serviceManager
     */
    public function __construct(DevisManager  $devisManager)
    {
        $this->devisManager = $devisManager;
    }

    /**
     * @Route(
     *     name="devis_delete",
     *     path="/devis/{id}",
     *     methods={"DELETE"},
     *     defaults={
     *         "_api_resource_class"=Devis::class,
     *         "_api_item_operation_name"="delete"
     *     }
     * )
     */
    public function __invoke(Request $request)
    {
        return $this->devisManager->DeleteDevis($request->attributes->get('id'));
    }
}