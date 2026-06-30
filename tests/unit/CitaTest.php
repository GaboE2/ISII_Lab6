<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../php/Citas/Dominio/Cita.php';
require_once __DIR__ . '/../../php/Citas/Dominio/DatosRegistroCita.php';

class CitaTest extends TestCase
{
    public function test_crea_cita_pendiente_correctamente()
    {
        $cita = new Cita(new DatosRegistroCita(
            idPaciente: 1,
            idDoctor: 3,
            fechaCita: '2026-07-15',
            horaCita: '10:30',
            motivo: 'Control general'
        ));

        $this->assertSame('pendiente', $cita->getEstado());
        $this->assertSame(1, $cita->getIdPaciente());
        $this->assertSame(3, $cita->getIdDoctor());
    }

    public function test_fecha_vacia_lanza_excepcion()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('fecha de la cita es obligatoria');

        new Cita(new DatosRegistroCita(
            idPaciente: 1,
            idDoctor: 3,
            fechaCita: '',
            horaCita: '10:30',
            motivo: ''
        ));
    }

    public function test_hora_vacia_lanza_excepcion()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('hora de la cita es obligatoria');

        new Cita(new DatosRegistroCita(
            idPaciente: 1,
            idDoctor: 3,
            fechaCita: '2026-07-15',
            horaCita: '',
            motivo: ''
        ));
    }

    public function test_paciente_igual_a_doctor_lanza_excepcion()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('paciente y el doctor no pueden ser la misma persona');

        new Cita(new DatosRegistroCita(
            idPaciente: 5,
            idDoctor: 5,
            fechaCita: '2026-07-15',
            horaCita: '10:30',
            motivo: ''
        ));
    }

    public function test_cancelar_cita_cambia_estado()
    {
        $cita = new Cita(new DatosRegistroCita(
            idPaciente: 1,
            idDoctor: 3,
            fechaCita: '2026-07-15',
            horaCita: '10:30',
            motivo: ''
        ));

        $cita->cancelar();

        $this->assertSame('cancelada', $cita->getEstado());
    }

    public function test_estado_invalido_lanza_excepcion()
    {
        $this->expectException(InvalidArgumentException::class);

        Cita::reconstruir(
            id: 10,
            idPaciente: 1,
            idDoctor: 3,
            fechaCita: '2026-07-15',
            horaCita: '10:30',
            motivo: '',
            estado: 'no_existe',
            creadoEn: '2026-06-30 10:00:00'
        );
    }
}
