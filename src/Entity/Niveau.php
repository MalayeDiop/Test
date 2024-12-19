<?php

namespace App\Entity;

use App\Repository\NiveauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NiveauRepository::class)]
class Niveau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom_niveau = null;

    /**
     * @var Collection<int, Classe>
     */
    #[ORM\OneToMany(targetEntity: Classe::class, mappedBy: 'niveau')]
    private Collection $Classe;

    public function __construct()
    {
        $this->Classe = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getNomNiveau(): ?string
    {
        return $this->nom_niveau;
    }

    public function setNomNiveau(string $nom_niveau): static
    {
        $this->nom_niveau = $nom_niveau;

        return $this;
    }

    /**
     * @return Collection<int, Classe>
     */
    public function getClasse(): Collection
    {
        return $this->Classe;
    }

    public function addClasse(Classe $classe): static
    {
        if (!$this->Classe->contains($classe)) {
            $this->Classe->add($classe);
            $classe->setNiveau($this);
        }

        return $this;
    }

    public function removeClasse(Classe $classe): static
    {
        if ($this->Classe->removeElement($classe)) {
            // set the owning side to null (unless already changed)
            if ($classe->getNiveau() === $this) {
                $classe->setNiveau(null);
            }
        }

        return $this;
    }
}
