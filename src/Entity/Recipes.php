<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecipesRepository")
 */
class Recipes
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
     * @ORM\Column(type="text")
     */
    private $instructions;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $suggestion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\RecipeType", inversedBy="typeID")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\RecipeCategory", inversedBy="catID")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecipeIngredients", mappedBy="recipe")
     */
    private $ingredients;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecipeHerb", mappedBy="recipe")
     */
    private $RecipeHerb;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Mealcourse", mappedBy="recipe")
     */
    private $mealcourses;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
        $this->RecipeHerb = new ArrayCollection();
        $this->mealcourses = new ArrayCollection();
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

    public function getInstructions(): ?string
    {
        return $this->instructions;
    }

    public function setInstructions(string $instructions): self
    {
        $this->instructions = $instructions;

        return $this;
    }

    public function getSuggestion(): ?string
    {
        return $this->suggestion;
    }

    public function setSuggestion(?string $suggestion): self
    {
        $this->suggestion = $suggestion;

        return $this;
    }

    public function getType(): ?RecipeType
    {
        return $this->type;
    }

    public function setType(?RecipeType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCategory(): ?RecipeCategory
    {
        return $this->category;
    }

    public function setCategory(?RecipeCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|RecipeIngredients[]
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(RecipeIngredients $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients[] = $ingredient;
            $ingredient->setRecipe($this);
        }

        return $this;
    }

    public function removeIngredient(RecipeIngredients $ingredient): self
    {
        if ($this->ingredients->contains($ingredient)) {
            $this->ingredients->removeElement($ingredient);
            // set the owning side to null (unless already changed)
            if ($ingredient->getRecipe() === $this) {
                $ingredient->setRecipe(null);
            }
        }

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
            $recipeHerb->setRecipe($this);
        }

        return $this;
    }

    public function removeRecipeHerb(RecipeHerb $recipeHerb): self
    {
        if ($this->RecipeHerb->contains($recipeHerb)) {
            $this->RecipeHerb->removeElement($recipeHerb);
            // set the owning side to null (unless already changed)
            if ($recipeHerb->getRecipe() === $this) {
                $recipeHerb->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Mealcourse[]
     */
    public function getMealcourses(): Collection
    {
        return $this->mealcourses;
    }

    public function addMealcourse(Mealcourse $mealcourse): self
    {
        if (!$this->mealcourses->contains($mealcourse)) {
            $this->mealcourses[] = $mealcourse;
            $mealcourse->setRecipe($this);
        }

        return $this;
    }

    public function removeMealcourse(Mealcourse $mealcourse): self
    {
        if ($this->mealcourses->contains($mealcourse)) {
            $this->mealcourses->removeElement($mealcourse);
            // set the owning side to null (unless already changed)
            if ($mealcourse->getRecipe() === $this) {
                $mealcourse->setRecipe(null);
            }
        }

        return $this;
    }
}
