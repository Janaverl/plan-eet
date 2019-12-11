<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecipeCategoryRepository")
 */
class RecipeCategory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Recipes", mappedBy="category")
     */
    private $catID;

    public function __construct()
    {
        $this->catID = new ArrayCollection();
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
     * @return Collection|Recipes[]
     */
    public function getCatID(): Collection
    {
        return $this->catID;
    }

    public function addCatID(Recipes $catID): self
    {
        if (!$this->catID->contains($catID)) {
            $this->catID[] = $catID;
            $catID->setCategory($this);
        }

        return $this;
    }

    public function removeCatID(Recipes $catID): self
    {
        if ($this->catID->contains($catID)) {
            $this->catID->removeElement($catID);
            // set the owning side to null (unless already changed)
            if ($catID->getCategory() === $this) {
                $catID->setCategory(null);
            }
        }

        return $this;
    }
}
