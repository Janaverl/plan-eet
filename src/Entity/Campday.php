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
     * @ORM\OneToMany(targetEntity="App\Entity\Campmeal", mappedBy="campday")
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
     * @return Collection|Campmeal[]
     */
    public function getCampmeals(): Collection
    {
        return $this->campmeals;
    }

    public function addCampmeal(CampMeal $campmeal): self
    {
        if (!$this->campmeals->contains($campmeal)) {
            $this->campmeals[] = $campmeal;
            $campmeal->setCampday($this);
        }

        return $this;
    }

    public function removeCampMeal(Campmeal $campmeal): self
    {
        if ($this->campmeals->contains($campmeal)) {
            $this->campmeals->removeElement($campmeal);
            // set the owning side to null (unless already changed)
            if ($campmeal->getCampday() === $this) {
                $campmeal->setCampday(null);
            }
        }

        return $this;
    }
}
