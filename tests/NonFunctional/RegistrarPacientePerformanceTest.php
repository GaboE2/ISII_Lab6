<?php

declare(strict_types=1);

namespace Tests\NonFunctional;

use App\Application\RegistrarPacienteService;
use App\Domain\Entity\Paciente;
use App\Domain\Repository\PacienteRepositoryInterface;
use PHPUnit\Framework\TestCase;

final class RegistrarPacientePerformanceTest extends TestCase
{
    public function test_registrar_paciente_se_ejecuta_rapidamente(): void
    {
        $repository = new class implements PacienteRepositoryInterface {
            public function save(Paciente $paciente): bool
            {
                return true;
            }
        };

        $service = new RegistrarPacienteService($repository);

        $startMemory = memory_get_usage(true);
        $start = microtime(true);
        $result = $service->ejecutar([
            'nombre' => 'Luis',
            'apellido' => 'Martinez',
            'dni' => '87654321',
        ]);
        $duration = microtime(true) - $start;
        $memoryDelta = memory_get_usage(true) - $startMemory;

        self::assertTrue($result);
        self::assertLessThan(0.1, $duration, 'La operación debe tardar menos de 100 ms.');
        self::assertLessThan(2 * 1024 * 1024, $memoryDelta, 'El incremento de memoria debe ser menor a 2 MB.');
    }
}
