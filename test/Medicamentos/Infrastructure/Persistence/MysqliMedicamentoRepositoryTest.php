<?php

declare(strict_types=1);

namespace Farmacia\Tests\Medicamentos\Infrastructure\Persistence;

use Farmacia\Medicamentos\Domain\Medicamento;
use Farmacia\Medicamentos\Domain\MedicamentoId;
use Farmacia\Medicamentos\Infrastructure\Persistence\MysqliMedicamentoRepository;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

/**
 * Pruebas unitarias del adaptador de repositorio (infraestructura / persistencia).
 */
#[Group('repositorio-medicamentos')]
final class MysqliMedicamentoRepositoryTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private MedicamentoId $idPruebaBusqueda;

    protected function setUp(): void
    {
        parent::setUp();
        $this->idPruebaBusqueda = MedicamentoId::fromInt(9);
    }

    protected function tearDown(): void
    {
        unset($this->idPruebaBusqueda);
        parent::tearDown();
    }

    public function test_findById_mapea_fila_a_agregado(): void
    {
        // Arrange
        $stmt = Mockery::mock('stdClass');
        $result = Mockery::mock('stdClass');

        $mysqli = Mockery::mock('stdClass');
        $mysqli->error = '';
        $mysqli->shouldReceive('prepare')
            ->once()
            ->with(Mockery::pattern('/SELECT.*medicamento/is'))
            ->andReturn($stmt);

        $stmt->shouldReceive('bind_param')->once()->with('i', Mockery::any())->andReturn(true);
        $stmt->shouldReceive('execute')->once()->andReturn(true);
        $stmt->shouldReceive('get_result')->once()->andReturn($result);
        $result->shouldReceive('fetch_assoc')->once()->andReturn([
            'ID_Medicamento' => 9,
            'Nombre_Medicamento' => 'Omeprazol',
            'Stock_medicamento' => 42,
        ]);
        $stmt->shouldReceive('close')->once()->andReturn(true);

        $sut = new MysqliMedicamentoRepository($mysqli);

        // Act
        $medicamento = $sut->findById($this->idPruebaBusqueda);

        // Assert
        $this->assertNotNull($medicamento);
        $this->assertSame(9, $medicamento->id()->toInt(), 'El ID debe mapearse desde la fila.');
        $this->assertSame('Omeprazol', $medicamento->nombre());
        $this->assertSame(42, $medicamento->stock());
    }

    public function test_findById_sin_fila_devuelve_null(): void
    {
        // Arrange
        $stmt = Mockery::mock('stdClass');
        $result = Mockery::mock('stdClass');

        $mysqli = Mockery::mock('stdClass');
        $mysqli->error = '';
        $mysqli->shouldReceive('prepare')->once()->andReturn($stmt);
        $stmt->shouldReceive('bind_param')->once()->andReturn(true);
        $stmt->shouldReceive('execute')->once()->andReturn(true);
        $stmt->shouldReceive('get_result')->once()->andReturn($result);
        $result->shouldReceive('fetch_assoc')->once()->andReturn(false);
        $stmt->shouldReceive('close')->once()->andReturn(true);

        $sut = new MysqliMedicamentoRepository($mysqli);

        // Act
        $medicamento = $sut->findById(MedicamentoId::fromInt(1));

        // Assert
        $this->assertNull($medicamento, 'Sin fila en BD el repositorio debe devolver null.');
    }

    public function test_prepare_falla_lanza_runtime_exception(): void
    {
        // Arrange
        $mysqli = Mockery::mock('stdClass');
        $mysqli->error = 'syntax error';
        $mysqli->shouldReceive('prepare')->once()->andReturn(false);

        $sut = new MysqliMedicamentoRepository($mysqli);

        // Assert
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Error al preparar consulta');

        // Act
        $sut->findById(MedicamentoId::fromInt(1));
    }

    public function test_save_ejecuta_update_con_stock_y_id(): void
    {
        // Arrange — doble manual: mysqli_stmt expone affected_rows como propiedad real
        $stmt = new class () {
            public int $affected_rows = 1;

            public string $tipos = '';

            public int $stock = 0;

            public int $id = 0;

            public bool $cerrado = false;

            public function bind_param(string $types, int &$stock, int &$id): bool
            {
                $this->tipos = $types;
                $this->stock = $stock;
                $this->id = $id;

                return true;
            }

            public function execute(): bool
            {
                return true;
            }

            public function close(): void
            {
                $this->cerrado = true;
            }
        };

        $mysqli = new class ($stmt) {
            public string $error = '';

            public function __construct(private object $stmt)
            {
            }

            public function prepare(string $sql): object|false
            {
                if (stripos($sql, 'UPDATE') === false || stripos($sql, 'medicamento') === false) {
                    return false;
                }

                return $this->stmt;
            }
        };

        $medicamento = new Medicamento(
            MedicamentoId::fromInt(3),
            'Paracetamol',
            11
        );

        $sut = new MysqliMedicamentoRepository($mysqli);

        // Act
        $sut->save($medicamento);

        // Assert
        $this->assertSame('ii', $stmt->tipos, 'bind_param debe usar dos enteros (stock, id).');
        $this->assertSame(11, $stmt->stock);
        $this->assertSame(3, $stmt->id);
        $this->assertTrue($stmt->cerrado, 'El statement debe cerrarse tras guardar.');
    }
}
