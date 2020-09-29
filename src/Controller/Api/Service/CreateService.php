<?php


namespace App\Controller\Api\Service;

use App\Entity\Service;
use App\Manager\ServiceManager;
use Symfony\Component\Routing\Annotation\Route;

class CreateService
{
    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * CreateService constructor.
     * @param ServiceManager $serviceManager
     */
    public function __construct(ServiceManager  $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * @Route(
     *     name="service_create",
     *     path="/services",
     *     methods={"POST"},
     *     defaults={
     *         "_api_resource_class"=Service::class,
     *         "_api_collection_operation_name"="post"
     *     }
     * )
     */
    public function __invoke(Service $data)
    {
        return $this->serviceManager->registerService($data);
    }
}