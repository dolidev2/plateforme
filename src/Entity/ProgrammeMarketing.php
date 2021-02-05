<?php

namespace App\Entity;

use App\Repository\ProgrammeMarketingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProgrammeMarketingRepository::class)
 */
class ProgrammeMarketing
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateFin;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="programmeMarketings")
     */
    private $user;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=TacheMarketing::class, mappedBy="programme")
     */
    private $tacheMarketings;

    public function __construct()
    {
        $this->tacheMarketings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(?\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
     * @return Collection|TacheMarketing[]
     */
    public function getTacheMarketings(): Collection
    {
        return $this->tacheMarketings;
    }

    public function addTacheMarketing(TacheMarketing $tacheMarketing): self
    {
        if (!$this->tacheMarketings->contains($tacheMarketing)) {
            $this->tacheMarketings[] = $tacheMarketing;
            $tacheMarketing->setProgramme($this);
        }

        return $this;
    }

    public function removeTacheMarketing(TacheMarketing $tacheMarketing): self
    {
        if ($this->tacheMarketings->removeElement($tacheMarketing)) {
            // set the owning side to null (unless already changed)
            if ($tacheMarketing->getProgramme() === $this) {
                $tacheMarketing->setProgramme(null);
            }
        }

        return $this;
    }
}
