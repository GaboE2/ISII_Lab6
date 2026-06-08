<?php

declare(strict_types=1);

namespace Farmacia\Medicamentos\Application\ReducirStock;

use Farmacia\Medicamentos\Domain\Cantidad;
use Farmacia\Medicamentos\Domain\InsufficientStockException;
use Farmacia\Medicamentos\Domain\MedicamentoId;
use Farmacia\Medicamentos\Domain\MedicamentoRepository;

/**
 * Caso de uso: orquesta dominio + puerto de persistencia (Clean Architecture).
 */
final class ReducirStockHandler
{
    public function __construct(
        private MedicamentoRepository $medicamentos
    ) {
    }

    /**
     * @throws InsufficientStockException
     * @throws \InvalidArgumentException
     */
    public function handle(ReducirStockCommand $command): void
    {
        $id = MedicamentoId::fromInt($command->medicamentoId);
        $cantidad = Cantidad::fromInt($command->unidades);

        $medicamento = $this->medicamentos->findById($id);
        if ($medicamento === null) {
            throw new \InvalidArgumentException('Medicamento no encontrado.');
        }

        $medicamento->retirarUnidades($cantidad);
        $this->medicamentos->save($medicamento);
    }
}
