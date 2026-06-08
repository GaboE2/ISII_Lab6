<?php

declare(strict_types=1);

namespace Farmacia\Tests\Consultas\Unit;

use App\Application\RegistrarConsultaService;
use App\Domain\Entity\Consulta;
use App\Domain\Repository\ConsultaRepositoryInterface;
use PHPUnit\Framework\TestCase;

final class RegistrarConsultaServiceTest extends TestCase
{
    public function test_ejecuta_y_guarda_consulta_con_mock(): void
    {
        $repo = $this->createMock(ConsultaRepositoryInterface::class);
        $repo->expects(self::once())
            ->method('save')
            ->with(self::isInstanceOf(Consulta::class))
            ->willReturn(true);

        $service = new RegistrarConsultaService($repo);

        $result = $service->ejecutar([
            'codigo' => 'C001',
            'fecha' => '2026-04-30',
            'inicio' => '10:00',
            'motivo' => 'Control',
            'id_paciente' => 3,
            'nombre_completo' => 'Ana Quispe',
            'fecha_nacimiento' => '2001-02-03',
            'sexo' => 'F',
            'telefono' => '987654321',
            'diagnostico' => 'Estable',
        ]);

        self::assertTrue($result);
    }
}
