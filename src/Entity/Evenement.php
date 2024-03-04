<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
#[UniqueEntity('ref_produit')]
class Evenement
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Ce champ ne peut pas être nul')]
    private ?string $ref_produit = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Ce champ ne peut pas être nul')]
    private ?string $type = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Ce champ doit avoir une valeur entière entre 0 et 100')]
    #[Assert\Type(type: 'integer', message: 'Ce champ doit avoir une valeur entière entre 0 et 100')]
    #[Assert\Range(
    min: 0,
    max: 100,   
    notInRangeMessage: 'Ce champ doit avoir une valeur entière entre 0 et 100'
)]
    private ?int $taux_remise = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRefProduit(): ?string
    {
        return $this->ref_produit;
    }

    public function setRefProduit(string $ref_produit): static
    {
        $this->ref_produit = $ref_produit;

        return $this;
    }


    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getTauxRemise(): ?int
    {
        return $this->taux_remise;
    }

    public function setTauxRemise(int $taux_remise): static
    {
        $this->taux_remise = $taux_remise;

        return $this;
    }
}
