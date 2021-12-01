<?php

namespace App\Entity;

use App\Repository\SejoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=SejoursRepository::class)
 */
class Sejours
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
    private $titre;

    /**
     * @Gedmo\Slug(fields={"titre"})
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
    private $introduction;

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
    private $prixMin;

    /**
     * @ORM\Column(type="text")
     */
    private $cadreDeVie;

    /**
     * @ORM\Column(type="text")
     */
    private $encadrement;

    /**
     * @ORM\Column(type="text")
     */
    private $plusDuSejour;

    /**
     * @ORM\Column(type="text")
     */
    private $indispensables;

    /**
     * @ORM\Column(type="text")
     */
    private $activitesDominantes;

    /**
     * @ORM\Column(type="text")
     */
    private $activitesAnnexes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photoEnAvant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $legendePhotoEnAvant;

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
    private $dateSejour;

    /**
     * @ORM\ManyToOne(targetEntity=Saisons::class, inversedBy="sejours")
     * @ORM\JoinColumn(nullable=false)
     */
    private $saisons;

    /**
     * @ORM\ManyToMany(targetEntity=DureeSejour::class, inversedBy="sejours", cascade={"persist"})
     */
    private $dureeSejour;

    /**
     * @ORM\ManyToOne(targetEntity=Activites::class, inversedBy="sejours")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activite;

    /**
     * @ORM\ManyToOne(targetEntity=Centres::class, inversedBy="sejours")
     * @ORM\JoinColumn(nullable=false)
     */
    private $centre;

    public function __construct()
    {
        $this->dureeSejour = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

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

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(string $introduction): self
    {
        $this->introduction = $introduction;

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

    public function getPrixMin(): ?string
    {
        return $this->prixMin;
    }

    public function setPrixMin(string $prixMin): self
    {
        $this->prixMin = $prixMin;

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
        return $this->encadrement;
    }

    public function setEncadrement(string $encadrement): self
    {
        $this->encadrement = $encadrement;

        return $this;
    }

    public function getPlusDuSejour(): ?string
    {
        return $this->plusDuSejour;
    }

    public function setPlusDuSejour(string $plusDuSejour): self
    {
        $this->plusDuSejour = $plusDuSejour;

        return $this;
    }

    public function getIndispensables(): ?string
    {
        return $this->indispensables;
    }

    public function setIndispensables(string $indispensables): self
    {
        $this->indispensables = $indispensables;

        return $this;
    }

    public function getActivitesDominantes(): ?string
    {
        return $this->activitesDominantes;
    }

    public function setActivitesDominantes(string $activitesDominantes): self
    {
        $this->activitesDominantes = $activitesDominantes;

        return $this;
    }

    public function getActivitesAnnexes(): ?string
    {
        return $this->activitesAnnexes;
    }

    public function setActivitesAnnexes(string $activitesAnnexes): self
    {
        $this->activitesAnnexes = $activitesAnnexes;

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

    public function getDateSejour(): ?string
    {
        return $this->dateSejour;
    }

    public function setDateSejour(string $dateSejour): self
    {
        $this->dateSejour = $dateSejour;

        return $this;
    }

    public function getSaisons(): ?Saisons
    {
        return $this->saisons;
    }

    public function setSaisons(?Saisons $saisons): self
    {
        $this->saisons = $saisons;

        return $this;
    }

    /**
     * @return Collection|DureeSejour[]
     */
    public function getDureeSejour(): Collection
    {
        return $this->dureeSejour;
    }

    public function addDureeSejour(DureeSejour $dureeSejour): self
    {
        if (!$this->dureeSejour->contains($dureeSejour)) {
            $this->dureeSejour[] = $dureeSejour;
        }

        return $this;
    }

    public function removeDureeSejour(DureeSejour $dureeSejour): self
    {
        $this->dureeSejour->removeElement($dureeSejour);

        return $this;
    }

    public function getActivite(): ?Activites
    {
        return $this->activite;
    }

    public function setActivite(?Activites $activite): self
    {
        $this->activite = $activite;

        return $this;
    }

    public function getCentre(): ?Centres
    {
        return $this->centre;
    }

    public function setCentre(?Centres $centre): self
    {
        $this->centre = $centre;

        return $this;
    }
}
