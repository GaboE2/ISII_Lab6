<?php
declare(strict_types=1);

require_once __DIR__ . '/Cita.php';

interface ICitaRepository
{
    /**
     * Guarda una nueva cita. Retorna true si fue exitoso.
     */
    public function guardar(Cita $cita): bool;

    /**
     * Busca las citas pendientes de un paciente, ordenadas por fecha/hora ascendente.
     * Retorna un array de arrays asociativos (incluyendo datos del doctor por el JOIN).
     */
    public function buscarPendientesPorPaciente(int $idPaciente): array;

    /**
     * Lista todos los doctores disponibles (id, nombres, apellidos, especialidad).
     */
    public function listarDoctores(): array;
}
