<?php

namespace Persistence\Repository;

use App\SQLiteConnection;
use Domain\Entity\Vehicle;
use Domain\Repository\VehicleRepositoryInterface;
use Domain\ValueObject\DateTimeVO;
use Domain\ValueObject\RegistrationNumber;
use Domain\ValueObject\VehicleType;

class VehicleRepository implements VehicleRepositoryInterface
{
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = (new SQLiteConnection())->connect();
    }

    public function getList()
    {
        $results = $this->pdo->query('SELECT * FROM vehicles');

        $items = [];
        foreach ($results as $row) {
            $items[] = $this->rowToEntity($row);
        }

        return $items;
    }

    public function getById($id)
    {
        $select = $this->pdo->prepare('SELECT * FROM vehicles WHERE id = :id');
        $select->execute([
            ':id' => $id
        ]);

        $row = $select->fetch(\PDO::FETCH_ASSOC);

        return $this->rowToEntity($row);
    }

    public function deleteById($id)
    {
        $delete = $this->pdo->prepare('DELETE FROM vehicles WHERE id = :id');
        $delete->execute([':id' => $id]);

        if ($delete->rowCount() === 0) {
            throw new \RuntimeException("Vehicle with id $id not found");
        }
    }

    public function persist(Vehicle $vehicle)
    {
        if ($vehicle->getId() === null) {
            $insert = $this->pdo->prepare('
                INSERT INTO `vehicles` (
                    `registration_number`, `brand`, `model`, `type`, `created_at`, `updated_at`
                ) VALUES (
                    :registration_number, :brand, :model, :type, :created_at, :updated_at
                )
            ');

            $insert->execute([
                ':registration_number' => $vehicle->getRegistrationNumber(),
                ':brand' => $vehicle->getBrand(),
                ':model' => $vehicle->getModel(),
                ':type' => $vehicle->getType(),
                ':created_at' => $vehicle->getCreatedAt(),
                ':updated_at' => $vehicle->getUpdatedAt(),
            ]);

        } else {
            $update = $this->pdo->prepare('
            UPDATE vehicles SET
                registration_number = :registration_number,
                brand = :brand,
                model = :model,
                type = :type,
                updated_at = :updated_at
            WHERE id = :id
        ');

            $update->execute([
                ':registration_number' => $vehicle->getRegistrationNumber(),
                ':brand' => $vehicle->getBrand(),
                ':model' => $vehicle->getModel(),
                ':type' => $vehicle->getType(),
                ':updated_at' => $vehicle->getUpdatedAt(),
                ':id' => $vehicle->getId(),
            ]);
        }
    }


    private function rowToEntity($row)
    {
        return (new Vehicle())
            ->setId($row['id'])
            ->setRegistrationNumber(new RegistrationNumber($row['registration_number']))
            ->setBrand($row['brand'])
            ->setModel($row['model'])
            ->setType(new VehicleType($row['type']))
            ->setCreatedAt(new DateTimeVO($row['created_at']))
            ->setUpdatedAt(new DateTimeVO($row['updated_at']))
        ;
    }
}
