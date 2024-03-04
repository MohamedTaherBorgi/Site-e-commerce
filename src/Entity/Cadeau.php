<?php

namespace App\Entity;

use App\Repository\CadeauRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CadeauRepository::class)]
#[UniqueEntity('evenement')]
class Cadeau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_produit = null;

    #[ORM\Column(length: 255)]
    private ?string $evenement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProduit(): ?string
    {
        return $this->nom_produit;
    }

    public function setNomProduit(string $nom_produit): static
    {
        $this->nom_produit = $nom_produit;

        return $this;
    }

    public function getEvenement(): ?int
    {
        return $this->evenement;
    }

    public function setEvenement(string $evenement): static
    {
        $this->evenement = $evenement;

        return $this;
    }
}
