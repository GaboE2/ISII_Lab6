<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\Entity\ConsultaPaciente;
use App\Domain\Repository\ConsultaPacienteRepositoryInterface;

final class RegistrarConsultaPacienteService
{
    public function __construct(private ConsultaPacienteRepositoryInterface $repository)
    {
    }

    public function ejecutar(array $input): bool
    {
        $entity = new ConsultaPaciente($input);

        return $this->repository->save($entity);
    }
}
