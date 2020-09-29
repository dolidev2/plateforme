<?php


namespace App\Controller\Api\Fournisseur;


use App\Manager\FournisseurManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FindFournisseur
{
    /**
     * @var FournisseurManager
     */
    protected $fournisseurManager;

    /**
     * CreateFournisseur constructor.
     * @param FournisseurManager $fournisseurManager
     */
    public function __construct(FournisseurManager  $fournisseurManager)
    {
        $this->fournisseurManager = $fournisseurManager;
    }

    /**
     * @Route(
     *     name="fournisseur_show_name",
     *     path="/fournisseurs/{name}/fournisseurs",
     *     methods={"GET"},
     *     defaults={
     *         "_api_resource_class"=Fournisseur::class,
     *         "_api_collection_operation_name"="get"
     *     }
     * )
     */
    public function __invoke(Request $request)
    {
        return $this->fournisseurManager->findFournisseur($request->attributes->get('name'));
    }

}