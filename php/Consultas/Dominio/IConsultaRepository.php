<?php
declare(strict_types=1);

require_once __DIR__ . '/Consulta.php';

interface IConsultaRepository
{
    /**
     * Busca los datos (fecha, motivo) de una cita perteneciente a un doctor.
     * Retorna null si no existe o no le pertenece.
     */
    public function buscarCitaDelDoctor(int $idCita, int $idDoctor): ?array;

    /**
     * Guarda una nueva consulta y retorna su id generado, o null si falló.
     */
    public function guardar(Consulta $consulta): ?int;

    /**
     * Marca una cita como atendida.
     */
    public function marcarCitaComoAtendida(int $idCita): bool;

    /**
     * Lista las consultas de un paciente (con datos del doctor), más recientes primero.
     */
    public function buscarPorPaciente(int $idPaciente): array;
}
