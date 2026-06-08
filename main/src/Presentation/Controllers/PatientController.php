<?php

namespace Farmacia\Presentation\Controllers;

use Farmacia\Application\DTOs\CreatePatientRequestDTO;
use Farmacia\Application\UseCases\CreatePatientUseCase;
use Farmacia\Infrastructure\Persistence\PatientRepository;

class PatientController
{
    private CreatePatientUseCase $createPatientUseCase;

    public function __construct()
    {
        $patientRepository = new PatientRepository();
        $this->createPatientUseCase = new CreatePatientUseCase($patientRepository);
    }

    /**
     * Crear un nuevo paciente
     * Espera POST con: fullName, birthDate, gender, phoneNumber, email
     */
    public function create(): void
    {
        try {
            $input = $_POST;

            $request = new CreatePatientRequestDTO(
                fullName: $input['nombre_completo'] ?? '',
                birthDate: $input['fecha_nacimiento'] ?? '',
                gender: $input['sexo'] ?? '',
                phoneNumber: $input['telefono'] ?? '',
                email: $input['email'] ?? ''
            );

            $result = $this->createPatientUseCase->execute($request);

            $this->jsonResponse(201, [
                'success' => true,
                'message' => 'Paciente creado exitosamente',
                'data' => $result->toArray()
            ]);
        } catch (\InvalidArgumentException $e) {
            $this->jsonResponse(400, [
                'success' => false,
                'message' => 'Datos inválidos: ' . $e->getMessage()
            ]);
        } catch (\Exception $e) {
            $this->jsonResponse(500, [
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage()
            ]);
        }
    }

    private function jsonResponse(int $statusCode, array $data): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
