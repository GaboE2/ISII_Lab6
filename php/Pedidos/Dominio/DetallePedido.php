<?php
declare(strict_types=1);

require_once __DIR__ . '/ItemCarrito.php';

class DetallePedido
{
    private const CANTIDAD_MAXIMA = 100;

    private string $nombreProducto;
    private int $cantidad;
    private float $precioUnitario;
    private float $subtotal;

    public function __construct(ItemCarrito $item)
    {
        if (trim($item->nombreProducto) === '') {
            throw new InvalidArgumentException("El nombre del producto es obligatorio.");
        }

        if ($item->cantidad <= 0) {
            throw new InvalidArgumentException("La cantidad debe ser mayor a 0.");
        }

        if ($item->cantidad > self::CANTIDAD_MAXIMA) {
            throw new InvalidArgumentException("La cantidad maxima por producto es " . self::CANTIDAD_MAXIMA . ".");
        }

        if ($item->precioUnitario <= 0) {
            throw new InvalidArgumentException("El precio unitario debe ser mayor a 0.");
        }

        $this->nombreProducto = $item->nombreProducto;
        $this->cantidad = $item->cantidad;
        $this->precioUnitario = $item->precioUnitario;
        $this->subtotal = round($item->cantidad * $item->precioUnitario, 2);
    }

    public function getNombreProducto(): string { return $this->nombreProducto; }
    public function getCantidad(): int { return $this->cantidad; }
    public function getPrecioUnitario(): float { return $this->precioUnitario; }
    public function getSubtotal(): float { return $this->subtotal; }
}

