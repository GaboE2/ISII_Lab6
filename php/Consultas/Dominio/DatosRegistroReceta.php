<?php
declare(strict_types=1);

final class DatosRegistroReceta
{
    public function __construct(
        public readonly int $idConsulta,
        public readonly int $idMedicamento,
        public readonly string $dosis,
        public readonly string $instrucciones = ''
    ) {}
}
