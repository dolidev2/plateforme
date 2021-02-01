<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Form\FactureType;
use App\Repository\ServiceRepository;
use App\Repository\UserRepository;
use App\Service\DirectionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/service/direction", name="app_")
 */
class DirectionController extends AbstractController
{
    const DIRECTION_ID = 6;
    const TYPE_FACTURE="facture";
    const TYPE_DEVIS="devis";
    const TYPE_COMMANDE="commande";
    private $userRepository;
    private $serviceRepository;
    private $directionService;
    private $em;

    public function __construct(UserRepository $userRepository, ServiceRepository $serviceRepository,
                                DirectionService $directionService, EntityManagerInterface $em)
    {
        $this->userRepository = $userRepository;
        $this->serviceRepository = $serviceRepository;
        $this->directionService = $directionService;
        $this->em = $em;
    }
    /**
     * @Route("/direction/{type}/{date}", name="service_direction_facture_consulter_date")
     */
    public function facture_consulter_date($type,$date)
    {
        $service = $this->serviceRepository->findOneById(self::DIRECTION_ID);
        $facture =  $this->directionService->afficherFacture($type,$date);
        return $this->render('direction/consulter.html.twig', [
            'type'=> $type,
            'service'=> $service,
            'facture'=> $facture,
        ]);
    }
    /**
     * @Route("/direction/{type}", name="service_direction_facture_consulter")
     */
    public function facture_consulter($type)
    {
        $service = $this->serviceRepository->findOneById(self::DIRECTION_ID);
        $facture =  $this->directionService->afficherFacture($type,date("Y-m-d"));
        return $this->render('direction/consulter.html.twig', [
            'type'=> $type,
            'service'=> $service,
            'facture'=> $facture,
        ]);
    }

    /**
     * @Route("/direction/{type}/ajouter", name="service_direction_facture_ajouter")
     */
    public function direction_facture_ajouter(Request $request,$type)
    {
        $session = $request->getSession()->get('user');
        $user = $this->userRepository->findOneById($session->getId());
        $service = $this->serviceRepository->findOneById(self::DIRECTION_ID);

        $facture = new Facture();
        $form = $this->createForm(FactureType::class,$facture);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

         
            $facture->setUpdatedAt(new \DateTimeImmutable());
            $facture->setUser($user);
            $facture->setType($type);

            $this->em->persist($facture);
            $this->em->flush();

            return $this->redirectToRoute('app_service_direction_facture_consulter',['type'=>$type]);
      
        }

        return $this->render('direction/ajouter.html.twig',[
            'service'=>$service,
            'form'=>$form->createView(),
            'type'=>$type,
        ]);
    }


     /**
     * @Route("/direction/{type}/modifier/{facture}", name="service_direction_facture_modifier")
     */
    public function direction_facture_modifier(Request $request, Facture $facture,$type)
    {
        $session = $request->getSession()->get('user');
        $user = $this->userRepository->findOneById($session->getId());
        $service = $this->serviceRepository->findOneById(self::DIRECTION_ID);

        $form = $this->createForm(FactureType::class,$facture);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $facture->setUpdatedAt(new \DateTimeImmutable());
            $facture->setUser($user);
        
            $this->em->flush();

            return $this->redirectToRoute('app_service_direction_facture_consulter',['type'=>$type]);
        }

        return $this->render('direction/modifier.html.twig',[
            'service'=>$service,
            'form'=>$form->createView(),
            'type'=>$type,
        ]);
    }

    
     /**
     * @Route("/direction/supprimer/{facture}/{type}", name="service_direction_facture_supprimer")
     */
    public function pao_creation_supprimer(Facture $facture,$type)
    {
        $this->em->remove($facture);
        $this->em->flush();
        return $this->redirectToRoute('app_service_direction_facture_consulter',['type'=>$type]);
    }
}
