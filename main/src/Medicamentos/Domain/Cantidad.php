<?php

declare(strict_types=1);

namespace Farmacia\Medicamentos\Domain;

final class Cantidad
{
    private function __construct(private int $unidades)
    {
        if ($this->unidades < 1) {
            throw new \InvalidArgumentException('La cantidad debe ser al menos 1 unidad.');
        }
    }

    public static function fromInt(int $unidades): self
    {
        return new self($unidades);
    }

    public function unidades(): int
    {
        return $this->unidades;
    }
}
