<?php
declare(strict_types=1);

namespace App\Application;

use App\Domain\Entity\Paciente;
use App\Domain\Repository\PacienteRepositoryInterface;
use InvalidArgumentException;

class RegistrarPacienteService {
    private PacienteRepositoryInterface $repository;

    public function __construct(PacienteRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function ejecutar(array $datos): bool {
        if (!isset($datos['nombre'], $datos['apellido'], $datos['dni'])) {
            throw new InvalidArgumentException('Faltan datos para registrar el paciente.');
        }

        $paciente = new Paciente($datos['nombre'], $datos['apellido'], $datos['dni']);
        return $this->repository->save($paciente);
    }
}
