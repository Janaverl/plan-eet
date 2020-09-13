<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CampRepository")
 */
class Camp
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
     * @ORM\Column(type="datetime")
     */
    private $startTime;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endTime;

    /**
     * @ORM\Column(type="integer")
     */
    private $nrOfParticipants;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="camps")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CampMealMoments", mappedBy="camp")
     */
    private $campMealMoments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Campday", mappedBy="camp")
     */
    private $campdays;

    public function __construct()
    {
        $this->campMealMoments = new ArrayCollection();
        $this->campdays = new ArrayCollection();
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

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeInterface $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(\DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getNrOfParticipants(): ?int
    {
        return $this->nrOfParticipants;
    }

    public function setNrOfParticipants(int $nrOfParticipants): self
    {
        $this->nrOfParticipants = $nrOfParticipants;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
            $campMealMoment->setCamp($this);
        }

        return $this;
    }

    public function removeCampMealMoment(CampMealMoments $campMealMoment): self
    {
        if ($this->campMealMoments->contains($campMealMoment)) {
            $this->campMealMoments->removeElement($campMealMoment);
            // set the owning side to null (unless already changed)
            if ($campMealMoment->getCamp() === $this) {
                $campMealMoment->setCamp(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Campday[]
     */
    public function getCampdays(): Collection
    {
        return $this->campdays;
    }

    public function addCampday(Campday $campday): self
    {
        if (!$this->campdays->contains($campday)) {
            $this->campdays[] = $campday;
            $campday->setCamp($this);
        }

        return $this;
    }

    public function removeCampday(Campday $campday): self
    {
        if ($this->campdays->contains($campday)) {
            $this->campdays->removeElement($campday);
            // set the owning side to null (unless already changed)
            if ($campday->getCamp() === $this) {
                $campday->setCamp(null);
            }
        }

        return $this;
    }
}
