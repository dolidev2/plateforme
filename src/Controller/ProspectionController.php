<?php

namespace App\Controller;

use App\Entity\Prospection;
use App\Form\ProspectionType;
use App\Repository\ServiceRepository;
use App\Repository\UserRepository;
use App\Service\CommercialService;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/service/commercial/prospection", name="app_service_commercial_prospection_")
 */
class ProspectionController extends AbstractController
{
    const COMMERCIAL_ID = 4;
    const STATUT_COURS=0;
    const STATUT_TERMINE=1;
    private $commercialService;
    private $serviceRepository;
    private $userRepository;
    private $em;

    public function __construct(CommercialService $commercialService, ServiceRepository $serviceRepository,
                                UserRepository $userRepository, EntityManagerInterface $em)
    {
        $this->commercialService = $commercialService;
        $this->serviceRepository = $serviceRepository;
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    /**
     * @Route("/consulter", name="consulter")
     */
    public function consulter(): Response
    {
        return $this->render('prospection/consulter.html.twig', [
            'service'=> $this->serviceRepository->findOneById(self::COMMERCIAL_ID),
            'dossier'=> $this->commercialService->afficherProspectionByStatut(Self::STATUT_COURS),
        ]);
    }  

    /**
     * @Route("/cloturer", name="cloturer")
     */
    public function cloturer(): Response
    {
        return $this->render('prospection/cloturer.html.twig', [
            'service'=> $this->serviceRepository->findOneById(self::COMMERCIAL_ID),
            'dossier'=> $this->commercialService->afficherProspectionByStatut(Self::STATUT_TERMINE),
        ]);
    }  
    
    /**
     * @Route("/ajouter", name="ajouter")
     */
    public function ajouter(Request $request): Response
    {
        $session = $request->getSession()->get('user');
        $user = $this->userRepository->findOneById($session->getId());

        $prospection = new Prospection();
        $form = $this->createForm(ProspectionType::class,$prospection);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) 
        { 
            $prospection->setCreatedAt(new \DateTimeImmutable());
            $prospection->setUpdatedAt(new \DateTimeImmutable());
            $prospection->setUser($user);
            $this->em->persist($prospection);
            $this->em->flush();
            return $this->redirectToRoute('app_service_commercial_prospection_consulter');
        }
        return $this->render('prospection/ajouter.html.twig', [
            'service' => $this->serviceRepository->findOneById(self::COMMERCIAL_ID),
            'dossier' => $this->commercialService->afficherProspectionByStatut(Self::STATUT_COURS),
            'form' => $form->createView(),
            'dos' => 'Ajouter',
        ]);
    }

    /**
     * @Route("/modifier/{prospection}", name="modifier")
     */
    public function modifier(Prospection $prospection,Request $request): Response
    {
        $form = $this->createForm(ProspectionType::class,$prospection);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) 
        { 
            $prospection->setUpdatedAt(new \DateTimeImmutable());
            $this->em->flush();
            return $this->redirectToRoute('app_service_commercial_prospection_consulter');
        }
        return $this->render('prospection/ajouter.html.twig', [
            'service' => $this->serviceRepository->findOneById(self::COMMERCIAL_ID),
            'dossier' => $this->commercialService->afficherProspectionByStatut(Self::STATUT_COURS),
            'form' => $form->createView(),
            'dos' => 'Modifier',
        ]);
    }

    /**
     * @Route("/supprimer/{prospection}", name="supprimer")
     */
    public function supprimer(Prospection $prospection): Response
    {
        $this->em->remove($prospection);
        $this->em->flush();
        return $this->redirectToRoute('app_service_commercial_prospection_consulter');
    }

}
