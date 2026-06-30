<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../php/Consultas/Dominio/Consulta.php';
require_once __DIR__ . '/../../php/Consultas/Dominio/DatosRegistroConsulta.php';

class ConsultaTest extends TestCase
{
    public function test_crea_consulta_valida_correctamente()
    {
        $consulta = new Consulta(new DatosRegistroConsulta(
            idCita: 5,
            idPaciente: 1,
            idDoctor: 3,
            fechaConsulta: '2026-07-10',
            motivo: 'Control general',
            diagnostico: 'Paciente estable'
        ));

        $this->assertSame(5, $consulta->getIdCita());
        $this->assertSame('Paciente estable', $consulta->getDiagnostico());
    }

    public function test_diagnostico_vacio_lanza_excepcion()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('diagnóstico es obligatorio');

        new Consulta(new DatosRegistroConsulta(
            idCita: 5,
            idPaciente: 1,
            idDoctor: 3,
            fechaConsulta: '2026-07-10',
            motivo: 'Control general',
            diagnostico: ''
        ));
    }

    public function test_id_cita_invalido_lanza_excepcion()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('cita asociada es obligatoria');

        new Consulta(new DatosRegistroConsulta(
            idCita: 0,
            idPaciente: 1,
            idDoctor: 3,
            fechaConsulta: '2026-07-10',
            motivo: '',
            diagnostico: 'Diagnóstico válido'
        ));
    }
}
