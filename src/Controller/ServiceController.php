<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Commentaire;
use App\Entity\Devis;
use App\Entity\Dossier;
use App\Entity\Fournisseur;
use App\Entity\Service;
use App\Form\CommentaireType;
use App\Form\DevisType;
use App\Form\DossierType;
use App\Form\FournisseurType;
use App\Repository\CommentaireRepository;
use App\Repository\DossierRepository;
use App\Repository\FournisseurRepository;
use App\Repository\ServiceRepository;
use App\Repository\UserRepository;
use App\Service\DossierService;
use App\Service\FileUploader;
use App\Service\PaoService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\Publisher;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
/**
 * @Route("/service", name="app_")
 */
class ServiceController extends AbstractController
{

    const DEVIS_DIRECTORY = "upload/devis";
    
    private $dossierRepository;
    private $dossierService;
    private $paoService;
    private $userRepository;
    private $commentaireRepository;
    private $serviceRepository;
    private $em;

    public  function __construct( DossierRepository $dossierRepository,UserRepository $userRepository,
                                  EntityManagerInterface $em,DossierService $dossierService
                                  ,CommentaireRepository $commentaireRepository,PaoService $paoService,
                                  ServiceRepository $serviceRepository)
    {
        $this->dossierRepository = $dossierRepository;
        $this->paoService = $paoService;
        $this->userRepository = $userRepository;
        $this->commentaireRepository = $commentaireRepository;
        $this->serviceRepository = $serviceRepository;
        $this->dossierService = $dossierService;
        $this->em = $em;
    }

    public function __invoke(PublisherInterface $publisher) : Response
    {
        $update = new Update(
            'http://plateforme.com/users/comment',
            json_encode(['status' => 'OutOfStock'])
        );

        // The Publisher service is an invokable object
        $publisher($update);

        return new Response('published!');
        
    }

    /**
     * @Route("/accueil", name="home")
     */
    public function index(ServiceRepository $serviceRepository,DossierRepository $dossierRepository)
    {
        $dossier = $this->dossierService->bilanDossier();

        return $this->render('home/index.html.twig', [
            'dossier' => $dossier,
        ]);
    }

    
    /**
     * @Route("/Details/{id}", name="service")
     */
    public function service(Service $id, ServiceRepository $serviceRepository, DossierRepository $dossierRepository)
    {

        $dossierService = $dossierRepository->findDossierService($id->getId());

        return $this->render('service/service.html.twig',[
            'dossier' =>$dossierService,
            'service' => $id,
        ]);
    }


