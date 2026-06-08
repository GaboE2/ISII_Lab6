<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\ConsultaPaciente;

interface ConsultaPacienteRepositoryInterface
{
    public function save(ConsultaPaciente $consultaPaciente): bool;
}
