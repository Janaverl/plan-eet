<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CampdayRepository")
 */
class Campday
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Camp", inversedBy="campdays")
     * @ORM\JoinColumn(nullable=false)
     */
    private $camp;

    /**
     * @ORM\Column(type="integer")
     */
    private $campdaycount;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CampMeal", mappedBy="campday")
     */
    private $campMeals;

    public function __construct()
    {
        $this->campMeals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCampdaycount(): ?int
    {
        return $this->campdaycount;
    }

    public function setCampdaycount(int $campdaycount): self
    {
        $this->campdaycount = $campdaycount;

        return $this;
    }

    /**
     * @return Collection|CampMeal[]
     */
    public function getCampMeals(): Collection
    {
        return $this->campMeals;
    }

    public function addCampMeal(CampMeal $campMeal): self
    {
        if (!$this->campMeals->contains($campMeal)) {
            $this->campMeals[] = $campMeal;
            $campMeal->setCampday($this);
        }

        return $this;
    }

    public function removeCampMeal(CampMeal $campMeal): self
    {
        if ($this->campMeals->contains($campMeal)) {
            $this->campMeals->removeElement($campMeal);
            // set the owning side to null (unless already changed)
            if ($campMeal->getCampday() === $this) {
                $campMeal->setCampday(null);
            }
        }

        return $this;
    }
}
