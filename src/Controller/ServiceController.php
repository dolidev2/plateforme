<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Devis;
use App\Entity\Dossier;
use App\Entity\Fournisseur;
use App\Form\DevisType;
use App\Form\DossierType;
use App\Form\FournisseurType;
use App\Repository\DevisRepository;
use App\Repository\DossierRepository;
use App\Repository\FournisseurRepository;
use App\Repository\ServiceRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ServiceController extends AbstractController
{

    const DEVIS_DIRECTORY = "upload/devis";
    /**
     * @Route("/Service/Details/{id}", name="app_service")
     */
    public function service($id, ServiceRepository $serviceRepository, DossierRepository $dossierRepository)
    {
        //Get all from service and dossier
        $service = $serviceRepository->findOneById($id);
        $dossierService = $dossierRepository->findDossierService($id);

        return $this->render('service/service.html.twig',[
            'dossier' =>$dossierService,
            'service' => $service,
        ]);
    }

    /**
     * @Route("/Service/{service}/{dossier}/Details", name="app_service_dossier")
     */
    public function service_dossier($dossier,$service, Request $request,DossierRepository $dossierRepository,DevisRepository $devisRepository,FournisseurRepository $fournisseurRepository,EntityManagerInterface $em)
    {
        /**
         * if data send with ajax
         */
        if($request->isXmlHttpRequest()){

            //Get vente, cout and dossierId for each dossier posted
            $vente = $request->request->get('vente');
            $cout = $request->request->get('devis');
            $dossierId = $request->request->get('dossier');

            //Get dossier to close
            $dosier = $dossierRepository->find($dossierId);
            //Set statut
            $dosier->setStatut(1);
            //Persist and save
            $em->persist($dosier);
            $em->flush();

            return new \Symfony\Component\HttpFoundation\JsonResponse($dosier);
        }

        //Get all data from dossier
        $dossiers = $dossierRepository->findOneById($dossier);

        //Get all Devis for this dossier
        $devis = $devisRepository->findDevisDossier($dossier);

        return $this->render('service/service_dossier.html.twig',[
            'dossier'=>$dossiers,
            'service'=>$service,
            'devis'=>$devis,
         ]);
    }
    /**
     * @Route("/Service/AjouterDossier/{service}", name="app_service_add_dossier")
     */
    public function ajouter_dossier( $service, Request $request, SluggerInterface $slugger, ServiceRepository $serviceRepository, EntityManagerInterface $em)
    {

        //Get all services
        $responseService = $serviceRepository->find($service);
        $dossier = new Dossier();
        $form = $this->createFormBuilder()
            ->add('nomDossier', TextType::class,[
                'attr'=>[
                    'placeholder'=>'Nom du dossier',
                ],
                'required'=>true
            ])
            ->add('type',ChoiceType::class,[
                'choices'=>[
                    'Interne' => 'Interne',
                    'Externe' => 'Externe'
                ]
            ])
            ->add('client',TextType::class,[
                'attr'=>[
                    'placeholder'=>"Nom du client si externe"
                ],
                'required'=>false
            ])
            ->getForm();
        ;
        //Hydrate data
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){

            //Save client if exist
            if(!empty($dossier->getClient()))
            {
                $client = new Client();

                $client->setNomClient($dossier->getClient());
                $client->setCreatedAt(new \DateTimeImmutable());
                $client->setUpdatedAt(new \DateTimeImmutable());

                //Persist & save
                $em->persist($client);
                $em->flush();
            }


            $dossier->setNomDossier($form->get('nomDossier')->getData());
            $dossier->setType($form->get('type')->getData());
            $dossier->setClient($form->get('client')->getData());
            $dossier->setService($responseService);

            //Set Statut
            $dossier->setStatut(0);
            //Set Date
            $dossier->setCreatedAt(new \DateTimeImmutable());
            $dossier->setUpdatedAt(new \DateTimeImmutable());

            //Persist & save
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
     * @Route("/Service/ModifierDossier/{dossier}/{service}", name="app_service_update_dossier")
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
        }

        return $this->render('service/up_dossier.html.twig',[
            'service'=>$responseService[0],
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route("/Service/CloturerDossier/{service}", name="app_service_cloturer_dossier")
     */
    public function cloturer_dossier($service,ServiceRepository $serviceRepository,DossierRepository $dossierRepository)
    {
        return $this->render('service/close_dossier.html.twig',[
            'service'=>$serviceRepository->find($service),
            'dossier'=>$dossierRepository->findDossierStatut(1,$service),
        ]);
    }
    /**
     * @Route("/Service/AjouterDevis/{dossier}/{service}/{dossierNom}", name="app_service_ajouter_devis")
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
     * @Route("/Service/devis_fournisseurs/{name}", name="app_devis_fournisseur")
     */
    public function devis_fournisseur( $name )
    {
        $path   = 'upload/devis/'.$name;
        return $this->render('service/view_dossier_devis.html.twig',[
            'name'=>$path
        ]);
    }


    /**
     * @Route("/Service/Historique/{service}", name="app_service_historique_dossier")
     */
    public function historique_dossier( $service)
    {
        return $this->render('service/story_dossier.html.twig',[
            'service'=>$service
        ]);
    }


}
