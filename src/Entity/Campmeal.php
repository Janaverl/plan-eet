<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CampmealRepository")
 */
class Campmeal
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CampMealmoments", inversedBy="campmeals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $campMealmoment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Campday", inversedBy="campmeals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $campday;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Mealcourse", mappedBy="campmeal")
     */
    private $mealcourses;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function __construct()
    {
        $this->mealcourses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCampMealmoment(): ?CampMealmoments
    {
        return $this->campMealmoment;
    }

    public function setCampMealmoment(?CampMealmoments $campMealmoment): self
    {
        $this->campMealmoment = $campMealmoment;

        return $this;
    }

    public function getCampday(): ?Campday
    {
        return $this->campday;
    }

    public function setCampday(?Campday $campday): self
    {
        $this->campday = $campday;

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
            $mealcourse->setCampmeal($this);
        }

        return $this;
    }

    public function removeMealcourse(Mealcourse $mealcourse): self
    {
        if ($this->mealcourses->contains($mealcourse)) {
            $this->mealcourses->removeElement($mealcourse);
            // set the owning side to null (unless already changed)
            if ($mealcourse->getCampmeal() === $this) {
                $mealcourse->setCampmeal(null);
            }
        }

        return $this;
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
}
