<?php

namespace App\Entity;

use App\Repository\ModelRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ModelRepository::class)
 */
class Model
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $model;

    /**
     * @ORM\ManyToOne(targetEntity=Maker::class, inversedBy="models")
     */
    private $maker;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getMaker(): ?Maker
    {
        return $this->maker;
    }

    public function setMaker(?Maker $maker): self
    {
        $this->maker = $maker;

        return $this;
    }

    public function __toString() {
        return $this->model;
    }
}
