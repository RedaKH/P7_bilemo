<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Hateoas\Configuration\Annotation as Hateoas;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Annotations as OA;


/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @OA\Schema
 */


class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("show_product")
     * @OA\Property(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("show_product")
     * @OA\Property(type="string",nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=555, nullable=true)
     * @Groups("show_product")
     * @OA\Property(type="string",nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="float", nullable=true)
     *@Groups("show_product")
     *@OA\Property(type="float",nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *@Groups("show_product")
     *@OA\Property(type="datetime",nullable=true)
     */
    private $created_at;



 



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

 

}