    /**
     * @Route("/{service}/{dossier}/Details", name="service_dossier" )
     */
    public function service_dossier($dossier,$service,Request $request,EntityManagerInterface $em)
    {
        
        if($request->isXmlHttpRequest()){

            $dossier = $request->request->get('dossier');

            if ( isset($dossier) && !empty($dossier) ){
                $this->dossierService->ModifierStatutDossier($dossier);
                return new \Symfony\Component\HttpFoundation\JsonResponse('bon');
            }
            $commentIdRequested = $request->request->get('id');

            if(isset($commentIdRequested) && !empty($commentIdRequested)){
                $responseUpdatedComment = $this
                                        ->dossierService
                                        ->commentaireModifyFromHttpRequest(
                                                 $request,
                                                 $commentIdRequested,
                                                 $request->request->get('message')
                                                );
                return new \Symfony\Component\HttpFoundation\JsonResponse($responseUpdatedComment);
            }
        } 

        $commentaire  = $this->dossierService->commentaire($dossier);
        $dos =  $this->dossierRepository->findOneById($dossier);

        $comment = new Commentaire();
        $form = $this->createForm(CommentaireType::class,$comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $user = $request->getSession()->get('user');
            $us = $this->userRepository->findOneById($user->getId());

            $comment->setCreatedAt(new \DateTimeImmutable());
            $comment->setUpdatedAt(new \DateTimeImmutable());
            $comment->setDossier($dos);
            $comment->setUser($us);

            $this->em->persist($comment);
            $this->em->flush();
            return $this->redirectToRoute('app_service_dossier',['service'=>$service,'dossier'=>$dossier]);
        }
        return $this->render('service/service_dossier.html.twig',[
            'dossier'=>$dos,
            'service'=>$service,
            'form'=>$form->createView(),
            'comment'=>$commentaire,
         ]);
    }
    /**
     * @Route("/ajouterDossier/{service}", name="service_add_dossier")
     */
    public function ajouter_dossier( $service, Request $request, SluggerInterface $slugger, ServiceRepository $serviceRepository, EntityManagerInterface $em)
    {
        $responseService = $serviceRepository->find($service);
        $dossier = new Dossier();
        $form = $this->createForm(DossierType::class,$dossier);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
            if(!empty($dossier->getClient()))
            {
                $client = new Client();
                $client->setNomClient($dossier->getClient());
                $client->setCreatedAt(new \DateTimeImmutable());
                $client->setUpdatedAt(new \DateTimeImmutable());
                $em->persist($client);
                $em->flush();
            }
            $dossier->setNomDossier($form->get('nomDossier')->getData());
            $dossier->setType($form->get('type')->getData());
            $dossier->setClient($form->get('client')->getData());
            $dossier->setService($responseService);
            $dossier->setStatut(0);
            $dossier->setCreatedAt(new \DateTimeImmutable());
            $dossier->setUpdatedAt(new \DateTimeImmutable());
            $em->persist($dossier);
            $em->flush();

           return $this->redirectToRoute('app_service',['id'=>$service]);
        }
        return $this->render('service/add_dossier.html.twig',[
            'service'=>$responseService,
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route("/ModifierDossier/{dossier}/{service}", name="service_update_dossier")
     */
    public function modifier_dossier(Dossier $dossier, $service, Request $request,ServiceRepository $serviceRepository,EntityManagerInterface $em)
    {
        //Get one service
        $responseService = $serviceRepository->findByNomService($service);

        //Create form dossier
        $form = $this->createForm(DossierType::class,$dossier);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $dossier->setUpdatedAt(new \DateTimeImmutable());
            $em->persist($dossier);
            $em->flush();

          return $this->redirectToRoute('app_service_dossier',['service'=>$service, 'dossier'=>$dossier->getId()]);
        }

        return $this->render('service/up_dossier.html.twig',[
            'service'=>$responseService[0],
            'form'=>$form->createView(),
        ]);
    }

     
    /**
     * @Route("/supprimer/dossier/{dossier}/{service}", name="supprimer_dossier")
     */
    public function dossier_supprimer(Dossier $dossier,$service,EntityManagerInterface $em)
    {

        $comment = $this->commentaireRepository->findCommentDossier($dossier);
        foreach ($comment as $cm) {

           $commentToRemove = $this->commentaireRepository->findOneById($cm['contentId']);
           $em->remove($commentToRemove);
           $em->flush();
        }

        $em->remove($dossier);
        $em->flush();

        return $this->redirectToRoute('app_service',['id'=>$service]);
    }

    /**
     * @Route("/CloturerDossier/{service}", name="service_cloturer_dossier")
     */
    public function cloturer_dossier($service,ServiceRepository $serviceRepository,DossierRepository $dossierRepository)
    {
        return $this->render('service/close_dossier.html.twig',[
            'service'=>$serviceRepository->find($service),
            'dossier'=>$dossierRepository->findDossierStatut(1,$service),
        ]);
    }
    /**
     * @Route("/AjouterDevis/{dossier}/{service}/{dossierNom}", name="service_ajouter_devis")
     */
    public function ajouter_dossier_devis( $dossier, $service, $dossierNom,FournisseurRepository $fournisseurRepository,EntityManagerInterface $em,ServiceRepository $serviceRepository, Request $request, SluggerInterface $slugger,DossierRepository $dossierRepository)
    {

        $form = $this->createFormBuilder()
            ->add('fournisseur',EntityType::class,[
                "class" => Fournisseur::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('f')
                        ->orderBy('f.createdAt', 'DESC');
                },
                'choice_label' => 'nomFournisseur',
                "attr" =>[
                    "class" =>"form-control",
                ],
                "label" => "Fournisseur",
            ])
            ->getForm()
        ;
        //Get all data from dossier
        $dos = $dossierRepository->find($dossier);
        //Get all data from service

        $responseService = $serviceRepository->findByNomService($service);

        $fournisseur = new Fournisseur();
        $formFour = $this->createForm(FournisseurType::class,$fournisseur);

        $devis = new Devis();
        $formDev = $this->createForm(DevisType::class,$devis);

        //Hydrate data from form
        $formFour->handleRequest($request);
        $formDev->handleRequest($request);
        $form->handleRequest($request);


        if($formFour->isSubmitted() && $formFour->isValid()) {

            $nameFournisseur = '';
            if(!empty($fournisseur->getNomFournisseur()))
            {
                $em->persist($fournisseur);
                $em->flush();

                $nameFournisseur = $fournisseur->getNomFournisseur();
            }else{
                $nameFournisseur =  $form->get('fournisseur')->getData()->getNomFournisseur();
            }

            if(!empty($nameFournisseur))
            {
                //Add Devis
                $devisFile = $formDev->get('nomDevis')->getData();

                /** @var UploadedFile $devisFile */
                if ($devisFile) {
                    $fileUploader = new  FileUploader(self::DEVIS_DIRECTORY, $slugger);
                    $devisFileName = $fileUploader->upload($devisFile);
                }
                //Get idFour and idDos for Fournisseur and Dossier
                $responseFour = $fournisseurRepository->findOneByNomFournisseur($nameFournisseur);

                //Save devis
                $devis->setNomDevis($devisFileName);
                $devis->setFournisseur($responseFour);
                $devis->setDossier($dos);
                $devis->setUpdatedAt(new \DateTimeImmutable());
                $devis->setCreatedAt(new \DateTimeImmutable());
                $em->persist($devis);
                $em->flush();

            }
        }

        return $this->render('service/ajouter_devis_dossier.html.twig',[
            'dossiers'=>$dos,
            'service'=>$responseService[0],
            'formFour'=>$formFour->createView(),
            'formDev'=>$formDev->createView(),
            'form'=>$form->createView(),
        ]);


        }

    /**
     * @Route("/devis_fournisseurs/{name}", name="devis_fournisseur")
     */
    public function devis_fournisseur( $name )
    {
        $path   = 'upload/devis/'.$name;
        return $this->render('service/view_dossier_devis.html.twig',[
            'name'=>$path
        ]);
    }


    /**
     * @Route("/Historique/{service}", name="service_historique_dossier")
     */
    public function historique_dossier( $service)
    {
        return $this->render('service/story_dossier.html.twig',[
            'service'=>$service
        ]);
    }

   



}
