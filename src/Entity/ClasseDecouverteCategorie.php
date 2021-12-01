<?php

namespace App\Entity;

use App\Repository\ClasseDecouverteCategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClasseDecouverteCategorieRepository::class)
 */
class ClasseDecouverteCategorie
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=ClasseDecouverte::class, mappedBy="categorie")
     */
    private $classeDecouvertes;

    public function __construct()
    {
        $this->classeDecouvertes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|ClasseDecouverte[]
     */
    public function getClasseDecouvertes(): Collection
    {
        return $this->classeDecouvertes;
    }

    public function addClasseDecouverte(ClasseDecouverte $classeDecouverte): self
    {
        if (!$this->classeDecouvertes->contains($classeDecouverte)) {
            $this->classeDecouvertes[] = $classeDecouverte;
            $classeDecouverte->setCategorie($this);
        }

        return $this;
    }

    public function removeClasseDecouverte(ClasseDecouverte $classeDecouverte): self
    {
        if ($this->classeDecouvertes->removeElement($classeDecouverte)) {
            // set the owning side to null (unless already changed)
            if ($classeDecouverte->getCategorie() === $this) {
                $classeDecouverte->setCategorie(null);
            }
        }

        return $this;
    }
}
