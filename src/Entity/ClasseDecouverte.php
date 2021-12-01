<?php

namespace App\Entity;

use App\Repository\ClasseDecouverteRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=ClasseDecouverteRepository::class)
 */
class ClasseDecouverte
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
     * @ORM\Column(type="text")
     */
    private $presentation;

    /**
     * @ORM\Column(type="text")
     */
    private $encadrement;

    /**
     * @ORM\Column(type="text")
     */
    private $hebergement;

    /**
     * @ORM\Column(type="text")
     */
    private $decouverte;

    /**
     * @ORM\Column(type="text")
     */
    private $animation;

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
    private $photoClasse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $legendePhotoClasse;

    /**
     * @ORM\ManyToOne(targetEntity=ClasseDecouverteCategorie::class, inversedBy="classeDecouvertes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

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

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

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

    public function getHebergement(): ?string
    {
        return $this->hebergement;
    }

    public function setHebergement(string $hebergement): self
    {
        $this->hebergement = $hebergement;

        return $this;
    }

    public function getDecouverte(): ?string
    {
        return $this->decouverte;
    }

    public function setDecouverte(string $decouverte): self
    {
        $this->decouverte = $decouverte;

        return $this;
    }

    public function getAnimation(): ?string
    {
        return $this->animation;
    }

    public function setAnimation(string $animation): self
    {
        $this->animation = $animation;

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

    public function getPhotoClasse(): ?string
    {
        return $this->photoClasse;
    }

    public function setPhotoClasse(string $photoClasse): self
    {
        $this->photoClasse = $photoClasse;

        return $this;
    }

    public function getLegendePhotoClasse(): ?string
    {
        return $this->legendePhotoClasse;
    }

    public function setLegendePhotoClasse(string $legendePhotoClasse): self
    {
        $this->legendePhotoClasse = $legendePhotoClasse;

        return $this;
    }

    public function getCategorie(): ?ClasseDecouverteCategorie
    {
        return $this->categorie;
    }

    public function setCategorie(?ClasseDecouverteCategorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}
