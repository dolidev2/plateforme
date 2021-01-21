<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\DossierService;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user", name="app_user_")
 */
class HomeController extends AbstractController
{
    
    private $dossierService;
    private $passwordEncoder;
    private $userService;
    private $userRepository;


    public function __construct( DossierService $dossierService,UserService $userService,
    UserRepository  $userRepository, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userService = $userService;
        $this->passwordEncoder = $passwordEncoder;
        $this->userRepository = $userRepository;
    }

  

    /**
     * @Route("/inscription", name="inscription")
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
             return  $this->redirectToRoute('app_home');
        }

        return $this->render('home/inscription.html.twig',[
            'form'=>$form->createView(),
          
        ]);
    }
    /**
     * @Route("/modifier/{user}", name="modifier")
     */
    public function user_modifier(User $user,Request $request,EntityManagerInterface $em)
    {

       ;
        $form = $this->createForm(UserType::class,$user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            //Encode User Password
            $password = $this->passwordEncoder->encodePassword($user,$user->getPassword());
            $user->setPassword($password);
            
            $user->setUpdatedAt(new \DateTimeImmutable());
    
            $em->flush();
             return  $this->redirectToRoute('app_user_liste');
        }

        return $this->render('home/inscription.html.twig',[
            'form'=>$form->createView(),
            
        ]);
    }

    /**
     * @Route("/liste", name="liste")
     */
    public function user_liste(Request $request)
    {
    
        //Get all users 
        $userInfo = $this->userService->userInfo();
        
     
        return $this->render('home/liste_user.html.twig',[
            'users'=>$userInfo
        ]);
    }
    
    /**
     * @Route("/supprimer/{user}", name="supprimer")
     */
    public function user_supprimer( User $user, EntityManagerInterface $em)
    {
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('app_user_liste');
    }

}
