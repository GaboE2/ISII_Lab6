<?php

declare(strict_types=1);

namespace Farmacia\Tests\Medicamentos\Domain;

use Farmacia\Medicamentos\Domain\Cantidad;
use Farmacia\Medicamentos\Domain\MedicamentoId;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

/**
 * Invariantes de objetos de valor del mismo bounded context (sin agregado completo).
 */
#[Group('dominio-medicamentos')]
final class ValorDeDominioMedicamentosTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_CP05_medicamento_id_cero_viola_invariante(): void
    {
        // Arrange
        $idInvalido = 0;

        // Assert
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('ID de medicamento inválido.');

        // Act
        MedicamentoId::fromInt($idInvalido);
    }

    public function test_CP06_cantidad_cero_viola_invariante(): void
    {
        // Arrange
        $unidades = 0;

        // Assert
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('La cantidad debe ser al menos 1 unidad.');

        // Act
        Cantidad::fromInt($unidades);
    }
}
