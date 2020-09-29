<?php


namespace App\Controller\Api\Service;


use App\Entity\Service;
use App\Manager\ServiceManager;
use Symfony\Component\Routing\Annotation\Route;

class UpdateService
{
    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * UpdateService constructor.
     * @param ServiceManager $serviceManager
     */
    public function __construct(ServiceManager  $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * @Route(
     *     name="service_update",
     *     path="/services/{id}",
     *     methods={"PUT"},
     *     defaults={
     *         "_api_resource_class"=Service::class,
     *         "_api_collection_operation_name"="put"
     *     }
     * )
     */
    public function __invoke(Service $data)
    {
        return $this->serviceManager->UpdateService($data);
    }
}