<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoriesRepository")
 */
class Categories
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
    private $nomCategories;

    /**
     * @ORM\Column(type="text")
     */
    private $descriptionCategories;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Produits", mappedBy="categories")
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

    public function getNomCategories(): ?string
    {
        return $this->nomCategories;
    }

    public function setNomCategories(string $nomCategories): self
    {
        $this->nomCategories = $nomCategories;

        return $this;
    }

    public function getDescriptionCategories(): ?string
    {
        return $this->descriptionCategories;
    }

    public function setDescriptionCategories(string $descriptionCategories): self
    {
        $this->descriptionCategories = $descriptionCategories;

        return $this;
    }

    /**
     * @return Collection|Produits[]
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produits $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
        }

        return $this;
    }

    public function removeProduit(Produits $produit): self
    {
        $this->produits->removeElement($produit);

        return $this;
    }

    public function __toString(): string
    {
        return $this->nomCategories;
    }
}