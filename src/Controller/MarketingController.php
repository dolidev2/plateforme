<?php

namespace App\Controller;

use App\Entity\ProgrammeMarketing;
use App\Entity\TacheMarketing;
use App\Form\ProgrammeType;
use App\Form\TacheMultipleType;
use App\Form\TacheType;
use App\Repository\ServiceRepository;
use App\Repository\UserRepository;
use App\Service\MarketingService;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/service/marketing", name="app_service_")
 */
class MarketingController extends AbstractController
{
    const MARKETING_ID = 2;
    private $marketingService;
    private $serviceRepository;
    private $userRepository;
    private $em;

    public function __construct(MarketingService $marketingService, ServiceRepository $serviceRepository,
                                UserRepository $userRepository, EntityManagerInterface $em)
    {
        $this->marketingService = $marketingService;
        $this->serviceRepository = $serviceRepository;
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    /**
     * @Route("/consulter", name="marketing_consulter")
     */
    public function marketing_consulter(): Response
    {
        return $this->render('marketing/consulter.html.twig', [
            'dossier' => $this->marketingService->afficherPogramme(),
            'service' => $this->serviceRepository->findOneById(self::MARKETING_ID),
        ]);
    }

     /**
     * @Route("/consulter/detail/{programme}", name="marketing_consulter_detail")
     */
    public function marketing_consulter_detail(ProgrammeMarketing $programme, Request $request): Response
    {
        $session = $request->getSession()->get('user');
        $user = $this->userRepository->findOneById($session->getId());

        $form = $this->createForm(TacheMultipleType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $tachesMarketing =$form->get('tacheMarketings')->getData();
            foreach($tachesMarketing as $tache)
            {
                $tache->setCreatedAt(new \DateTimeImmutable());
                $tache->setUpdatedAt(new \DateTimeImmutable());
                $tache->setUser($user);
                $tache->setProgramme($programme);
                $this->em->persist($tache);
                $this->em->flush();
            }
            return $this->redirectToRoute('app_service_marketing_consulter_detail',['programme'=>$programme->getId()]);
        }

        return $this->render('marketing/detail.html.twig', [
            'programme' => $programme,
            'service' => $this->serviceRepository->findOneById(self::MARKETING_ID),
            'form' => $form->createView(),
            'dossier' => $this->marketingService->afficherTacheProgrammeByResponsable($programme->getId()),
        ]);
    }

     /**
     * @Route("/modifier/tache/{tache}/{programme}", name="marketing_modifier_tache")
     */
    public function marketing_modifier_tache(TacheMarketing $tache, ProgrammeMarketing $programme,Request $request): Response
    {
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $tache->setUpdatedAt(new DateTimeImmutable());
            $this->em->flush();
            return $this->redirectToRoute('app_service_marketing_consulter_detail',['programme'=>$programme->getId()]);
        }
        return $this->render('marketing/modifier_tache.html.twig', [
            'service' => $this->serviceRepository->findOneById(self::MARKETING_ID),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/supprimer/tache/{tache}/{programme}", name="marketing_supprimer_tache")
     */
    public function marketing_supprimer_tache(TacheMarketing $tache, ProgrammeMarketing $programme)
    {
        $this->em->remove($tache);
        $this->em->flush();
        return $this->redirectToRoute('app_service_marketing_consulter_detail',['programme'=>$programme->getId()]);
    }

    /**
     * @Route("/ajouter", name="marketing_ajouter")
     */
    public function marketing_ajouter(Request $request): Response
    {
        $session = $request->getSession()->get('user');
        $user = $this->userRepository->findOneById($session->getId());

        $programme = new ProgrammeMarketing();
        $form = $this->createForm(ProgrammeType::class,$programme);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $programme->setUpdatedAt(new \DateTimeImmutable());
            $programme->setCreatedAt(new \DateTimeImmutable());
            $programme->setUser($user);
            $this->em->persist($programme);

            $tacheMarketing = $programme->getTacheMarketings();
            foreach($tacheMarketing as $tache)
            {
                $tache->setCreatedAt(new \DateTimeImmutable());
                $tache->setUpdatedAt(new \DateTimeImmutable());
                $tache->setUser($user);
                $this->em->persist($tache);
            }
            $this->em->flush();
            return $this->redirectToRoute('app_service_marketing_consulter');
        }
        return $this->render('marketing/ajouter.html.twig', [
            'form' => $form->createView(),
            'dos' =>"Ajouter",
            'service' => $this->serviceRepository->findOneById(self::MARKETING_ID),
        ]);
    }

     /**
     * @Route("/modifier/{programme}", name="marketing_modifier")
     */
    public function marketing_modifier(Request $request): Response
    {
        $programme = new ProgrammeMarketing();
        $form = $this->createForm(ProgrammeType::class,$programme);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $programme->setUpdatedAt(new \DateTimeImmutable());
            $this->em->flush();
            return $this->redirectToRoute('app_service_marketing_consulter');
        }
        return $this->render('marketing/modifier_tache.html.twig', [
            'form' => $form->createView(),
            'service' => $this->serviceRepository->findOneById(self::MARKETING_ID),
        ]);
    }

     /**
     * @Route("/supprimer/{programme}", name="marketing_supprimer")
     */
    public function marketing_supprimer(ProgrammeMarketing $programme)
    {
      $this->em->remove($programme);
      $this->em->flush();
      return $this->redirectToRoute('app_service_marketing_consulter');
    }
}
