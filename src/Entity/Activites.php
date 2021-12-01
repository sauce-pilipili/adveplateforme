<?php

namespace App\Entity;

use App\Repository\ActivitesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=ActivitesRepository::class)
 */
class Activites
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
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $metaDescription;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     */
    private $histoire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $citation;

    /**
     * @ORM\Column(type="text")
     */
    private $discipline;

    /**
     * @ORM\Column(type="text")
     */
    private $equipement;

    /**
     * @ORM\Column(type="text")
     */
    private $aptitudes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photoEnAvant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $legendeEnAvant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photoHistoire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $legendeHistoire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photoDiscipline;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $legendePhotoDiscipline;

    /**
     * @ORM\ManyToOne(targetEntity=ActiviteCategorie::class, inversedBy="activites")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity=Sejours::class, mappedBy="activite")
     */
    private $sejours;

    public function __construct()
    {
        $this->sejours = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(string $metaDescription): self
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getHistoire(): ?string
    {
        return $this->histoire;
    }

    public function setHistoire(string $histoire): self
    {
        $this->histoire = $histoire;

        return $this;
    }

    public function getCitation(): ?string
    {
        return $this->citation;
    }

    public function setCitation(?string $citation): self
    {
        $this->citation = $citation;

        return $this;
    }

    public function getDiscipline(): ?string
    {
        return $this->discipline;
    }

    public function setDiscipline(string $discipline): self
    {
        $this->discipline = $discipline;

        return $this;
    }

    public function getEquipement(): ?string
    {
        return $this->equipement;
    }

    public function setEquipement(string $equipement): self
    {
        $this->equipement = $equipement;

        return $this;
    }

    public function getAptitudes(): ?string
    {
        return $this->aptitudes;
    }

    public function setAptitudes(string $aptitudes): self
    {
        $this->aptitudes = $aptitudes;

        return $this;
    }

    public function getPhotoEnAvant(): ?string
    {
        return $this->photoEnAvant;
    }

    public function setPhotoEnAvant(string $photoEnAvant): self
    {
        $this->photoEnAvant = $photoEnAvant;

        return $this;
    }

    public function getLegendeEnAvant(): ?string
    {
        return $this->legendeEnAvant;
    }

    public function setLegendeEnAvant(string $legendeEnAvant): self
    {
        $this->legendeEnAvant = $legendeEnAvant;

        return $this;
    }

    public function getPhotoHistoire(): ?string
    {
        return $this->photoHistoire;
    }

    public function setPhotoHistoire(string $photoHistoire): self
    {
        $this->photoHistoire = $photoHistoire;

        return $this;
    }

    public function getLegendeHistoire(): ?string
    {
        return $this->legendeHistoire;
    }

    public function setLegendeHistoire(string $legendeHistoire): self
    {
        $this->legendeHistoire = $legendeHistoire;

        return $this;
    }

    public function getPhotoDiscipline(): ?string
    {
        return $this->photoDiscipline;
    }

    public function setPhotoDiscipline(string $photoDiscipline): self
    {
        $this->photoDiscipline = $photoDiscipline;

        return $this;
    }

    public function getLegendePhotoDiscipline(): ?string
    {
        return $this->legendePhotoDiscipline;
    }

    public function setLegendePhotoDiscipline(string $legendePhotoDiscipline): self
    {
        $this->legendePhotoDiscipline = $legendePhotoDiscipline;

        return $this;
    }

    public function getCategorie(): ?ActiviteCategorie
    {
        return $this->categorie;
    }

    public function setCategorie(?ActiviteCategorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection|Sejours[]
     */
    public function getSejours(): Collection
    {
        return $this->sejours;
    }

    public function addSejour(Sejours $sejour): self
    {
        if (!$this->sejours->contains($sejour)) {
            $this->sejours[] = $sejour;
            $sejour->setActivite($this);
        }

        return $this;
    }

    public function removeSejour(Sejours $sejour): self
    {
        if ($this->sejours->removeElement($sejour)) {
            // set the owning side to null (unless already changed)
            if ($sejour->getActivite() === $this) {
                $sejour->setActivite(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
     return $this->getName();
    }
}
