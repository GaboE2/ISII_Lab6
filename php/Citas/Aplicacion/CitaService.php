<?php
declare(strict_types=1);

require_once __DIR__ . '/../Dominio/Cita.php';
require_once __DIR__ . '/../Dominio/DatosRegistroCita.php';
require_once __DIR__ . '/../Dominio/ICitaRepository.php';

class CitaService
{
    private ICitaRepository $repository;

    public function __construct(ICitaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function reservar(DatosRegistroCita $datos): bool
    {
        $cita = new Cita($datos);

        return $this->repository->guardar($cita);
    }

    public function obtenerProximasCitasDePaciente(int $idPaciente): array
    {
        return $this->repository->buscarPendientesPorPaciente($idPaciente);
    }

    public function obtenerDoctoresDisponibles(): array
    {
        return $this->repository->listarDoctores();
    }
}
