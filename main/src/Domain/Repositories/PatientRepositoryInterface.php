<?php

namespace Farmacia\Domain\Repositories;

use Farmacia\Domain\Entities\Patient;

interface PatientRepositoryInterface
{
    /**
     * Guardar un paciente nuevo o actualizado
     */
    public function save(Patient $patient): void;

    /**
     * Obtener un paciente por ID
     */
    public function findById(int $id): ?Patient;

    /**
     * Obtener todos los pacientes
     */
    public function findAll(): array;

    /**
     * Eliminar un paciente
     */
    public function delete(int $id): void;
}
