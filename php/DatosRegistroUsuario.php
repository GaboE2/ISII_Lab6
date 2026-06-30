<?php
declare(strict_types=1);

/**
 * Parameter Object: agrupa los datos de registro de un Usuario.
 * Refactoring: Introduce Parameter Object (reduce Long Parameter List).
 */
final class DatosRegistroUsuario
{
    public function __construct(
        public readonly string $tipoDocumento,
        public readonly string $numeroDocumento,
        public readonly string $fechaNacimiento,
        public readonly string $nombres,
        public readonly string $apellidos,
        public readonly string $telefono,
        public readonly string $passwordPlano,
        public readonly string $rol,
        public readonly ?string $especialidad = null
    ) {}
}
