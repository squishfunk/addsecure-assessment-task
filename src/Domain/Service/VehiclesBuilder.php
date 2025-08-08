<?php

namespace Domain\Service;

use Domain\Entity\Vehicle;
use Domain\Repository\VehicleRepositoryInterface;

class VehiclesBuilder
{
    public function __construct(private VehicleRepositoryInterface $vehicleRepository)
    {
    }

    public function getList()
    {
        $items = $this->vehicleRepository->getList();
        return array_map([$this, 'entityToDTO'], $items);
    }

    private function entityToDTO(Vehicle $vehicle)
    {
        $vehicleDTO = new VehicleDTO();
        $vehicleDTO->id = $vehicle->getId();
        $vehicleDTO->registrationNumber = $vehicle->getRegistrationNumber()->getValue();
        $vehicleDTO->brand = $vehicle->getBrand();
        $vehicleDTO->model = $vehicle->getModel();
        $vehicleDTO->type = $vehicle->getType()->getValue();
        $vehicleDTO->createdAt = $vehicle->getCreatedAt()->format();
        $vehicleDTO->updatedAt = $vehicle->getUpdatedAt()->format();

        return $vehicleDTO;
    }
}
