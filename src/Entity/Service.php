<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\Api\Service\CreateService;
use App\Controller\Api\Service\UpdateService;
use App\Controller\Api\Service\ShowService;
use App\Controller\Api\Service\ShowOneService;
use App\Controller\Api\Service\ShowOneServiceByName;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ServiceRepository::class)
 * @ApiResource(
 *     normalizationContext={
 *          "groups"={"service:read"}
 *  },
 *     denormalizationContext={
 *          "groups"={"service:write"},
 *  },
 *     collectionOperations={
 *        "get"={
 *          "path"= "/services",
 *          "controller"= ShowService::class
 *     },
 *       "post"={
 *          "path"= "/services",
 *          "controller"= CreateService::class
 *     },
 *     "service"={
 *          "method"="GET",
 *          "path"="/services/service/{service}",
 *          "controller"= ShowOneServiceByName::class
 *     },
 *     },
 *     itemOperations={
 *      "get"={
 *          "path"= "/services/{id}",
 *          "controller"= ShowOneService::class
 *       },
 *     "put"={
 *          "path"= "/services/{id}",
 *          "controller"= UpdateService::class
 *       },
 *     "delete"={
 *          "path"= "/services/{id}",
 *          "controller"= DeleteService::class
 *       },
 *}
 * )
 */
class Service
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"service:read"})
     * @Groups("user:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"service:read","service:write"})
     * @Groups("user:read")
     */
    private $nomService;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"service:read","service:write"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"service:read","service:write"})
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Dossier::class, mappedBy="service", cascade={"persist"})
     * @Groups({"service:read","service:write"})
     */
    private $dossiers;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="service")
     * @Groups({"service:read","service:write"})
     */
    private $users;

    public function __construct()
    {
        $this->dossiers = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomService(): ?string
    {
        return $this->nomService;
    }

    public function setNomService(string $nomService): self
    {
        $this->nomService = $nomService;

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
     * @return Collection|Dossier[]
     */
    public function getDossiers(): Collection
    {
        return $this->dossiers;
    }

    public function addDossier(Dossier $dossier): self
    {
        if (!$this->dossiers->contains($dossier)) {
            $this->dossiers[] = $dossier;
            $dossier->setService($this);
        }

        return $this;
    }

    public function removeDossier(Dossier $dossier): self
    {
        if ($this->dossiers->contains($dossier)) {
            $this->dossiers->removeElement($dossier);
            // set the owning side to null (unless already changed)
            if ($dossier->getService() === $this) {
                $dossier->setService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setService($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getService() === $this) {
                $user->setService(null);
            }
        }

        return $this;
    }
    
}
