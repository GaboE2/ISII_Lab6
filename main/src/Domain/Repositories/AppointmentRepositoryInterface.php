<?php

namespace Farmacia\Domain\Repositories;

use Farmacia\Domain\Entities\Appointment;

interface AppointmentRepositoryInterface
{
    /**
     * Guardar una cita nueva o actualizada
     */
    public function save(Appointment $appointment): void;

    /**
     * Obtener una cita por ID
     */
    public function findById(int $id): ?Appointment;

    /**
     * Obtener todas las citas de un paciente
     */
    public function findByPatientId(int $patientId): array;

    /**
     * Obtener todas las citas de un doctor
     */
    public function findByDoctorId(int $doctorId): array;

    /**
     * Eliminar una cita
     */
    public function delete(int $id): void;
}
