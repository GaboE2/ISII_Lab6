<?php

namespace Farmacia\Application\UseCases;

use Farmacia\Application\DTOs\AppointmentDTO;
use Farmacia\Domain\Entities\Appointment;
use Farmacia\Domain\Repositories\AppointmentRepositoryInterface;

class CreateAppointmentUseCase
{
    private AppointmentRepositoryInterface $appointmentRepository;

    public function __construct(AppointmentRepositoryInterface $appointmentRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
    }

    /**
     * Crear una nueva cita
     */
    public function execute(
        int $patientId,
        int $doctorId,
        string $appointmentDate,
        string $reason,
        int $durationMinutes
    ): AppointmentDTO {
        $appointmentDateTime = \DateTime::createFromFormat('Y-m-d H:i', $appointmentDate);
        if (!$appointmentDateTime) {
            throw new \InvalidArgumentException("Formato de fecha/hora inválido");
        }

        $appointment = new Appointment(
            id: $this->generateAppointmentId(),
            patientId: $patientId,
            doctorId: $doctorId,
            appointmentDate: $appointmentDateTime,
            reason: $reason,
            durationMinutes: $durationMinutes
        );

        $this->appointmentRepository->save($appointment);

        return new AppointmentDTO(
            id: $appointment->getId(),
            patientId: $appointment->getPatientId(),
            doctorId: $appointment->getDoctorId(),
            appointmentDate: $appointment->getAppointmentDate()->format('Y-m-d H:i'),
            reason: $appointment->getReason(),
            durationMinutes: $appointment->getDurationMinutes(),
            status: $appointment->getStatus()
        );
    }

    private function generateAppointmentId(): int
    {
        return (int)(microtime(true) * 10000);
    }
}
