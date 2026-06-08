<?php

declare(strict_types=1);

namespace Farmacia\Medicamentos\Infrastructure;

use Farmacia\Medicamentos\Application\ReducirStock\ReducirStockHandler;
use Farmacia\Medicamentos\Infrastructure\Persistence\MysqliMedicamentoRepository;
use Farmacia\Shared\Infrastructure\MysqliConnectionFactory;

/**
 * Composition root del bounded context Medicamentos.
 */
final class MedicamentosKernel
{
    public static function reducirStockHandler(): ReducirStockHandler
    {
        $mysqli = MysqliConnectionFactory::farmaciaDefault();
        $repo = new MysqliMedicamentoRepository($mysqli);

        return new ReducirStockHandler($repo);
    }
}
