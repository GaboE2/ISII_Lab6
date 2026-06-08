<?php

declare(strict_types=1);

namespace Farmacia\Recetas\Application\EmitirLineaReceta;

use Farmacia\Recetas\Domain\ConsultaId;
use Farmacia\Recetas\Domain\IdMedicamentoReceta;
use Farmacia\Recetas\Domain\LineaReceta;
use Farmacia\Recetas\Domain\RecetaId;
use Farmacia\Recetas\Domain\RecetaRepository;

final class EmitirLineaRecetaHandler
{
    public function __construct(
        private RecetaRepository $recetas
    ) {
    }

    public function handle(EmitirLineaRecetaCommand $command): void
    {
        $linea = new LineaReceta(
            RecetaId::fromInt($command->idReceta),
            ConsultaId::fromInt($command->idConsulta),
            IdMedicamentoReceta::fromInt($command->idMedicamento),
            $command->cantidadPreinscrita,
            $command->fechaReceta
        );

        $this->recetas->save($linea);
    }
}
