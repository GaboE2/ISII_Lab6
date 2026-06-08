<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\Entity\Consulta;
use App\Domain\Repository\ConsultaRepositoryInterface;
use mysqli;

final class MysqliConsultaRepository implements ConsultaRepositoryInterface
{
    public function __construct(private mysqli $connection)
    {
    }

    public function save(Consulta $consulta): bool
    {
        $d = $consulta->toArray();

        $stmt = $this->connection->prepare(
            'INSERT INTO consultas (codigo, fecha, hora, motivo, id_paciente, nombre_completo, fecha_nacimiento, sexo, telefono, diagnostico)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)' 
        );

        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param(
            'ssssisssss',
            $d['codigo'],
            $d['fecha'],
            $d['hora'],
            $d['motivo'],
            $d['id_paciente'],
            $d['nombre_completo'],
            $d['fecha_nacimiento'],
            $d['sexo'],
            $d['telefono'],
            $d['diagnostico']
        );

        return $stmt->execute();
    }
}
