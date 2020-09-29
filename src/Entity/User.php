<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\Api\User\CreateUser;
use App\Controller\Api\User\UpdateUser;
use App\Controller\Api\User\ShowUser;
use App\Controller\Api\User\ShowOneUser;
use App\Controller\Api\User\LoginUser;
use App\Controller\Api\User\PasswordResetUser;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ApiResource(
 *     normalizationContext={
 *      "groups"={"user:read"}
 *     },
 *     denormalizationContext={
 *       "groups"={"user:write"}
 *     },
 *     collectionOperations={
 *      "get"={
 *          "path"= "/users",
 *          "controller"= ShowUser::class
 *     },
 *      "post"={
 *          "path"= "/users",
 *          "controller"= CreateUser::class
 *     },
 *      "login"={
 *          "method"="POST",
 *          "path"= "/users/login",
 *          "controller"= LoginUser::class
 *     },
 *        "Passwordreset"={
 *          "method"="POST",
 *          "path"= "/users/password",
 *          "controller"= PasswordResetUser::class
 *     }
 *     },
 *     itemOperations={
 *      "get"={
 *          "path"= "/users/{id}",
 *          "controller"= ShowOneUser::class
 *     },
 *      "put"={
 *          "path"= "/users/{id}",
 *          "controller"= UpdateUser::class
 *     },
 *      "delete"={
 *          "path"= "/users/{id}",
 *          "controller"= DeleteUser::class
 *     }
 *     }
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("user:read")
     * @Groups("user:write")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups("user:read")
     * @Groups("user:write")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Groups("user:read")
     * @Groups("user:write")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups("user:read")
     * @Groups("user:write")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups("user:read")
     * @Groups("user:write")
     */
    private $password;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("user:read")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("user:read")
     * @Groups("user:write")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=70)
     * @Groups({"user:read","user:write"})
     */
    private $role;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="users")
     * @Groups({"user:read","user:write"})
     */
    private $service;


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
    public function getRoles()
    {
        return ['role'=>''];
    }
    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
        return null;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

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



}
