<?php
declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use RuntimeException;

require_once __DIR__ . '/../../php/Productos/Aplicacion/IProductoRepository.php';
require_once __DIR__ . '/../../php/Productos/Aplicacion/ProductoService.php';

final class ProductoServiceTest extends TestCase
{
    private function datosMedicamento(array $overrides = []): \DatosRegistroProducto
    {
        $defaults = [
            'tipo'   => 'medicamento',
            'nombre' => 'Paracetamol',
            'clase'  => 'Analgésico',
            'stock'  => 50,
            'precio' => 10.5,
            'imagen' => 'img_123.jpg',
        ];
        $merged = array_merge($defaults, $overrides);
        return new \DatosRegistroProducto(...$merged);
    }

    public function testRegistraProductoNuevoCorrectamente(): void
    {
        $repoMock = $this->createMock(\IProductoRepository::class);
        $repoMock->method('existeNombre')->willReturn(false);
        $repoMock->method('guardar')->willReturn(42);

        $service = new \ProductoService($repoMock);
        $id = $service->registrarProducto($this->datosMedicamento());

        $this->assertSame(42, $id);
    }

    public function testLanzaExcepcionSiNombreYaExiste(): void
    {
        $repoMock = $this->createMock(\IProductoRepository::class);
        $repoMock->method('existeNombre')->willReturn(true);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Ya existe un producto con ese nombre.');

        $service = new \ProductoService($repoMock);
        $service->registrarProducto($this->datosMedicamento());
    }

    public function testGuardarEsLlamadoExactamenteUnaVez(): void
    {
        $repoMock = $this->createMock(\IProductoRepository::class);
        $repoMock->method('existeNombre')->willReturn(false);
        $repoMock->expects($this->once())
                 ->method('guardar')
                 ->willReturn(1);

        $service = new \ProductoService($repoMock);
        $service->registrarProducto($this->datosMedicamento());
    }
}
