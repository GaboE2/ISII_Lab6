<?php

declare(strict_types=1);

namespace Farmacia\Tests\Consultas\Unit;

use App\Domain\Entity\Consulta;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class ConsultaTest extends TestCase
{
    public function test_crea_consulta_valida(): void
    {
        $consulta = new Consulta('C001', '2026-04-30', '10:00', 'Dolor', 10, 'Juan Perez', '2000-01-01', 'M', '999', 'Gripe');

        self::assertSame('C001', $consulta->toArray()['codigo']);
    }

    public function test_falla_si_id_paciente_no_es_positivo(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Consulta('C001', '2026-04-30', '10:00', 'Dolor', 0, 'Juan Perez', '2000-01-01', 'M', '999', 'Gripe');
    }
}
