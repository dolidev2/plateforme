<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Repository\DossierRepository;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/comment/supprimer/{comment}", name="app_comment_supprimer")
     */
    public function supprimer(Commentaire $comment, EntityManagerInterface $em,
                              DossierRepository $dossierRepository, ServiceRepository $serviceRepository)
    {
        $dossier = $dossierRepository->findOneByCommentaires($comment);
        $service = $serviceRepository->findOneByDossier($dossier->getId());

        $em->remove($comment);
        $em->flush();

        return $this->redirectToRoute('app_service_dossier',
            ['service'=>$service->getNomService(),'dossier'=>$dossier->getId()]);
    }
}
