<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MealcourseRepository")
 */
class Mealcourse
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Campmeal", inversedBy="mealcourses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $campmeal;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Recipes", inversedBy="mealcourses")
     */
    private $recipe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCampmeal(): ?Campmeal
    {
        return $this->campmeal;
    }

    public function setCampmeal(?Campmeal $campmeal): self
    {
        $this->campmeal = $campmeal;

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
