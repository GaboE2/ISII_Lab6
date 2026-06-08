<?php

declare(strict_types=1);

namespace Farmacia\Medicamentos\Infrastructure\Persistence;

use Farmacia\Medicamentos\Domain\Medicamento;
use Farmacia\Medicamentos\Domain\MedicamentoId;
use Farmacia\Medicamentos\Domain\MedicamentoRepository;

/**
 * Adaptador de infraestructura: implementa el puerto con mysqli (detalle técnico).
 */
final class MysqliMedicamentoRepository implements MedicamentoRepository
{
    /**
     * @param \mysqli|object $conexion En producción se usa \mysqli; en pruebas unitarias un doble con la misma API (prepare, error).
     */
    public function __construct(
        private object $conexion
    ) {
    }

    public function findById(MedicamentoId $id): ?Medicamento
    {
        $sql = 'SELECT ID_Medicamento, Nombre_Medicamento, Stock_medicamento
                FROM medicamento WHERE ID_Medicamento = ? LIMIT 1';
        $stmt = $this->conexion->prepare($sql);
        if ($stmt === false) {
            throw new \RuntimeException('Error al preparar consulta: ' . $this->conexion->error);
        }

        $mid = $id->toInt();
        $stmt->bind_param('i', $mid);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result !== false ? $result->fetch_assoc() : null;
        $stmt->close();

        if ($row === null || $row === false) {
            return null;
        }

        return new Medicamento(
            MedicamentoId::fromInt((int) $row['ID_Medicamento']),
            (string) $row['Nombre_Medicamento'],
            (int) $row['Stock_medicamento']
        );
    }

    public function save(Medicamento $medicamento): void
    {
        $sql = 'UPDATE medicamento SET Stock_medicamento = ? WHERE ID_Medicamento = ?';
        $stmt = $this->conexion->prepare($sql);
        if ($stmt === false) {
            throw new \RuntimeException('Error al preparar actualización: ' . $this->conexion->error);
        }

        $stock = $medicamento->stock();
        $id = $medicamento->id()->toInt();
        $stmt->bind_param('ii', $stock, $id);
        $stmt->execute();
        if ($stmt->affected_rows < 0) {
            $stmt->close();
            throw new \RuntimeException('Error al guardar stock: ' . $this->conexion->error);
        }
        $stmt->close();
    }
}
