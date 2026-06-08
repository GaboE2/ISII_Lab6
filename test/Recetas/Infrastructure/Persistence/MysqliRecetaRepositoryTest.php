<?php

declare(strict_types=1);

namespace Farmacia\Tests\Recetas\Infrastructure\Persistence;

use Farmacia\Recetas\Domain\ConsultaId;
use Farmacia\Recetas\Domain\IdMedicamentoReceta;
use Farmacia\Recetas\Domain\LineaReceta;
use Farmacia\Recetas\Domain\RecetaId;
use Farmacia\Recetas\Infrastructure\Persistence\MysqliRecetaRepository;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

#[Group('repositorio-recetas')]
final class MysqliRecetaRepositoryTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function test_save_prepara_insert_con_cinco_parametros(): void
    {
        $stmt = new class () {
            public string $sql = '';

            public string $tipos = '';

            /** @var array<int, int|string> */
            public array $params = [];

            public bool $cerrado = false;

            public function bind_param(string $types, int &$a, int &$b, int &$c, string &$d, string &$e): bool
            {
                $this->tipos = $types;
                $this->params = [$a, $b, $c, $d, $e];

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
                if (stripos($sql, 'INSERT') === false || stripos($sql, 'receta') === false) {
                    return false;
                }
                $this->stmt->sql = $sql;

                return $this->stmt;
            }
        };

        $linea = new LineaReceta(
            RecetaId::fromInt(100),
            ConsultaId::fromInt(20),
            IdMedicamentoReceta::fromInt(30),
            '1 frasco',
            '2026-06-01'
        );

        $sut = new MysqliRecetaRepository($mysqli);

        $sut->save($linea);

        $this->assertSame('iiiss', $stmt->tipos);
        $this->assertSame([100, 20, 30, '1 frasco', '2026-06-01'], $stmt->params);
        $this->assertTrue($stmt->cerrado);
    }

    public function test_prepare_falla_lanza_runtime(): void
    {
        $mysqli = Mockery::mock('stdClass');
        $mysqli->error = 'fail';
        $mysqli->shouldReceive('prepare')->once()->andReturn(false);

        $sut = new MysqliRecetaRepository($mysqli);

        $linea = new LineaReceta(
            RecetaId::fromInt(1),
            ConsultaId::fromInt(1),
            IdMedicamentoReceta::fromInt(1),
            'x',
            '2026-01-01'
        );

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('preparar inserción');

        $sut->save($linea);
    }
}
