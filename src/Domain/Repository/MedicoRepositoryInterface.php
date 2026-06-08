<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Medico;

interface MedicoRepositoryInterface {
    public function save(Medico $medico): bool;
}
