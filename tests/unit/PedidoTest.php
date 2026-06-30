<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../php/Pedidos/Dominio/Pedido.php';
require_once __DIR__ . '/../../php/Pedidos/Dominio/DatosEnvioPedido.php';
require_once __DIR__ . '/../../php/Pedidos/Dominio/DetallePedido.php';
require_once __DIR__ . '/../../php/Pedidos/Dominio/ItemCarrito.php';

class PedidoTest extends TestCase
{
    private function datosEnvioValidos(): DatosEnvioPedido
    {
        return new DatosEnvioPedido(
            idUsuario: 1,
            nombreEnvio: 'Juan Pérez',
            direccion: 'Av. Principal 123',
            ciudad: 'Arequipa',
            telefono: '999888777'
        );
    }

    public function test_crea_pedido_valido_y_calcula_total()
    {
        $detalle = new DetallePedido(new ItemCarrito('Paracetamol', 2, 10.0));

        $pedido = new Pedido($this->datosEnvioValidos(), [$detalle]);

        $this->assertSame(20.0, $pedido->getTotal());
        $this->assertSame('completado', $pedido->getEstado());
        $this->assertCount(1, $pedido->getDetalles());
    }

    public function test_carrito_vacio_lanza_excepcion()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('carrito está vacío');

        new Pedido($this->datosEnvioValidos(), []);
    }

    public function test_nombre_envio_vacio_lanza_excepcion()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('nombre de envío es obligatorio');

        $detalle = new DetallePedido(new ItemCarrito('Paracetamol', 1, 10.0));

        new Pedido(new DatosEnvioPedido(
            idUsuario: 1,
            nombreEnvio: '',
            direccion: 'Av. Principal 123',
            ciudad: 'Arequipa',
            telefono: '999888777'
        ), [$detalle]);
    }

    public function test_calcula_total_con_multiples_detalles()
    {
        $detalle1 = new DetallePedido(new ItemCarrito('Paracetamol', 2, 10.0));
        $detalle2 = new DetallePedido(new ItemCarrito('Ibuprofeno', 1, 15.5));

        $pedido = new Pedido($this->datosEnvioValidos(), [$detalle1, $detalle2]);

        $this->assertSame(35.5, $pedido->getTotal());
    }
}

