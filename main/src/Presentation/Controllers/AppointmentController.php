<?php

namespace Farmacia\Presentation\Controllers;

use Farmacia\Application\UseCases\CreateAppointmentUseCase;
use Farmacia\Infrastructure\Persistence\AppointmentRepository;

class AppointmentController
{
    private CreateAppointmentUseCase $createAppointmentUseCase;

    public function __construct()
    {
        $appointmentRepository = new AppointmentRepository();
        $this->createAppointmentUseCase = new CreateAppointmentUseCase($appointmentRepository);
    }

    /**
     * Crear una nueva cita
     * Espera POST con: id_paciente, id_doctor, fecha_cita, motivo, duracion
     */
    public function create(): void
    {
        try {
            $input = $_POST;

            $result = $this->createAppointmentUseCase->execute(
                patientId: (int)($input['id_paciente'] ?? 0),
                doctorId: (int)($input['id_doctor'] ?? 0),
                appointmentDate: $input['fecha_cita'] ?? '',
                reason: $input['motivo'] ?? '',
                durationMinutes: (int)($input['duracion'] ?? 0)
            );

            $this->jsonResponse(201, [
                'success' => true,
                'message' => 'Cita creada exitosamente',
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
