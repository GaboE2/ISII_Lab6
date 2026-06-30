<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../php/Pedidos/Dominio/DetallePedido.php';
require_once __DIR__ . '/../../php/Pedidos/Dominio/ItemCarrito.php';

class DetallePedidoTest extends TestCase
{
    public function test_calcula_subtotal_correctamente()
    {
        $detalle = new DetallePedido(new ItemCarrito('Paracetamol', 3, 5.5));

        $this->assertSame(16.5, $detalle->getSubtotal());
    }

    public function test_cantidad_cero_lanza_excepcion()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('cantidad debe ser mayor a 0');

        new DetallePedido(new ItemCarrito('Paracetamol', 0, 5.5));
    }

    public function test_cantidad_supera_maximo_lanza_excepcion()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('cantidad maxima por producto es 100');

        new DetallePedido(new ItemCarrito('Paracetamol', 101, 5.5));
    }

    public function test_precio_cero_lanza_excepcion()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('precio unitario debe ser mayor a 0');

        new DetallePedido(new ItemCarrito('Paracetamol', 1, 0));
    }
}

