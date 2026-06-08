<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Consulta;

interface ConsultaRepositoryInterface
{
    public function save(Consulta $consulta): bool;
}
