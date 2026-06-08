<?php

namespace Farmacia\Infrastructure\Persistence;

use Farmacia\Domain\Entities\Appointment;
use Farmacia\Domain\Repositories\AppointmentRepositoryInterface;
use Farmacia\Infrastructure\Database\Connection;

class AppointmentRepository implements AppointmentRepositoryInterface
{
    private \mysqli $connection;

    public function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    public function save(Appointment $appointment): void
    {
        $id = $appointment->getId();
        $patientId = $appointment->getPatientId();
        $doctorId = $appointment->getDoctorId();
        $appointmentDate = $appointment->getAppointmentDate()->format('Y-m-d H:i');
        $reason = $appointment->getReason();
        $durationMinutes = $appointment->getDurationMinutes();
        $status = $appointment->getStatus();

        $stmt = $this->connection->prepare(
            "INSERT INTO citas (id, id_paciente, id_doctor, fecha_cita, motivo, duracion, estado)
             VALUES (?, ?, ?, ?, ?, ?, ?)
             ON DUPLICATE KEY UPDATE id_paciente=?, id_doctor=?, fecha_cita=?, motivo=?, duracion=?, estado=?"
        );

        if (!$stmt) {
            throw new \Exception("Error en preparación: " . $this->connection->error);
        }

        $stmt->bind_param(
            "iiisiii" . "iiisiii",
            $id,
            $patientId,
            $doctorId,
            $appointmentDate,
            $reason,
            $durationMinutes,
            $status,
            $patientId,
            $doctorId,
            $appointmentDate,
            $reason,
            $durationMinutes,
            $status
        );

        if (!$stmt->execute()) {
            throw new \Exception("Error al guardar cita: " . $stmt->error);
        }

        $stmt->close();
    }

    public function findById(int $id): ?Appointment
    {
        $stmt = $this->connection->prepare("SELECT * FROM citas WHERE id = ?");
        if (!$stmt) {
            throw new \Exception("Error en preparación: " . $this->connection->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $stmt->close();
            return null;
        }

        $row = $result->fetch_assoc();
        $stmt->close();

        return new Appointment(
            id: (int)$row['id'],
            patientId: (int)$row['id_paciente'],
            doctorId: (int)$row['id_doctor'],
            appointmentDate: new \DateTime($row['fecha_cita']),
            reason: $row['motivo'],
            durationMinutes: (int)$row['duracion'],
            status: $row['estado']
        );
    }

    public function findByPatientId(int $patientId): array
    {
        $stmt = $this->connection->prepare("SELECT * FROM citas WHERE id_paciente = ?");
        if (!$stmt) {
            throw new \Exception("Error en preparación: " . $this->connection->error);
        }

        $stmt->bind_param("i", $patientId);
        $stmt->execute();
        $result = $stmt->get_result();

        $appointments = [];
        while ($row = $result->fetch_assoc()) {
            $appointments[] = new Appointment(
                id: (int)$row['id'],
                patientId: (int)$row['id_paciente'],
                doctorId: (int)$row['id_doctor'],
                appointmentDate: new \DateTime($row['fecha_cita']),
                reason: $row['motivo'],
                durationMinutes: (int)$row['duracion'],
                status: $row['estado']
            );
        }

        $stmt->close();
        return $appointments;
    }

    public function findByDoctorId(int $doctorId): array
    {
        $stmt = $this->connection->prepare("SELECT * FROM citas WHERE id_doctor = ?");
        if (!$stmt) {
            throw new \Exception("Error en preparación: " . $this->connection->error);
        }

        $stmt->bind_param("i", $doctorId);
        $stmt->execute();
        $result = $stmt->get_result();

        $appointments = [];
        while ($row = $result->fetch_assoc()) {
            $appointments[] = new Appointment(
                id: (int)$row['id'],
                patientId: (int)$row['id_paciente'],
                doctorId: (int)$row['id_doctor'],
                appointmentDate: new \DateTime($row['fecha_cita']),
                reason: $row['motivo'],
                durationMinutes: (int)$row['duracion'],
                status: $row['estado']
            );
        }

        $stmt->close();
        return $appointments;
    }

    public function delete(int $id): void
    {
        $stmt = $this->connection->prepare("DELETE FROM citas WHERE id = ?");
        if (!$stmt) {
            throw new \Exception("Error en preparación: " . $this->connection->error);
        }

        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            throw new \Exception("Error al eliminar: " . $stmt->error);
        }

        $stmt->close();
    }
}
