<?php
declare(strict_types=1);

final class DatosEnvioPedido
{
    public function __construct(
        public readonly int $idUsuario,
        public readonly string $nombreEnvio,
        public readonly string $direccion,
        public readonly string $ciudad,
        public readonly string $telefono
    ) {}
}

