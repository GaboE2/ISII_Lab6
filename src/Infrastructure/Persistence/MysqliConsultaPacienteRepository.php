<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\Entity\ConsultaPaciente;
use App\Domain\Repository\ConsultaPacienteRepositoryInterface;
use mysqli;

final class MysqliConsultaPacienteRepository implements ConsultaPacienteRepositoryInterface
{
    public function __construct(private mysqli $connection)
    {
    }

    public function save(ConsultaPaciente $consultaPaciente): bool
    {
        $d = $consultaPaciente->toArray();

        $stmt = $this->connection->prepare(
            'INSERT INTO consultapaciente (codigo, fecha_consulta, hora_consulta, duracion_consulta, motivo_consulta, nombre_paciente, id_paciente, telefono_paciente, correo_paciente, fecha_nacimiento_paciente, sexo_paciente, nombre_medico, id_medico, especialidad_medico, telefono_medico, correo_medico, diagnostico, evaluacion)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );

        if ($stmt === false) {
            return false;
        }

        $idPaciente = (int)($d['id_paciente'] ?? 0);
        $idMedico = (int)($d['id_medico'] ?? 0);

        $stmt->bind_param(
            'ssssssisssssisssss',
            $d['codigo'],
            $d['fecha'],
            $d['hora_consulta'],
            $d['duracion_consulta'],
            $d['motivo_consulta'],
            $d['nombre_paciente'],
            $idPaciente,
            $d['telefono_paciente'],
            $d['correo_paciente'],
            $d['fecha_nacimiento_paciente'],
            $d['sexo_paciente'],
            $d['nombre_medico'],
            $idMedico,
            $d['especialidad_medico'],
            $d['telefono_medico'],
            $d['correo_medico'],
            $d['diagnostico'],
            $d['evaluacion']
        );

        return $stmt->execute();
    }
}
