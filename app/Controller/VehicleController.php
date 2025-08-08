<?php

namespace App\Controller;

use Domain\Service\VehicleDTO;
use Domain\Service\VehiclesBuilder;
use Domain\Service\VehiclesWriter;
use Persistence\Repository\VehicleRepository;
use Symfony\Component\HttpFoundation\{JsonResponse, Request, Response};

class VehicleController extends BaseController
{
    public function index(): Response
    {
        ob_start();
        include __DIR__ . '/../views/index.php';
        return (new Response(ob_get_clean()))->send();
    }

    public function list(): JsonResponse
    {
        $results = (new VehiclesBuilder(new VehicleRepository()))->getList();

        return $this->toJsonResponse(['results' => $results]);
    }

    public function save(?int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent());

        if (!$data) {
            return $this->toJsonResponse(['error' => 'Invalid data'], 400);
        }

        try {
            $dto = new VehicleDTO();
            $dto->id = $id ?: null;
            $dto->registrationNumber = $data->registration_number;
            $dto->brand = $data->brand;
            $dto->model = $data->model;
            $dto->type = $data->type;
            $dto->createdAt = null;
            $dto->updatedAt = null;

            $writer = new VehiclesWriter(new VehicleRepository());
            $writer->saveVehicle($dto);

            return $this->toJsonResponse(['success' => true]);
        } catch (\Exception $e) {
            return $this->toJsonResponse(['error' => $e->getMessage()], 500);
        }

    }

    public function delete(int $id): JsonResponse
    {
        try{
            $writer = new VehiclesWriter(new VehicleRepository());
            $writer->deleteById($id);
        } catch (\Exception $e) {
            return $this->toJsonResponse(['error' => $e->getMessage()], 404);
        }

        return $this->toJsonResponse(['success' => true]);
    }
}
