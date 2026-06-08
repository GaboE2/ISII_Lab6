<?php

declare(strict_types=1);

namespace Farmacia\Recetas\Application\EmitirLineaReceta;

final class EmitirLineaRecetaCommand
{
    public function __construct(
        public int $idReceta,
        public int $idConsulta,
        public int $idMedicamento,
        public string $cantidadPreinscrita,
        public string $fechaReceta
    ) {
    }
}
