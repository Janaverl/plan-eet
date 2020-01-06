<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecipeHerbRepository")
 */
class RecipeHerb
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Herb", inversedBy="RecipeHerb")
     * @ORM\JoinColumn(nullable=false)
     */
    private $herb;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Recipes", inversedBy="RecipeHerb")
     * @ORM\JoinColumn(nullable=false)
     */
    private $recipe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHerb(): ?Herb
    {
        return $this->herb;
    }

    public function setHerb(?Herb $herb): self
    {
        $this->herb = $herb;

        return $this;
    }

    public function getRecipe(): ?Recipes
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipes $recipe): self
    {
        $this->recipe = $recipe;

        return $this;
    }
}
