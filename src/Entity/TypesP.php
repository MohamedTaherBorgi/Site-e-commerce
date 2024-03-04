<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\TypesPRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypesPRepository")
 */
class TypesP
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomTypes;

    /**
     * @ORM\Column(type="text")
     */
    private $descriptionTypes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Produits", mappedBy="typeProduits")
     */
    private $produits;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomTypes(): ?string
    {
        return $this->nomTypes;
    }

    public function setNomTypes(string $nomTypes): self
    {
        $this->nomTypes = $nomTypes;

        return $this;
    }

    public function getDescriptionTypes(): ?string
    {
        return $this->descriptionTypes;
    }

    public function setDescriptionTypes(?string $descriptionTypes): self
    {
        $this->descriptionTypes = $descriptionTypes;

        return $this;
    }

    public function __toString(): string
    {
        return $this->nomTypes;
    }
}