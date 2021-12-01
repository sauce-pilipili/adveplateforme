<?php

namespace App\Entity;

use App\Repository\CentresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=CentresRepository::class)
 */
class Centres
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
     * @ORM\Column(type="string", length=255)
     */
    private $localisation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ageMin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ageMax;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photoCadre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $legendePhotoCadre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photoEncadrement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $legendePhotoEncadrement;

    /**
     * @ORM\Column(type="text")
     */
    private $cadreDeVie;

    /**
     * @ORM\Column(type="text")
     */
    private $Encadrement;

    /**
     * @ORM\Column(type="text")
     */
    private $centrePlus;



    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photoEnAvant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $legendePhotoEnAvant;

    /**
     * @ORM\ManyToOne(targetEntity=CentresCategories::class, inversedBy="centres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorieCentre;

    /**
     * @ORM\OneToMany(targetEntity=Sejours::class, mappedBy="centre")
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

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getAgeMin(): ?string
    {
        return $this->ageMin;
    }

    public function setAgeMin(string $ageMin): self
    {
        $this->ageMin = $ageMin;

        return $this;
    }

    public function getAgeMax(): ?string
    {
        return $this->ageMax;
    }

    public function setAgeMax(string $ageMax): self
    {
        $this->ageMax = $ageMax;

        return $this;
    }

    public function getPhotoCadre(): ?string
    {
        return $this->photoCadre;
    }

    public function setPhotoCadre(string $photoCadre): self
    {
        $this->photoCadre = $photoCadre;

        return $this;
    }

    public function getLegendePhotoCadre(): ?string
    {
        return $this->legendePhotoCadre;
    }

    public function setLegendePhotoCadre(string $legendePhotoCadre): self
    {
        $this->legendePhotoCadre = $legendePhotoCadre;

        return $this;
    }

    public function getPhotoEncadrement(): ?string
    {
        return $this->photoEncadrement;
    }

    public function setPhotoEncadrement(string $photoEncadrement): self
    {
        $this->photoEncadrement = $photoEncadrement;

        return $this;
    }

    public function getLegendePhotoEncadrement(): ?string
    {
        return $this->legendePhotoEncadrement;
    }

    public function setLegendePhotoEncadrement(string $legendePhotoEncadrement): self
    {
        $this->legendePhotoEncadrement = $legendePhotoEncadrement;

        return $this;
    }

    public function getCadreDeVie(): ?string
    {
        return $this->cadreDeVie;
    }

    public function setCadreDeVie(string $cadreDeVie): self
    {
        $this->cadreDeVie = $cadreDeVie;

        return $this;
    }

    public function getEncadrement(): ?string
    {
        return $this->Encadrement;
    }

    public function setEncadrement(string $Encadrement): self
    {
        $this->Encadrement = $Encadrement;

        return $this;
    }

    public function getCentrePlus(): ?string
    {
        return $this->centrePlus;
    }

    public function setCentrePlus(string $centrePlus): self
    {
        $this->centrePlus = $centrePlus;

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

    public function getLegendePhotoEnAvant(): ?string
    {
        return $this->legendePhotoEnAvant;
    }

    public function setLegendePhotoEnAvant(string $legendePhotoEnAvant): self
    {
        $this->legendePhotoEnAvant = $legendePhotoEnAvant;

        return $this;
    }

    public function getCategorieCentre(): ?CentresCategories
    {
        return $this->categorieCentre;
    }

    public function setCategorieCentre(?CentresCategories $categorieCentre): self
    {
        $this->categorieCentre = $categorieCentre;

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
            $sejour->setCentre($this);
        }

        return $this;
    }

    public function removeSejour(Sejours $sejour): self
    {
        if ($this->sejours->removeElement($sejour)) {
            // set the owning side to null (unless already changed)
            if ($sejour->getCentre() === $this) {
                $sejour->setCentre(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
     return $this->getName();
    }


}
