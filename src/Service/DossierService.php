<?php


namespace App\Service;


use App\Repository\CommentaireRepository;
use App\Repository\DossierRepository;
use App\Repository\ServiceRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class DossierService
{
    private $dossierRepository;
    private $serviceRepository;
    private $commentRepository;
    private $em;

    public function __construct(DossierRepository $dossierRepository,ServiceRepository $serviceRepository,
                                CommentaireRepository $commentRepository,EntityManagerInterface $em)
    {
        $this->dossierRepository = $dossierRepository;
        $this->commentRepository = $commentRepository;
        $this->serviceRepository = $serviceRepository;
        $this->em = $em;
    }

    public function bilanDossier(){


        //Define empty array to receive two folder for one service
        $data=[];
        //Get all services
        $responseServices = $this->serviceRepository->findAll();

        //Get folder
        for ($i=0; $i < count($responseServices); $i++)
        {
            $responseDossier = $this->dossierRepository->findDossierServiceLimit($responseServices[$i]->getId());

            if (count($responseDossier) >= 2) {
                //Put folder in array
                $dataDossier = [
                    'id' => $responseServices[$i]->getId(),
                    'total' => 2,
                    'service' => $responseServices[$i]->getNomService(),
                    'dossier_1_id' => $responseDossier[0]->getId(),
                    'dossier_1' => $responseDossier[0]->getNomDossier(),
                    'date_1' => $responseDossier[0]->getCreatedAt(),
                    'dossier_2_id' => $responseDossier[1]->getId(),
                    'dossier_2' => $responseDossier[1]->getNomDossier(),
                    'date_2' => $responseDossier[1]->getCreatedAt()
                ];

            }elseif (count($responseDossier) == 1){
                $dataDossier = [
                    'id' => $responseServices[$i]->getId(),
                    'total' => 1,
                    'service' => $responseServices[$i]->getNomService(),
                    'dossier_1_id' => $responseDossier[0]->getId(),
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


      return $data;
    }

    public  function commentaire($dossier){

        return $this->commentRepository->findCommentDossier($dossier);

    }

    public  function commentaireModifyFromHttpRequest($request,$commentaireIdRequest, $commentaireMessageRequest){
        
   
       $userConnected = $request->getSession()->get('user');
       $commentaire = $this->commentRepository->findOneById($commentaireIdRequest);

       //Verify who wrote comment
       if($userConnected->getId() == $commentaire->getUser()->getId()){

            $commentaire->setContent($commentaireMessageRequest);
            $commentaire->setUpdatedAt(new DateTimeImmutable());
    
            $this->em->flush();

            return true;
       }      
       return false;
    }
    public function ModifierStatutDossier($dossier){
        
        //Get dossier to close
        $dossierToUpdate = $this->dossierRepository->findOneById($dossier);
        //Set statut
        $dossierToUpdate->setStatut(1); 
        $this->em->flush();

    }




}