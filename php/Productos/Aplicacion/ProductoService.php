<?php
declare(strict_types=1);

require_once __DIR__ . '/../Dominio/Medicamento.php';
require_once __DIR__ . '/../Dominio/DatosRegistroProducto.php';
require_once __DIR__ . '/IProductoRepository.php';

class ProductoService
{
    private IProductoRepository $repository;

    public function __construct(IProductoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function registrarProducto(DatosRegistroProducto $datos): int
    {
        if ($this->repository->existeNombre($datos->nombre)) {
            throw new RuntimeException("Ya existe un producto con ese nombre.");
        }

        $producto = new Medicamento($datos);
        return $this->repository->guardar($producto);
    }
}
