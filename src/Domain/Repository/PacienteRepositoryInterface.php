<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Paciente;

interface PacienteRepositoryInterface {
    public function save(Paciente $paciente): bool;
}
