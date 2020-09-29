<?php


namespace App\Controller\Api\Service;


use App\Manager\ServiceManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DeleteService
{
    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * DeleteService constructor.
     * @param ServiceManager $serviceManager
     */
    public function __construct(ServiceManager  $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * @Route(
     *     name="service_delete",
     *     path="/services/{id}",
     *     methods={"DELETE"},
     *     defaults={
     *         "_api_resource_class"=Service::class,
     *         "_api_item_operation_name"="delete"
     *     }
     * )
     */
    public function __invoke(Request $request)
    {
        return $this->serviceManager->DeleteService($request->attributes->get('id'));
    }
}