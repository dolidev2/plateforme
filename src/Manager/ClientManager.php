<?php


namespace App\Manager;


use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ClientManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;
    /**
     * @var ClientRepository
     */
    protected $clientRepository;


    /**
     * ClientManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param ClientRepository $clientRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ClientRepository $clientRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->clientRepository = $clientRepository;
    }

    /**
     * @param Client $client
     * @return array
     * @throws \Exception
     */
    public function registerClient(Client $client)
    {
        //Set Date
        $client->setCreatedAt(new \DateTimeImmutable());
        $client->setUpdatedAt(new \DateTimeImmutable());

        //Persist & save
        $this->entityManager->persist($client);
        $this->entityManager->flush();

        return [
            'statut'=>'SUCCESS',
            'Message'=>"Client crée avec succès",
            'client'=>$client
        ];

    }

    /**
     * @param Client $client
     * @return array
     * @throws \Exception
     */
    public function updateClient(Client $client)
    {
        //Set Date
        $client->setUpdatedAt(new \DateTimeImmutable());

        //Persist & save
        $this->entityManager->persist($client);
        $this->entityManager->flush();

        return [
            'statut'=>'SUCCESS',
            'Message'=>"Client modifié avec succès",
            'client'=>$client
        ];

    }

    /**
     * @return mixed
     */
    public function ShowClient()
    {
        return $this->clientRepository->findClient();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function ShowOneClient($id)
    {
        return $this->clientRepository->findById($id);
    }

    /**
     * @param $id
     */
    public function DeleteClient($id)
    {

        $client = $this->clientRepository->findById($id);
        $this->entityManager->remove($client);

        if($this->entityManager->flush())

            return [
                'statut'=> 'SUCCESS',
                'message'=>'Client supprimé avec succès',
            ];
    }

}