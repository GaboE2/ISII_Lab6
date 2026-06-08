<?php
declare(strict_types=1);

namespace App\Application;

use App\Domain\Entity\Medico;
use App\Domain\Repository\MedicoRepositoryInterface;
use InvalidArgumentException;

class RegistrarMedicoService {
    private MedicoRepositoryInterface $repository;

    public function __construct(MedicoRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function ejecutar(array $datos): bool {
        if (!isset($datos['cmp'], $datos['nombre'], $datos['especialidad'])) {
            throw new InvalidArgumentException('Faltan datos para registrar el médico.');
        }

        $medico = new Medico($datos['cmp'], $datos['nombre'], $datos['especialidad']);
        return $this->repository->save($medico);
    }
}
