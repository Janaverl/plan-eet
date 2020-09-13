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
     * @ORM\OneToMany(targetEntity="App\Entity\CampMealMoments", mappedBy="mealmoment")
     */
    private $campMealMoments;

    public function __construct()
    {
        $this->campMealMoments = new ArrayCollection();
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
     * @return Collection|CampMealMoments[]
     */
    public function getCampMealMoments(): Collection
    {
        return $this->campMealMoments;
    }

    public function addCampMealMoment(CampMealMoments $campMealMoment): self
    {
        if (!$this->campMealMoments->contains($campMealMoment)) {
            $this->campMealMoments[] = $campMealMoment;
            $campMealMoment->setMealMoment($this);
        }

        return $this;
    }

    public function removeCampMealMoment(CampMealMoments $campMealMoment): self
    {
        if ($this->campMealMoments->contains($campMealMoment)) {
            $this->campMealMoments->removeElement($campMealMoment);
            // set the owning side to null (unless already changed)
            if ($campMealMoment->getMealMoment() === $this) {
                $campMealMoment->setMealMoment(null);
            }
        }

        return $this;
    }
}
