<?php


namespace App\Controller\Api\Dossier;


use App\Entity\Dossier;
use App\Manager\DossierManager;
use Symfony\Component\HttpFoundation\Request;

class UpdateMargeDossier
{
    /**
     * @var DossierManager
     */
    protected $dossierManager;

    /**
     * UpdateDossier constructor.
     * @param DossierManager $dossierManager
     */
    public function __construct(DossierManager $dossierManager)
    {
        $this->dossierManager = $dossierManager;
    }

    /**
     * @param Dossier $data
     * @return array
     * @throws \Exception
     */
    public function __invoke(Request $request)
    {
        return $this->dossierManager->updateMargeDossier($request->attributes->get('id'),$request->attributes->get('vente'),$request->attributes->get('cout'));
    }
}