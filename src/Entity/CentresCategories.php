<?php

namespace App\Entity;

use App\Repository\CentresCategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CentresCategoriesRepository::class)
 */
class CentresCategories
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
     * @ORM\OneToMany(targetEntity=Centres::class, mappedBy="categorieCentre")
     */
    private $centres;

    public function __construct()
    {
        $this->centres = new ArrayCollection();
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
     * @return Collection|Centres[]
     */
    public function getCentres(): Collection
    {
        return $this->centres;
    }

    public function addCentre(Centres $centre): self
    {
        if (!$this->centres->contains($centre)) {
            $this->centres[] = $centre;
            $centre->setCategorieCentre($this);
        }

        return $this;
    }

    public function removeCentre(Centres $centre): self
    {
        if ($this->centres->removeElement($centre)) {
            // set the owning side to null (unless already changed)
            if ($centre->getCategorieCentre() === $this) {
                $centre->setCategorieCentre(null);
            }
        }

        return $this;
    }



}
