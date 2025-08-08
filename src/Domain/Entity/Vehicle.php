<?php

namespace Domain\Entity;

use Domain\ValueObject\DateTimeVO;
use Domain\ValueObject\RegistrationNumber;
use Domain\ValueObject\VehicleType;

class Vehicle
{
    private ?int $id = null;
    private RegistrationNumber $registrationNumber;
    private string $brand;
    private string $model;
    private VehicleType $type;
    private DateTimeVO $createdAt;
    private DateTimeVO $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getRegistrationNumber(): RegistrationNumber
    {
        return $this->registrationNumber;
    }

    public function setRegistrationNumber(RegistrationNumber $registrationNumber): static
    {
        $this->registrationNumber = $registrationNumber;
        return $this;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;
        return $this;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;
        return $this;
    }

    public function getType(): VehicleType
    {
        return $this->type;
    }

    public function setType(VehicleType $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function getCreatedAt(): DateTimeVO
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeVO $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): DateTimeVO
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeVO $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
