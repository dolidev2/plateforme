<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DossierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\Api\Dossier\CreateDossier;
use App\Controller\Api\Dossier\UpdateDossier;
use App\Controller\Api\Dossier\UpdateMargeDossier;
use App\Controller\Api\Dossier\ShowDossier;
use App\Controller\Api\Dossier\ShowDossierService;
use App\Controller\Api\Dossier\ShowDossierServiceLimit;
use App\Controller\Api\Dossier\ShowDossierOpen;
use App\Controller\Api\Dossier\ShowDossierClose;
use App\Controller\Api\Dossier\ShowOneDossier;
use App\Controller\Api\Dossier\DeleteDossier;
use App\Controller\Api\Dossier\findDossier;
use App\Controller\Api\Dossier\CloseDossier;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=DossierRepository::class)
 *@ApiResource(
 *     normalizationContext={
 *          "groups"={"dossier:read"}
 *  },
 *     denormalizationContext={
 *          "groups"={"dossier:write"}
 *  },
 *     collectionOperations={
 *        "get"={
 *          "path"= "/dossiers",
 *          "controller"= ShowDossier::class
 *     },
 *       "post"={
 *          "path"= "/dossiers",
 *          "controller"= CreateDossier::class
 *     },
 *       "open"={
 *          "method"="GET",
 *          "path"= "/dossiers/{dossier}/open",
 *          "controller"= ShowDossierOpen::class
 *     },
 *       "close"={
 *          "method"="GET",
 *          "path"= "/dossiers/{dossier}/close",
 *          "controller"= ShowDossierClose::class
 *     },
 *      "closeDossier"={
 *          "method"="GET",
 *          "path"= "/dossiers/{dossier}/close/dossier",
 *          "controller"= CloseDossier::class
 *     },
 *
 *       "dossier_service"={
 *          "method"="GET",
 *          "path"= "/dossiers/{service}/service",
 *          "controller"= ShowDossierService::class
 *     },
 *     "dossier_service_limit"={
 *          "method"="GET",
 *          "path"= "/dossiers/{service}/services",
 *          "controller"= ShowDossierServiceLimit::class
 *     },
 *     "find_dossier"={
 *          "method"="GET",
 *          "path"= "/dossiers/{name}/dossiers",
 *          "controller"=findDossier::class
 *     },
 *        "marge_dossier"={
 *          "method"="GET",
 *          "path"= "/dossiers/marge/{id}/{vente}/{cout}",
 *          "controller"= UpdateMargeDossier::class
 *       },
 *     },
 *     itemOperations={
 *      "get"={
 *          "path"= "/dossiers/{id}",
 *          "controller"= ShowOneDossier::class
 *       },
 *     "put"={
 *          "path"= "/dossiers/{id}",
 *          "controller"= UpdateDossier::class
 *       },
 *     "delete"
 *}
 * )
 */
class Dossier
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"dossier:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"dossier:read","dossier:write"})
     */
    private $nomDossier;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"dossier:read","dossier:write"})
     */
    private $cout;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"dossier:read","dossier:write"})
     */
    private $vente;

    /**
     * @ORM\Column(type="string", length=20)
     * @Groups({"dossier:read","dossier:write"})
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"dossier:read","dossier:write"})
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="dossiers")
     * @Groups({"dossier:read","dossier:write"})
     */
    private $service;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"dossier:read","dossier:write"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"dossier:read","dossier:write"})
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Devis::class, mappedBy="dossier", cascade={"persist"})
     * @Groups({"dossier:read","dossier:write"})
     */
    private $devis;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     * @Groups({"dossier:read","dossier:write"})
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="dossier")
     */
    private $commentaires;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descript;

    public function __construct()
    {
        $this->devis = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDossier(): ?string
    {
        return $this->nomDossier;
    }

    public function setNomDossier(string $nomDossier): self
    {
        $this->nomDossier = $nomDossier;

        return $this;
    }

    public function getCout(): ?float
    {
        return $this->cout;
    }

    public function setCout(?float $cout): self
    {
        $this->cout = $cout;

        return $this;
    }

    public function getVente(): ?float
    {
        return $this->vente;
    }

    public function setVente(?float $vente): self
    {
        $this->vente = $vente;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

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
            $devi->setDossier($this);
        }

        return $this;
    }

    public function removeDevi(Devis $devi): self
    {
        if ($this->devis->contains($devi)) {
            $this->devis->removeElement($devi);
            // set the owning side to null (unless already changed)
            if ($devi->getDossier() === $this) {
                $devi->setDossier(null);
            }
        }

        return $this;
    }

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient(?string $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setDossier($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getDossier() === $this) {
                $commentaire->setDossier(null);
            }
        }

        return $this;
    }

    public function getDescript(): ?string
    {
        return $this->descript;
    }

    public function setDescript(?string $descript): self
    {
        $this->descript = $descript;

        return $this;
    }
}
