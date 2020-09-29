<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DevisRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\Api\Devis\CreateDevis;
use App\Controller\Api\Devis\UpdateDevis;
use App\Controller\Api\Devis\ShowDevisDossier;
use App\Controller\Api\Devis\ShowOneDevis;
use App\Controller\Api\Devis\DeleteDevis;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=DevisRepository::class)
 * @ApiResource(
 *     normalizationContext={
 *          "groups"={"devis:read"}
 *  },
 *     denormalizationContext={
 *          "groups"={"devis:write"}
 *  },
 *     collectionOperations={
 *       "post"={
 *          "path"= "/devis",
 *          "controller"= CreateDevis::class
 *     },
 *         "dossier_service"={
 *           "method"="GET",
 *          "path"= "/devis/dossier/{id}",
 *          "controller"= ShowDevisDossier::class
 *     },
 *  },
 *     itemOperations={
 *      "get"={
 *          "path"= "/devis/{id}",
 *          "controller"= ShowOneDevis::class
 *       },
 *     "put"={
 *          "path"= "/devis/{id}",
 *          "controller"= UpdateDevis::class
 *       },
 *     "delete"={
 *          "path"= "/devis/{id}",
 *          "controller"= DeleteDevis::class
 *       },
 *}
 * )
 */
class Devis
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"devis:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"devis:read","devis:write"})
     */
    private $nomDevis;

    /**
     * @ORM\ManyToOne(targetEntity=Fournisseur::class, inversedBy="devis")
     *  @Groups({"devis:read","devis:write"})
     */
    private $fournisseur;

    /**
     * @ORM\ManyToOne(targetEntity=Dossier::class, inversedBy="devis")
     * @Groups({"devis:read","devis:write"})
     */
    private $dossier;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"devis:read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *  @Groups({"devis:read","devis:write"})
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDevis(): ?string
    {
        return $this->nomDevis;
    }

    public function setNomDevis(string $nomDevis): self
    {
        $this->nomDevis = $nomDevis;

        return $this;
    }

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): self
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    public function getDossier(): ?Dossier
    {
        return $this->dossier;
    }

    public function setDossier(?Dossier $dossier): self
    {
        $this->dossier = $dossier;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
