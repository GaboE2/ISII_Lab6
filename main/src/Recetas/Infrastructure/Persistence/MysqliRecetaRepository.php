<?php

declare(strict_types=1);

namespace Farmacia\Recetas\Infrastructure\Persistence;

use Farmacia\Recetas\Domain\LineaReceta;
use Farmacia\Recetas\Domain\RecetaRepository;

final class MysqliRecetaRepository implements RecetaRepository
{
    /**
     * @param \mysqli|object $conexion Producción: \mysqli; tests: doble compatible.
     */
    public function __construct(
        private object $conexion
    ) {
    }

    public function save(LineaReceta $linea): void
    {
        $sql = 'INSERT INTO receta (ID_Receta, ID_Consulta, ID_Medicamento, Cantidad_preinscrita, Fecha_receta)
                VALUES (?, ?, ?, ?, ?)';
        $stmt = $this->conexion->prepare($sql);
        if ($stmt === false) {
            throw new \RuntimeException('Error al preparar inserción de receta: ' . $this->conexion->error);
        }

        $idR = $linea->recetaId()->toInt();
        $idC = $linea->consultaId()->toInt();
        $idM = $linea->medicamentoId()->toInt();
        $cant = $linea->cantidadPreinscrita();
        $fecha = $linea->fechaReceta();

        $stmt->bind_param('iiiss', $idR, $idC, $idM, $cant, $fecha);
        if (!$stmt->execute()) {
            $err = $stmt->error;
            $stmt->close();
            throw new \RuntimeException('Error al guardar receta: ' . $err);
        }
        $stmt->close();
    }
}
