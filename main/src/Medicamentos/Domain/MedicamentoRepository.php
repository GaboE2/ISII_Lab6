<?php

declare(strict_types=1);

namespace Farmacia\Medicamentos\Domain;

/**
 * Puerto de persistencia (DDD): el dominio no conoce MySQL/mysqli.
 */
interface MedicamentoRepository
{
    public function findById(MedicamentoId $id): ?Medicamento;

    public function save(Medicamento $medicamento): void;
}
