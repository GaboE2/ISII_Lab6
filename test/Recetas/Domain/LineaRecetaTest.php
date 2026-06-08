<?php

declare(strict_types=1);

namespace Farmacia\Tests\Recetas\Domain;

use Farmacia\Recetas\Domain\ConsultaId;
use Farmacia\Recetas\Domain\IdMedicamentoReceta;
use Farmacia\Recetas\Domain\LineaReceta;
use Farmacia\Recetas\Domain\RecetaId;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

#[Group('dominio-recetas')]
final class LineaRecetaTest extends TestCase
{
    private RecetaId $idReceta;

    private ConsultaId $idConsulta;

    private IdMedicamentoReceta $idMedicamento;

    protected function setUp(): void
    {
        parent::setUp();
        $this->idReceta = RecetaId::fromInt(1);
        $this->idConsulta = ConsultaId::fromInt(10);
        $this->idMedicamento = IdMedicamentoReceta::fromInt(5);
    }

    protected function tearDown(): void
    {
        unset($this->idReceta, $this->idConsulta, $this->idMedicamento);
        parent::tearDown();
    }

    public function test_linea_valida_conserva_cantidad_y_fecha(): void
    {
        // Arrange
        $cant = '  2 cápsulas c/8h  ';
        $fecha = '2026-05-14';

        // Act
        $sut = new LineaReceta(
            $this->idReceta,
            $this->idConsulta,
            $this->idMedicamento,
            $cant,
            $fecha
        );

        // Assert
        $this->assertSame('2 cápsulas c/8h', $sut->cantidadPreinscrita());
        $this->assertSame($fecha, $sut->fechaReceta());
        $this->assertSame(1, $sut->recetaId()->toInt());
    }

    public function test_cantidad_vacia_lanza_invalid_argument(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('La cantidad prescrita no puede estar vacía.');

        new LineaReceta(
            $this->idReceta,
            $this->idConsulta,
            $this->idMedicamento,
            '   ',
            '2026-01-15'
        );
    }

    public function test_fecha_invalida_lanza_invalid_argument(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('La fecha de receta debe ser válida (Y-m-d).');

        new LineaReceta(
            $this->idReceta,
            $this->idConsulta,
            $this->idMedicamento,
            '1 tableta',
            '2026-13-40'
        );
    }
}
