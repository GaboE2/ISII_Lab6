<?php

declare(strict_types=1);

namespace Farmacia\Tests\Medicamentos\Domain;

use Farmacia\Medicamentos\Domain\Cantidad;
use Farmacia\Medicamentos\Domain\InsufficientStockException;
use Farmacia\Medicamentos\Domain\Medicamento;
use Farmacia\Medicamentos\Domain\MedicamentoId;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

/**
 * Test Case: comportamiento del agregado Medicamento (módulo dominio Medicamentos).
 */
#[Group('dominio-medicamentos')]
final class MedicamentoTest extends TestCase
{
    private MedicamentoId $idMedicamentoFijo;

    protected function setUp(): void
    {
        parent::setUp();
        // Arrange común: identificador válido reutilizable (aislamiento por test)
        $this->idMedicamentoFijo = MedicamentoId::fromInt(1);
    }

    protected function tearDown(): void
    {
        unset($this->idMedicamentoFijo);
        parent::tearDown();
    }

    public function test_CP01_retirar_unidades_descuenta_stock(): void
    {
        // Arrange
        $sut = new Medicamento($this->idMedicamentoFijo, 'Paracetamol', 10);
        $retiro = Cantidad::fromInt(3);
        $stockEsperado = 7;

        // Act
        $sut->retirarUnidades($retiro);

        // Assert
        $this->assertSame(
            $stockEsperado,
            $sut->stock(),
            'Tras un retiro válido, el stock debe decrecer exactamente en las unidades retiradas.'
        );
    }

    public function test_CP02_retirar_mas_del_disponible_lanza_excepcion(): void
    {
        // Arrange
        $sut = new Medicamento($this->idMedicamentoFijo, 'Paracetamol', 2);
        $retiro = Cantidad::fromInt(5);

        // Assert (expectativa antes del Act en PHPUnit)
        $this->expectException(InsufficientStockException::class);

        // Act
        $sut->retirarUnidades($retiro);
    }

    public function test_CP03_retirar_unidades_hasta_dejar_stock_en_cero(): void
    {
        // Arrange
        $sut = new Medicamento($this->idMedicamentoFijo, 'Ibuprofeno', 4);
        $retiro = Cantidad::fromInt(4);

        // Act
        $sut->retirarUnidades($retiro);

        // Assert
        $this->assertSame(0, $sut->stock(), 'Debe permitirse agotar el stock (límite inferior 0).');
    }

    public function test_CP04_constructor_rechaza_stock_negativo_invariante(): void
    {
        // Arrange
        $stockInicial = -1;

        // Assert
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('El stock no puede ser negativo.');

        // Act
        new Medicamento($this->idMedicamentoFijo, 'Producto', $stockInicial);
    }
}
