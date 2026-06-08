<?php

namespace Farmacia\Application\DTOs;

class AppointmentDTO
{
    public int $id;
    public int $patientId;
    public int $doctorId;
    public string $appointmentDate;
    public string $reason;
    public int $durationMinutes;
    public string $status;

    public function __construct(
        int $id,
        int $patientId,
        int $doctorId,
        string $appointmentDate,
        string $reason,
        int $durationMinutes,
        string $status = 'pending'
    ) {
        $this->id = $id;
        $this->patientId = $patientId;
        $this->doctorId = $doctorId;
        $this->appointmentDate = $appointmentDate;
        $this->reason = $reason;
        $this->durationMinutes = $durationMinutes;
        $this->status = $status;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'patientId' => $this->patientId,
            'doctorId' => $this->doctorId,
            'appointmentDate' => $this->appointmentDate,
            'reason' => $this->reason,
            'durationMinutes' => $this->durationMinutes,
            'status' => $this->status,
        ];
    }
}
