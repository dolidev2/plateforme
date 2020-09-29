<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\DossierRepository;
use App\Repository\ServiceRepository;
use App\Repository\UserRepository;
use App\Service\HttpRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Attribute\NamespacedAttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends AbstractController
{
    private $passwordEncoder;

    public function __construct( UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/accueil", name="home")
     */
    public function index(ServiceRepository $serviceRepository,DossierRepository$dossierRepository)
    {

        //Define empty array to receive two folder for one service
        $data=[];
        //Get all services
        $responseServices = $serviceRepository->findAll();

        //Get folder
        for ($i=0; $i < count($responseServices); $i++)
        {
            $responseDossier = $dossierRepository->findDossierServiceLimit($responseServices[$i]->getId());

            if (count($responseDossier) >= 2) {
                //Put folder in array
                $dataDossier = [
                    'id' => $responseServices[$i]->getId(),
                    'total' => 2,
                    'service' => $responseServices[$i]->getNomService(),
                    'dossier_1' => $responseDossier[0]->getNomDossier(),
                    'date_1' => $responseDossier[0]->getCreatedAt(),
                    'dossier_2' => $responseDossier[1]->getNomDossier(),
                    'date_2' => $responseDossier[1]->getCreatedAt()
                ];

            }elseif (count($responseDossier) == 1){
                $dataDossier = [
                    'id' => $responseServices[$i]->getId(),
                    'total' => 1,
                    'service' => $responseServices[$i]->getNomService(),
                    'dossier_1' => $responseDossier[0]->getNomDossier(),
                    'date_1' => $responseDossier[0]->getCreatedAt(),
                ];
            }elseif(count($responseDossier) == 0){
                $dataDossier = [
                    'id'=>$responseServices[$i]->getId(),
                    'total'=>0,
                    'service'=>$responseServices[$i]->getNomService(),
                    'dossier_1'=>"Aucun dossier en cours"
                ];
            }
            array_push($data,$dataDossier);
        }
        $this->get('session')->set('dossier',$data);
        return $this->render('home/index.html.twig', [
            'dossier' => $data,
        ]);
    }


    /**
     * @Route("/", name="app_login")
     */
    public function login( Request $request, UserRepository $userRepository)
    {
        $session = new Session(new NativeSessionStorage(), new NamespacedAttributeBag());

        $user = new User();
        $form = $this->createFormBuilder($user)
        ->add('username',TextType::class,[
            'attr'=>[
                'class'=>'form-control form-control-l',
                'placeholder'=>'Nom d\'utilisateur'
            ],
            'label'=>'Nom d\'utilisateur'
            ])
            ->add('password',PasswordType::class,[
                'attr'=>[
                    'class'=>'form-control form-control-l',
                    'placeholder'=>'Mot de passe'
                ],
                'label'=>'Mot de passe'
            ])
            ->getForm()
        ;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $userData = $userRepository->findByUsername($user->getUsername());

            if($userData)
            {
                if($this->passwordEncoder->isPasswordValid($userData[0],$user->getPassword()))
                   {
                       $session->set('idService',$userData[0]->getService()->getId());
                       $session->set('service',$userData[0]->getService()->getNomService());
                       $session->set('nom',$userData[0]->getNom());
                       $session->set('prenom',$userData[0]->getPrenom());
                       $session->set('role',$userData[0]->getRole());
                       $session->set('username',$userData[0]->getUsername());
                       return $this->redirectToRoute('home');
                   }
            }

        }
        $session->invalidate();
        return $this->render('service/login.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/inscription", name="app_inscription")
     */
    public function inscription(Request $request,EntityManagerInterface $em)
    {
        $user = new User();
        $form = $this->createForm(UserType::class,$user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            //Encode User Password
            $password = $this->passwordEncoder->encodePassword($user,$user->getPassword());
            $user->setPassword($password);


            $user->setCreatedAt(new \DateTimeImmutable());
            $user->setUpdatedAt(new \DateTimeImmutable());
            $em->persist($user);
            $em->flush();
             return  $this->redirectToRoute('home');
        }

        return $this->render('service/inscription.html.twig',[
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route("/Password/Reset", name="app_reset_password")
     */
    public function Passwordreset(Request $request,UserRepository $userRepository,EntityManagerInterface $em)
    {
        $user = new User();
        $form = $this->createFormBuilder($user)
            ->add('username',TextType::class,[
                'attr'=>[
                    'class'=>'form-control form-control-l',
                    'placeholder'=>'Nom d\'utilisateur'
                ],
                'label'=>'Nom d\'utilisateur'
            ])
            ->add('password',PasswordType::class,[
                'attr'=>[
                    'class'=>'form-control form-control-l',
                    'placeholder'=>'Entrer le nouveau ot de passe'
                ],
                'label'=>'Mot de passe'
            ])
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $userData = $userRepository->findByUsername($user->getUsername());
            if ($userData)
            {
                //Encode User Password
                $password = $this->passwordEncoder->encodePassword($user,$user->getPassword());
                $userData[0]->setPassword($password);

                $userData[0]->setUpdatedAt(new \DateTimeImmutable());
                $em->persist( $userData[0]);
                $em->flush();
                return  $this->redirectToRoute('app_login');
            }
        }

        return $this->render('service/PasswordReset.html.twig',[
            'form'=>$form->createView(),
        ]);
    }

}
