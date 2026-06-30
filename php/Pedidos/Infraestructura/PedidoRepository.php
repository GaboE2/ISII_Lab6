<?php
declare(strict_types=1);

require_once __DIR__ . '/../Dominio/IPedidoRepository.php';
require_once __DIR__ . '/../Dominio/Pedido.php';

final class PedidoRepository implements IPedidoRepository
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function guardar(Pedido $pedido): ?int
    {
        $sql = "INSERT INTO pedido (id_usuario, nombre_envio, direccion, ciudad, telefono, total, estado)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Error al preparar el pedido: " . $this->conn->error);
            return null;
        }

        $idUsuario = $pedido->getIdUsuario();
        $nombreEnvio = $pedido->getNombreEnvio();
        $direccion = $pedido->getDireccion();
        $ciudad = $pedido->getCiudad();
        $telefono = $pedido->getTelefono();
        $total = $pedido->getTotal();
        $estado = $pedido->getEstado();

        $stmt->bind_param(
            "issssds",
            $idUsuario,
            $nombreEnvio,
            $direccion,
            $ciudad,
            $telefono,
            $total,
            $estado
        );

        if (!$stmt->execute()) {
            error_log("Error al insertar pedido: " . $stmt->error);
            $stmt->close();
            return null;
        }

        $idPedido = $stmt->insert_id;
        $stmt->close();

        $sqlDetalle = "INSERT INTO detalle_pedido (id_pedido, nombre_producto, cantidad, precio_unitario, subtotal)
                       VALUES (?, ?, ?, ?, ?)";
        $stmtDetalle = $this->conn->prepare($sqlDetalle);

        $sqlStock = "UPDATE medicamento SET stock = stock - ? WHERE nombre = ? AND stock >= ?";
        $stmtStock = $this->conn->prepare($sqlStock);

        foreach ($pedido->getDetalles() as $detalle) {
            $nombre = $detalle->getNombreProducto();
            $cantidad = $detalle->getCantidad();
            $precio = $detalle->getPrecioUnitario();
            $subtotal = $detalle->getSubtotal();

            $stmtDetalle->bind_param("isidd", $idPedido, $nombre, $cantidad, $precio, $subtotal);
            $stmtDetalle->execute();

            $stmtStock->bind_param("isi", $cantidad, $nombre, $cantidad);
            $stmtStock->execute();
        }

        $stmtDetalle->close();
        $stmtStock->close();

        return $idPedido;
    }
}

