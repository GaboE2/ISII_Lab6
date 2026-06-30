<?php
declare(strict_types=1);

require_once __DIR__ . '/../Dominio/Pedido.php';
require_once __DIR__ . '/../Dominio/DatosEnvioPedido.php';
require_once __DIR__ . '/../Dominio/DetallePedido.php';
require_once __DIR__ . '/../Dominio/ItemCarrito.php';
require_once __DIR__ . '/../Dominio/IPedidoRepository.php';

class PedidoService
{
    private IPedidoRepository $repository;

    public function __construct(IPedidoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $carritoCrudo Array de items con keys: name, quantity, price
     */
    public function realizarPedido(DatosEnvioPedido $datosEnvio, array $carritoCrudo): ?int
    {
        $detalles = [];
        foreach ($carritoCrudo as $item) {
            $detalles[] = new DetallePedido(new ItemCarrito(
                nombreProducto: trim($item['name'] ?? ''),
                cantidad: (int) ($item['quantity'] ?? 0),
                precioUnitario: (float) ($item['price'] ?? 0)
            ));
        }

        $pedido = new Pedido($datosEnvio, $detalles);

        return $this->repository->guardar($pedido);
    }
}

