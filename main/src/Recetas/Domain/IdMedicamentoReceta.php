<?php

declare(strict_types=1);

namespace Farmacia\Recetas\Domain;

/** Referencia al medicamento dentro del contexto Recetas (evita acoplar al BC Medicamentos). */
final class IdMedicamentoReceta
{
    private function __construct(private int $valor)
    {
        if ($this->valor < 1) {
            throw new \InvalidArgumentException('ID de medicamento en receta inválido.');
        }
    }

    public static function fromInt(int $id): self
    {
        return new self($id);
    }

    public function toInt(): int
    {
        return $this->valor;
    }
}
