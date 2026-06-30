<?php
declare(strict_types=1);

/**
 * Parameter Object: agrupa los datos necesarios para registrar una Cita.
 */
final class DatosRegistroCita
{
    public function __construct(
        public readonly int $idPaciente,
        public readonly int $idDoctor,
        public readonly string $fechaCita,
        public readonly string $horaCita,
        public readonly string $motivo = ''
    ) {}
}
