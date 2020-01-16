<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CampMealmomentsRepository")
 */
class CampMealmoments
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Time;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Camp", inversedBy="campMealmoments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $camp;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Mealmoment", inversedBy="campMealmoments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mealmoment;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Campmeal", mappedBy="campMealmoment")
     */
    private $campmeals;

    public function __construct()
    {
        $this->campmeals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTime(): ?int
    {
        return $this->Time;
    }

    public function setTime(?int $Time): self
    {
        $this->Time = $Time;

        return $this;
    }

    public function getCamp(): ?Camp
    {
        return $this->camp;
    }

    public function setCamp(?Camp $camp): self
    {
        $this->camp = $camp;

        return $this;
    }

    public function getMealmoment(): ?Mealmoment
    {
        return $this->mealmoment;
    }

    public function setMealmoment(?Mealmoment $mealmoment): self
    {
        $this->mealmoment = $mealmoment;

        return $this;
    }

    /**
     * @return Collection|Campmeal[]
     */
    public function getCampmeals(): Collection
    {
        return $this->campmeals;
    }

    public function addCampmeal(Campmeal $campmeal): self
    {
        if (!$this->campmeals->contains($campmeal)) {
            $this->campmeals[] = $campmeal;
            $campmeal->setCampMealmoment($this);
        }

        return $this;
    }

    public function removeCampmeal(Campmeal $campmeal): self
    {
        if ($this->campmeals->contains($campmeal)) {
            $this->campmeals->removeElement($campmeal);
            // set the owning side to null (unless already changed)
            if ($campmeal->getCampMealmoment() === $this) {
                $campmeal->setCampMealmoment(null);
            }
        }

        return $this;
    }
}
