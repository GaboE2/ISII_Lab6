<?php
declare(strict_types=1);

require_once __DIR__ . '/../Dominio/Medicamento.php';

interface IProductoRepository
{
    public function guardar(Medicamento $producto): int;
    public function existeNombre(string $nombre): bool;
}
