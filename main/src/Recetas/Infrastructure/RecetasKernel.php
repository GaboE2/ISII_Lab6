<?php

declare(strict_types=1);

namespace Farmacia\Recetas\Infrastructure;

use Farmacia\Recetas\Application\EmitirLineaReceta\EmitirLineaRecetaHandler;
use Farmacia\Recetas\Infrastructure\Persistence\MysqliRecetaRepository;
use Farmacia\Shared\Infrastructure\MysqliConnectionFactory;

final class RecetasKernel
{
    public static function emitirLineaRecetaHandler(): EmitirLineaRecetaHandler
    {
        $mysqli = MysqliConnectionFactory::farmaciaDefault();

        return new EmitirLineaRecetaHandler(new MysqliRecetaRepository($mysqli));
    }
}
