<?php

namespace App\Controller;

use App\Entity\Comptabilite;
use App\Entity\FichierComptabilite;
use App\Form\ComptabiliteType;
use App\Form\FichierComptabiliteType;
use App\Repository\ServiceRepository;
use App\Repository\UserRepository;
use App\Service\ComptabiliteService;
use App\Service\FileUploader;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/service/comptabilite", name="app_service_")
 */
class ComptabiliteController extends AbstractController
{
    const COMPTABILITE_ID = 7;
    const STATUT_COURS = 0;
    const STATUT_CLOTURE = 1;
    private $comptabiliteService;
    private $serviceRepository;
    private $userRepository;
    private $em;

    public function __construct(ComptabiliteService $comptabiliteService, ServiceRepository $serviceRepository,
                                UserRepository $userRepository, EntityManagerInterface $em)
    {
        $this->comptabiliteService = $comptabiliteService;
        $this->serviceRepository = $serviceRepository;
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    /**
     * @Route("/consulter", name="comptabilite_consulter")
     */
    public function comptabilite_consulter(): Response
    {
        return $this->render('comptabilite/consulter.html.twig', [
            'dossier'=>$this->comptabiliteService->afficherDossierByStatut(self::STATUT_COURS),
            'service'=>$this->serviceRepository->findOneById(self::COMPTABILITE_ID),
        ]);
    }

    /**
     * @Route("/cloturer", name="comptabilite_cloturer")
     */
    public function comptabilite_cloturer(): Response
    {
        return $this->render('comptabilite/consulter.html.twig', [
            'dossier'=>$this->comptabiliteService->afficherDossierByStatut(self::STATUT_CLOTURE),
            'service'=>$this->serviceRepository->findOneById(self::COMPTABILITE_ID),
        ]);
    }
    
    /**
     * @Route("/affichier/{fichier}", name="comptabilite_consulter_fichier")
     */
    public function afficher_fichier_joint($fichier)
    {
        $projectRoot = $this->getParameter('kernel.project_dir');
        $file = new File($projectRoot.'/fileUpload/comptabilite/'.$fichier);
        return $this->file($file, $fichier,ResponseHeaderBag::DISPOSITION_INLINE);
    }

     /**
     * @Route("/consulter/detail/{comptabilite}", name="comptabilite_consulter_detail")
     */
    public function comptabilite_consulter_detail(Comptabilite $comptabilite,Request $request, SluggerInterface $slugger): Response
    {
        if($request->isXmlHttpRequest()){

            $dossier = $request->request->get('dossier');
            if ( isset($dossier) && !empty($dossier) ){
                $this->comptabiliteService->ModifierStatutDossier($dossier);
                return new \Symfony\Component\HttpFoundation\JsonResponse('bon');
            }
        }
        $session = $request->getSession()->get('user');
        $user = $this->userRepository->findOneById($session->getId());
        $service = $this->serviceRepository->findOneById(self::COMPTABILITE_ID);
        $fichierComptabilite = new FichierComptabilite();

        $form = $this->createForm(FichierComptabiliteType::class, $fichierComptabilite);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $projectRoot = $this->getParameter('kernel.project_dir');
            $path_file = $projectRoot.'/fileUpload/comptabilite';
            $files = $form->get('nom')->getData();
            foreach($files as $file)
            {
                $fileUploader = new  FileUploader($path_file, $slugger);
                $fileName = $fileUploader->upload($file);

                $fileCompta = new FichierComptabilite();
                $fileCompta->setNom($fileName);
                $fileCompta->setUser($user);
                $fileCompta->setCreatedAt(new \DateTimeImmutable());
                $fileCompta->setUpdatedAt(new \DateTimeImmutable());
                $fileCompta->setComptabilite($comptabilite);
                $this->em->persist($fileCompta);
                $this->em->flush();
            }
            return $this->redirectToRoute('app_service_comptabilite_consulter_detail',['comptabilite'=>$comptabilite->getId()]);
        }
        return $this->render('comptabilite/detail.html.twig', [
            'dossier'=>$this->comptabiliteService->afficherDossierOneByStatut($comptabilite,self::STATUT_COURS),
            'service'=> $service,
            'form'=>$form->createView(),
            'file'=>$this->comptabiliteService->afficherFichierFromDossier($comptabilite->getId()),
        ]);
    }

     /**
     * @Route("/ajouter", name="comptabilite_ajouter")
     */
    public function comptabilite_ajouter(Request $request): Response
    {
        $session = $request->getSession()->get('user');
        $user = $this->userRepository->findOneById($session->getId());
        $service = $this->serviceRepository->findOneById(self::COMPTABILITE_ID);

        $dossier = new Comptabilite();
        $form = $this->createForm(ComptabiliteType::class,$dossier);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $dossier->setUpdatedAt(new \DateTimeImmutable());
            $dossier->setCreatedAt(new \DateTimeImmutable());
            $dossier->setStatut(0);
            $dossier->setUser($user);
            $this->em->persist($dossier);
            $this->em->flush();

            return $this->redirectToRoute('app_service_comptabilite_consulter');
        }

        return $this->render('comptabilite/form.html.twig', [
            'service'=>$service,
            'form'=>$form->createView(),
            'dos'=>"Ajouter",
        ]);
    } 
    
    /**
     * @Route("/modifier/{comptabilite}", name="comptabilite_modifier")
     */
    public function comptabilite_modifier(Comptabilite $comptabilite, Request $request): Response
    {
        $session = $request->getSession()->get('user');
        $user = $this->userRepository->findOneById($session->getId());
        $service = $this->serviceRepository->findOneById(self::COMPTABILITE_ID);

        $form = $this->createForm(ComptabiliteType::class,$comptabilite);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $comptabilite->setUpdatedAt(new \DateTimeImmutable());
            $comptabilite->setUser($user);
            $this->em->flush();
            return $this->redirectToRoute('app_service_comptabilite_consulter');
        }

        return $this->render('comptabilite/form.html.twig', [
            'service'=>$service,
            'form'=>$form->createView(),
            'dos'=>"Modifier",
        ]);
    }

     /**
     * @Route("/supprimer/{comptabilite}", name="comptabilite_supprimer")
     */
    public function comptabilite_supprimer(Comptabilite $comptabilite, Request $request)
    {
        $fichierComptabilite = $comptabilite->getFichierComptabilite();
        foreach($fichierComptabilite as $fichier)
        {
            $comptabilite->removeFichierComptabilite($fichier);
        }

        $this->em->remove($comptabilite);
        $this->em->flush();

        return $this->redirectToRoute('app_service_comptabilite_consulter');
    }
}
