<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use InvalidArgumentException;

final class Consulta
{
    public function __construct(
        private string $codigo,
        private string $fecha,
        private string $hora,
        private string $motivo,
        private int $idPaciente,
        private string $nombreCompleto,
        private string $fechaNacimiento,
        private string $sexo,
        private string $telefono,
        private string $diagnostico
    ) {
        if (trim($codigo) === '') {
            throw new InvalidArgumentException('El código es obligatorio.');
        }

        if (trim($motivo) === '') {
            throw new InvalidArgumentException('El motivo es obligatorio.');
        }

        if ($idPaciente <= 0) {
            throw new InvalidArgumentException('El id del paciente debe ser positivo.');
        }
    }

    public function toArray(): array
    {
        return [
            'codigo' => $this->codigo,
            'fecha' => $this->fecha,
            'hora' => $this->hora,
            'motivo' => $this->motivo,
            'id_paciente' => $this->idPaciente,
            'nombre_completo' => $this->nombreCompleto,
            'fecha_nacimiento' => $this->fechaNacimiento,
            'sexo' => $this->sexo,
            'telefono' => $this->telefono,
            'diagnostico' => $this->diagnostico,
        ];
    }
}
