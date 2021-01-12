<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\DossierRepository;
use App\Repository\ServiceRepository;
use App\Repository\UserRepository;
use App\Service\DossierService;
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
    
    private $dossierService;

    public function __construct( DossierService $dossierService)
    {
        $this->dossierService = $dossierService;
    }

    /**
     * @Route("/", name="app_login")
     */
    public function login( )
    {

        return $this->render('service/login.html.twig',[
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

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout( )
    {

    }

}
