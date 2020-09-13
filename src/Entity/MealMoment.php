<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MealMomentRepository")
 */
class Mealmoment
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
     * @ORM\OneToMany(targetEntity="App\Entity\CampMealmoments", mappedBy="mealmoment")
     */
    private $campMealmoments;

    public function __construct()
    {
        $this->campMealmoments = new ArrayCollection();
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
     * @return Collection|CampMealmoments[]
     */
    public function getCampMealmoments(): Collection
    {
        return $this->campMealmoments;
    }

    public function addCampMealmoment(CampMealmoments $campMealmoment): self
    {
        if (!$this->campMealmoments->contains($campMealmoment)) {
            $this->campMealmoments[] = $campMealmoment;
            $campMealmoment->setMealmoment($this);
        }

        return $this;
    }

    public function removeCampMealmoment(CampMealmoments $campMealmoment): self
    {
        if ($this->campMealmoments->contains($campMealmoment)) {
            $this->campMealmoments->removeElement($campMealmoment);
            // set the owning side to null (unless already changed)
            if ($campMealmoment->getMealmoment() === $this) {
                $campMealmoment->setMealmoment(null);
            }
        }

        return $this;
    }
}
