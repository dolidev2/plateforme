<?php


namespace App\Controller\Api\Client;

use App\Entity\Client;
use App\Manager\ClientManager;
use Symfony\Component\Routing\Annotation\Route;

class CreateClient
{

    /**
     * @var ClientManager
     */
    protected $clientManager;

    /**
     * CreateClient constructor.
     * @param ClientManager $clientManager
     */
    public function __construct(ClientManager $clientManager)
    {
        $this->clientManager = $clientManager;
    }

    /**
     * @Route(
     *     name="client_create",
     *     path="/clients",
     *     methods={"POST"},
     *     defaults={
     *         "_api_resource_class"=Client::class,
     *         "_api_collection_operation_name"="post"
     *     }
     * )
     */
    public function __invoke(Client $data)
    {
        return $this->clientManager->registerClient($data);
    }
}