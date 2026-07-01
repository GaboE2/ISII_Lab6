<?php
declare(strict_types=1);

require_once __DIR__ . '/Pedido.php';

interface IPedidoRepository
{
    /**
     * Guarda el pedido y sus detalles, y reduce el stock de cada producto.
     * Retorna el id generado del pedido, o null si falló.
     */
    public function guardar(Pedido $pedido): ?int;
}

