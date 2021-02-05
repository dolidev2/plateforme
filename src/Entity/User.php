<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)

     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $password;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;
    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="users")
     */
    private $service;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="user")
     */
    private $commentaires;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity=Creation::class, mappedBy="user")
     */
    private $creations;

    /**
     * @ORM\OneToMany(targetEntity=Facture::class, mappedBy="user")
     */
    private $factures;

    /**
     * @ORM\OneToMany(targetEntity=Commercial::class, mappedBy="user")
     */
    private $commercials;

    /**
     * @ORM\OneToMany(targetEntity=FichierComptabilite::class, mappedBy="user")
     */
    private $fichierComptabilite;

    /**
     * @ORM\OneToMany(targetEntity=Comptabilite::class, mappedBy="user")
     */
    private $comptabilites;

    /**
     * @ORM\OneToMany(targetEntity=ProgrammeMarketing::class, mappedBy="user")
     */
    private $programmeMarketings;

    /**
     * @ORM\OneToMany(targetEntity=TacheMarketing::class, mappedBy="user")
     */
    private $tacheMarketings;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->creations = new ArrayCollection();
        $this->factures = new ArrayCollection();
        $this->commercials = new ArrayCollection();
        $this->fichierComptabilite = new ArrayCollection();
        $this->comptabilites = new ArrayCollection();
        $this->programmeMarketings = new ArrayCollection();
        $this->tacheMarketings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    public function getRoles():array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }
    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
        return null;
    }

   

    public function setRoles(array $role): self
    {
        $this->roles = $role;

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
            $commentaire->setUser($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getUser() === $this) {
                $commentaire->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Creation[]
     */
    public function getCreations(): Collection
    {
        return $this->creations;
    }

    public function addCreation(Creation $creation): self
    {
        if (!$this->creations->contains($creation)) {
            $this->creations[] = $creation;
            $creation->setUser($this);
        }

        return $this;
    }

    public function removeCreation(Creation $creation): self
    {
        if ($this->creations->contains($creation)) {
            $this->creations->removeElement($creation);
            // set the owning side to null (unless already changed)
            if ($creation->getUser() === $this) {
                $creation->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Facture[]
     */
    public function getFactures(): Collection
    {
        return $this->factures;
    }

    public function addFacture(Facture $facture): self
    {
        if (!$this->factures->contains($facture)) {
            $this->factures[] = $facture;
            $facture->setUser($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): self
    {
        if ($this->factures->removeElement($facture)) {
            // set the owning side to null (unless already changed)
            if ($facture->getUser() === $this) {
                $facture->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commercial[]
     */
    public function getCommercials(): Collection
    {
        return $this->commercials;
    }

    public function addCommercial(Commercial $commercial): self
    {
        if (!$this->commercials->contains($commercial)) {
            $this->commercials[] = $commercial;
            $commercial->setUser($this);
        }

        return $this;
    }

    public function removeCommercial(Commercial $commercial): self
    {
        if ($this->commercials->removeElement($commercial)) {
            // set the owning side to null (unless already changed)
            if ($commercial->getUser() === $this) {
                $commercial->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FichierComptabilite[]
     */
    public function getFichierComptabilite(): Collection
    {
        return $this->fichierComptabilite;
    }

    public function addFichierComptabilite(FichierComptabilite $comptabilite): self
    {
        if (!$this->fichierComptabilite->contains($comptabilite)) {
            $this->fichierComptabilite[] = $comptabilite;
            $comptabilite->setUser($this);
        }

        return $this;
    }

    public function removeFichierComptabilite(FichierComptabilite $comptabilite): self
    {
        if ($this->fichierComptabilite->removeElement($comptabilite)) {
            // set the owning side to null (unless already changed)
            if ($comptabilite->getUser() === $this) {
                $comptabilite->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comptabilite[]
     */
    public function getComptabilites(): Collection
    {
        return $this->comptabilites;
    }

    public function addComptabilite(Comptabilite $comptabilite): self
    {
        if (!$this->comptabilites->contains($comptabilite)) {
            $this->comptabilites[] = $comptabilite;
            $comptabilite->setUser($this);
        }

        return $this;
    }

    public function removeComptabilite(Comptabilite $comptabilite): self
    {
        if ($this->comptabilites->removeElement($comptabilite)) {
            // set the owning side to null (unless already changed)
            if ($comptabilite->getUser() === $this) {
                $comptabilite->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProgrammeMarketing[]
     */
    public function getProgrammeMarketings(): Collection
    {
        return $this->programmeMarketings;
    }

    public function addProgrammeMarketing(ProgrammeMarketing $programmeMarketing): self
    {
        if (!$this->programmeMarketings->contains($programmeMarketing)) {
            $this->programmeMarketings[] = $programmeMarketing;
            $programmeMarketing->setUser($this);
        }

        return $this;
    }

    public function removeProgrammeMarketing(ProgrammeMarketing $programmeMarketing): self
    {
        if ($this->programmeMarketings->removeElement($programmeMarketing)) {
            // set the owning side to null (unless already changed)
            if ($programmeMarketing->getUser() === $this) {
                $programmeMarketing->setUser(null);
            }
        }

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
            $tacheMarketing->setUser($this);
        }

        return $this;
    }

    public function removeTacheMarketing(TacheMarketing $tacheMarketing): self
    {
        if ($this->tacheMarketings->removeElement($tacheMarketing)) {
            // set the owning side to null (unless already changed)
            if ($tacheMarketing->getUser() === $this) {
                $tacheMarketing->setUser(null);
            }
        }

        return $this;
    }
}
