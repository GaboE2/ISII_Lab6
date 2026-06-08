<?php

declare(strict_types=1);

namespace Farmacia\Tests\Recetas\Application;

use Farmacia\Recetas\Application\EmitirLineaReceta\EmitirLineaRecetaCommand;
use Farmacia\Recetas\Application\EmitirLineaReceta\EmitirLineaRecetaHandler;
use Farmacia\Recetas\Domain\LineaReceta;
use Farmacia\Recetas\Domain\RecetaRepository;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

#[Group('aplicacion-recetas')]
final class EmitirLineaRecetaHandlerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function test_delega_en_repositorio_tras_construir_linea(): void
    {
        $repo = Mockery::mock(RecetaRepository::class);
        $repo->shouldReceive('save')
            ->once()
            ->with(Mockery::on(static function ($linea) {
                if (!$linea instanceof LineaReceta) {
                    return false;
                }

                return $linea->recetaId()->toInt() === 7
                    && $linea->consultaId()->toInt() === 2
                    && $linea->medicamentoId()->toInt() === 3
                    && $linea->cantidadPreinscrita() === '10 ml'
                    && $linea->fechaReceta() === '2026-03-01';
            }));

        $handler = new EmitirLineaRecetaHandler($repo);
        $handler->handle(new EmitirLineaRecetaCommand(7, 2, 3, '10 ml', '2026-03-01'));
    }
}
