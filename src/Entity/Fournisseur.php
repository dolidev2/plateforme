<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FournisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\Api\Fournisseur\CreateFournisseur;
use App\Controller\Api\Fournisseur\UpdateFournisseur;
use App\Controller\Api\Fournisseur\ShowOneFournisseur;
use App\Controller\Api\Fournisseur\ShowFournisseur;
use App\Controller\Api\Fournisseur\DeleteFournisseur;
use App\Controller\Api\Fournisseur\FindFournisseur;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=FournisseurRepository::class)
 * @ApiResource(
 *     normalizationContext={
 *          "groups"={"fournisseur:read"}
 *  },
 *     denormalizationContext={
 *          "groups"={"fournisseur:write"}
 *  },
 *     collectionOperations={
 *        "get"={
 *          "path"= "/fournisseurs",
 *          "controller"= ShowFournisseur::class
 *     },
 *       "post"={
 *          "path"= "/fournisseurs",
 *          "controller"= CreateFournisseur::class
 *     },
 *          "find_fournisseur"={
 *          "method"="GET",
 *          "path"= "/fournisseurs/{name}/fournisseurs",
 *          "controller"= FindFournisseur::class
 *     },
 *     },
 *     itemOperations={
 *      "get"={
 *          "path"= "/fournisseurs/{id}",
 *          "controller"= ShowOneFournisseur::class
 *       },
 *     "put"={
 *          "path"= "/fournisseurs/{id}",
 *          "controller"= UpdateFournisseur::class
 *       },
 *     "delete"={
 *          "path"= "/fournisseurs/{id}",
 *          "controller"= DeleteFournisseur::class
 *       },
 *}
 * )
 */
class Fournisseur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"fournisseur:read"})
     * @Groups({"devis:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     * @Groups({"fournisseur:read","fournisseur:write"})
     * @Groups({"devis:read"})
     */
    private $nomFournisseur;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"fournisseur:read","fournisseur:write"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"fournisseur:read","fournisseur:write"})
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Devis::class, mappedBy="fournisseur")
     * @Groups({"fournisseur:read","fournisseur:write"})
     */
    private $devis;

    public function __construct()
    {
        $this->devis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFournisseur(): ?string
    {
        return $this->nomFournisseur;
    }

    public function setNomFournisseur(?string $nomFournisseur): self
    {
        $this->nomFournisseur = $nomFournisseur;

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

    /**
     * @return Collection|Devis[]
     */
    public function getDevis(): Collection
    {
        return $this->devis;
    }

    public function addDevi(Devis $devi): self
    {
        if (!$this->devis->contains($devi)) {
            $this->devis[] = $devi;
            $devi->setFournisseur($this);
        }

        return $this;
    }

    public function removeDevi(Devis $devi): self
    {
        if ($this->devis->contains($devi)) {
            $this->devis->removeElement($devi);
            // set the owning side to null (unless already changed)
            if ($devi->getFournisseur() === $this) {
                $devi->setFournisseur(null);
            }
        }

        return $this;
    }
}
