<?php

declare(strict_types=1);

namespace Farmacia\Shared\Infrastructure;

/**
 * Fábrica de conexión: detalle de infraestructura compartido (no pertenece al dominio).
 */
final class MysqliConnectionFactory
{
    public static function farmaciaDefault(): \mysqli
    {
        $mysqli = new \mysqli('localhost', 'root', '', 'farmacia', 3310);
        if ($mysqli->connect_error !== null) {
            throw new \RuntimeException('Fallo de conexión MySQL: ' . $mysqli->connect_error);
        }

        return $mysqli;
    }
}
