<?php

namespace App\Controller;

use App\Entity\Commercial;
use App\Form\CommercialModifierType;
use App\Form\CommercialType;
use App\Repository\ServiceRepository;
use App\Repository\UserRepository;
use App\Service\CommercialService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/service/commercial", name="app_service_")
 */
class CommercialController extends AbstractController
{
    const COMMERCIAL_ID = 4;
    const TYPE_SODIBO="sodibo";
    const TYPE_CLIENT="client";
    private $commercialService;
    private $serviceRepository;
    private $userRepository;
    private $em;

    public function __construct(CommercialService $commercialService,ServiceRepository $serviceRepository,
                                UserRepository $userRepository, EntityManagerInterface $em){

        $this->commercialService = $commercialService;
        $this->serviceRepository = $serviceRepository;
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    /**
     * @Route("/consulter/{type}/{support}", name="commercial_consulter")
     */
    public function commercial_consulter($type,$support)
    {
        $service = $this->serviceRepository->findOneById(self::COMMERCIAL_ID);
        $dossier =  $this->commercialService->afficherDossierCommercial($type,$support);
        return $this->render('commercial/consulter.html.twig', [
            'type'=> $type,
            'support'=> $support,
            'service'=> $service,
            'dossier'=> $dossier,
        ]);
    }


     /**
     * @Route("/cloturer/{type}/{support}", name="commercial_cloturer")
     */
    public function commercial_cloturer($type,$support)
    {
        $service = $this->serviceRepository->findOneById(self::COMMERCIAL_ID);
        $dossier =  $this->commercialService->afficherDossierClocturer($type,$support);
        return $this->render('commercial/cloturer.html.twig', [
            'type'=> $type,
            'support'=> $support,
            'service'=> $service,
            'dossier'=> $dossier,
        ]);
    }

    /**
     * @Route("/ajouter/{type}/{support}", name="commercial_ajouter")
     */
    public function direction_facture_ajouter(Request $request,$type,$support)
    {
        $session = $request->getSession()->get('user');
        $user = $this->userRepository->findOneById($session->getId());
        $service = $this->serviceRepository->findOneById(self::COMMERCIAL_ID);

        $dossier = new Commercial();
        $form = $this->createForm(CommercialType::class,$dossier);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $dossier->setUpdatedAt(new \DateTimeImmutable());
            $dossier->setCreatedAt(new \DateTimeImmutable());
            $dossier->setStatut(0);
            $dossier->setUser($user);
            $dossier->setType($type);
            $dossier->setType($support);
            $this->em->persist($dossier);
            $this->em->flush();
            return $this->redirectToRoute('app_service_commercial_consulter',['type'=>$type,'support'=>$support]);
        }
        return $this->render('commercial/ajouter.html.twig',[
            'service'=>$service,
            'form'=>$form->createView(),
            'type'=>$type,
            'support'=>$support,
            'dos'=>"Ajouter",
        ]);
    }

     /**
     * @Route("/modifier/{type}/{dossier}/{support}", name="commercial_modifier")
     */
    public function direction_facture_modifier(Request $request, Commercial $dossier,$type,$support)
    {
        $session = $request->getSession()->get('user');
        $user = $this->userRepository->findOneById($session->getId());
        $service = $this->serviceRepository->findOneById(self::COMMERCIAL_ID);

        $form = $this->createForm(CommercialModifierType::class,$dossier);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $dossier->setUpdatedAt(new \DateTimeImmutable());
            $dossier->setUser($user);
            $this->em->flush();
            return $this->redirectToRoute('app_service_commercial_consulter',['type'=>$type,'support'=>$support]);
        }

        return $this->render('commercial/ajouter.html.twig',[
            'service'=>$service,
            'form'=>$form->createView(),
            'type'=>$type,
            'support'=>$support,
            'dos'=>"Modifier",
        ]);
    }

     /**
     * @Route("supprimer/{dossier}/{type}/{support}", name="commercial_supprimer")
     */
    public function pao_creation_supprimer(Commercial $dossier,$type,$support)
    {
        $this->em->remove($dossier);
        $this->em->flush();
        return $this->redirectToRoute('app_service_commercial_consulter',['type'=>$type,'support'=>$support]);
    }
}
