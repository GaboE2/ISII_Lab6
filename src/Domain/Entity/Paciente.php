<?php
declare(strict_types=1);

namespace App\Domain\Entity;

use InvalidArgumentException;

class Paciente {
    private string $nombre;
    private string $apellido;
    private string $dni;

    public function __construct(string $nombre, string $apellido, string $dni) {
        if (trim($nombre) === '') {
            throw new InvalidArgumentException('El nombre no puede estar vacío.');
        }
        if (trim($apellido) === '') {
            throw new InvalidArgumentException('El apellido no puede estar vacío.');
        }
        if (strlen(trim($dni)) !== 8 || !ctype_digit(trim($dni))) {
            throw new InvalidArgumentException('El DNI debe tener exactamente 8 dígitos.');
        }

        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->dni = $dni;
    }

    public function toArray(): array {
        return [
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'dni' => $this->dni,
        ];
    }
}
