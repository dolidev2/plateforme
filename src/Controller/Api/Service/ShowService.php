<?php


namespace App\Controller\Api\Service;


use App\Entity\Service;
use App\Manager\ServiceManager;
use Symfony\Component\Routing\Annotation\Route;

class ShowService
{
    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * ShowService constructor.
     * @param ServiceManager $serviceManager
     */
    public function __construct(ServiceManager  $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * @Route(
     *     name="service_show",
     *     path="/services",
     *     methods={"GET"},
     *     defaults={
     *         "_api_resource_class"=Service::class,
     *         "_api_collection_operation_name"="get"
     *     }
     * )
     */
    public function __invoke()
    {
        return $this->serviceManager->ShowService();
    }
}