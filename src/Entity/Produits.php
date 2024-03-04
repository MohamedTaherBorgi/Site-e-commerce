<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\ProduitsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\Unique;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProduitsRepository")
 * @UniqueEntity(fields={"nomProduits"}, message="Ce nom de produit est déjà utilisé.")
 */
class Produits
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
    private $referenceProduits;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomProduits;

    /**
     * @ORM\Column(type="text")
     */
    private $descriptionProduits;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypesP", inversedBy="produits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeProduits;

    /**
     * @ORM\Column(type="integer")
     */
    private $stock;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Categories", inversedBy="produits")
     */
    private $categories;

    /**
     * @ORM\Column(type="json")
     */
    private $imageProduits;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReferenceProduits(): ?string
    {
        return $this->referenceProduits;
    }

    public function setReferenceProduits(string $referenceProduits): self
    {
        $this->referenceProduits = $referenceProduits;

        return $this;
    }

    public function getNomProduits(): ?string
    {
        return $this->nomProduits;
    }

    public function setNomProduits(string $nomProduits): self
    {
        $this->nomProduits = $nomProduits;

        return $this;
    }

    public function getDescriptionProduits(): ?string
    {
        return $this->descriptionProduits;
    }

    public function setDescriptionProduits(string $descriptionProduits): self
    {
        $this->descriptionProduits = $descriptionProduits;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getTypeProduits(): ?TypesP
    {
        return $this->typeProduits;
    }

    public function setTypeProduits(?TypesP $typeProduits): self
    {
        $this->typeProduits = $typeProduits;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * @return Collection|Categories[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categories $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Categories $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getImageProduits()
    {
        return $this->imageProduits;
    }

    public function setImageProduits($imageProduits): self
    {
        $this->imageProduits = $imageProduits;

        return $this;
    }
}
