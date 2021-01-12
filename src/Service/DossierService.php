<?php


namespace App\Service;


use App\Repository\CommentaireRepository;
use App\Repository\DossierRepository;
use App\Repository\ServiceRepository;

class DossierService
{
    private $dossierRepository;
    private $serviceRepository;
    private $commentRepository;

    public function __construct(DossierRepository $dossierRepository,ServiceRepository $serviceRepository,
                                CommentaireRepository $commentRepository)
    {
        $this->dossierRepository = $dossierRepository;
        $this->commentRepository = $commentRepository;
        $this->serviceRepository = $serviceRepository;
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




}