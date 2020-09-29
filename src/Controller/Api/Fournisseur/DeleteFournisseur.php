<?php


namespace App\Controller\Api\Fournisseur;


use App\Manager\FournisseurManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DeleteFournisseur
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
     *     name="fournisseur_show",
     *     path="/fournisseurs/{id}",
     *     methods={"GET"},
     *     defaults={
     *         "_api_resource_class"=Fournisseur::class,
     *         "_api_item_operation_name"="get"
     *     }
     * )
     */
    public function __invoke(Request $request)
    {
        return $this->fournisseurManager->DeleteFournisseur($request->attributes->get('id'));
    }

}