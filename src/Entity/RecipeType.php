<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecipeTypeRepository")
 * @UniqueEntity(fields={"name"}, message="This vallue allready exists")
 */
class RecipeType
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
     * @ORM\OneToMany(targetEntity="App\Entity\Recipes", mappedBy="type")
     */
    private $typeID;

    public function __construct()
    {
        $this->typeID = new ArrayCollection();
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
     * @return Collection|Recipes[]
     */
    public function getTypeID(): Collection
    {
        return $this->typeID;
    }

    public function addTypeID(Recipes $typeID): self
    {
        if (!$this->typeID->contains($typeID)) {
            $this->typeID[] = $typeID;
            $typeID->setType($this);
        }

        return $this;
    }

    public function removeTypeID(Recipes $typeID): self
    {
        if ($this->typeID->contains($typeID)) {
            $this->typeID->removeElement($typeID);
            // set the owning side to null (unless already changed)
            if ($typeID->getType() === $this) {
                $typeID->setType(null);
            }
        }

        return $this;
    }
}
