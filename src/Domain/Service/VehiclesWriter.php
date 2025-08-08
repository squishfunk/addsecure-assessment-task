<?php

namespace Domain\Service;

use Domain\Entity\Vehicle;
use Domain\Repository\VehicleRepositoryInterface;
use Domain\ValueObject\DateTimeVO;
use Domain\ValueObject\RegistrationNumber;
use Domain\ValueObject\VehicleType;

class VehiclesWriter
{
    public function __construct(private VehicleRepositoryInterface $vehicleRepository)
    {
    }

    public function saveVehicle(VehicleDTO $dto)
    {
        if ($dto->id === null) {
            $vehicle = new Vehicle();
            $vehicle->setCreatedAt(new DateTimeVO(time()));
        } else {
            $vehicle = $this->vehicleRepository->getById($dto->id);
            if (!$vehicle) {
                throw new \Exception("Vehicle not found");
            }
        }
        $vehicle->setRegistrationNumber(new RegistrationNumber($dto->registrationNumber));
        $vehicle->setBrand($dto->brand);
        $vehicle->setModel($dto->model);
        $vehicle->setType(new VehicleType($dto->type));
        $vehicle->setUpdatedAt(new DateTimeVO(time()));

        $this->vehicleRepository->persist($vehicle);
    }

    public function deleteById(int $id): void
    {
        $this->vehicleRepository->deleteById($id);
    }

}
