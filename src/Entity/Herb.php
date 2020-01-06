<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HerbRepository")
 */
class Herb
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=190, unique=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecipeHerb", mappedBy="herb")
     */
    private $RecipeHerb;

    public function __construct()
    {
        $this->RecipeHerb = new ArrayCollection();
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
     * @return Collection|RecipeHerb[]
     */
    public function getRecipeHerb(): Collection
    {
        return $this->RecipeHerb;
    }

    public function addRecipeHerb(RecipeHerb $recipeHerb): self
    {
        if (!$this->RecipeHerb->contains($recipeHerb)) {
            $this->RecipeHerb[] = $recipeHerb;
            $recipeHerb->setHerb($this);
        }

        return $this;
    }

    public function removeRecipeHerb(RecipeHerb $recipeHerb): self
    {
        if ($this->RecipeHerb->contains($recipeHerb)) {
            $this->RecipeHerb->removeElement($recipeHerb);
            // set the owning side to null (unless already changed)
            if ($recipeHerb->getHerb() === $this) {
                $recipeHerb->setHerb(null);
            }
        }

        return $this;
    }
}
