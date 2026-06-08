<?php

declare(strict_types=1);

namespace Farmacia\Tests\Medicamentos\Support;

use Farmacia\Medicamentos\Domain\Medicamento;
use Farmacia\Medicamentos\Domain\MedicamentoId;
use Farmacia\Medicamentos\Domain\MedicamentoRepository;

/**
 * Doble de integración: implementa el puerto del dominio sin MySQL (estado en memoria).
 */
final class InMemoryMedicamentoRepository implements MedicamentoRepository
{
    /** @var array<int, Medicamento> */
    private array $porId = [];

    public function seed(Medicamento $medicamento): void
    {
        $this->porId[$medicamento->id()->toInt()] = $medicamento;
    }

    public function findById(MedicamentoId $id): ?Medicamento
    {
        return $this->porId[$id->toInt()] ?? null;
    }

    public function save(Medicamento $medicamento): void
    {
        $this->porId[$medicamento->id()->toInt()] = $medicamento;
    }
}
