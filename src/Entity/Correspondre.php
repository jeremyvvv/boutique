<?php

namespace App\Entity;

use App\Repository\CorrespondreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CorrespondreRepository::class)
 */
class Correspondre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Tag::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_tag;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_produit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdTag(): ?Tag
    {
        return $this->id_tag;
    }

    public function setIdTag(?Tag $id_tag): self
    {
        $this->id_tag = $id_tag;

        return $this;
    }

    public function getIdProduit(): ?Produit
    {
        return $this->id_produit;
    }

    public function setIdProduit(?Produit $id_produit): self
    {
        $this->id_produit = $id_produit;

        return $this;
    }
}
