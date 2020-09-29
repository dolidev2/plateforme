<?php


namespace App\Manager;


use App\Entity\Service;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;

class ServiceManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;
    /**
     * @var ServiceRepository
     */
    protected $serviceRepository;


    /**
     * ServiceManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param ServiceRepository $serviceRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ServiceRepository $serviceRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->serviceRepository = $serviceRepository;
    }

    /**
     * @param Service $service
     * @return array
     * @throws \Exception
     */
    public function registerService(Service $service)
    {
        //Set Date
        $service->setCreatedAt(new \DateTimeImmutable());
        $service->setUpdatedAt(new \DateTimeImmutable());

        //Persist & save
        $this->entityManager->persist($service);
        $this->entityManager->flush();

        return [
            'statut'=>'SUCCESS',
            'Message'=>"Service crée avec succès",
            'Service'=>$service
        ];

    }

    /**
     * @param Service $service
     * @return array
     * @throws \Exception
     */
    public function updateService(Service $service)
    {
        //Set Date
        $service->setUpdatedAt(new \DateTimeImmutable());

        //Persist & save
        $this->entityManager->persist($service);
        $this->entityManager->flush();

        return [
            'statut'=>'SUCCESS',
            'Message'=>"Service modifié avec succès",
            'Service'=>$service
        ];

    }

    /**
     * @return mixed
     */
    public function ShowService()
    {
        return $this->serviceRepository->findAll();
    }

      /**
     * @param $id
     * @return mixed
     */
    public function ShowOneService($id)
    {
        return $this->serviceRepository->findById($id);
    }

    /**
     * @param $name
     * @return Service[]
     */
    public function ShowOneServiceName($name)
    {
        return $this->serviceRepository->findByNomService($name);
    }

    /**
     * @param $id
     */
    public function DeleteService($id)
    {

        $service = $this->serviceRepository->findById($id);
        $this->entityManager->remove($service);

        if($this->entityManager->flush())

            return [
                'statut'=> 'SUCCESS',
                'message'=>'Service supprimé avec succès',
            ];
    }
}