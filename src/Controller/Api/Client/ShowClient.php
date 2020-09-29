<?php


namespace App\Controller\Api\Client;


use App\Entity\Client;
use App\Manager\ClientManager;
use Symfony\Component\Routing\Annotation\Route;

class ShowClient
{

    /**
     * @var ClientManager
     */
    protected $clientManager;

    /**
     * CreateUser constructor.
     * @param ClientManager $clientManager
     */
    public function __construct(ClientManager $clientManager)
    {
        $this->clientManager = $clientManager;
    }

    /**
     * @Route(
     *     name="client_show",
     *     path="/clients",
     *     methods={"GET"},
     *     defaults={
     *         "_api_resource_class"=Client::class,
     *         "_api_collection_operation_name"="get"
     *     }
     * )
     */
    public function __invoke()
    {
        return $this->clientManager->ShowClient();
    }
}