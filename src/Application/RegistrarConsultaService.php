<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\Entity\Consulta;
use App\Domain\Repository\ConsultaRepositoryInterface;

final class RegistrarConsultaService
{
    public function __construct(private ConsultaRepositoryInterface $repository)
    {
    }

    public function ejecutar(array $input): bool
    {
        $consulta = new Consulta(
            (string)($input['codigo'] ?? ''),
            (string)($input['fecha'] ?? ''),
            (string)($input['inicio'] ?? ''),
            (string)($input['motivo'] ?? ''),
            (int)($input['id_paciente'] ?? 0),
            (string)($input['nombre_completo'] ?? ''),
            (string)($input['fecha_nacimiento'] ?? ''),
            (string)($input['sexo'] ?? ''),
            (string)($input['telefono'] ?? ''),
            (string)($input['diagnostico'] ?? '')
        );

        return $this->repository->save($consulta);
    }
}
