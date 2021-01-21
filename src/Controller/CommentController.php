<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Entity\Commentaire;
use App\Repository\CommentaireRepository;
use App\Repository\DossierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class CommentController extends AbstractController
{
    /**
     * @Route("/comment/modi", name="comment")
     */
    public function index()
    {
        return $this->render('');
    }

    /**
     * @Route("/", name="app_login")
     */
    public function login( )
    {

        return $this->render('home/login.html.twig',[
        ]);
    }

       /**
     * @Route("/logout", name="app_logout")
     */
    public function logout( )
    {

    }

    
    /**
     * @Route("/comment/supprimer/{comment}", name="app_comment_supprimer")
     */
    public function supprimer(Commentaire $comment, EntityManagerInterface $em,
                              DossierRepository $dossierRepository, 
                              CommentaireRepository $commentRepository)
    {
        $dossier = $commentRepository->findDossierByComment($comment->getId());
        $service = $dossierRepository->findNomServiceByDossier($dossier->getDossier()->getId());
     
        $em->remove($comment);
        $em->flush();

        return $this->redirectToRoute('app_service_dossier',
            ['service'=>$service['service'],'dossier'=>$dossier->getDossier()->getId()]);
    }

        /**
     * @Route("/Password/Reset", name="app_user_reset_password")
     */
    public function Passwordreset(Request $request,UserRepository $userRepository,
                                EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder)
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
                    'class'=>'form-control form-control',
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
                $password = $passwordEncoder->encodePassword($user,$user->getPassword());
                $userData[0]->setPassword($password);

                $userData[0]->setUpdatedAt(new \DateTimeImmutable());
                $em->persist( $userData[0]);
                $em->flush();
                return  $this->redirectToRoute('app_login');
            }
        }

        return $this->render('home/PasswordReset.html.twig',[
            'form'=>$form->createView(),
        ]);
    }
}
