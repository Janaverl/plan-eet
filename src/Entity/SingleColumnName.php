<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SingleColumnNameRepository")
 */
class SingleColumnName
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
     * @ORM\Column(type="string", length=255)
     */
    private $tablename;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $API;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $translation;

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

    public function getTablename(): ?string
    {
        return $this->tablename;
    }

    public function setTablename(string $tablename): self
    {
        $this->tablename = $tablename;

        return $this;
    }

    public function getAPI(): ?string
    {
        return $this->API;
    }

    public function setAPI(string $API): self
    {
        $this->API = $API;

        return $this;
    }

    public function getTranslation(): ?string
    {
        return $this->translation;
    }

    public function setTranslation(string $translation): self
    {
        $this->translation = $translation;

        return $this;
    }
}
