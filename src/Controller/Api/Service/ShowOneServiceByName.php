<?php


namespace App\Controller\Api\Service;


use App\Manager\ServiceManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ShowOneServiceByName
{
    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * ShowOneService constructor.
     * @param ServiceManager $serviceManager
     */
    public function __construct(ServiceManager  $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * @Route(
     *     name="service_show_one",
     *     path="/services/{id}",
     *     methods={"GET"},
     *     defaults={
     *         "_api_resource_class"=Service::class,
     *         "_api_item_operation_name"="get"
     *     }
     * )
     */
    public function __invoke(Request $request)
    {
        return $this->serviceManager->ShowOneServiceName($request->attributes->get('service'));
    }

}