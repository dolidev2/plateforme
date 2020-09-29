<?php


namespace App\Controller\Api\Devis;


use App\Manager\DevisManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ShowOneDevis
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
     *     name="devis_show_one",
     *     path="/devis/{id}",
     *     methods={"GET"},
     *     defaults={
     *         "_api_resource_class"=Devis::class,
     *         "_api_item_operation_name"="get"
     *     }
     * )
     */
    public function __invoke(Request $request)
    {
        return $this->devisManager->ShowOneDevis($request->attributes->get('id'));
    }
}