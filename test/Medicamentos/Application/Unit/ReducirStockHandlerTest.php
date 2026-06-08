<?php

declare(strict_types=1);

namespace Farmacia\Tests\Medicamentos\Application\Unit;

use Farmacia\Medicamentos\Application\ReducirStock\ReducirStockCommand;
use Farmacia\Medicamentos\Application\ReducirStock\ReducirStockHandler;
use Farmacia\Medicamentos\Domain\InsufficientStockException;
use Farmacia\Medicamentos\Domain\Medicamento;
use Farmacia\Medicamentos\Domain\MedicamentoId;
use Farmacia\Medicamentos\Domain\MedicamentoRepository;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

/**
 * Pruebas unitarias del servicio de aplicación con mock del repositorio (doble aislado).
 */
#[Group('aplicacion-medicamentos-unit')]
final class ReducirStockHandlerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_SA_U01_persiste_medicamento_tras_reducir_stock(): void
    {
        // Arrange
        $id = MedicamentoId::fromInt(5);
        $agregado = new Medicamento($id, 'Ibuprofeno', 4);

        $repo = Mockery::mock(MedicamentoRepository::class);
        $repo->shouldReceive('findById')
            ->once()
            ->with(Mockery::on(static fn ($arg) => $arg instanceof MedicamentoId && $arg->toInt() === 5))
            ->andReturn($agregado);
        $repo->shouldReceive('save')
            ->once()
            ->with(Mockery::on(static function ($m) {
                return $m instanceof Medicamento && $m->stock() === 1;
            }));

        $handler = new ReducirStockHandler($repo);

        // Act
        $handler->handle(new ReducirStockCommand(5, 3));

        // Assert: mismo agregado mutado + expectativas Mockery sobre el repositorio
        $this->assertSame(1, $agregado->stock());
    }

    public function test_SA_U02_medicamento_no_encontrado_lanza_invalid_argument(): void
    {
        // Arrange
        $repo = Mockery::mock(MedicamentoRepository::class);
        $repo->shouldReceive('findById')
            ->once()
            ->andReturn(null);
        $repo->shouldReceive('save')->never();

        $handler = new ReducirStockHandler($repo);

        // Assert
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Medicamento no encontrado.');

        // Act
        $handler->handle(new ReducirStockCommand(404, 1));
    }

    public function test_SA_U03_stock_insuficiente_no_persiste_y_propaga(): void
    {
        // Arrange
        $agregado = new Medicamento(MedicamentoId::fromInt(2), 'Paracetamol', 2);

        $repo = Mockery::mock(MedicamentoRepository::class);
        $repo->shouldReceive('findById')->once()->andReturn($agregado);
        $repo->shouldReceive('save')->never();

        $handler = new ReducirStockHandler($repo);

        // Assert
        $this->expectException(InsufficientStockException::class);

        // Act
        $handler->handle(new ReducirStockCommand(2, 5));
    }
}
