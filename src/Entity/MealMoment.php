<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MealMomentRepository")
 */
class MealMoment
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
     * @ORM\OneToMany(targetEntity="App\Entity\MealMomentsCamp", mappedBy="MealMoment")
     */
    private $mealMomentsCamps;

    public function __construct()
    {
        $this->mealMomentsCamps = new ArrayCollection();
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
     * @return Collection|MealMomentsCamp[]
     */
    public function getMealMomentsCamps(): Collection
    {
        return $this->mealMomentsCamps;
    }

    public function addMealMomentsCamp(MealMomentsCamp $mealMomentsCamp): self
    {
        if (!$this->mealMomentsCamps->contains($mealMomentsCamp)) {
            $this->mealMomentsCamps[] = $mealMomentsCamp;
            $mealMomentsCamp->setMealMoment($this);
        }

        return $this;
    }

    public function removeMealMomentsCamp(MealMomentsCamp $mealMomentsCamp): self
    {
        if ($this->mealMomentsCamps->contains($mealMomentsCamp)) {
            $this->mealMomentsCamps->removeElement($mealMomentsCamp);
            // set the owning side to null (unless already changed)
            if ($mealMomentsCamp->getMealMoment() === $this) {
                $mealMomentsCamp->setMealMoment(null);
            }
        }

        return $this;
    }
}
