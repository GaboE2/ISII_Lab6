<?php

declare(strict_types=1);

namespace Tests\Functional;

use App\Application\RegistrarPacienteService;
use App\Domain\Entity\Paciente;
use App\Domain\Repository\PacienteRepositoryInterface;
use PHPUnit\Framework\TestCase;

final class RegistrarPacienteFlowTest extends TestCase
{
    public function test_registra_paciente_completo_como_flujo_funcional(): void
    {
        $repository = new class implements PacienteRepositoryInterface {
            public ?Paciente $saved = null;

            public function save(Paciente $paciente): bool
            {
                $this->saved = $paciente;
                return true;
            }
        };

        $service = new RegistrarPacienteService($repository);
        $result = $service->ejecutar([
            'nombre' => 'Ana',
            'apellido' => 'Lopez',
            'dni' => '12345678',
        ]);

        self::assertTrue($result);
        self::assertNotNull($repository->saved);
        self::assertSame(
            [
                'nombre' => 'Ana',
                'apellido' => 'Lopez',
                'dni' => '12345678',
            ],
            $repository->saved->toArray()
        );
    }
}
