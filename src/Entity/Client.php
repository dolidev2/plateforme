<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\Api\Client\CreateClient;
use App\Controller\Api\Client\UpdateClient;
use App\Controller\Api\Client\ShowOneClient;
use App\Controller\Api\Client\ShowClient;
use App\Controller\Api\Client\DeleteClient;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 *@ApiResource(
 *     normalizationContext={
 *          "groups"={"client:read"}
 *  },
 *     denormalizationContext={
 *          "groups"={"client:write"}
 *  },
 *     collectionOperations={
 *        "get"={
 *          "path"= "/clients",
 *          "controller"= ShowClient::class
 *     },
 *       "post"={
 *          "path"= "/clients",
 *          "controller"= CreateClient::class
 *     },
 *     },
 *     itemOperations={
 *      "get"={
 *          "path"= "/clients/{id}",
 *          "controller"= ShowOneClient::class
 *       },
 *     "put"={
 *          "path"= "/clients/{id}",
 *          "controller"= UpdateClient::class
 *       },
 *     "delete"={
 *          "path"= "/clients/{id}",
 *          "controller"= DeleteClient::class
 *       },
 *}
 * )
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"client:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Groups({"client:read"})
     *  @Groups({"client:write"})
     */
    private $nomClient;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"client:read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"client:read"})
     * @Groups({"client:write"})
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomClient(): ?string
    {
        return $this->nomClient;
    }

    public function setNomClient(?string $nomClient): self
    {
        $this->nomClient = $nomClient;

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
