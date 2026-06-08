<?php

declare(strict_types=1);

namespace Tests\Integration;

use App\Application\RegistrarConsultaPacienteService;
use App\Domain\Entity\ConsultaPaciente;
use App\Domain\Repository\ConsultaPacienteRepositoryInterface;
use PHPUnit\Framework\TestCase;

final class RegistrarConsultaPacienteServiceTest extends TestCase
{
    public function test_integra_servicio_con_repositorio_fake(): void
    {
        $repo = new class implements ConsultaPacienteRepositoryInterface {
            public ?ConsultaPaciente $saved = null;
            public function save(ConsultaPaciente $consultaPaciente): bool
            {
                $this->saved = $consultaPaciente;
                return true;
            }
        };

        $service = new RegistrarConsultaPacienteService($repo);
        $ok = $service->ejecutar([
            'codigo' => 'CP-1',
            'fecha' => '2026-04-30',
            'hora_consulta' => '11:00',
            'duracion_consulta' => '30',
            'motivo_consulta' => 'Chequeo',
            'nombre_paciente' => 'Carlos',
            'id_paciente' => 12,
            'telefono_paciente' => '999999',
            'correo_paciente' => 'c@c.com',
            'fecha_nacimiento_paciente' => '2000-01-01',
            'sexo_paciente' => 'M',
            'nombre_medico' => 'Dra A',
            'id_medico' => 2,
            'especialidad_medico' => 'General',
            'telefono_medico' => '111',
            'correo_medico' => 'd@d.com',
            'diagnostico' => 'ok',
            'evaluacion' => 'ok',
        ]);

        self::assertTrue($ok);
        self::assertNotNull($repo->saved);
    }
}
