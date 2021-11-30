<?php

namespace App\Entity;

use App\Repository\InterCategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InterCategorieRepository::class)
 */
class InterCategorie
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
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=Inter::class, mappedBy="categorie", orphanRemoval=true)
     */
    private $inters;

    public function __construct()
    {
        $this->inters = new ArrayCollection();
    }

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

    /**
     * @return Collection|Inter[]
     */
    public function getInters(): Collection
    {
        return $this->inters;
    }

    public function addInter(Inter $inter): self
    {
        if (!$this->inters->contains($inter)) {
            $this->inters[] = $inter;
            $inter->setCategorie($this);
        }

        return $this;
    }

    public function removeInter(Inter $inter): self
    {
        if ($this->inters->removeElement($inter)) {
            // set the owning side to null (unless already changed)
            if ($inter->getCategorie() === $this) {
                $inter->setCategorie(null);
            }
        }

        return $this;
    }
}
