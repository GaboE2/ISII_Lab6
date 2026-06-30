<?php
declare(strict_types=1);

final class DatosRegistroConsulta
{
    public function __construct(
        public readonly int $idCita,
        public readonly int $idPaciente,
        public readonly int $idDoctor,
        public readonly string $fechaConsulta,
        public readonly string $motivo,
        public readonly string $diagnostico
    ) {}
}
