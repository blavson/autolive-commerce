<?php

namespace App\Entity;

use App\Repository\ModelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\OneToMany(targetEntity=Car::class, mappedBy="model", orphanRemoval=false)
     */
    private $cars;

    /**
     * @ORM\ManyToOne(targetEntity=Maker::class, inversedBy="models")
     * @ORM\JoinColumn(nullable=false)
     */
    private $makers;

    /**
     * @ORM\OneToMany(targetEntity=Car::class, mappedBy="model", orphanRemoval=true)
     */

    public function __construct()
    {
        $this->cars = new ArrayCollection();
    }

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

    /**
     * @return Collection|car[]
     */
    public function getCars(): Collection
    {
        return $this->cars;
    }

    public function addCar(car $car): self
    {
        if (!$this->cars->contains($car)) {
            $this->cars[] = $car;
            $car->setModel($this);
        }

        return $this;
    }

    public function removeCar(car $car): self
    {
        if ($this->cars->removeElement($car)) {
            // set the owning side to null (unless already changed)
            if ($car->getModel() === $this) {
                $car->setModel(null);
            }
        }

        return $this;
    }

    public function getMakers(): ?Maker
    {
        return $this->makers;
    }

    public function setMakers(?Maker $makers): self
    {
        $this->makers = $makers;

        return $this;
    }


}
