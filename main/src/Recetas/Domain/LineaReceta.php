<?php

declare(strict_types=1);

namespace Farmacia\Recetas\Domain;

/**
 * Línea de prescripción asociada a una consulta (fila agregada tabla Receta).
 */
final class LineaReceta
{
    public function __construct(
        private RecetaId $recetaId,
        private ConsultaId $consultaId,
        private IdMedicamentoReceta $medicamentoId,
        private string $cantidadPreinscrita,
        private string $fechaReceta
    ) {
        if (trim($this->cantidadPreinscrita) === '') {
            throw new \InvalidArgumentException('La cantidad prescrita no puede estar vacía.');
        }
        if (!self::esFechaValida($this->fechaReceta)) {
            throw new \InvalidArgumentException('La fecha de receta debe ser válida (Y-m-d).');
        }
    }

    public function recetaId(): RecetaId
    {
        return $this->recetaId;
    }

    public function consultaId(): ConsultaId
    {
        return $this->consultaId;
    }

    public function medicamentoId(): IdMedicamentoReceta
    {
        return $this->medicamentoId;
    }

    public function cantidadPreinscrita(): string
    {
        return trim($this->cantidadPreinscrita);
    }

    public function fechaReceta(): string
    {
        return $this->fechaReceta;
    }

    private static function esFechaValida(string $fecha): bool
    {
        $dt = \DateTimeImmutable::createFromFormat('Y-m-d', $fecha);

        return $dt !== false && $dt->format('Y-m-d') === $fecha;
    }
}
