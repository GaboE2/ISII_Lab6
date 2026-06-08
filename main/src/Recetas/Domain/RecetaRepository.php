<?php

declare(strict_types=1);

namespace Farmacia\Recetas\Domain;

interface RecetaRepository
{
    public function save(LineaReceta $linea): void;
}
