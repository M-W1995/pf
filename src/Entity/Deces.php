<?php

namespace App\Entity;

use App\Repository\DecesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DecesRepository::class)
 */
class Deces
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
    private $civilite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $message;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cle;

    /**
     * @ORM\OneToMany(targetEntity=Condoleances::class, mappedBy="Deces", orphanRemoval=true)
     * @ORM\OrderBy({"id" = "DESC"})
     */
    private $condoleances;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $naissance;

    /**
     * @ORM\Column(type="integer")
     */
    private $age;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $bougies;

    public function __construct()
    {
        $this->condoleances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCivilite(): ?string
    {
        return $this->civilite;
    }

    public function setCivilite(string $civilite): self
    {
        $this->civilite = $civilite;

        return $this;
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

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getCle(): ?string
    {
        return $this->cle;
    }

    public function setCle(string $cle): self
    {
        $this->cle = $cle;

        return $this;
    }

    /**
     * @return Collection|Condoleances[]
     */
    public function getCondoleances(): Collection
    {
        return $this->condoleances;
    }

    public function addCondoleance(Condoleances $condoleance): self
    {
        if (!$this->condoleances->contains($condoleance)) {
            $this->condoleances[] = $condoleance;
            $condoleance->setDeces($this);
        }

        return $this;
    }

    public function removeCondoleance(Condoleances $condoleance): self
    {
        if ($this->condoleances->removeElement($condoleance)) {
            // set the owning side to null (unless already changed)
            if ($condoleance->getDeces() === $this) {
                $condoleance->setDeces(null);
            }
        }

        return $this;
    }

    public function getNaissance(): ?string
    {
        return $this->naissance;
    }

    public function setNaissance(string $naissance): self
    {
        $this->naissance = $naissance;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getBougies(): ?int
    {
        return $this->bougies;
    }

    public function setBougies(?int $bougies): self
    {
        $this->bougies = $bougies;

        return $this;
    }
}
