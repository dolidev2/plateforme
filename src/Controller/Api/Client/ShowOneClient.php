<?php


namespace App\Controller\Api\Client;

use App\Manager\ClientManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ShowOneClient
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
     *     name="client_show_one",
     *     path="/clients/{id}",
     *     methods={"GET"},
     *     defaults={
     *         "_api_resource_class"=Client::class,
     *         "_api_item_operation_name"="get"
     *     }
     * )
     */
    public function __invoke(Request $request)
    {
        return $this->clientManager->ShowOneClient($request->attributes->get('id'));
    }

}