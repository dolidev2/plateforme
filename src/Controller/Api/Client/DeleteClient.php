<?php


namespace App\Controller\Api\Client;


use App\Entity\Client;
use App\Manager\ClientManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DeleteClient
{

    /**
     * @var UserManager
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
     *     name="client_delete",
     *     path="/clients/{id}",
     *     methods={"DELETE"},
     *     defaults={
     *         "_api_resource_class"=Client::class,
     *         "_api_collection_operation_name"="delete"
     *     }
     * )
     */
    public function __invoke(Request $request)
    {
        return $this->clientManager->DeleteClient($request->attributes->get('id'));
    }
}