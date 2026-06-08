<?php

declare(strict_types=1);

namespace Farmacia\Recetas\Domain;

final class ConsultaId
{
    private function __construct(private int $valor)
    {
        if ($this->valor < 1) {
            throw new \InvalidArgumentException('ID de consulta inválido.');
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
