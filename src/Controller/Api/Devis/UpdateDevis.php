<?php
namespace App\Controller\Api\Devis;

use App\Entity\Devis;
use App\Manager\DevisManager;
use Symfony\Component\Routing\Annotation\Route;

class UpdateDevis
{
    /**
     * @var DevisManager
     */
    protected $devisManager;

    /**
     * UpdateDevis constructor.
     * @param DevisManager $serviceManager
     */
    public function __construct(DevisManager  $devisManager)
    {
        $this->devisManager = $devisManager;
    }

    /**
     * @Route(
     *     name="devis_update",
     *     path="/devis/{id}",
     *     methods={"PUT"},
     *     defaults={
     *         "_api_resource_class"=Devis::class,
     *         "_api_collection_operation_name"="put"
     *     }
     * )
     */
    public function __invoke(Devis $data)
    {
        return $this->devisManager->updateDevis($data);
    }
}