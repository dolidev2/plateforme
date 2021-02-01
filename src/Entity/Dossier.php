<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=DossierRepository::class)
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

    public function getCommercial(): ?string
    {
        return $this->commercial;
    }

    public function setCommercial(?string $commercial): self
    {
        $this->commercial = $commercial;

        return $this;
    }
}
