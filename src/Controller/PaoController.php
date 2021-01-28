<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CreationType;
use App\Entity\Creation;
use App\Form\CreationUpdateType;
use App\Repository\ServiceRepository;
use App\Repository\UserRepository;
use App\Service\PaoService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/service/pao", name="app_")
 */
class PaoController extends AbstractController
{

  const PAO_ID = 5;
  const TYPE_CREATION="création";
  const TYPE_ADAPTATION="adaptation";
  const TYPE_BRANDING="branding";
  private $serviceRepository;
  private $userRepository;
  private $paoService;
  private $em;

  public function __construct(ServiceRepository $serviceRepository,PaoService $paoService,
                              UserRepository $userRepository,EntityManagerInterface $em)
  {
    $this->serviceRepository = $serviceRepository;
    $this->userRepository = $userRepository;
    $this->paoService = $paoService;
    $this->em = $em;

  }

     /**
     * @Route("/creation/consulter/{type}", name="service_pao_creation")
     */
    public function pao_creation_consulter($type)
    {
        $service = $this->serviceRepository->findOneById(self::PAO_ID);
        $creation = $this->paoService->afficherCreations($type);
        return $this->render('pao/consulter.html.twig',[
            'service'=>$service,
            'creation'=>$creation,
            'type'=>$type,
        ]);
    }

     /**
     * @Route("/creation/{type}/ajouter", name="service_pao_creation_ajouter")
     */
    public function pao_creation_ajouter($type,Request $request)
    {
        $session = $request->getSession()->get('user');
        $user = $this->userRepository->findOneById($session->getId());
        $service = $this->serviceRepository->findOneById(self::PAO_ID);
        $creation = new Creation();
        $form = $this->createForm(CreationType::class,$creation);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $creation->setUpdatedAt(new \DateTimeImmutable());
            $creation->setUser($user);
            $creation->setStatut(0);
            $creation->setType($type);
            $this->em->persist($creation);
            $this->em->flush();
            return $this->redirectToRoute('app_service_pao_creation',['type'=>$type]);
      
        }

        return $this->render('pao/ajouter.html.twig',[
            'service'=>$service,
            'form'=>$form->createView(),
            'type'=>$type,
        ]);
    }


     /**
     * @Route("/creation/{type}/modifier/{creation}", name="service_pao_creation_modifier")
     */
    public function pao_creation_modifier($type,Creation $creation,Request $request)
    {
        $session = $request->getSession()->get('user');
        $user = $this->userRepository->findOneById($session->getId());
        $service = $this->serviceRepository->findOneById(self::PAO_ID);

        $form = $this->createForm(CreationUpdateType::class,$creation);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $creation->setUpdatedAt(new \DateTimeImmutable());
            $creation->setUser($user);
            $this->em->flush();
            return $this->redirectToRoute('app_service_pao_creation',['type'=>$type]);
        }

        return $this->render('pao/modifier.html.twig',[
            'service'=>$service,
            'form'=>$form->createView(),
            'type'=>$type,
        ]);
    }

    
     /**
     * @Route("/creation/{type}/supprimer/{creation}", name="service_pao_creation_supprimer")
     */
    public function pao_creation_supprimer($type,Creation $creation)
    {
        
        $this->em->remove($creation);
        $this->em->flush();
        return $this->redirectToRoute('app_service_pao_creation',['type'=>$type]);
    }

     /**
     * @Route("/creation/utilisateur/{type}", name="service_pao_creation_utilisateur")
     */
    public function pao_creation_utilisateur($type)
    {
        $service = $this->serviceRepository->findOneById(self::PAO_ID);
        $userPaoCreation =$this->paoService->CreationsFromPaoUser($service->getId());
        return $this->render('pao/utilisateur.html.twig',[
            'service'=>$service,
            'userCreation' =>  $userPaoCreation,
            'type'=>$type
        ]);
    }
}
