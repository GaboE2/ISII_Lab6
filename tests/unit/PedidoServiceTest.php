<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../php/Pedidos/Aplicacion/PedidoService.php';
require_once __DIR__ . '/../../php/Pedidos/Dominio/IPedidoRepository.php';
require_once __DIR__ . '/../../php/Pedidos/Dominio/DatosEnvioPedido.php';

class PedidoServiceTest extends TestCase
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

    public function test_realiza_pedido_correctamente()
    {
        $repoMock = $this->createMock(IPedidoRepository::class);
        $repoMock->expects($this->once())
                  ->method('guardar')
                  ->willReturn(42);

        $service = new PedidoService($repoMock);

        $idPedido = $service->realizarPedido($this->datosEnvioValidos(), [
            ['name' => 'Paracetamol', 'quantity' => 2, 'price' => 10.0],
        ]);

        $this->assertSame(42, $idPedido);
    }

    public function test_no_guarda_si_carrito_esta_vacio()
    {
        $repoMock = $this->createMock(IPedidoRepository::class);
        $repoMock->expects($this->never())->method('guardar');

        $service = new PedidoService($repoMock);

        $this->expectException(InvalidArgumentException::class);

        $service->realizarPedido($this->datosEnvioValidos(), []);
    }

    public function test_no_guarda_si_cantidad_invalida()
    {
        $repoMock = $this->createMock(IPedidoRepository::class);
        $repoMock->expects($this->never())->method('guardar');

        $service = new PedidoService($repoMock);

        $this->expectException(InvalidArgumentException::class);

        $service->realizarPedido($this->datosEnvioValidos(), [
            ['name' => 'Paracetamol', 'quantity' => 0, 'price' => 10.0],
        ]);
    }
}

