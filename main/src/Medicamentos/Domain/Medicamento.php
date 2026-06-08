<?php

declare(strict_types=1);

namespace Farmacia\Medicamentos\Domain;

/**
 * Agregado raíz: inventario de un medicamento (contexto catálogo / stock).
 */
final class Medicamento
{
    private int $stockActual;

    public function __construct(
        private MedicamentoId $id,
        private string $nombre,
        int $stockInicial
    ) {
        if ($stockInicial < 0) {
            throw new \InvalidArgumentException('El stock no puede ser negativo.');
        }
        $this->stockActual = $stockInicial;
    }

    public function id(): MedicamentoId
    {
        return $this->id;
    }

    public function nombre(): string
    {
        return $this->nombre;
    }

    public function stock(): int
    {
        return $this->stockActual;
    }

    public function retirarUnidades(Cantidad $cantidad): void
    {
        $n = $cantidad->unidades();
        if ($this->stockActual < $n) {
            throw new InsufficientStockException('Stock insuficiente para la operación solicitada.');
        }
        $this->stockActual -= $n;
    }
}
