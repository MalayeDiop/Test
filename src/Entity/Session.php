<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dated = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $datef = null;

    /**
     * @var Collection<int, Classe>
     */
    #[ORM\ManyToOne(targetEntity: Classe::class, inversedBy: 'session')]
    private Collection $Classe;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'], inversedBy: 'session')]
    private ?Cours $Cours = null;

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

    public function getDated(): ?\DateTimeImmutable
    {
        return $this->dated;
    }

    public function setDated(\DateTimeImmutable $dated): static
    {
        $this->dated = $dated;

        return $this;
    }

    public function getDatef(): ?\DateTimeImmutable
    {
        return $this->datef;
    }

    public function setDatef(\DateTimeImmutable $datef): static
    {
        $this->datef = $datef;

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
            $classe->setSession($this);
        }

        return $this;
    }

    public function removeClasse(Classe $classe): static
    {
        if ($this->Classe->removeElement($classe)) {
            // set the owning side to null (unless already changed)
            if ($classe->getSession() === $this) {
                $classe->setSession(null);
            }
        }

        return $this;
    }

    public function getCours(): ?Cours
    {
        return $this->Cours;
    }

    public function setCours(?Cours $Cours): static
    {
        $this->Cours = $Cours;

        return $this;
    }
}
