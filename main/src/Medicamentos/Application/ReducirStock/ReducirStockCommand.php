<?php

declare(strict_types=1);

namespace Farmacia\Medicamentos\Application\ReducirStock;

/**
 * DTO de entrada del caso de uso (capa aplicación).
 */
final class ReducirStockCommand
{
    public function __construct(
        public int $medicamentoId,
        public int $unidades
    ) {
    }
}
