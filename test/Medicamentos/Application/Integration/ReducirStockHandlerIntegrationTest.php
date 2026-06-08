<?php

declare(strict_types=1);

namespace Farmacia\Tests\Medicamentos\Application\Integration;

use Farmacia\Medicamentos\Application\ReducirStock\ReducirStockCommand;
use Farmacia\Medicamentos\Application\ReducirStock\ReducirStockHandler;
use Farmacia\Medicamentos\Domain\Medicamento;
use Farmacia\Medicamentos\Domain\MedicamentoId;
use Farmacia\Tests\Medicamentos\Support\InMemoryMedicamentoRepository;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

/**
 * Integración servicio de aplicación + implementación real del puerto (repositorio en memoria).
 */
#[Group('aplicacion-medicamentos-integracion')]
final class ReducirStockHandlerIntegrationTest extends TestCase
{
    private InMemoryMedicamentoRepository $repositorio;

    private ReducirStockHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repositorio = new InMemoryMedicamentoRepository();
        $this->handler = new ReducirStockHandler($this->repositorio);
    }

    protected function tearDown(): void
    {
        unset($this->repositorio, $this->handler);
        parent::tearDown();
    }

    public function test_SA_I01_reducir_stock_actualiza_estado_en_repositorio(): void
    {
        // Arrange
        $m = new Medicamento(MedicamentoId::fromInt(10), 'Metformina', 100);
        $this->repositorio->seed($m);

        // Act
        $this->handler->handle(new ReducirStockCommand(10, 15));

        // Assert
        $persistido = $this->repositorio->findById(MedicamentoId::fromInt(10));
        $this->assertNotNull($persistido);
        $this->assertSame(85, $persistido->stock(), 'El repositorio en memoria debe reflejar el stock tras el caso de uso.');
    }

    public function test_SA_I02_sin_medicamento_sembrado_falla(): void
    {
        // Arrange: repositorio vacío

        // Assert
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Medicamento no encontrado.');

        // Act
        $this->handler->handle(new ReducirStockCommand(99, 1));
    }
}
