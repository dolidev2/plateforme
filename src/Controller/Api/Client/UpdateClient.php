<?php


namespace App\Controller\Api\Client;


use App\Entity\Client;
use App\Manager\ClientManager;
use Symfony\Component\Routing\Annotation\Route;

class UpdateClient
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
     *     name="client_update",
     *     path="/clients/{id}",
     *     methods={"PUT"},
     *     defaults={
     *         "_api_resource_class"=Client::class,
     *         "_api_item_operation_name"="put"
     *     }
     * )
     */
    public function __invoke(Client $data)
    {

        return $this->clientManager->updateClient($data);
    }
}