<?php


namespace App\Controller\Api\Devis;


use App\Entity\Devis;
use App\Manager\DevisManager;
use Symfony\Component\Routing\Annotation\Route;

class CreateDevis
{
    /**
     * @var DevisManager
     */
    protected $devisManager;

    /**
     * CreateDevis constructor.
     * @param DevisManager $serviceManager
     */
    public function __construct(DevisManager  $devisManager)
    {
        $this->devisManager = $devisManager;
    }

    /**
     * @Route(
     *     name="devis_create",
     *     path="/devis",
     *     methods={"POST"},
     *     defaults={
     *         "_api_resource_class"=Devis::class,
     *         "_api_collection_operation_name"="post"
     *     }
     * )
     */
    public function __invoke(Devis $data)
    {
        return $this->devisManager->registerDevis($data);
    }
}