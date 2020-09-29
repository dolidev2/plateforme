<?php


namespace App\Controller\Api\Dossier;


use App\Manager\DossierManager;
use Symfony\Component\HttpFoundation\Request;

class CloseDossier
{
    /**
     * @var DossierManager
     */
    protected $dossierManager;

    /**
     * ShowDossierClose constructor.
     * @param DossierManager $dossierManager
     */
    public function __construct(DossierManager $dossierManager)
    {
        $this->dossierManager = $dossierManager;
    }

    /**
     * @param Request $request
     * @return \App\Entity\Dossier|null
     */
    public function __invoke(Request $request)
    {
        return $this->dossierManager->closeDossier($request->attributes->get('dossier'));
    }
}