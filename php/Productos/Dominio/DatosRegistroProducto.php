<?php
declare(strict_types=1);

final class DatosRegistroProducto
{
    public function __construct(
        public readonly string $tipo,
        public readonly string $nombre,
        public readonly string $clase,
        public readonly int $stock,
        public readonly float $precio,
        public readonly string $imagen
    ) {}
}

