<?php

namespace Farmacia\Domain\Entities;

use Farmacia\Domain\ValueObjects\Email;
use Farmacia\Domain\ValueObjects\PhoneNumber;

class Appointment
{
    private int $id;
    private int $patientId;
    private int $doctorId;
    private \DateTime $appointmentDate;
    private string $reason;
    private int $durationMinutes;
    private string $status;
    private \DateTime $createdAt;

    public function __construct(
        int $id,
        int $patientId,
        int $doctorId,
        \DateTime $appointmentDate,
        string $reason,
        int $durationMinutes,
        string $status = 'pending'
    ) {
        if ($durationMinutes <= 0) {
            throw new \InvalidArgumentException("Duración de la cita debe ser mayor a 0");
        }
        if ($appointmentDate < new \DateTime()) {
            throw new \InvalidArgumentException("La fecha de la cita no puede ser en el pasado");
        }

        $this->id = $id;
        $this->patientId = $patientId;
        $this->doctorId = $doctorId;
        $this->appointmentDate = $appointmentDate;
        $this->reason = $reason;
        $this->durationMinutes = $durationMinutes;
        $this->status = $status;
        $this->createdAt = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPatientId(): int
    {
        return $this->patientId;
    }

    public function getDoctorId(): int
    {
        return $this->doctorId;
    }

    public function getAppointmentDate(): \DateTime
    {
        return $this->appointmentDate;
    }

    public function getReason(): string
    {
        return $this->reason;
    }

    public function getDurationMinutes(): int
    {
        return $this->durationMinutes;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function cancel(): void
    {
        if ($this->status === 'completed') {
            throw new \InvalidArgumentException("No se puede cancelar una cita completada");
        }
        $this->status = 'cancelled';
    }

    public function complete(): void
    {
        $this->status = 'completed';
    }
}
