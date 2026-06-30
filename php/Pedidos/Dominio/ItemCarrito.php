<?php
declare(strict_types=1);

final class ItemCarrito
{
    public function __construct(
        public readonly string $nombreProducto,
        public readonly int $cantidad,
        public readonly float $precioUnitario
    ) {}
}

