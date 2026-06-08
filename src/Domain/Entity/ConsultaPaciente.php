<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use InvalidArgumentException;

final class ConsultaPaciente
{
    public function __construct(private array $data)
    {
        foreach (['codigo', 'motivo_consulta', 'nombre_paciente', 'nombre_medico'] as $required) {
            if (!isset($data[$required]) || trim((string) $data[$required]) === '') {
                throw new InvalidArgumentException("El campo {$required} es obligatorio.");
            }
        }
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
