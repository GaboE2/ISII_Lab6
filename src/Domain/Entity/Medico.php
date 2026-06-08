<?php
declare(strict_types=1);

namespace App\Domain\Entity;

use InvalidArgumentException;

class Medico {
    private string $cmp;
    private string $nombre;
    private string $especialidad;

    public function __construct(string $cmp, string $nombre, string $especialidad) {
        if (trim($cmp) === '') {
            throw new InvalidArgumentException('El CMP no puede estar vacío.');
        }
        if (trim($nombre) === '') {
            throw new InvalidArgumentException('El nombre no puede estar vacío.');
        }
        if (trim($especialidad) === '') {
            throw new InvalidArgumentException('La especialidad no puede estar vacía.');
        }

        $this->cmp = $cmp;
        $this->nombre = $nombre;
        $this->especialidad = $especialidad;
    }

    public function toArray(): array {
        return [
            'cmp' => $this->cmp,
            'nombre' => $this->nombre,
            'especialidad' => $this->especialidad,
        ];
    }
}
